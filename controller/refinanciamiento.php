<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once("../models/Refinanciamiento.php");

$refinanciamiento = new Refinanciamiento();

$msgError = "REGISTRO NO INGRESADO";
$msgBadRequest = "ERROR EN REQUEST";

$jsonBody = json_decode(file_get_contents("php://input"));

if (!isset($_GET['opcion'])) {
    http_response_code(400);
    echo $msgBadRequest;
    return;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET["opcion"]) {
            case 'getClientesId':
                $returnedData = $refinanciamiento->get_info_cliente($_GET["id"]);
                break;
            case 'getClientes':
                $returnedData = $refinanciamiento->get_info_clientes();
                break;
            default:
                http_response_code(400);
                echo $msgBadRequest;
                return;
        }
        if (!empty($returnedData)) {
            http_response_code(200);
            echo json_encode($returnedData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400);
            echo "REGISTRO NO INGRESADO";
        }
    case 'POST':
        switch ($_GET["opcion"]) {
            case 'postDatosRefi':
                if ($jsonBody) {
                    $returnedData = $refinanciamiento->set_insertFormRefi($jsonBody);
                } else {
                    echo "Error, no hay cuerpo de datos";
                }
                break;
            default:
                http_response_code(400);
                echo $msgBadRequest;
                return;
        }

        if (!empty($returnedData)) {
            http_response_code(200);
            echo json_encode($returnedData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400);
            echo $msgError;
        }
}

?>