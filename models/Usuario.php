<?php

namespace Model;

class Usuario extends ActiveRecord
{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }


    //Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre Es Obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido Es Obligatorio';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Telefono Es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email Es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password Es Obligatorio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }


        return self::$alertas;
    }

    //Mensajes de validacion para el Login

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }


    //Validar E-Mail 
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        return self::$alertas;
    }

    //Validar Password
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }









    //Validando que exista el usuario
    public function existeUsuario()
    {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);


        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }
        return $resultado;
    }


    //Encriptando la contraseña
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    //Creando el Token
    public function crearToken()
    {
        $this->token = uniqid(); //Funcion que retorna 13 caracteres
    }


    //Validar que la Contraseña este correcta y el Usuario este confirmado
    public function comprobarPasswordAndVerificado($password)
    {
        $resultado = password_verify($password, $this->password);

        //If para confirmar si existe la contraseña o su esta confirmada la cuenta con 1
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o Cuenta no confirmada';
        } else {
            return true;
        }
    }
}
