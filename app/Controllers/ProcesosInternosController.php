<?php

namespace App\Controllers;

use App\Models\ProcesoModel;
class ProcesosInternosController extends BaseController
{

    public function crearProceso()
    {
        return view("procesosInternos/crearProceso");
    }

    public function verDocumentosFinalizados($id)
    {
        if ($id == 1) {
            return view("portalProcesos/estudioMercadoFinalizado");
        } elseif ($id == 2) {
            return view("portalProcesos/anexoPropuesta");
        }
    }
    public function crearProcesos($id)
    {

        return view("procesosInternos/crearProceso", [
            'id' => $id

        ]);
    }

    public function getProcesosById($id = null)
    {

        $model = new ProcesoModel();

        $data = $model->obtenerDocumentosPorProceso($id);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function verProcesosFinalizados($id)
    {
        return view("procesosInternos/verProceso", [
            'id' => $id

        ]);

    }
    // Vista principal del portal de procesos (tarjetas)
    public function procesos()
    {
        return view("portalProcesos/portalProcesos");
    }
    public function getProcesos()
    {
        $procesosModel = new ProcesoModel(); //conozco a la tabla donde obtendre mis datos
        $procesos = $procesosModel->findAll(); // mando a llamar mi variable que ya conoce esos datos

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $procesos
        ]);

    }
    public function crearDocumento($id)
    {
        if ($id == 1) {
            return view("portalProcesos/crearDocumento");
        } elseif ($id == 2) {
            return view("portalProcesos/anexoPropuesta");
        }
    }

    public function adjudicacionDirecta()
    {

    }

    public function licitacionPublica()
    {
    }


    public function invitacionRestringida()
    {

    }
}