<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');



require_once("../models/Verificacion.php");
$Verificacion = new Verificacion();

$body = json_decode(file_get_contents("php://input"));
$msgBadRequest = "ERROR EN REQUEST";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET["opcion"]) {

            case 'getUsersParaReservar':
                $consult = $Verificacion->get_user();
                $rest = empty($consult);
                if ($rest == true) {
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Sin resultados"));
                } else if ($rest == false) {
                    $consult = $Verificacion->get_user();

                    http_response_code(200);
                    print_r(json_encode($consult));
                } else {
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Error en la peticion"));
                }

                break;

            case 'reservarVerificacionUser':
                if ($cedula = isset($_GET["cedula"]) && $_GET["nombreGestor"]) {
                    $cedula = ($_GET["cedula"]);
                    $nombreGestor = ($_GET["nombreGestor"]);
                    $consult = $Verificacion->reservarVerificacionUser($cedula, $nombreGestor);
                    http_response_code(200);
                    echo json_encode(array("status" => "OK", "message" => "Usuario actualizado correctamente"));
                } else {
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Error en la peticion"));
                }
                break;

            case 'getUsersVerificados':
                if ($nombreGestor = isset($_GET["nombreGestor"])) {
                    $nombreGestor = ($_GET["nombreGestor"]);
                    $consult = $Verificacion->getUsersVerificados($nombreGestor);
                    print_r(json_encode($consult));
                } else {
                    http_response_code(400);
                    echo json_encode(array("status" => "error", "message" => "Error en la peticion"));
                }
                break;


            case 'VerificacionesDomicilio':
                if ($cedula = isset($_GET["cedula"])) {
                    $cedula = ($_GET["cedula"]);
                    $consult2 = $Verificacion->obtenerVerificaciones($cedula);
                    $rest = empty($consult2);
                    if ($rest == true) {
                        http_response_code(401);
                        echo json_encode(array("status" => "error", "message" => "Sin resultados"));
                    } else if ($rest == false) {
                        $consult2 = $Verificacion->obtenerVerificaciones($cedula);
                        $cedulaCliente = $consult2[0]->cedulaCliente;
                        $nombreCliente = $consult2[0]->nombreCliente;
                        $codigoVerificacion = $consult2[0]->codigoVerificacion;
                        $direccionDomiciliaria = $consult2[0]->direccionDomiciliaria;
                        $tipoVivienda = $consult2[0]->tipoVivienda;
                        $personaQuienRealizaLaVerificacion = $consult2[0]->personaQuienRealizaLaVerificacion;
                        $residenciaMinimaTresMeses = $consult2[0]->residenciaMinimaTresMeses;
                        $localTerrenoPropio = $consult2[0]->localTerrenoPropio;
                        $localTerrenoArrendado = $consult2[0]->localTerrenoArrendado;
                        $planillaServicioBasico = $consult2[0]->planillaServicioBasico;
                        $planillaServicioBasicoImagen = $consult2[0]->planillaServicioBasicoImagen;
                        $confirmacionInfoVecinos = $consult2[0]->confirmacionInfoVecinos;
                        $nombreInfoVecino = $consult2[0]->nombreInfoVecino;
                        $estabilidadLaboraSeisMesesImagen = $consult2[0]->estabilidadLaboraSeisMesesImagen;
                        $facturasProveedoresUltimosTresMesesImagen = $consult2[0]->facturasProveedoresUltimosTresMesesImagen;
                        $interiorDelNegocioImagen = $consult2[0]->interiorDelNegocioImagen;
                        $clienteDentroDelNegocioImagen = $consult2[0]->clienteDentroDelNegocioImagen;
                        $clienteFueraDelNegocioImagen = $consult2[0]->fachadaDelNegocioImagen;
                        $tituloPropiedaGaranteOCodeudorImagen = $consult2[0]->tituloPropiedaGaranteOCodeudorImagen;
                        $impuestoPredialImagen = $consult2[0]->impuestoPredialImagen;
                        $respaldoIngresosImagen = $consult2[0]->respaldoIngresosImagen;
                        $certificadoLaboralImagen = $consult2[0]->certificadoLaboralImagen;
                        $interiorDomicilioImagen = $consult2[0]->interiorDomicilioImagen;
                        $certificadoLaboralImagen = $consult2[0]->certificadoLaboralImagen;
                        $latitud = $consult2[0]->latitud;
                        $longitud = $consult2[0]->longitud;
                        $vf_nombre_tienda = $consult2[0]->vf_nombre_tienda;
                        $nombreGestor = $consult2[0]->nombreGestor;
                        $fechaverificacion = $consult2[0]->fechaverificacion;


                        $data = array(
                            "cedulaCliente" => $cedulaCliente,
                            "nombreCliente" => $nombreCliente,
                            "codigoVerificacion" => $codigoVerificacion,
                            "direccionDomiciliaria" => $direccionDomiciliaria,
                            "tipoVivienda" => $tipoVivienda,
                            "personaQuienRealizaLaVerificacion" => $personaQuienRealizaLaVerificacion,
                            "residenciaMinimaTresMeses" => $residenciaMinimaTresMeses,
                            "localTerrenoPropio" => $localTerrenoPropio,
                            "localTerrenoArrendado" => $localTerrenoArrendado,
                            "planillaServicioBasico" => $planillaServicioBasico,
                            "planillaServicioBasicoImagen" => $planillaServicioBasicoImagen,
                            "confirmacionInfoVecinos" => $confirmacionInfoVecinos,
                            "nombreInfoVecino" => $nombreInfoVecino,
                            "estabilidadLaboraSeisMesesImagen" => $estabilidadLaboraSeisMesesImagen,
                            "facturasProveedoresUltimosTresMesesImagen" => $facturasProveedoresUltimosTresMesesImagen,
                            "interiorDelNegocioImagen" => $interiorDelNegocioImagen,
                            "clienteDentroDelNegocioImagen" => $clienteDentroDelNegocioImagen,
                            "clienteFueraDelNegocioImagen" => $clienteFueraDelNegocioImagen,
                            "tituloPropiedaGaranteOCodeudorImagen" => $tituloPropiedaGaranteOCodeudorImagen,
                            "impuestoPredialImagen" => $impuestoPredialImagen,
                            "respaldoIngresosImagen" => $respaldoIngresosImagen,
                            "certificadoLaboralImagen" => $certificadoLaboralImagen,
                            "interiorDomicilioImagen" => $interiorDomicilioImagen,
                            "certificadoLaboralImagen" => $certificadoLaboralImagen,
                            "latitud" => $latitud,
                            "longitud" => $longitud,
                            "nombreTienda" => $vf_nombre_tienda,
                            "nombreGestor" => $nombreGestor,
                            "fechaverificacion" => $fechaverificacion
                        );

                        http_response_code(200);
                        print_r(json_encode($data));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("status" => "error", "message" => "Error en la peticion"));
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(array("status" => "error", "message" => "Falta parametros"));
                }
                break;
            case 'send':
                // Codigo
                $DesdeLetra = "a";
                $HastaLetra = "z";
                $DesdeNumero = 1;
                $HastaNumero = 10000;
                $letraAleatoria = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
                $numeroAleatorio = rand($DesdeNumero, $HastaNumero);
                $code = $letraAleatoria . $numeroAleatorio;
                // end Codigo
                $cellphone = $_GET["number"];

                $cellphonemodify = substr($cellphone, 1);

                $cellphonefinal = "593" . $cellphonemodify;

                $url = "https://api2.massend.com/enviosms";

                $curl = curl_init($url);

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


                $headers = array(
                    "Authorization: aWNlc3NhLWFwaUBtYXNzZW5kLmNvbQ==",
                    "Content-Type: application/x-www-form-urlencoded",
                );

                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = "username=icessa-api&mensajeid=32743&telefono=$cellphonefinal&tipo=1&datos=$code";

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $resp = curl_exec($curl);
                $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($status == 201) {
                    print_r(json_encode(array("status" => "OK", "message" => "Mensaje enviado, espere unos segundos, por favor...", "code" => $code)));
                } else {
                    print_r(json_encode(array("status" => "error", "message" => "El mensaje no se pudo enviar")));
                }
                break;

            default:
                http_response_code(400);
                echo $msgBadRequest;
                return;
                break;
        }
        break;

    case 'POST':
        switch ($_GET["op"]) {
            case 'insertCheck':
                http_response_code(200);
                $datos = json_decode(file_get_contents('php://input'));
                $cedulaCliente = $datos->cedulaCliente;
                $nombreCliente = $datos->nombreCliente;
                $codigoVerificacion = $datos->codigoVerificacion;
                $direccionDomiciliaria = $datos->direccionDomiciliaria;
                $tipoVivienda = $datos->tipoVivienda;
                $personaQuienRealizaLaVerificacion = $datos->personaQuienRealizaLaVerificacion;
                $residenciaMinimaTresMeses = $datos->residenciaMinimaTresMeses;
                $localTerrenoPropio = $datos->localTerrenoPropio;
                $localTerrenoArrendado = $datos->localTerrenoArrendado;
                $planillaServicioBasico = $datos->planillaServicioBasico;
                $planillaServicioBasicoImagen = $datos->planillaServicioBasicoImagen;
                $seguridadPuertasVentanas = $datos->seguridadPuertasVentanas;
                $muebleriaBasica = $datos->muebleriaBasica;
                $materialCasa = $datos->materialCasa;
                $periodicidadActividadesLaborales = $datos->periodicidadActividadesLaborales;
                $confirmacionInfoVecinos = $datos->confirmacionInfoVecinos;
                $nombreInfoVecino = $datos->nombreInfoVecino;
                $celularInfoVecino = $datos->celularInfoVecino;
                $estabilidadLaboraSeisMesesImagen = $datos->estabilidadLaboraSeisMesesImagen;
                $facturasProveedoresUltimosTresMesesImagen = $datos->facturasProveedoresUltimosTresMesesImagen;
                $fachadaDelNegocioImagen = $datos->fachadaDelNegocioImagen;
                $interiorDelNegocioImagen = $datos->interiorDelNegocioImagen;
                $clienteDentroDelNegocioImagen = $datos->clienteDentroDelNegocioImagen;
                $clienteFueraDelNegocioImagen = $datos->clienteFueraDelNegocioImagen;
                $tituloPropiedaGaranteOCodeudorImagen = $datos->tituloPropiedaGaranteOCodeudorImagen;
                $impuestoPredialImagen = $datos->impuestoPredialImagen;
                $respaldoIngresosImagen = $datos->respaldoIngresosImagen;
                $certificadoLaboralImagen = $datos->certificadoLaboralImagen;
                $interiorDomicilioImagen = $datos->interiorDomicilioImagen;
                $latitud = $datos->latitud;
                $longitud = $datos->longitud;
                $coordenadas = $datos->coordenadas;
                $vf_nombre_tienda = $datos->vf_nombre_tienda;
                $nombreGestor = $datos->nombreGestor;
                $fechaverificacion = $datos->fechaverificacion;
                var_dump($cedulaCliente);
                print_r(json_encode(array("status" => "OK", "message" => "Ejecución método POST")));
                break;
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
            default:

                http_response_code(400);
                echo $msgBadRequest;
                return;
        }
}