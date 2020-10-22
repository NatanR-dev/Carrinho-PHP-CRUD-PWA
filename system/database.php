<?php

/**
 * Conexão com a DB
 */
$db = new DatabaseClass(
    $_CONFIG['database']['host'],
    $_CONFIG['database']['user'],
    $_CONFIG['database']['pass'],
    $_CONFIG['database']['name']
);

?>