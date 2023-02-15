<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');
// require_once("../config/conexionTest.php");
require_once("../config/conexion.php");
require_once("../models/Verificacion.php");
$Verificacion = new Verificacion();

$body = json_decode(file_get_contents("php://input"));

switch ($_GET["op"]) {
    case 'insertVer':

        if ($body) {
            $cedulaCliente = filter_var($body->cedulaCliente, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $nombreCliente = filter_var($body->nombreCliente, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $codigoVerificacion = filter_var($body->codigoVerificacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $direccionDomiciliaria = filter_var($body->direccionDomiciliaria, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $tipoVivienda = filter_var($body->tipoVivienda, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $personaQuienRealizaLaVerificacion = filter_var($body->personaQuienRealizaLaVerificacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $residenciaMinimaTresMeses = filter_var($body->residenciaMinimaTresMeses, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $localTerrenoPropio = filter_var($body->localTerrenoPropio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $localTerrenoArrendado = filter_var($body->localTerrenoArrendado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $planillaServicioBasico = filter_var($body->planillaServicioBasico, FILTER_VALIDATE_BOOLEAN);
            $planillaServicioBasicoImagen = $body->planillaServicioBasicoImagen;
            $seguridadPuertasVentanas = filter_var($body->seguridadPuertasVentanas, FILTER_VALIDATE_BOOLEAN);
            $muebleriaBasica = filter_var($body->muebleriaBasica, FILTER_VALIDATE_BOOLEAN);
            $materialCasa = filter_var($body->materialCasa, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $periodicidadActividadesLaborales = filter_var($body->periodicidadActividadesLaborales, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $confirmacionInfoVecinos = filter_var($body->confirmacionInfoVecinos, FILTER_VALIDATE_BOOLEAN);
            $nombreInfoVecino = filter_var($body->nombreInfoVecino, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $celularInfoVecino = filter_var($body->celularInfoVecino, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $estabilidadLaboraSeisMesesImagen = filter_var_array($body->estabilidadLaboraSeisMesesImagen);
            $facturasProveedoresUltimosTresMesesImagen = filter_var_array($body->facturasProveedoresUltimosTresMesesImagen);
            $fachadaDelNegocioImagen = filter_var_array($body->fachadaDelNegocioImagen);
            $interiorDelNegocioImagen = filter_var_array($body->interiorDelNegocioImagen);
            $clienteDentroDelNegocioImagen = filter_var_array($body->clienteDentroDelNegocioImagen);
            $clienteFueraDelNegocioImagen = filter_var_array($body->clienteFueraDelNegocioImagen);
            $tituloPropiedaGaranteOCodeudorImagen = filter_var_array($body->tituloPropiedaGaranteOCodeudorImagen);
            $impuestoPredialImagen = filter_var_array($body->impuestoPredialImagen);
            $respaldoIngresosImagen = filter_var_array($body->respaldoIngresosImagen);
            $certificadoLaboralImagen = filter_var_array($body->certificadoLaboralImagen);
            $interiorDomicilioImagen = filter_var_array($body->interiorDomicilioImagen);
            $latitud = filter_var($body->latitud, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $longitud = filter_var($body->longitud, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $vf_nombre_tienda = filter_var($body->vf_nombre_tienda, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $nombreGestor = filter_var($body->nombreGestor, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

            // $p_imagen_files = filter_var_array($body->imagen_files);
            // $p_imagen_paths = filter_var($body->imagen_paths);
            // echo 'xxxx ' + $p_imagen_files;


            $datos = $Verificacion->set_insertFormVerificacion(
                $cedulaCliente,
                $nombreCliente,
                $codigoVerificacion,
                $direccionDomiciliaria,
                $tipoVivienda,
                $personaQuienRealizaLaVerificacion,
                $residenciaMinimaTresMeses,
                $localTerrenoPropio,
                $localTerrenoArrendado,
                $planillaServicioBasico,
                $planillaServicioBasicoImagen,
                $seguridadPuertasVentanas,
                $muebleriaBasica,
                $materialCasa,
                $periodicidadActividadesLaborales,
                $confirmacionInfoVecinos,
                $nombreInfoVecino,
                $celularInfoVecino,
                $estabilidadLaboraSeisMesesImagen,
                $facturasProveedoresUltimosTresMesesImagen,
                $fachadaDelNegocioImagen,
                $interiorDelNegocioImagen,
                $clienteDentroDelNegocioImagen,
                $clienteFueraDelNegocioImagen,
                $tituloPropiedaGaranteOCodeudorImagen,
                $impuestoPredialImagen,
                $respaldoIngresosImagen,
                $certificadoLaboralImagen,
                $interiorDomicilioImagen,
                $latitud,
                $longitud,
                $vf_nombre_tienda,
                $nombreGestor
            );

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