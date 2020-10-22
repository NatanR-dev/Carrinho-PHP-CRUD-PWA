<?php

/**
 * Product Controller Class
 *
 * Método chamado por URI
 * Exemplo : /admin/product chamará a função index() nesta classe
 */
class Product extends ControllerClass
{
    /**
     * Index do Produto - Mostra a Lista de Produtos
     * URL : admin/product/index
     */
    public function index()
    {
        $title = config('name').' - Lista de Produtos';

        $data['products'] = $this->db->query('SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id');

        $this->view('admin/product-index', ['data' => $data, 'title' => $title]);
    }

    /**
     * Cria um novo produto
     * URL : admin/product/create
     */
    public function create()
    {
        // Dados Iniciais
        $product = [
            'id' => null,
            'category_id' => null,
            'name' => null,
            'description' => null,
            'quantity' => null,
            'price' => null,
            'images' => null,
        ];

        $error = false;
        $validation = true;

        // Armazena no banco de dados se o método for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Assign POST Data
            $product['category_id'] = $category_id = filter($_POST['category_id']);
            $product['name'] = $name = filter($_POST['name']);
            $product['slug'] = $slug = toKebabCase(filter($_POST['name']));
            $product['description'] = $description = filter($_POST['description']);
            $product['quantity'] = $quantity = filter($_POST['quantity']);
            $product['price'] = $price = filter($_POST['price']);
            $now = date('Y-m-d H:i:s');
            $images = null;

            // Faz Upload das Imagens
            if (isset($_FILES['images']['name'])) {

                $upload = $this->uploadImages($_FILES['images'], $slug);

                if ( $upload['status'] == true ) {
                    $images = json_encode($upload['files']);
                } else {
                    $validation = false;
                    $error = $upload['response'];
                }
            }

            if ($validation) {
                // Insere no banco de dados
                $query = $this->db->query("INSERT INTO products (category_id, slug, name, description, quantity, price, images, created_at, updated_at) VALUES('$category_id', '$slug', '$name', '$description', '$quantity', '$price', '$images', '$now', '$now')");

                if ($query === true) {
                    redirect('admin/product?message=success');
                } else {
                    dump($query);
                    $error = $query;
                }
            }
        }

        $title = config('name').' - Create Product';
        $data['title'] = 'Input Product';
        $data['product'] = $product;
        $data['categories'] = $this->db->query("SELECT * FROM categories");
        $data['submitUrl'] = baseurl('admin/product/create');
        $data['error'] = $error;

        $this->view('admin/product-form', ['data' => $data, 'title' => $title]);
    }

    /**
     * Editar produtos
     * URL : admin/product/edit/{{id}}
     */
    public function edit($id = null)
    {
        // Dados Iniciais
        $id = filter($id);
        $product = $this->db->query("SELECT * FROM products WHERE id = '$id'");

        // Retorne o erro 404 se não houver resultado da consulta
        if ( ! $product ) {
            $this->error404();
        }
        $product = $product[0];

        $error = false;
        $validation = true;

        // Atualiza para banco de dados se o método for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Assign POST Data
            $product['category_id'] = $category_id = filter($_POST['category_id']);
            $product['name'] = $name = filter($_POST['name']);
            $product['slug'] = $slug = toKebabCase(filter($_POST['name']));
            $product['description'] = $description = filter($_POST['description']);
            $product['quantity'] = $quantity = filter($_POST['quantity']);
            $product['price'] = $price = filter($_POST['price']);
            $now = date('Y-m-d H:i:s');
            $images = [];

            // Verifica as imagens anteriores armazenadas no banco de dados
            $prevImages = getImages($product['images'], true, false);
            $prevImagesKeep = [];
            $prevImagesDeleted = [];

            // Verifica a imagem anterior mantida enviada na edição do formulário
            if (isset($_POST['prev_images'])) {
                $images = $prevImagesKeep = $_POST['prev_images'];
            }

            // Atribui o caminho das imagens para excluir / desvincula posteriormente após a consulta de atualização
            foreach ($prevImages as $key => $image) {
                if ( ! in_array($image, $prevImagesKeep) ) {
                    $prevImagesDeleted[] = getcwd().str_replace(baseurl(), '', $image);
                }
            }

            // Processo de upload de novas imagens
            if (isset($_FILES['images']['name'])) {

                $upload = $this->uploadImages($_FILES['images'], $slug);

                if ( $upload['status'] == true ) {
                    $images = array_merge($images, $upload['files']);
                } else {
                    $validation = false;
                    $error = $upload['response'];
                }
            }

            if ($validation) {

                // Converte dados de imagens em json se os dados forem atribuídos
                if (count($images) > 0) {
                    $images = json_encode($images);
                } else {
                    $images = null;
                }

                // Atualiza para banco de dados
                $query = $this->db->query("UPDATE products SET category_id = '$category_id', name = '$name', slug = '$slug', description = '$description', quantity = '$quantity', price = '$price', images = '$images', updated_at = '$now' WHERE id = '$id'");

                // Desvincula as imagens excluídas
                foreach ($prevImagesDeleted as $file) {
                    unlink($file);
                }

                if ($query === true) {
                    redirect('admin/product?message=success');
                } else {
                    $error = $query;
                }
            }
        }

        $title = config('name').' - Edit '.$product['name'];
        $data['title'] = 'Editar Produto';
        $data['product'] = $product;
        $data['categories'] = $this->db->query("SELECT * FROM categories");
        $data['submitUrl'] = baseurl('admin/product/edit/'.$id);
        $data['error'] = $error;

        $this->view('admin/product-form', ['data' => $data, 'title' => $title]);
    }

    /**
     * Deleta os produtos
     * URL : admin/product/delete/{{id}}
     */
    public function delete($id = null)
    {
        $id = filter($id);

        // Desvincula ou remove as imagens
        $result = $this->db->query("SELECT images FROM products WHERE id = '$id'");

        if ( isset($result[0]) ) {

            $images = getImage($result[0]['images'], true, array());

            foreach ($images as $key => $image) {
                unlink(getcwd().str_replace(baseurl(), '', $image));
            }
        }

        // Excluir o registro do banco de dados
        $result = $this->db->query("DELETE FROM products WHERE id = '$id'");

        if ($result) {
            redirect('admin/product?message=success');
        } else {
            redirect('admin/product?message=failed');
        }
    }

    /**
     * Faz Upload de imagens do produto
     */
    private function uploadImages($images, $prefix = null)
    {
        $exts = ['jpg', 'jpeg', 'png', 'gif'];
        $saveDir = getcwd().'\public\images\products\\';
        $url = baseurl('public/images/products/');

        $uploads = [];
        foreach ($images['name'] as $key => $filename) {

            // Verifica a extensão do arquivo de imagem
            $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if ( ! in_array($filetype, $exts) ) {
                return [
                    'status' => false,
                    'response' => 'File '.$filename.' não é um formato jpg ou png válido',
                    'files' => [],
                ];
            }

            // Verifique se o arquivo é uma imagem real ou falsa
            if ( ! getimagesize($images["tmp_name"][$key]) ) {
                return [
                    'status' => false,
                    'response' => 'File '.$filename.' não é uma imagem',
                    'files' => [],
                ];
            }

            // Verifica o tamanho da imagem
            if ( $images["size"][$key] > 2000000 ) {
                return [
                    'status' => false,
                    'response' => 'Image '.$filename.' o tamanho deve ser abaixo de 2MB',
                    'files' => [],
                ];
            }

            $prevName = $filename;
            $filename = $prefix.'-'.date('YmdHis').'-'.$key.'.'.$filetype;
            $uploads[] = [
                'temp' => $images["tmp_name"][$key],
                'save' => $saveDir.basename($filename),
                'filename' => $filename,
                'prev_name' => $prevName,
            ];
        }

        // Move o Upload da Imagem para um diretório temporário
        $images = [];
        foreach ($uploads as $file) {
            if( ! move_uploaded_file($file['temp'], $file['save']) ) {
                return [
                    'status' => false,
                    'response' => 'Erro ao mover o arquivo '.$file['prev_name'],
                    'files' => [],
                ];
            }

            $images[] = $url.$file['filename'];
        }

        return [
            'status' => true,
            'response' => $images,
            'files' => $images,
        ];
    }

}

?>