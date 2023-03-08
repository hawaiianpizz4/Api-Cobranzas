<?php
require_once("../utils/dotenv.php");
(new DotEnv('../.env'))->load();
class Conectar
{
    protected $dbh;
    protected function conexion()
    {
        $databaseDns = getenv('DATABASE_DNS');
        $databaseUser = getenv('DATABASE_USER');
        $databasePass = getenv('DATABASE_PASSWORD');

        try {


            $conectar = $this->dbh = new PDO($databaseDns, $databaseUser, $databasePass);
            $conectar->exec("SET NAMES utf8");

            return $conectar;
        } catch (Exception $e) {
            echo "!Error de conexión ! : " . $e->getMessage();
            die();
        }
    }
    public function setNames()
    {
        return $this->dbh->query("Set Names 'utf8mb4'");
    }
}
?>