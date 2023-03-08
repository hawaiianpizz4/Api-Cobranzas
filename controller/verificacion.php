<?php
if (isset($_SERVER["HTTP_ORIGIN"])) {
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600"); // cache for 10 minutes

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}

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
            $returnedData = $verificacion->setClienteReservado($_GET["cedula"], $_GET["nombreGestor"], $_GET["longitud"], $_GET["latitud"]);
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