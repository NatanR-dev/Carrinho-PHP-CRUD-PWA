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
    'baseurl' => '',   // URL ou se for testar localmente use 'localhost'

    // Index Controller
    'index' => 'Home',

    // Config da DB
    'database' => [
        'host'  => 'localhost',
        'user'  => '',
        'pass'  => '',
        'name'  => '',
    ],

];

// Boot Core System
include 'system/boot.php';

?>
