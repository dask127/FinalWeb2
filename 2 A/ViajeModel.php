<?php

class ViajeModel {

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_viajes;charset=utf8', 'root', '');
    }


    function getAllViajes(){
        $sentencia = $this->db->prepare("SELECT * FROM viaje");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}