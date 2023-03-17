<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    //Funcion Del Admin Servicios
    public static function index(Router $router)
    {
        if (!$_SESSION) {
            session_start();
        }

        isAdmin(); //En caso de que no sea admin lo regresa

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    //Funcion Del Admin Crear 
    public static function crear(Router $router)
    {

        if (!$_SESSION) {
            session_start();
        }

        isAdmin(); //En caso de que no sea admin lo regresa

        $servicio = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                //debuguear($servicio);
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    //Funcion Del Admin Actualizar 
    public static function actualizar(Router $router)
    {
        if (!$_SESSION) {
            session_start();
        }

        isAdmin(); //En caso de que no sea admin lo regresa

        if (!is_numeric($_GET['id'])) return; //VALIDANDO EL ID

        $servicio = Servicio::find($_GET['id']); //TRAE EL SERVICIO QUE DESESAMOS EDITAR
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    //Funcion Del Admin Eliminar 
    public static function eliminar()
    {
        if (!$_SESSION) {
            session_start();
        }

        isAdmin(); //En caso de que no sea admin lo regresa


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //debuguear($_POST);
            $id = $_POST['id'];
            $servicio = Servicio::find($id); //Buscando el servicio a eliminar
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}
