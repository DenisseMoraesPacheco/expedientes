<?php

namespace App\Controllers;

use App\Models\CostosTotalesModel;
use App\Models\DescripcionEstudioMercado;
use App\Models\EstudioMercadoModel;
use App\Models\ProcesoModel;
use App\Models\DocumentosProcesosModel;
use App\Models\NombreRazonSocialModel;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class PortalProcesosController extends BaseController
{
    public function guardarProceso()
    {
        try {

            $db = \Config\Database::connect();
            $data = $this->request->getJSON(true);
            var_dump($data);
            exit();
            if (!$data) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'No se recibieron datos'
                ]);
            }

            // =========================
            // VALIDACIONES BÁSICAS
            // =========================
            if (empty($data['id_area']) || empty($data['catalogo']) || empty($data['nomb_procedimiento'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'Faltan datos obligatorios'
                ]);
            }

            // =========================
            // INICIAR TRANSACCIÓN
            // =========================
            $db->transBegin();

            // =========================
            // 1. GUARDAR PROCESO
            // =========================
            $proceso = [
                'nombre_estudio' => $data['nomb_procedimiento'],
                'fk_area' => $data['id_area'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $db->table('estudio_mercado')->insert($proceso);
            $id_proceso = $db->insertID();

            if (!$id_proceso) {
                throw new \Exception('No se pudo crear el proceso');
            }
            $nombre_razon = [
                'fk_descripcion_estudio_mercado' => $data['id_estudio'],
                'fk_proveedor' => $data['proveedor'],
                'precio_unitario' => $data['precio'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $db->table('estudio_mercado')->insert($proceso);
            $id_proceso = $db->insertID();

            if (!$id_proceso) {
                throw new \Exception('No se pudo crear el proceso');
            }

            // =========================
            // 2. GUARDAR PUNTOS
            // =========================
            if (!empty($data['puntos'])) {
                foreach ($data['puntos'] as $punto) {

                    if (trim($punto) === '')
                        continue;

                    $db->table('puntos')->insert([
                        'id_proceso' => $id_proceso,
                        'descripcion' => $punto
                    ]);
                }
            }

            // =========================
            // 3. PRODUCTOS
            // =========================
            if (!empty($data['productos'])) {

                foreach ($data['productos'] as $producto) {

                    // Validación básica
                    if (empty($producto['id_producto']))
                        continue;

                    $db->table('proceso_productos')->insert([
                        'id_proceso' => $id_proceso,
                        'id_producto' => $producto['id_producto'],
                        'cantidad' => $producto['cantidad'] ?? 0
                    ]);

                    // =========================
                    // 4. PRECIOS POR PROVEEDOR
                    // =========================
                    if (!empty($producto['precios'])) {

                        foreach ($producto['precios'] as $precio) {

                            // Evitar precios vacíos
                            if (empty($precio['precio']))
                                continue;

                            $db->table('proceso_precios')->insert([
                                'id_proceso' => $id_proceso,
                                'id_producto' => $producto['id_producto'],
                                'id_proveedor' => $precio['proveedor'],
                                'precio' => $precio['precio']
                            ]);
                        }
                    }
                }
            }

            // =========================
            // FINALIZAR TRANSACCIÓN
            // =========================
            if ($db->transStatus() === false) {
                $db->transRollback();

                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'Error en la transacción'
                ]);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'id_proceso' => $id_proceso
            ]);

        } catch (\Throwable $e) {

            if (isset($db)) {
                $db->transRollback();
            }

            return $this->response->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function verEstudioMercado($idEstudio)
    {
        return view("portalProcesos/verEstudioMercado");
    }

    // CONTROLADOR

    public function obtenerEstudioMercadoPorId($id)
    {
        try {

            $model = new EstudioMercadoModel();
            $data = $model->getEstudioById($id);

            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function obtenerEstudiosFinalizados()
    {
        try {

            $model = new EstudioMercadoModel();
            $data = $model->obtenerEstudiosFinalizados();

            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function guardarEstudioMercado()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!$data) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No llegaron datos'
            ]);
        }

        try {

            // =========================
            // TABLA PRINCIPAL
            // =========================

            $estudioMercadoModel = new EstudioMercadoModel();

            $estudioMercadoModel->insert([

                'nombre_estudio' => $data['nomb_procedimiento'],

                'fk_area' => $data['id_area'],

                'fecha' => date('Y-m-d')

            ]);

            $idEstudio = $estudioMercadoModel->insertID();

            // =========================
            // DETALLE DE DESCRIPCIONES
            // =========================

            $descripcionModel = new DescripcionEstudioMercado();
            $idsDescripcion = [];

            foreach ($data['productos'] as $index => $producto) {

                $descripcionModel->insert([
                    'fk_estudio_mercado' => $idEstudio,
                    'partida' => $index + 1,
                    'cantidad' =>  $producto['cantidad'],
                    'fk_descripcion_catalogo' => $producto['id_producto']
                ]);

                $idsDescripcion[$index] = $descripcionModel->insertID();
            }

            // =========================
            // TABLA RAZÓN SOCIAL
            // =========================

            $razonSocialModel = new NombreRazonSocialModel();
            $costosTotales = new CostosTotalesModel();

            $idsRazonSocial = [];

            $razonSocialModel = new NombreRazonSocialModel();

            foreach ($data['productos'] as $index => $producto) {

                $idDescripcion = $idsDescripcion[$index];

                foreach ($producto['precios'] as $detalle) {

                    $razonSocialModel->insert([

                        'fk_descripcion_estudio_mercado' => $idDescripcion,

                        'fk_proveedor' => $detalle['proveedor'],

                        'precio_unitario' => $detalle['precio'],

                        'precio_total' => $detalle['total_producto'],

                        'marca_modelo' => $detalle['marca_modelo']

                    ]);

                    $idRazonSocial = $razonSocialModel->insertID();

                    // GUARDAR ID POR PROVEEDOR
                    $idsRazonSocial[$detalle['proveedor']] = $idRazonSocial;

                }
            }
            // =========================
// TABLA COSTOS TOTALES
// =========================

            $costosTotales = new CostosTotalesModel();

            foreach ($data['totales'] as $totalProveedor) {

                $subtotal = str_replace(['$', ','], '', $totalProveedor['subtotal']);

                $iva = str_replace(['$', ','], '', $totalProveedor['iva']);

                $total = str_replace(['$', ','], '', $totalProveedor['total']);

                $costosTotales->insert([

                    'fk_nombre_razon_social' =>
                        $idsRazonSocial[$totalProveedor['proveedor']],

                    'subtotal' => $subtotal,

                    'iva' => $iva,

                    'total' => $total

                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Estudio guardado correctamente'
            ]);

        } catch (\Exception $e) {

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function descargarDocumento($id_documento)
    {
        $model = new DocumentosProcesosModel();
        $documento = $model->find($id_documento);

        // ✅ Validar si existe el documento en BD
        if (!$documento) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Documento no encontrado'
            ]);
        }

        // ✅ Usar $documento, no $id_documento
        $rutaArchivo = ROOTPATH . ltrim($documento['ruta_documento'], '/');

        if (!file_exists($rutaArchivo)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Archivo no encontrado',
                'ruta' => $rutaArchivo
            ]);
        }

        $extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);

        return $this->response->download($rutaArchivo, null)
            ->setFileName($documento['nombre_proceso'] . '.' . $extension);
    }

    public function verDocumento($id_documento)
    {
        $model = new DocumentosProcesosModel();
        $documento = $model->find($id_documento);

        if (!$documento) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Documento no encontrado'
            ]);
        }

        $rutaArchivo = ROOTPATH . ltrim($documento['ruta_documento'], '/');

        if (!file_exists($rutaArchivo)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Archivo no encontrado'
            ]);
        }

        // Obtener extensión
        $extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);

        // Detectar tipo MIME
        $mime = mime_content_type($rutaArchivo);

        // 🔥 MOSTRAR EN EL NAVEGADOR (NO DESCARGAR)
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $documento['nombre_proceso'] . '.' . $extension . '"')
            ->setBody(file_get_contents($rutaArchivo));
    }

    public function verProcesos($id_proceso)
    {

        $model = new ProcesoModel();
        $proceso = $model->getProcesoPorID($id_proceso);
        //var_dump($proceso);
        return view('procesosInternos/verProcesos', [
            'procesos' => $proceso
        ]);

    }
    public function procesos()
    {
        return view("portalProcesos/portalProcesos");
    }
    public function obtenerProcesos()
    {
        try {
            $model = new ProcesoModel();
            $procesos = $model->orderBy('id_proceso', 'DESC')->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $procesos
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener procesos: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cargar los procesos'
            ]);
        }
    }

    public function obtenerProceso($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID no especificado'
                ]);
            }

            $model = new ProcesoModel();
            $proceso = $model->find($id);

            if (!$proceso) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Proceso no encontrado'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $proceso
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener proceso: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cargar el proceso'
            ]);
        }
    }

    public function guardar()
    {
        try {
            // Verificar si es petición AJAX
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Petición no válida'
                ]);
            }

            $data = $this->request->getPost();

            // Validar campos requeridos
            if (empty($data['nombre']) || empty($data['clave'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nombre y clave son requeridos'
                ]);
            }

            $model = new ProcesoModel();

            // Verificar si ya existe un proceso con el mismo nombre o clave
            $existeNombre = $model->where('nombre', $data['nombre'])->first();
            if ($existeNombre) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ya existe un proceso con este nombre'
                ]);
            }

            $existeClave = $model->where('clave', $data['clave'])->first();
            if ($existeClave) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ya existe un proceso con esta clave'
                ]);
            }

            $proceso = [
                'nombre' => trim($data['nombre']),
                'clave' => trim($data['clave']),
                'descripcion' => $data['descripcion'] ?? null,
                'activo' => isset($data['activo']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $id = $model->insert($proceso);

            if ($id) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proceso guardado exitosamente',
                    'id_proceso' => $id
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar el proceso'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar proceso: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }

    public function actualizar($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID no especificado'
                ]);
            }

            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Petición no válida'
                ]);
            }

            $data = $this->request->getPost();

            if (empty($data['nombre']) || empty($data['clave'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nombre y clave son requeridos'
                ]);
            }

            $model = new ProcesoModel();

            // Verificar si ya existe otro proceso con el mismo nombre
            $existeNombre = $model->where('nombre', $data['nombre'])
                ->where('id_proceso !=', $id)
                ->first();
            if ($existeNombre) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ya existe otro proceso con este nombre'
                ]);
            }

            // Verificar si ya existe otro proceso con la misma clave
            $existeClave = $model->where('clave', $data['clave'])
                ->where('id_proceso !=', $id)
                ->first();
            if ($existeClave) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ya existe otro proceso con esta clave'
                ]);
            }

            $proceso = [
                'nombre' => trim($data['nombre']),
                'clave' => trim($data['clave']),
                'descripcion' => $data['descripcion'] ?? null,
                'activo' => isset($data['activo']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $model->update($id, $proceso);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proceso actualizado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el proceso'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar proceso: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminar($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID no especificado'
                ]);
            }

            $model = new ProcesoModel();
            $proceso = $model->find($id);

            if (!$proceso) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Proceso no encontrado'
                ]);
            }

            $result = $model->delete($id);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proceso eliminado exitosamente'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al eliminar el proceso'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar proceso: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }

    public function cambiarEstado($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID no especificado'
                ]);
            }

            $data = $this->request->getPost();
            $nuevoEstado = isset($data['activo']) ? (int) $data['activo'] : null;

            if ($nuevoEstado === null || !in_array($nuevoEstado, [0, 1])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Estado no válido'
                ]);
            }

            $model = new ProcesoModel();
            $proceso = $model->find($id);

            if (!$proceso) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Proceso no encontrado'
                ]);
            }

            $result = $model->update($id, [
                'activo' => $nuevoEstado,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $nuevoEstado == 1 ? 'Proceso activado' : 'Proceso desactivado'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al cambiar el estado'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al cambiar estado: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }
}