<?php

class Verificacion extends Conectar
{
    public function set_insertFormVerificacion(
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
    )
    {
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
            echo "SQL error: ";
            exit;
        }
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        // return json_encode($sql);
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

        $concatPaths = $this->ConcatPaths($rutas, $ruta_imagenes, $ruta_web_imagenes);
        return $concatPaths;
    }
}
?>