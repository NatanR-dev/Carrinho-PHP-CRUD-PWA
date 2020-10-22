<?php

/**
 * Author: github.com/NatanR-dev
 */

class DatabaseClass
{
    /**
     * Variáveis ​​de classe inicial
     */
    protected $host;
    protected $username;
    protected $password;
    protected $database;
    // -- //
    public $connection;

    /**
     * Construtor de Classe
     *
     * Conecta-se a MySQL DB
     *
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        // Starta a Conexão
        $connection = mysqli_connect($host, $username, $password, $database);
        if ( ! $connection ) {
            die ("Connection Failed. ". mysqli_connect_error());
        }

        $this->connection = $connection;
    }

    /**
     * Obtém os dados da tabela por query e retorna como array
     */
    public function query($string, $returnMysqlObject = false)
    {
        $result = false;
        $query = $this->connection->query($string);

        // Query String obtém dados da tabela / insere a Update
        if (strpos(strtoupper($string), 'SELECT') !== false) {

            $result = [];

            if ($query == true && $query->num_rows > 0) {
                $rows = [];
                while ($row = $query->fetch_assoc()) {
                    $rows[] = $row;
                }
                $result = $rows;
            }

        } else {

            if ($this->connection->error) {
                $result = $this->connection->error;
            } else if($returnMysqlObject) {
                $result = $this->connection;
            } else {
                $result = $query;
            }

        }

        return $result;
    }

}

?>