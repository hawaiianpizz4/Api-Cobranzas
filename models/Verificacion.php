<?php
require_once("../config/conexion.php");
require_once("../utils/dotenv.php");
require_once("../utils/Utils.php");

(new DotEnv('../.env'))->load();

$utils = new Utils();
$proceso = 'Verificacion';

class Verificacion extends Conectar
{

    public function getUsersParaReservar()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM ventaspdv_verificaciones.verificaciones_usuarios_tb_pruebas WHERE estado=0 AND verificado=0";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerVerificaciones($cedula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM ventaspdv_verificaciones.checklistverificadomicilio_tb WHERE cedulaCliente='$cedula'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }


    public function enviarSMS($number)
    {
        global $utils;

        $code = $utils->randomSmsCode();
        $number = "593" . substr($number, 1);
        $number = "59398439756";

        $urlParams = "username=icessa-api&mensajeid=32743&telefono=$number&tipo=1&datos=$code";
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('SMS_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $urlParams,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . getenv('SMS_URL_AUTH'),
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        echo $status;

        return json_decode($response);
    }


    public function insertarVerificaciones(
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
        $coordenadas,
        $vf_nombre_tienda,
        $nombreGestor,
        $fechaverificacion
    )
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO checklistverificadomicilio_tb (cedulaCliente, nombreCliente, codigoVerificacion, direccionDomiciliaria,
            tipoVivienda, personaQuienRealizaLaVerificacion, residenciaMinimaTresMeses, localTerrenoPropio,
            localTerrenoArrendado, planillaServicioBasico, planillaServicioBasicoImagen, seguridadPuertasVentanas,
            muebleriaBasica, materialCasa, periodicidadActividadesLaborales, confirmacionInfoVecinos, nombreInfoVecino,
            celularInfoVecino, estabilidadLaboraSeisMesesImagen, facturasProveedoresUltimosTresMesesImagen,
            fachadaDelNegocioImagen, interiorDelNegocioImagen, clienteDentroDelNegocioImagen, clienteFueraDelNegocioImagen,
            tituloPropiedaGaranteOCodeudorImagen, impuestoPredialImagen, respaldoIngresosImagen, certificadoLaboralImagen,
            interiorDomicilioImagen,
            latitud, longitud, coordenadas, vf_nombre_tienda, nombreGestor, fechaverificacion)
            VALUES ('$cedulaCliente', '$nombreCliente', '$codigoVerificacion', '$direccionDomiciliaria',
            '$tipoVivienda', '$personaQuienRealizaLaVerificacion', '$residenciaMinimaTresMeses', '$localTerrenoPropio', '$localTerrenoArrendado',
            '$planillaServicioBasico', '$planillaServicioBasicoImagen', '$seguridadPuertasVentanas', '$muebleriaBasica', '$materialCasa',
            '$periodicidadActividadesLaborales', '$confirmacionInfoVecinos', '$nombreInfoVecino', '$celularInfoVecino', '$estabilidadLaboraSeisMesesImagen',
            '$facturasProveedoresUltimosTresMesesImagen', '$fachadaDelNegocioImagen', '$interiorDelNegocioImagen', '$clienteDentroDelNegocioImagen',
            '$clienteFueraDelNegocioImagen', '$tituloPropiedaGaranteOCodeudorImagen', '$impuestoPredialImagen', '$respaldoIngresosImagen',
            '$certificadoLaboralImagen', '$interiorDomicilioImagen', '$latitud', '$longitud', '$coordenadas', '$vf_nombre_tienda',
            '$nombreGestor', '$fechaverificacion');";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function reservarVerificacionUser($cedula, $nombreGestor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE ventaspdv_verificaciones.verificaciones_usuarios_tb_pruebas SET estado='1', nombre_gestor='$nombreGestor'
            WHERE vf_cedula_cliente='$cedula'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }


    public function getUsersVerificados($nombreGestor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "Select * from ventaspdv_verificaciones.checklist_verifica_domicilio_app_tb where nombreGestor = '$nombreGestor'";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function checkUserForGestorPrueba()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT vf_nombre_tienda, vf_nombre_vendedor, vf_nombre_cliente, vf_cedula_cliente, vf_lugar_a_verificar,
            dndlD_ciudad_residencia, dndlD_sector_de_domicilio, dndlD_direccion_domiciliaria, dndlD_referencia_domiciliaria,
            dndlN_nombre_empresa_trabaja, dndlN_actividad_laboral, dndlN_direccion_trabajo, dndlN_telefonofijo,
            dndlN_telefonocelular, b.vf_gestor  from ventaspdv_verificaciones.verificaciones_usuarios_tb a
            inner join ventaspdv_verificaciones.verificaciones_fisicas b on
            a.vf_cedula_cliente =b.vf_cedula and DATE_FORMAT(a.fechaIngreso,'%Y-%m-%d')  = DATE_FORMAT(b.fechaIngreso,'%Y-%m-%d')
            WHERE estado ='1' and verificado ='0' and b.vf_gestor='MRAMIREZ'  group by  a.vf_cedula_cliente";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }
    public function set_insertFormVerificacion($body)
    {
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
        $conectar = parent::conexion();
        parent::set_names();

        $ruta_imagenes = "\\\\210.17.1.38\\htdocs\\VerificacionesFisicas\\APP_Cobranzas_Fotos\\Verificacion\\" . $nombreCliente . "\\";
        $ruta_web_imagenes = "http://200.7.249.21:90/VerificacionesFisicas/APP_Cobranzas_Fotos/Verificacion/" . $nombreCliente . "/";

        $planillaServicioBasicoImagenPath = $this->grabarImagenesEnServer($planillaServicioBasicoImagen, "PLANILLA", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $estabilidadLaboraSeisMesesImagenPath = $this->grabarImagenesEnServer($estabilidadLaboraSeisMesesImagen, "ESTABILIDAD", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $facturasProveedoresUltimosTresMesesImagenPath = $this->grabarImagenesEnServer($facturasProveedoresUltimosTresMesesImagen, "FACTURAS_PROV", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $fachadaDelNegocioImagenPath = $this->grabarImagenesEnServer($fachadaDelNegocioImagen, "NEGO_EXTERIOR", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $interiorDelNegocioImagenPath = $this->grabarImagenesEnServer($interiorDelNegocioImagen, "NEGO_INTERIOR", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $clienteDentroDelNegocioImagenPath = $this->grabarImagenesEnServer($clienteDentroDelNegocioImagen, "CLIENTE_NEGO_INTERIOR", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $clienteFueraDelNegocioImagenPath = $this->grabarImagenesEnServer($clienteFueraDelNegocioImagen, "CLIENTE_NEGO_EXTERIOR", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $tituloPropiedaGaranteOCodeudorImagenPath = $this->grabarImagenesEnServer($tituloPropiedaGaranteOCodeudorImagen, "TITULO_PROPIEDAD", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $impuestoPredialImagenPath = $this->grabarImagenesEnServer($impuestoPredialImagen, "PREDIAL", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $respaldoIngresosImagenPath = $this->grabarImagenesEnServer($respaldoIngresosImagen, "RESPALDO", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $certificadoLaboralImagenPath = $this->grabarImagenesEnServer($certificadoLaboralImagen, "CERTIFICADO", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);
        $interiorDomicilioImagenPath = $this->grabarImagenesEnServer($interiorDomicilioImagen, "INTERIOR_DOMICILIO", $cedulaCliente, $codigoVerificacion, $ruta_imagenes, $ruta_web_imagenes);

        $sql = "CALL proc_insert_checklist_verifica_domicilio_app (
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?
        )";

        $sql = $conectar->prepare($sql);

        $i = 1;
        $sql->bindValue($i++, $cedulaCliente);
        $sql->bindValue($i++, $nombreCliente);
        $sql->bindValue($i++, $codigoVerificacion);
        $sql->bindValue($i++, $direccionDomiciliaria);
        $sql->bindValue($i++, $tipoVivienda);
        $sql->bindValue($i++, $personaQuienRealizaLaVerificacion);
        $sql->bindValue($i++, $residenciaMinimaTresMeses);
        $sql->bindValue($i++, $localTerrenoPropio);
        $sql->bindValue($i++, $localTerrenoArrendado);
        $sql->bindValue($i++, $planillaServicioBasico);
        $sql->bindValue($i++, $planillaServicioBasicoImagenPath);
        $sql->bindValue($i++, $seguridadPuertasVentanas);
        $sql->bindValue($i++, $muebleriaBasica);
        $sql->bindValue($i++, $materialCasa);
        $sql->bindValue($i++, $periodicidadActividadesLaborales);
        $sql->bindValue($i++, $confirmacionInfoVecinos);
        $sql->bindValue($i++, $nombreInfoVecino);
        $sql->bindValue($i++, $celularInfoVecino);
        $sql->bindValue($i++, $estabilidadLaboraSeisMesesImagenPath);
        $sql->bindValue($i++, $facturasProveedoresUltimosTresMesesImagenPath);
        $sql->bindValue($i++, $fachadaDelNegocioImagenPath);
        $sql->bindValue($i++, $interiorDelNegocioImagenPath);
        $sql->bindValue($i++, $clienteDentroDelNegocioImagenPath);
        $sql->bindValue($i++, $clienteFueraDelNegocioImagenPath);
        $sql->bindValue($i++, $tituloPropiedaGaranteOCodeudorImagenPath);
        $sql->bindValue($i++, $impuestoPredialImagenPath);
        $sql->bindValue($i++, $respaldoIngresosImagenPath);
        $sql->bindValue($i++, $certificadoLaboralImagenPath);
        $sql->bindValue($i++, $interiorDomicilioImagenPath);
        $sql->bindValue($i++, $latitud);
        $sql->bindValue($i++, $longitud);
        $sql->bindValue($i++, $vf_nombre_tienda);
        $sql->bindValue($i++, $nombreGestor);
        $sql->execute();

        // Check if the SQL statement produced an error
        if ($conectar->errorCode() != '00000') {
            // If an error occurred, print the error message and exit
            $errorInfo = $conectar->errorInfo();
            echo `SQL error: ${errorInfo}`;
            exit;
        }
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public function ConcatPaths($p_imagen_paths, $ruta_imagenes, $ruta_web_imagenes)
    {
        $p_imagen_paths_concat = '';
        foreach ($p_imagen_paths as $path) {

            $path = str_replace($ruta_imagenes, $ruta_web_imagenes, $path);
            $p_imagen_paths_concat = $p_imagen_paths_concat . $path . ';';
        }
        return $p_imagen_paths_concat;
    }
    public function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = "" //chr(123) // ""
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . ""; //chr(125); // ""
            return $uuid;
        }
    }

    public function grabarImagenesEnServer($p_imagesArray, $tipo, $cedula, $operacion, $ruta_imagenes, $ruta_web_imagenes)
    {
        $imageGUID = $this->getGUID();
        $rutas = array();

        if (!file_exists($ruta_imagenes)) {
            mkdir($ruta_imagenes, 0777, true);
        }

        $i = 1;
        foreach ($p_imagesArray as $blob) {
            $filename = $ruta_imagenes . "$tipo - $cedula - $imageGUID - $i" . ".png";
            file_put_contents($filename, base64_decode($blob));
            array_push($rutas, str_replace('/', '\\', $filename));
            $i++;
        }

        return $this->ConcatPaths($rutas, $ruta_imagenes, $ruta_web_imagenes);
        ;
    }
}
?>