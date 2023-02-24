<?php
class Conectar
{
    protected $dbh;
    protected function Conexion()
    {
        try {
            $conectar = $this->dbh = new PDO("mysql:host=210.17.1.36;port=3317;dbname=gestion_terreno", "cargaBI", "%@3*ay4U");
            return $conectar;
        } catch (Exception $e) {
            print "!Error BD ICESA! : " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public function set_names()
    {
        return $this->dbh->query("Set Names 'utf8'");
    }
}
?>