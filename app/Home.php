<?php

/**
 * Home Controller Class
 *
 * Método chamado por URI
 * Exemplo : /home/index chamará a função index() nesta classe
 */
class Home extends ControllerClass
{
    /**
     * Home Page - Lista de Produtos
     * URL : home/index
     */
    public function index()
    {
        // Corrige o URL da imagem no primeiro carregamento
        if (getSession('fix_image') == null) {
            setSession('fix_image', '1');
            $this->fixImage();
        }

        // Obtém os dados do produto cujo valor não seja 0
        $data['products'] = $this->db->query("SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.quantity > 0");

        $this->view('home', ['data' => $data]);
    }

    /**
     * Atualiza o link da imagem
     */
    public function fixImage()
    {
        // Seta o sinalizador para excluir arquivo de imagem se não estiver listado na DB
        $cleanFiles = isset($_GET['clean']) ? true : false;
        $usedFiles = [];
        $directory = getcwd().'\public\images\products\\';

        $prevProducts = $this->db->query("SELECT id, images FROM products WHERE images <> ''");
        $productIds = [];
        $sqlCase = "";

        foreach ($prevProducts as $key => $product) {

            $prevLinks = json_decode($product['images']);
            $newLinks = [];

            foreach ($prevLinks as $link) {
                /**
                 * Obtém o nome do arquivo
                 * Explode a url em array por delimiter '/'
                 * Obtém o último valor do array
                 */
                $filename = array_values( array_slice( explode('/', $link), -1) )[0];
                $newLinks[] = baseurl('public/images/products/').$filename;

                $usedFiles[] = $filename;
            }

            $productIds[] = $product['id'];
            $newLinks = json_encode($newLinks);
            $sqlCase .= "WHEN id = '$product[id]' THEN '$newLinks'";

        }

        // Atualiza as Imagens na DB
        if (count($productIds) > 0) {

            $productIds = implode(', ', $productIds);
            $sql = "UPDATE products SET images = (CASE $sqlCase END) WHERE id IN ($productIds)";
            $this->db->query($sql);

        }

        // Limpa as imagens não listadas na DB
        if ($cleanFiles) {

            $files = scandir($directory);
            $usedFiles = array_merge($usedFiles, ['.', '..']);

            // Remove arquivo no diretório
            foreach ($files as $file) {
                if ( ! in_array($file, $usedFiles) ) {
                    unlink($directory.$file);
                }
            }

        }

        // Retorna para Home Page
        redirect('/');
    }

}

?>