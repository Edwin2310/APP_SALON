<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    //Funcion para loguearse
    public static function login(Router $router)
    {
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();



            if (empty($alertas)) {
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    //Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        //Autenticar el Usuario

                        if (!$_SESSION) {
                            session_start();
                        }

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento

                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }


    //Funcion para desloguearse
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }




    //Funcion Creada Cuando el Usuario Olvide su Contraseña
    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            //Verificar que el usuario exista y este confirmado
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado === "1") {

                    //Generar Token
                    $usuario->crearToken();
                    $usuario->guardar(); //Actualizar Datos

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();


                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');
                } else {
                    //Alerta de error
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas

        ]);
    }


    //Funcion para Recuperar Contraseña
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;

        $token = S($_GET['token']); //Sanitizamos el TOKEN

        //Buscar usuario por su TOKEN
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no Valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();


            if (empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }



    //Funcion para Crear Usuario
    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que las alertas esten vacias
            if (empty($alertas)) {

                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el Password
                    $usuario->hashPassword();

                    //Generar un Token unico
                    $usuario->crearToken();

                    //Enviar el E-Mail
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el Usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje'); //Redireccionamos a la pagina mensaje en auth
                    }
                }
            }
        }


        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    //Funcion MENSAJE
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }


    //Funcion para Confirmar Cuenta
    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']); //Sanitizamos el TOKEN

        //Buscar usuario por su TOKEN
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            //Mostrar mensajes de error
            Usuario::setAlerta('error', 'Token No Valido');
        } else {
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        //Obtener Alertas
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
