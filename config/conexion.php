<?php

require_once("../utils/dotenv.php");
(new DotEnv('../.env'))->load();

class Conectar
{
    protected $dbh;
    protected function Conexion()
    {
        // dev
        $databaseDns = getenv('DATABASE_DNS');
        $databaseUser = getenv('DATABASE_USER');
        $databasePass = getenv('DATABASE_PASSWORD');

        try {
            $conectar = $this->dbh = new PDO($databaseDns, $databaseUser, $databasePass);
            $this->set_names();
            return $conectar;
        } catch (Exception $e) {
            echo "!Error de conexión ! : " . $e->getMessage();
            die();
        }
    }
    public function set_names()
    {
        return $this->dbh->query("Set Names 'utf8'");
    }
}
?>