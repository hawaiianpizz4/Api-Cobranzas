<?php
// Allow from any origin
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

require_once("../models/Refinanciamiento.php");
require_once("../utils/Utils.php");

$refinanciamiento = new Refinanciamiento();
$utils = new Utils();

$msgError = "REGISTRO NO INGRESADO";
$msgBadRequest = "BAD REQUEST";

$jsonBody = json_decode(file_get_contents("php://input"));




if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('Content-Type: application/json');
    http_response_code(200);
    exit;
}




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
    global $refinanciamiento, $msgBadRequest, $jsonBody, $msgError, $utils;

    if ($_GET["opcion"] == 'postDatosRefi') {
        $returnedData = postDatosRefi();
    } else {
        $utils->returnMessage(400, $msgBadRequest, null);
        return;
    }
    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);
}

function getHandler()
{
    global $refinanciamiento, $msgBadRequest, $msgError, $utils;

    switch ($_GET["opcion"]) {
        case 'getClientesId':
            $returnedData = $refinanciamiento->getDatosMinaCliente($_GET["id"]);
            break;
        case 'getHistorial':
            $returnedData = $refinanciamiento->getHistorialUsuario($_GET["nombre"]);
            break;
        default:
            $utils->returnMessage(400, $msgBadRequest, null);
            return;
    }
    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);
}

function postDatosRefi()
{
    global $jsonBody, $refinanciamiento, $utils, $msgBadRequest;
    if ($jsonBody) {
        return $refinanciamiento->insertRefinanciamiento($jsonBody);
    } else {
        $utils->returnMessage(400, $msgBadRequest, "NO HAY CUERPO DE DATOS");
    }
}
?>