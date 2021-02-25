<?php

class ViajeModel {

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_viajes;charset=utf8', 'root', '');
    }


    function eliminarViaje($id){
        $sentencia = $this->db->prepare("DELETE * FROM viaje WHERE id=?");
        $sentencia->execute(array($id));
        return $sentencia->rowCount();
    }

    function getViaje($id){
        $sentencia = $this->db->prepare("SELECT * FROM viaje WHERE id=?");
        $sentencia->execute(array($id));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }
}