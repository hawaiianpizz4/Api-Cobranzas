<?php

require_once("../config/conexion.php");
require_once("../utils/dotenv.php");
require_once("../utils/Utils.php");

(new DotEnv('../.env'))->load();

$utils = new Utils();
$proceso = 'Refinanciamiento';
class Refinanciamiento extends Conectar
{
    public function getHistorialUsuario($nombre)
    {
        $conectar = parent::conexion();
        $sql = "SELECT * FROM datos_refinanciamiento_app_tb WHERE refi_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRefinanciamiento($operacion)
    {
        $conectar = parent::conexion();
        $sql = "SELECT id, refi_operacion, cliente_cedula FROM datos_refinanciamiento_app_tb WHERE refi_operacion = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $operacion);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function getDatosMinaCliente($id)
    {
        $data = array("numero_cedula" => $id);
        $dataStr = json_encode($data);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('API_MINA_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $dataStr,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . getenv('API_MINA_BEARER'),
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }


    public function insertRefinanciamiento($jsonBody)
    {
        global $utils, $proceso;

        $conectar = parent::conexion();
        $imageName = $jsonBody->cliente_cedula . '-' . $jsonBody->refi_operacion;
        $params = $utils->filterEntries($jsonBody);

        $dbParams = $utils->exportImagesFromParams(
            $params,
            $imageName,
            $proceso,
            $jsonBody->cliente_nombres
        );

        // echo json_encode($dbParams, JSON_PRETTY_PRINT);

        $sql = "CALL proc_insert_refinanciamiento_app (
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?
        )";

        $sql = $conectar->prepare($sql);

        $i = 1;
        foreach ($dbParams as $key => $value) {
            $sql->bindValue($i++, strtoupper($value));
        }

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>