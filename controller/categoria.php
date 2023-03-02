<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');
require_once("../config/conexionGestion.php");
require_once("../models/Categoria.php");
$categoria = new Categoria();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case 'user':
        $datos = $categoria->get_informacion_supervisores($_GET["nombre"]);
        http_response_code(200);
        echo json_encode($datos);
        break;
    case 'pull':
        $datos = $_GET["data"];
        $datos = substr($datos, 1);
        $datos = substr($datos, 0, -1);
        $datos = explode(",", $datos);
        $newValuesInsert = [];
        foreach ($datos as $value) {

            $newValue = substr($value, 1, 9);
            switch ($newValue) {
                case 'cedula":"':
                    $cedula = substr($value, 10, -1);
                    array_push($newValuesInsert, $cedula);
                    break;
                case 'operacion':
                    $operacion = substr($value, 13, -1);
                    array_push($newValuesInsert, $operacion);
                    break;
                case 'gestion":':
                    $gestion = substr($value, 11, -1);
                    array_push($newValuesInsert, $gestion);
                    break;
                case 'cobranza"':
                    $cobranza = substr($value, 12, -1);
                    array_push($newValuesInsert, $cobranza);
                    break;
                case 'observaci':
                    $observacion = substr($value, 15, -1);
                    array_push($newValuesInsert, $observacion);
                    break;
                case 'contacto"':
                    $contacto = substr($value, 12, -1);
                    array_push($newValuesInsert, $contacto);
                    break;
                case 'plazoNuev':
                    $plazoNuevo = substr($value, 13);
                    array_push($newValuesInsert, $plazoNuevo);
                    break;
                case 'valorRene':
                    $valorRene = substr($value, 17);
                    array_push($newValuesInsert, $valorRene);
                    break;
                case 'latitud":':
                    $latitud = substr($value, 10, -1);
                    array_push($newValuesInsert, $latitud);
                    break;
                case 'longitud"':
                    $longitud = substr($value, 11, -1);
                    array_push($newValuesInsert, $longitud);
                    break;
                case 'gestor":"':
                    $gestor = substr($value, 10, -1);
                    array_push($newValuesInsert, $gestor);
                    break;
                default:
                    break;
            }
        }
        $enviar = $categoria->insertForm(
            $newValuesInsert[0], $newValuesInsert[1], $newValuesInsert[2], $newValuesInsert[3],
            $newValuesInsert[5], $newValuesInsert[8], $newValuesInsert[9], $newValuesInsert[10], $newValuesInsert[10], $newValuesInsert[4],
            $newValuesInsert[6], $newValuesInsert[7]
        );
        if (!empty($enviar)) {
            http_response_code(200);
            echo json_encode($enviar);
        } else {
            http_response_code(400);
            echo "REGISTRO NO INGRESADO";
        }
        break;
    case 'historial':
        $historial = $categoria->historialXusuario($_GET["nombre"]);
        if (!empty($historial)) {
            http_response_code(200);
            echo json_encode($historial);
        } else {
            http_response_code(400);
            echo "REGISTROS NO ENCONTRADOS";
        }
        break;
}
?>