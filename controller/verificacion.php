<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once("../models/Verificacion.php");
require_once("../utils/Utils.php");

$verificacion = new Verificacion();
$utils = new Utils();

$msgError = "REGISTRO NO INGRESADO";
$msgBadRequest = "BAD REQUEST";

$jsonBody = json_decode(file_get_contents("php://input"));

if (!isset($_GET['opcion'])) {
    $utils->returnMessage(400, $msgBadRequest, null);
    return;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        getHandler();
        break;
    case 'POST':
        postHandler();
        break;
    default:
        $utils->returnMessage(400, $msgBadRequest, null);
        return;
}

function postHandler()
{
    global $verificacion, $msgBadRequest, $jsonBody, $msgError, $utils;
    switch ($_GET["opcion"]) {
        case 'insertVer':
            $returnedData = postDatosVeri();
            break;
        case 'reservarVerificacionUser':
            if ($cedula = isset($_GET["cedula"]) && $_GET["nombreGestor"]) {
                $cedula = ($_GET["cedula"]);
                $nombreGestor = ($_GET["nombreGestor"]);
                $consult = $verificacion->reservarVerificacionUser($cedula, $nombreGestor);
                http_response_code(200);
                echo json_encode(array("status" => "OK", "message" => "Usuario actualizado correctamente"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error en la peticion"));
            }
            break;
        default:
            $utils->returnMessage(400, $msgBadRequest, null);
            return;
    }

    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);
}



function getHandler()
{
    global $verificacion, $msgBadRequest, $msgError, $utils;
    switch ($_GET["opcion"]) {

        case 'getUsersParaReservar':
            $returnedData = $verificacion->get_usgetUsersParaReservarer();
            break;

        case 'getUsersVerificados':
            $returnedData = $verificacion->getUsersVerificados($_GET["nombreGestor"]);
            break;
        case 'send':
            $returnedData = $verificacion->enviarSMS($_GET["number"]);
            break;

        default:
            $utils->returnMessage(400, $msgBadRequest, null);
            break;
    }
    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);

}

function postDatosVeri()
{
    global $jsonBody, $verificacion, $utils, $msgBadRequest;
    if ($jsonBody) {
        return $verificacion->set_insertFormVerificacion($jsonBody);
    } else {
        $utils->returnMessage(400, $msgBadRequest, "NO HAY CUERPO DE DATOS");
    }
}



?>