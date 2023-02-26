<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once("../models/Refinanciamiento.php");
require_once("../utils/Utils.php");

$refinanciamiento = new Refinanciamiento();
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
        case 'getClientes':
            $returnedData = $refinanciamiento->getDatosMinaClientes();
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