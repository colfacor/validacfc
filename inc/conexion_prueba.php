<?php

class Database
{
    private $hostname = "localhost";
    private $database = "colfacor_user";
    private $username = "colfacor_validador_cfc";
    private $password = "dG#4%Yh+m,{V";
    private $charset = "utf8";

    /**
     * Se conecta a la base de datos y devuelve un objeto PDO.
     * 
     * @return La conexión a la base de datos.
     */
    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {
            echo 'Error conexion: ' . $e->getMessage();
            exit;
        }
    }
}