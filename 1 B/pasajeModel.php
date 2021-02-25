<?php

class PasajeModel {

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_viajes;charset=utf8', 'root', '');
    }

    function getPasajesDeViaje($id){
        $sentencia = $this->db->prepare("SELECT * FROM pasaje WHERE id_viaje=?");
        $sentencia->execute(array($id));
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    function modifyPasaje($cancelado, $id){
        $sentencia = $this->db->prepare("UPDATE pasaje SET cancelado=? WHERE id=?");
        $sentencia->execute(array($cancelado, $id));
        return $sentencia->rowCount();
    }
}