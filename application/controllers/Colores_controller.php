<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
 
class Colores_controller extends REST_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->model('Colores_model','colores');
	}
 
    public function obtenerTodos_get() {
        $result = $this->colores->getAll();
        if (@$result['status'] === false)
            $this->response($result);
        else if ($result) {
            $this->response(formatResponse($result));
        } else {
            $this->response(formatResponse(false, "No se encontraron resultados."));            
        }
    }

    public function obtenerPorId_get() {
        $idColor = $this->get('idColor');	
        $result = $this->colores->getById($idColor);
        if (@$result['status'] === false)
            $this->response($result);
        else if ($result) {
            $this->response(formatResponse($result));
        } else {
            $this->response(formatResponse(false, "No se encontraron resultados."));            
        }
    }

    public function obtenerPorModelo_get() {
        $idModeloVehiculo = $this->get('idModeloVehiculo');

        $result = $this->colores->getByModel($idModeloVehiculo);
        if (@$result['status'] === false)
            $this->response($result);
        else if ($result) {
            $this->response(formatResponse($result));
        } else {
            $this->response(formatResponse(false, "No se encontraron resultados."));           
        }
    }

    public function nuevaRelacionModeloColor_post() {
        $idModeloVehiculo = $this->post('idModeloVehiculo');
        $idColor = $this->post('idColor');

        $requiredArray = ['idModeloVehiculo', 'idColor'];
        $validate = validateRequired($this->post(),$requiredArray);
        if(!@$validate['status'])
            $this->response(formatResponse(false,'Parámetros requeridos: '.implode(', ',$validate['error'])));
        $result = $this->colores->insertRelModeloColor($idModeloVehiculo, $idColor);
        if (@$result['status'] === false)
            $this->response($result);
        else
            $this->response(formatResponse($result));
    }

    public function nuevo_post() {
        $color = $this->post();
        $requiredArray = ['color'];
        $validate = validateRequired($color,$requiredArray);
        if(!@$validate['status'])
            $this->response(formatResponse(false,'Parámetros requeridos: '.implode(', ',$validate['error'])));
        $result = $this->colores->insert($color);
        if (@$result['status'] === false)
            $this->response($result);
        else
            $this->response(formatResponse($result));
    }

    public function editar_put() {
        $idColor = $this->get('idColor');	
        $color = $this->put();
        $requiredArray = ['color'];
        $validate = validateRequired($color,$requiredArray);
        if (!@$validate['status'])
            $this->response(formatResponse(false,'Parámetros requeridos: '.implode(', ',$validate['error'])));
        $result = $this->colores->updateById($idColor, $color);
        if (@$result['status'] === false)
            $this->response($result);
        else
            $this->response(formatResponse($result));
    }

    public function eliminarPorModelo_delete() {
        $idColor = $this->get('idColor');
        $idModeloVehiculo = $this->get('idModeloVehiculo');

        $result = $this->colores->deleteByModel($idColor, $idModeloVehiculo);
        if (@$result['status'] === false)
            $this->response($result);
        else
            $this->response(formatResponse($result));
    }
}