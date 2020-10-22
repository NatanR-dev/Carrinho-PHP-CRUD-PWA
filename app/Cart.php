<?php

/**
 * Cart Controller Class
 *
 * Método chamado por URI
 * Exemplo : /cart/index chamará a função index() nesta classe
 */
class Cart extends ControllerClass
{
    /**
     * Index do Carrinho
     * URL : /cart
     */
    public function index()
    {
        $userId = getSession('user_id', randomString(5));
        $now = date('Y-m-d H:i:s');

        // Obtém os Produtos do Carrinho
        $carts = $this->db->query("SELECT carts.*, cart_products.* FROM carts JOIN cart_products ON carts.id = cart_products.cart_id WHERE carts.user_id = '$userId'");

        // Obtém os Dados do Produto
        $productIds = implode(', ', pluck($carts, 'product_id'));
        $products = $this->db->query("SELECT id, price, quantity FROM products WHERE id IN ($productIds)");
        $products = keyBy($products, 'id');

        $totalPrice = 0;
        foreach ($carts as $key => $cart) {
            $productId = $cart['product_id'];
            $cart['total_item_price'] = $products[$productId]['price'] * $cart['quantity'];
            $cart['max_qty'] = $products[$productId]['quantity'];
            $carts[$key] = $cart;
            $totalPrice += $cart['total_item_price'];
        }

        $title = config('name').' - Carrinho';
        $data['carts'] = $carts;
        $data['total_price'] = $totalPrice;

        $this->view('cart', ['data' => $data, 'title' => $title]);
    }

    /**
     * Processo de Backend do Carrinho
     * Somente em JSON
     * URL : /cart/process
     *
     * Parâmetro do Post: product_id, quantity, method [ add / delete ]
     */
    public function process()
    {
        // Seta o header de resposta em Json
        header('Content-Type: application/json');

        $status = true;
        $response = 'OK';
        $userId = getSession('user_id', randomString(5));
        $now = date('Y-m-d H:i:s');

        /**
         * Seta o Carrinho
         * Cria se não existir
         */
        $cartProductIds = [];
        $carts = $this->db->query("SELECT * FROM carts WHERE user_id = '$userId'");

        if (count($carts) > 0) {
            $cartId = $carts[0]['id'];
            $cartProducts = $this->db->query("SELECT * FROM cart_products WHERE cart_id = '$cartId'");
            $cartProductIds = pluck($cartProducts, 'product_id');
            $cartProductsKeyId = keyBy($cartProducts, 'product_id');
        } else {
            $sql = "INSERT INTO carts (user_id, created_at, updated_at) VALUES('$userId', '$now', '$now')";
            $query = $this->db->query($sql, true);
            $cartId = $query->insert_id;
        }
        // Final - Setup do Carrinho

        /**
         * Setup de Produtos do Carrinho (add, remove) por Request Post
         * Parâmetro : product_id, qty, método (add, delete)
         */
        if (isset($_POST['product_id'])) {

            // Bulk Array Inicial
            $bulkInsertCarts = $bulkUpdateCarts = $bulkDeleteCarts = [];

            /**
             * Quantidade inicial
             * Força o array
             * O valor da quantidade padrão é 1
             */
            $quantities = $_POST['qty'] ?? [1];
            if ( ! is_array($quantities) ) $quantities = [$quantities];

            /**
             * Método inicial (add, delete)
             * Força o array
             */
            $methods = $_POST['method'] ?? [];
            if ( ! is_array($methods) ) $methods = [$methods];

            /**
             * Obtém a DB dos Produtos por Request Id Products
             */
            $postProductIds = $_POST['product_id'];

            if (is_array($postProductIds)) {
                // Filtra os product id
                foreach ($postProductIds as $key => $idProduct) {
                    $postProductIds[$key] = filter($idProduct);
                }
                $sql = "WHERE products.id IN (".implode(', ', $postProductIds).")";
            } else {
                $postProductIds = filter($postProductIds);
                $sql = "WHERE products.id = '$postProductIds'";
            }

            $sql = "SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id $sql";
            $products = $this->db->query($sql);
            $products = keyBy($products, 'id');
            // Final do - Get Produtos DB

            /**
             * Looping Array Request Data
             */
            foreach ($methods as $key => $method) {

                /**
                 * Seta o ID e valor do produto selecionado
                 */
                $idProduct = $postProductIds[$key];
                $product = $products[$idProduct];

                /**
                 * Produto de Quantidade de Validação
                 * O número deve ser igual ou menor do que o valor do products.quantity 
                 * Se a quantidade do produto do banco de dados estiver vazia, force o método a excluir
                 */
                $qty = intval($quantities[$key]);
                if ( $qty < 1 ) $qty = 1;

                if ($method == 'add') {
                    $prevQty = isset($cartProductsKeyId[$idProduct]['quantity']) ? intval($cartProductsKeyId[$idProduct]['quantity']) : 0;
                    $qty = $prevQty + $qty;
                }

                if ( $qty > $product['quantity'] ) $qty = $product['quantity'];
                if ( $qty < 1) $method = 'delete';

                /**
                 * Seta o valor do Bulk Array po Método Selecionado
                 */
                switch ($method) {
                    case 'delete':
                        $bulkDeleteCarts[] = $idProduct;
                        break;
                    case 'add':
                    case 'update':
                    default:
                        if ( ! in_array($idProduct, $cartProductIds) ) {
                            // Seta o valor para inserção em massa
                            $bulkInsertCarts[] = "('$cartId', '$product[id]', '$product[category_id]', '$product[category_name]', '$product[name]', '$product[description]', '$product[price]', '$product[images]', '$qty', '$now', '$now')";
                        } else {
                            // Seta o valor para atualização em massa
                            $bulks = [];
                            $bulks['product_id'] = $idProduct;
                            $bulks['case_category_id'] = "WHEN product_id = '$idProduct' THEN '$product[category_id]'";
                            $bulks['case_category_name'] = "WHEN product_id = '$idProduct' THEN '$product[category_name]'";
                            $bulks['case_name'] = "WHEN product_id = '$idProduct' THEN '$product[name]'";
                            $bulks['case_description'] = "WHEN product_id = '$idProduct' THEN '$product[description]'";
                            $bulks['case_price'] = "WHEN product_id = '$idProduct' THEN '$product[price]'";
                            $bulks['case_images'] = "WHEN product_id = '$idProduct' THEN '$product[images]'";
                            $bulks['case_quantity'] = "WHEN product_id = '$idProduct' THEN '$qty'";
                            $bulkUpdateCarts[] = $bulks;
                        }
                        break;
                }

            }

            /**
             * Insere Produtos no Carrinho em massa
             */
            if (count($bulkInsertCarts) > 0) {

                $bulkInsertCarts = implode(', ', $bulkInsertCarts);

                $sql = "INSERT INTO cart_products (cart_id, product_id, category_id, category_name, name, description, price, images, quantity, created_at, updated_at)  VALUES $bulkInsertCarts";

                $this->db->query($sql);
            }

            /**
             * Produtos do carrinho de atualização em massa
             */
            if (count($bulkUpdateCarts) > 0) {

                $bulkProductIds = implode(', ', pluck($bulkUpdateCarts, 'product_id'));
                $caseCategoryId = implode(' ', pluck($bulkUpdateCarts, 'case_category_id'));
                $caseCategoryName = implode(' ', pluck($bulkUpdateCarts, 'case_category_name'));
                $caseName = implode(' ', pluck($bulkUpdateCarts, 'case_name'));
                $caseDescription = implode(' ', pluck($bulkUpdateCarts, 'case_description'));
                $casePrice = implode(' ', pluck($bulkUpdateCarts, 'case_price'));
                $caseImages = implode(' ', pluck($bulkUpdateCarts, 'case_images'));
                $caseQuantity = implode(' ', pluck($bulkUpdateCarts, 'case_quantity'));

                $sql = "UPDATE cart_products SET
                    category_id = (CASE $caseCategoryId END),
                    category_name = (CASE $caseCategoryName END),
                    name = (CASE $caseName END),
                    description = (CASE $caseDescription END),
                    price = (CASE $casePrice END),
                    images = (CASE $caseImages END),
                    quantity = (CASE $caseQuantity END),
                    updated_at = '$now'
                WHERE cart_id = '$cartId' AND product_id IN ($bulkProductIds)";

                // Remover quebra de linha e espaços em branco duplos
                $sql = trim(preg_replace("/\s\s+/", " ", $sql));

                $this->db->query($sql);
            }

            /**
             * Produtos de carrinho de exclusão em massa
             */
            if (count($bulkDeleteCarts) > 0) {

                $bulkDeleteCarts = implode(', ', $bulkDeleteCarts);

                $sql = "DELETE FROM cart_products WHERE cart_id = '$cartId' AND product_id IN ($bulkDeleteCarts)";

                $this->db->query($sql);
            }

        }
        // Final do - Setup do Produtos no Carrinho

        /**
         * Resposta em Json
         */
        echo json_encode([
            'status' => $status,
            'response' => $response,
            'redirect' => baseurl('cart'),
        ]);
    }

    /**
     * Página do Carrinho
     * URL : cart/checkout
     */
    public function checkout()
    {
        $userId = getSession('user_id', randomString(5));
        $now = date('Y-m-d H:i:s');

        // Validação por Input Request
        $name = isset($_POST['name']) ? filter($_POST['name']) : null;
        $address = isset($_POST['address']) ? filter($_POST['address']) : null;

        // Obtém os Produtos no Carrinho
        $carts = $this->db->query("SELECT carts.*, cart_products.* FROM carts JOIN cart_products ON carts.id = cart_products.cart_id WHERE carts.user_id = '$userId'");

        /**
         * Verifica os dados do carrinho, nome de entrada e endereço de entrada
         */
        if (count($carts) > 0 && $name && $address) {

            /**
             * Obtém os dados originais do produto
             * Id do produto da tabela de produtos do carrinho
             * Selecione apenas o produto onde a quantidade é > 0
             */
            $productIds = implode(', ', pluck($carts, 'product_id'));
            $sql = "SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.quantity > 0 AND products.id IN ($productIds)";
            $products = $this->db->query($sql);
            $products = keyBy($products, 'id');

            // Verifica se os dados do produto ainda estão disponíveis
            if (count($carts) == count($products)) {

                /**
                 * Insere pedido de dados
                 */
                $sql = "INSERT INTO orders (user_id, name, address, created_at, updated_at) VALUES('$userId', '$name', '$address', '$now', '$now')";
                $query = $this->db->query($sql, true);
                $orderId = $query->insert_id;

                /**
                 * Dados iniciais para atualização de inserção em massa
                 */
                $bulkInsertOrders = $bulkUpdateProducts = [];
                $totalPrice = 0;
                foreach ($carts as $cart) {
                    $idProduct = $cart['product_id'];
                    $product = $products[$idProduct];
                    $qtyLeft = $product['quantity'] - $cart['quantity'];
                    $totalPrice += ( $product['price'] * $cart['quantity'] );

                    // Define produtos de pedido de inserção em massa de dados
                    $bulkInsertOrders[] = "('$orderId', '$idProduct', '$product[category_id]', '$product[category_name]', '$product[name]', '$product[description]', '$product[price]', '$product[images]', '$cart[quantity]', '$now', '$now')";

                    // Define a quantidade de produto de atualização em massa de dados
                    $bulks = [];
                    $bulks['id'] = $idProduct;
                    $bulks['case'] = "WHEN id = '$idProduct' THEN '$qtyLeft'";
                    $bulkUpdateProducts[] = $bulks;
                }

                /**
                 * Insere Pedidos em Massa de Produtos
                 */
                $bulkInsertOrders = implode(', ', $bulkInsertOrders);
                $sql = "INSERT INTO order_products (order_id, product_id, category_id, category_name, name, description, price, images, quantity, created_at, updated_at) VALUES $bulkInsertOrders";
                $this->db->query($sql);

                /**
                 * Atualiza o preço total do produto
                 */
                $sql = "UPDATE orders SET total_price = '$totalPrice' WHERE id = '$orderId'";
                $this->db->query($sql);

                /**
                 * Quantidade de produtos de atualização em massa
                 */
                $productIds = implode(', ', pluck($bulkUpdateProducts, 'id'));
                $qtyCases = implode(' ', pluck($bulkUpdateProducts, 'case'));
                $sql = "UPDATE products SET quantity = (CASE $qtyCases END) WHERE id IN ($productIds)";
                $this->db->query($sql);

                /**
                 * Limpa os dados e produtos do carrinho
                 */
                $cartId = $carts[0]['cart_id'];
                $sql = "DELETE FROM carts WHERE id = '$cartId'";
                $this->db->query($sql);
                $sql = "DELETE FROM cart_products WHERE cart_id = '$cartId'";
                $this->db->query($sql);

                /**
                 * Exibe a página de sucesso
                 */
                $this->view('checkout-success');
            }
        } else {

            /**
             * Redirecionar para Home se não não tem itens no carrinho
             */
            redirect('/');
        }
    }

}

?>