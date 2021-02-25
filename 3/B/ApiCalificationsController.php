<?php
require_once 'ApiController.php';

class ApiCommentController extends ApiController
{

    private $userModel;

    function __construct()
    {
        $this->model = new Model();

        parent::__construct();
        $this->view = new APIView();
    }



    //nota: voy a estar creando $obj para devolver mensajes ya que la View solo acepta objetos.





    //El endpoint seria: 

    //GET api/viaje/{id del viaje}/puntaje

    function getCalificaciones($params = null)
    {

        if ($params != null) {
            $id = $params[":ID"];
            $calificaciones = $this->model->getPuntuacionDeViaje($id);

            if (!empty($calificaciones)) {
                $this->view->response($calificaciones, 200);
                die();
            } else {
                $obj = (object) array('message' => "El viaje no posee calificaciones");
                $this->view->response($obj, 404);
                die();
            }
        } else {
            $obj = (object) array('message' => "El viaje no existe");
            $this->view->response($obj, 404);
            die();
        }
    }


    //el endpoint seria: 

    //DELETE api/viaje/{id del viaje}/puntaje/{id de la calificacion}

    function deleteCalificacion($params = null)
    {

        if ($params != null) {
            $id = $params[":ID"];
            $confirmacion = $this->model->deletePuntuacion($id);

            if ($confirmacion != 0) {
                $obj = (object) array('message' => "La calificacion con ID: " + $id + " ha sido eliminada correctamente");
                $this->view->response($obj, 200);
                die();
            } else {
                $obj = (object) array('message' => "La calificacion con ID: " + $id + " no se ha podido borrar");
                $this->view->response($obj, 500);
                die();
            }
        } else {
            $obj = (object) array('message' => "La calificaion no existe");
            $this->view->response($obj, 404);
            die();
        }
    }


    //el endpoint seria: 

    //PUT  api/viaje/{id del viaje}/puntaje/

    function agregarCalificacion()
    {
        $body = $this->getData();

        if (!empty($body)) {
                                                //hipoteticamente esto compondria un comentario
           $obj_creado = $this->model->agregarPuntuacion($body->usuario, $body->calificacion, $body->text);

           //objecto creado es el comentario ya albergado en la db más su id unica.
           if (!empty($obj_creado)) {

            $this->view->response($obj_creado, 200);
            die();

           } else {
            $obj = (object) array('message' => "No se ha podido crear la calificacion");
            $this->view->response($obj, 500);
            die();
           }

        } else {
            $obj = (object) array('message' => "No se ha dado una calificacion");
            $this->view->response($obj, 404);
            die();
        }
    }
}
