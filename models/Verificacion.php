<?php
require_once("../config/conexion.php");
require_once("../utils/dotenv.php");
require_once("../utils/Utils.php");

(new DotEnv('../.env'))->load();

$utils = new Utils();
$proceso = 'Verificacion';

class Verificacion extends Conectar
{
    public function getClientesParaReservar()
    {
        $conectar = parent::conexion();

        $sql = "SELECT * FROM verificaciones_usuarios_tb_pruebas WHERE estado=0 AND verificado=0";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getClientesParaVerificar($nombreGestor)
    {
        $conectar = parent::conexion();
        // $sql = "SELECT * FROM verificaciones_usuarios_tb_pruebas WHERE estado=1 AND verificado=0 AND nombreGestor = '$nombreGestor'";
        $sql = "SELECT * FROM verificaciones_usuarios_tb_pruebas WHERE estado=1 AND verificado=0";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getClientesVerificados($nombreGestor)
    {
        $conectar = parent::conexion();
        $sql = "SELECT * FROM checklist_verifica_domicilio_app_tb WHERE nombreGestor = '$nombreGestor'";
        // $sql = "SELECT * FROM checklist_verifica_domicilio_app_tb";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getClienteVerificadoId($cedula)
    {
        $conectar = parent::conexion();
        $sql = "SELECT * FROM checklistverificadomicilio_tb WHERE cedulaCliente='$cedula'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function setClienteReservado($cedula, $nombreGestor)
    {
        $conectar = parent::conexion();
        // $sql = "UPDATE verificaciones_usuarios_tb_pruebas SET estado='1', nombre_gestor='$nombreGestor' WHERE vf_cedula_cliente='$cedula'";
        $sql = "UPDATE verificaciones_usuarios_tb_pruebas SET estado='1' WHERE vf_cedula_cliente='$cedula'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "SELECT ROW_COUNT()";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function setClienteVerificado($jsonBody)
    {
        global $utils, $proceso;

        $conectar = parent::conexion();
        $imageName = $jsonBody->cedulaCliente;
        $params = $utils->filterEntries($jsonBody);

        $dbParams = $utils->exportImagesFromParams(
            $params,
            $imageName,
            $proceso,
            $jsonBody->nombreCliente
        );



        $sql = "UPDATE verificaciones_usuarios_tb_pruebas SET verificado='1' WHERE vf_cedula_cliente= $jsonBody->cedulaCliente";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "CALL proc_insert_checklist_verifica_domicilio_app (
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?
        )";

        $sql = $conectar->prepare($sql);

        $i = 1;
        foreach ($dbParams as $key => $value) {
            $sql->bindValue($i++, $value);
        }

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enviarSMS($number)
    {
        global $utils;

        $code = $utils->randomSmsCode();
        $number = "593" . substr($number, 1);
        // $number = "593969838598";

        // echo $number;
        return;
        $urlParams = array(
            'username' => getenv('SMS_USERNAME'),
            'mensajeid' => getenv('SMS_MSGID'),
            'telefono' => $number,
            'tipo' => getenv('SMS_TIPO'),
            'datos' => $code,
        );
        $urlParams = http_build_query($urlParams);

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('SMS_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $urlParams,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . getenv('SMS_URL_AUTH'),
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
?>