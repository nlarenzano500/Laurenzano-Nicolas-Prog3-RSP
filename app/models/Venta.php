<?php

class Venta {
    public $id;
    public $nombreCripto;
    public $usuario;
    public $fecha;
    public $cantidad;
    public $precio;
    public $foto;

    public function crear() {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventas (nombreCripto, usuario, fecha, cantidad, precio, foto) VALUES (:nombreCripto, :usuario, :fecha, :cantidad, :precio, :foto)");

        $consulta->bindValue(':nombreCripto', $this->nombreCripto, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $this->GuardarImagen();
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    private function GuardarImagen() {

        $separador = "_";
        $usuario = $this->usuario;
        $usuarioTemp = strstr($usuario, "@", true);
        if ($usuarioTemp != "")
            $usuario = $usuarioTemp;

        $extension = "." . pathinfo($_FILES["foto"]["name"])['extension'];
        $nombre_archivo = $this->nombreCripto.$separador.$usuario.$separador.$this->fecha.$extension;

        $destino = "FotosCripto/".$nombre_archivo;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        $this->foto = $nombre_archivo;
    }

    public static function obtenerTodosNacionalidad($nacionalidad, $inicio, $fin) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreCripto, usuario, fecha, cantidad, precio, foto FROM ventas WHERE nacionalidad = :nacionalidad AND fecha >= :inicio AND fecha <= :fin");


        // $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreCripto, usuario, fecha, cantidad, precio, foto FROM ventas WHERE nacionalidad = :nacionalidad AND fecha >= :inicio AND fecha <= :fin");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':inicio', $inicio, PDO::PARAM_STR);
        $consulta->bindValue(':fin', $fin, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }




}