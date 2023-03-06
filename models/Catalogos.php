<?php
require_once("../config/conexion.php");


class Catalogos extends Conectar
{
    public function getNombreCatalogo($codigo, $tipo)
    {

        $conectar = parent::conexion();

        $sql = "CALL proc_get_nombre_catalogo (?,?)";
        $sql = $conectar->prepare($sql);

        $i = 1;

        $sql->bindValue($i++, $codigo);
        $sql->bindValue($i++, $tipo);

        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
?>