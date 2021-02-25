<?php

require_once "ViajeModel.php";
require_once "pasajeModel.php";

class Controller
{

    private $view;
    private $viajeModel;
    private $pasajeModel;
    private $ciudadModel;

    function __construct()
    {
        $this->view = new View();
        $this->viajeModel = new ViajeModel();
        $this->pasajeModel = new PasajeModel();
        $this->ciudadModel = new CiudadModel();
    }


    function infoViajes()
    {
        //me lo traigo de la db en modo de array asociativo para manejarlo mejor
        $viajes = $this->viajeModel->getAllViajes();

        foreach ($viajes as $viaje) {
            $pasajes = $this->pasajeModel->getPasajesDeViaje($viaje->id);

            //si no tiene pasajes lo saco de $pasajes
            if (empty($pasajes)) {
                unset($viaje);
            } else {

                //les reemplazo la id por el nombre de la ciudad

                $nombre_origen = $this->ciudadModel->getNombreCiudad($viaje["id_ciudad_origen"]);

                unset($viaje["id_ciudad_origen"]);

                $viaje["ciudad_origen"] = $nombre_origen;



                $nombre_destino = $this->ciudadModel->getNombreCiudad($viaje["id_ciudad_destino"]);

                unset($viaje["id_ciudad_destino"]);

                $viaje["ciudad_destino"] = $nombre_destino;


                //aca voy a guardar los detalles de cada pasaje: $pasajeDetalles[DNI] = cantidad de pasajes vendidos a ese dni
                $pasajeDetalles = [];

                foreach ($pasajes as $pasaje) {

                    //agarro los DNIs ya guardados en las keys de $pasajeDetalles
                    $keys = array_keys($pasajeDetalles);

                    $flag = false;

                    //si ya esta en el array el dni que busco, lo omito con una flag
                    foreach ($keys as $key) {
                        if ($key == $pasaje->dni) {
                            $flag = true;
                        }
                    }

                    if ($flag == false) {

                        $cantidad_pasajes = $this->pasajeModel->getCantPasajesByDni($pasaje->dni, $viaje["id"]);

                        //guarda en un array el dni y la cantidad de comprados de cada dni
                        //ta rebuscado
                        $pasajeDetalles[$pasaje->dni] = $cantidad_pasajes;
                    }
                }

                //guarda la cantidad de pasajes en el viaje
                //lo consigo sumando la cantidad de todos los pasajes
                $viaje["cantidad_pasajes"] = array_sum($pasajeDetalles);

                //le guardo la info de los pasajes a viaje
                $viaje["detalle_pasajes"] = $pasajeDetalles;
            }
        }
        //le doy todo eso a la vista para que lo trabaje
        $this->view->ShowViajesInfo($viajes);
    }
}
