<?php
require_once("../utils/dotenv.php");
(new DotEnv('../.env'))->load();
class Conectar
{
    protected $dbh;
    protected function conexion()
    {
        $databaseDns = getenv('DATABASE_DNS_GEST');
        $databaseUser = getenv('DATABASE_USER_GEST');
        $databasePass = getenv('DATABASE_PASSWORD_GEST');

        try {
            $conectar = $this->dbh = new PDO($databaseDns, $databaseUser, $databasePass);
            $this->set_names();
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