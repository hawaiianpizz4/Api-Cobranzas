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

        case 'setClienteReservado':
            $returnedData = $verificacion->setClienteReservado($_GET["cedula"], $_GET["nombreGestor"]);
            break;
        case 'setClienteVerificado':
            $returnedData = setClienteVerificado();
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

        case 'getClientesParaReservar':
            $returnedData = $verificacion->getClientesParaReservar();
            break;
        case 'getClientesParaVerificar':
            $returnedData = $verificacion->getClientesParaVerificar($_GET["nombreGestor"]);
            break;
        case 'getClientesVerificados':
            $returnedData = $verificacion->getClientesVerificados($_GET["nombreGestor"]);
            break;
        case 'getSmsCode':
            $returnedData = $verificacion->enviarSMS($_GET["number"]);
            break;
        default:
            $utils->returnMessage(400, $msgBadRequest, null);
            break;
    }
    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);
}

function setClienteVerificado()
{
    global $jsonBody, $verificacion, $utils, $msgBadRequest;
    if ($jsonBody) {
        return $verificacion->setClienteVerificado($jsonBody);
    } else {
        $utils->returnMessage(400, $msgBadRequest, "NO HAY CUERPO DE DATOS");
    }
}

?>