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

require_once("../models/Catalogos.php");
require_once("../utils/Utils.php");

$catalogos = new Catalogos();
$utils = new Utils();

$msgError = "REGISTRO NO INGRESADO";
$msgBadRequest = "BAD REQUEST";


if (!isset($_GET['opcion'])) {
    $utils->returnMessage(400, $msgBadRequest, null);
    return;
}
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        getHandler();
        break;
    default:
        $utils->returnMessage(400, $msgBadRequest, null);
        return;
}


function getHandler()
{
    global $catalogos, $msgBadRequest, $msgError, $utils;

    switch ($_GET["opcion"]) {
        case 'getNombreCatalogo':
            $returnedData = $catalogos->getNombreCatalogo($_GET["codigo"], $_GET["tipo"]);
            break;
        default:
            $utils->returnMessage(400, $msgBadRequest, null);
            return;
    }
    empty($returnedData) ? $utils->returnMessage(400, "ERROR", $msgError) : $utils->returnMessage(200, "OK", $returnedData);
}
?>