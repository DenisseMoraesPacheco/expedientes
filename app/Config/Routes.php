<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta principal
$routes->get('/', 'Home::index');

// Grupo USUARIOS
$routes->group('usuarios', function ($routes) {
    // =========================
    // CONSULTAS (GET)
    // =========================
    $routes->get('editarUsuario/(:num)', 'UsuariosController::editarUsuario/$1');
    $routes->post('actualizar/(:num)', 'UsuariosController::actualizar/$1');
    $routes->get('obtenerUsuario/(:num)', 'UsuariosController::obtenerUsuario/$1');
    $routes->get('crearUsuarios', 'UsuariosController::crearUsuarios');
    $routes->get('listar', 'UsuariosController::listar');
    $routes->get('obtenerProveedores', 'UsuariosController::obtenerProveedores');
    $routes->get('verUsuarios', 'UsuariosController::listar');
    $routes->get('obtenerUsuarios', 'UsuariosController::obtenerUsuarios');
    $routes->get('obtenerUsuariosConRol', 'UsuariosController::obtenerUsuariosConRol');
    $routes->post('cambiarEstado/(:num)', 'UsuariosController::cambiarEstado/$1');
    $routes->post('crearProveedorTemporal', 'UsuariosController::crearProveedorTemporal');
});

$routes->group('admin', function ($routes) {
    $routes->post('guardar', 'AdminController::guardar');
    $routes->get('crearUsuarios', 'UsuariosController::crearUsuarios');
    $routes->get('usuarios', 'UsuariosController::listar');
});
$routes->group('areas', function ($routes) {
    $routes->get('obtenerAreas', 'AreasController::obtenerAreas');

});

$routes->group('unidades', function ($routes) {
    $routes->get('obtenerUnidadesMedida', 'UnidadesController::obtenerUnidadesMedida');

});
$routes->group('catalogo', function ($routes) { //alias o nombre que recibe el controlador
    $routes->get('obtenerCatalogo', 'CatalogoController::obtenerCatalogo');

});
$routes->group('descripcionCatalogo', function ($routes) { //alias o nombre que recibe el controlador
    $routes->get('obtenerDescripcionCatalogo/(:num)', 'DescripcionCatalogoController::obtenerDescripcionCatalogo/$1');

});

// Portal de Procesos
$routes->group('portalProcesos', function ($routes) {
    $routes->get('procesos', 'PortalProcesosController::procesos');
    $routes->get('obtenerEstudiosFinalizados', 'PortalProcesosController::obtenerEstudiosFinalizados');
    $routes->get('obtenerProcesos', 'PortalProcesosController::obtenerProcesos');
    $routes->get('obtenerProceso/(:num)', 'PortalProcesosController::obtenerProceso/$1');
    $routes->get('descargarDocumento/(:num)', 'PortalProcesosController::descargarDocumento/$1');
    $routes->post('guardar', 'PortalProcesosController::guardar');
    $routes->post('actualizar/(:num)', 'PortalProcesosController::actualizar/$1');
    $routes->post('guardarEstudioMercado', 'PortalProcesosController::guardarEstudioMercado');
    $routes->get('verProcesos/(:num)', 'PortalProcesosController::verProcesos/$1');
    $routes->delete('eliminar/(:num)', 'PortalProcesosController::eliminar/$1');
    $routes->post('cambiarEstado/(:num)', 'PortalProcesosController::cambiarEstado/$1');
    $routes->post('guardarProceso', 'PortalProcesosController::guardarProceso');
    $routes->get('verEstudioMercado/(:num)', 'PortalProcesosController::verEstudioMercado/$1');
    $routes->get('obtenerEstudioMercadoPorId/(:num)', 'PortalProcesosController::obtenerEstudioMercadoPorId/$1');
});

$routes->group('procesosInternos', function ($routes) {
    $routes->get('crearProcesos/(:num)', 'ProcesosInternosController::crearProcesos/$1');
    $routes->get('getProcesosById/(:num)', 'ProcesosInternosController::getProcesosById/$1');
    $routes->get('procesos', 'ProcesosInternosController::procesos');
    $routes->get('crearProceso', 'ProcesosInternosController::crearProceso');
    $routes->get('verProcesosFinalizados/(:num)', 'ProcesosInternosController::verProcesosFinalizados/$1');
    $routes->get('verDocumentosFinalizados/(:num)', 'ProcesosInternosController::verDocumentosFinalizados/$1');
    $routes->get('crearDocumento/(:num)', 'ProcesosInternosController::crearDocumento/$1');
    $routes->get('getProcesos', 'ProcesosInternosController::getProcesos');
    $routes->get('adjudicacionDirecta', 'ProcesosInternosController::adjudicacionDirecta');
    $routes->get('licitacionPublica', 'ProcesosInternosController::licitacionPublica');
    $routes->get('invitacionRestringida', 'ProcesosInternosController::invitacionRestringida');
});
