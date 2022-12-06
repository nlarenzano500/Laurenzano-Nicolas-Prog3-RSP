<?php

class Usuario {
    public $id;
    public $usuario;
    public $clave;
    public $tipo;
    public $nombre;

    public function crearUsuario() {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, clave, tipo, nombre) VALUES (:usuario, :clave, :tipo, :nombre)");

        $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos() {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, clave, tipo, nombre FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($usuario) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, clave, tipo, nombre FROM usuarios WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public function modificarUsuario($idUsuario) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuarios SET usuario = :usuario, clave = :clave, tipo = :tipo, nombre = :nombre WHERE id = :id");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':id', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarUsuario($idUsuario) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();
    }
}