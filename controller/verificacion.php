<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');
// require_once("../config/conexionTest.php");

require_once("../models/Verificacion.php");
$Verificacion = new Verificacion();

$body = json_decode(file_get_contents("php://input"));

switch ($_GET["op"]) {
    case 'insertVer':

        if ($body) {

            $datos = $Verificacion->set_insertFormVerificacion($body);

            if (!empty($datos)) {
                http_response_code(200);
                echo json_encode($datos);
            } else {
                http_response_code(400);
                echo "REGISTRO NO INGRESADO";
            }
        } else {
            echo "Error, no hay cuerpo de datos";
        }
        break;
}



?>