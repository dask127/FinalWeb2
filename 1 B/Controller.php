<?php

require_once "ViajeModel.php";
require_once "pasajeModel.php";

class Controller
{

    private $viajeModel;
    private $view;
    private $pasajeModel;

    function __construct()
    {
        $this->viajeModel = new ViajeModel();
        $this->pasajeModel = new PasajeModel();
        $this->view = new View();
    }

    //se accederia a esta funcion a través de: "/eliminarviaje/:ID"
    function removerViaje($params = null)
    {

        //verifica las credenciales del que intente entrar
        $this->checkAdminAuth();

        if ($params != null) {
            $id = $params[":ID"];

            $viaje = $this->viajeModel->getViaje($id);

            if (!empty($viaje)) {

                $status = $this->viajeModel->eliminarViaje($id);

                if ($status != 0) {
                    $this->view->show("se ha eliminado satisfactoriamente el viaje con id: " + $id);

                    $pasajes = $this->pasajeModel->getPasajesDeViaje($id);

                    if (!empty($pasajes)) {
                        foreach ($pasajes as $pasaje) {
                            $this->pasajeModel->modifyPasaje(true, $pasaje->id);
                        }
                    }

                } else  $this->view->show("no se ha podido eliminar el viaje con id: " + $id);
            } else  $this->view->show("no existe el viaje con id:" + $id);
        } else  $this->view->show("no se ha proporcionado una ID valida");
    }


    function checkAdminAuth()
    {
        session_start();

        //si no esta seteada la sesion no esta registrado y lo devuelvo al home
        if (!isset($_SESSION)) {
            $this->view->showHome();
            die();
        } else {

            //si no tiene la autorizacion lo devuelvo al home
            if ((!isset($_SESSION["ADMIN_AUTH"])) || ($_SESSION["ADMIN_AUTH"]  != true)) {
                $this->view->showHome();
                die();
            }
        }
    }
}
