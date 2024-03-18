<?php
#Nome do arquivo: Connection.php
#Objetivo: classe para conectar ao banco de dados

//require_once(__DIR__ . "/../util/config.php");

class Connection {

    //Retorna a conexão a partir da classe
    public static function getConn() {
        $conn = new Connection();
        return $conn->getConnection();
    }

    //Retorna uma conexão com o MySQL
    public function getConnection() {
        //mysql:host=XXXX;dbname=XXX
        $str_conn = "mysql:host=". DB_HOST .";dbname=". DB_NAME;

        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", //Define o charset
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION); //Define o tipo de exceção
        
        try{ 
            #$conn = new PDO("mysql:host=XXXX;dbname=XXX", "root", "root", array());
            $conn = new PDO($str_conn, DB_USER, DB_PASSWORD, $options);
            return $conn;
        } catch (PDOException $e) {
            echo "Falha ao conectar na base de dados: " . $e->getMessage();
        }
    }

}