<?php

class CiudadModel {

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_viajes;charset=utf8', 'root', '');
    }

    function getCiudad($id){
        $sentencia = $this->db->prepare("SELECT * FROM ciudad WHERE id=?");
        $sentencia->execute(array($id));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    function getNombreCiudad($id){
        $sentencia = $this->db->prepare("SELECT ciudad.nombre FROM ciudad WHERE id=?");
        $sentencia->execute(array($id));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }
}