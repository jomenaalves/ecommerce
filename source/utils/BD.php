<?php

namespace Source\Utils;

use Source\Utils\Utils;
use PDO;

class BD extends PDO
{

    /**
     * Instance of your SGBD
     * @property Object
     */
    private object $conn;

    public function __construct()
    {
        // Create a new pdo instance
        $this->conn = new PDO("mysql:host=" . HOST_OF_YOUR_DBMS . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

        // Set attributes for the PDO
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getAdminByEmail(String $email)
    {

        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClient(Int $id){
        $query = "SELECT * FROM all_clientes WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadProduct(String $nome, String $valor)
    {

        //verificar se já está cadastrado
        $query = "SELECT * FROM products WHERE nome = :n";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':n' => $nome
        ]);

        if($stmt->fetchAll(PDO::FETCH_ASSOC) !== []){
            return false;
        }

        $query = "INSERT INTO products(nome, valor) VALUES (:nome, :valor)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':nome' => $nome,
            ':valor' => $valor
        ]);

        if ($this->conn->lastInsertId()) {
            return true;
        }

        return false;
    }

    public function upProduct(String $nome, String $valor, Int $id)
    {

        $query = "UPDATE products SET nome=:nome, valor=:valor WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':nome' => $nome,
            ':valor' => $valor
        ]);

        $count = $stmt->rowCount();

        if($count == '0'){
            return false;
        }

        return true;
        
       
    }

    public function delProduct(Int $id)
    {

        $query = "DELETE FROM products WHERE id = $id";
        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;
        }

        return false;
    
    }
    public function getProductByID(Int $id){
        $query = "SELECT * FROM products WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
