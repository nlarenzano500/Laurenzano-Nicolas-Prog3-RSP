<?php

class Cripto {
    public $id;
    public $precio;
    public $nombre;
    public $foto;
    public $nacionalidad;

    public function crear() {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cripto (precio, nombre, foto, nacionalidad) VALUES (:precio, :nombre, :foto, :nacionalidad)");

        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $this->GuardarImagen();
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    private function GuardarImagen() {

        $separador = "_";
        $extension = "." . pathinfo($_FILES["foto"]["name"])['extension'];

        $nombre_archivo = $this->nacionalidad.$separador.$this->nombre.$extension;
        $destino = "Imagenes/".$nombre_archivo;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        $this->foto = $nombre_archivo;
    }

    public static function obtenerTodos() {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, foto, nacionalidad FROM cripto");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cripto');
    }

    public static function obtenerTodosFiltro($clave) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, foto, nacionalidad FROM cripto WHERE nacionalidad = :clave");
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cripto');
    }
    
    public static function obtenerUno($id) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio, nombre, foto, nacionalidad FROM cripto WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cripto');
    }




}