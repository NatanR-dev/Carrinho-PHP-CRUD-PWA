<?php

/**
 * Category Controller Class
 *
 * Método chamado por URI
 * Exemplo : /admin/category chamará a função index() nesta classe
 */
class Category extends ControllerClass
{
    /**
     * Index da Categoria
     * URL : admin/category/index
     */
    public function index()
    {
        $title = config('name').' - Lista de Categorias';

        $data['categories'] = $this->db->query('SELECT * FROM categories');

        $this->view('admin/category-index', ['data' => $data, 'title' => $title]);
    }

    /**
     * Cria uma nova categoria
     * URL : admin/category/create
     */
    public function create()
    {
        // Dados Iniciais
        $category = [
            'id' => null,
            'parent_id' => null,
            'name' => null,
            'description' => null,
        ];

        $error = false;
        // Armazena no banco de dados se o método for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $validation = true;

            // Assign POST Data
            $category['parent_id'] = $parent_id = filter($_POST['parent_id']);
            $category['name'] = $name = filter($_POST['name']);
            $category['slug'] = $slug = toKebabCase(filter($_POST['name']));
            $category['description'] = $description = filter($_POST['description']);
            $now = date('Y-m-d H:i:s');

            if ($validation) {
                // Insere no banco de dados
                $query = $this->db->query("INSERT INTO categories (parent_id, slug, name, description, created_at, updated_at) VALUES('$parent_id', '$slug', '$name', '$description', '$now', '$now')");

                if ($query === true) {
                    redirect('admin/category?message=success');
                } else {
                    $error = $query;
                }
            }
        }

        // Obtém a categoria pai
        $data['parentCategories'] = [];
        $query = $this->db->query('SELECT * FROM categories');
        if ($query) $data['parentCategories'] = $query;

        $title = config('name').' - Criar Categoria';
        $data['title'] = 'Insira uma Categoria';
        $data['category'] = $category;
        $data['submitUrl'] = baseurl('admin/category/create');
        $data['error'] = $error;

        $this->view('admin/category-form', ['data' => $data, 'title' => $title]);
    }

    /**
     * Editar categoria
     * URL : admin/category/edit
     */
    public function edit($id = null)
    {
        // Dados Iniciais
        $id = filter($id);
        $category = $this->db->query("SELECT * FROM categories WHERE id = '$id'");

        // Retorne o erro 404 se não houver resultado da consulta
        if ( ! $category ) {
            $this->error404();
        }
        $category = $category[0];

        $error = false;
        // Armazena no banco de dados se o método for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $validation = true;

            // Assign POST Data
            $category['parent_id'] = $parent_id = filter($_POST['parent_id']);
            $category['name'] = $name = filter($_POST['name']);
            $category['slug'] = $slug = toKebabCase(filter($_POST['name']));
            $category['description'] = $description = filter($_POST['description']);
            $now = date('Y-m-d H:i:s');

            if ($validation) {
                // Atualiza para banco de dados
                $query = $this->db->query("UPDATE categories SET parent_id = '$parent_id', slug = '$slug', name = '$name', description = '$description', updated_at = '$now' WHERE id = '$id'");

                if ($query === true) {
                    redirect('admin/category?message=success');
                } else {
                    $error = $query;
                }
            }
        }

        // Obté, a categoria pai
        $data['parentCategories'] = [];
        $query = $this->db->query('SELECT * FROM categories');
        if ($query) $data['parentCategories'] = $query;

        $title = config('name').' - Editar '.$category['name'];
        $data['title'] = 'Edit Categoria';
        $data['category'] = $category;
        $data['submitUrl'] = baseurl('admin/category/edit/'.$id);
        $data['error'] = $error;

        $this->view('admin/category-form', ['data' => $data, 'title' => $title]);
    }

    /**
     * Excluir categoria
     * URL : admin/category/delete/{{id}}
     */
    public function delete($id = null)
    {
        $id = filter($id);
        $result = $this->db->query("DELETE FROM categories WHERE id = '$id'");

        if ($result) {
            redirect('admin/category?message=success');
        } else {
            redirect('admin/category?message=failed');
        }
    }

}

?>