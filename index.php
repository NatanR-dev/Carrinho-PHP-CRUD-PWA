<?php

/**
 * Carrinho CRUD PHP
 * Author: github.com/NatanR-dev
 * Script desenvolvido para entrevista da Precode Soluções | 21 Out 2020
 */

// Config
$_CONFIG = [

    // Nome da Aplicação
    'name' => 'CRUD | Carrinho PHP',

    // URL da aplicação
    'baseurl' => 'http://g21flix.000webhostapp.com/cart',   // URL ou se for testar localmente use 'localhost'

    // Index Controller
    'index' => 'Home',

    // Config da DB
    'database' => [
        'host'  => 'localhost',
        'user'  => 'id10997928_db_user',
        'pass'  => '@D]R[#d@V@!eX8#K',
        'name'  => 'id10997928_native_php_shopping_cart',
    ],

];

// Boot Core System
include 'system/boot.php';

?>
