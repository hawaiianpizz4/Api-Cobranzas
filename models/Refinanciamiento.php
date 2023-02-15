<?php
class Refinanciamiento extends Conectar
{

    public function get_info_cliente($id)
    {

        $data = array("numero_cedula" => $id);
        $data_str = json_encode($data);

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://200.7.249.22:9000/api/v1/datossolicitud',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data_str,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer eyJhbGciOiJQUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxNDgwMTYxMjIwMjIiLCJuYW1lIjoiSWNlc2EiLCJhZG1pbiI6ZmFsc2UsImlhdCI6MjAyMjAxMDF9.TnZE2DzldD8x4KHOjX38gxsNxtRIlzss2V7yc7VyLy1ckz_19mrJJWCh34xLqprI-IRtHa3hA2sAGgF2yA2qnbfDYCq0Vn0gDZCHd7-sEkUOq9M5niVUfu355qGG_OUc3US73ShG_dER9nj3NFC-kuU7-fve52h1vjspOY5ePjwSl1of-g4CLOPGMT7dI0d0Y17c-fmxpNBr1wk7NHDQtl0v4CqbP1r7sf5mZIt92v262Xuvt-c6lK9E4-0SlfeoX6Qd5mw-JsPwvqO6uLZnSazr43tTfWx6ZrwpBzARqtnkAy9tQ5KGXiTqMt_hYCyKKQWvwd_uIIb0Qd0Bd8cuBg',
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function get_info_clientes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL PruebasProyectos.proc_get_clientes()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }



    public function set_insertFormRefi(
        $p_refi_usuario,
        $p_refi_fecha,
        $p_refi_operacion,
        $p_refi_autorizacion,
        $p_refi_autorizacion_original,
        $p_refi_plazo,
        $p_refi_valor_cuota,
        $p_refi_pago_gastos_admin,
        $p_refi_total_reest,
        $p_refi_total_pagar,
        $p_cliente_cedula,
        $p_cliente_nombres,
        $p_cliente_nacionalidad,
        $p_cliente_ciudad_nacimiento,
        $p_cliente_fecha_nacimiento,
        $p_cliente_sexo,
        $p_cliente_nivel_educativo,
        $p_cliente_profesion,
        $p_cliente_estado_civil,
        $p_cliente_numero_dependientes,
        $p_dir_direccion_exacta,
        $p_dir_provincia,
        $p_dir_canton_ciudad,
        $p_dir_parroquia,
        $p_dir_direccion,
        $p_dir_calle_transversal,
        $p_dir_numero,
        $p_dir_latitud,
        $p_dir_longitud,
        $p_dir_referencia,
        $p_dir_tipo_vivienda,
        $p_dir_tiempo,
        $p_dir_telf_1,
        $p_dir_telf_2,
        $p_dir_email,
        $p_dir_nombre_arrendador,
        $p_dir_telf_arrendador,
        $p_conyuge_cedula,
        $p_conyuge_nombres,
        $p_conyuge_email,
        $p_conyuge_telf_1,
        $p_conyuge_telf_2,
        $p_conyuge_tipo_actividad,
        $p_conyuge_nombre_empresa,
        $p_conyuge_actividad_empresa,
        $p_conyuge_cargo,
        $p_conyuge_telefono_empresa,
        $p_conyuge_ingresos_mensuales,
        $p_ref1_nombres,
        $p_ref1_parentesco,
        $p_ref1_telf_1,
        $p_ref1_telf_2,
        $p_ref2_nombres,
        $p_ref2_parentesco,
        $p_ref2_telf_1,
        $p_ref2_telf_2,
        $p_trabajo_tipo_actividad,
        $p_trabajo_ruc,
        $p_trabajo_nombre,
        $p_trabajo_provincia,
        $p_trabajo_canton,
        $p_trabajo_parroquia,
        $p_trabajo_barrio,
        $p_trabajo_direccion,
        $p_trabajo_numero,
        $p_trabajo_calle_transversal,
        $p_trabajo_ref_ubicacion,
        $p_trabajo_telefono,
        $p_trabajo_antiguedad,
        $p_imagen_files
    )
    {
        // print_r($p_imagen_files);

        // $ruta_imagenes = "//171.23.12.43/_shared/";
        // $ruta_imagenes = "//210.17.1.38/htdocs/ApiVerificaciones/App_Cobranzas_img/";

        // $ruta_imagenes = "//210.17.1.38/htdocs/VerificacionesFisicas/Fotos_APP_Cobranzas/Refinanciamiento/" . $p_cliente_nombres . "/";




        $ruta_imagenes = "\\\\210.17.1.38\\htdocs\\VerificacionesFisicas\\APP_Cobranzas_Fotos\\Refinanciamiento\\" . $p_cliente_nombres . "\\";
        $ruta_web_imagenes = "http://200.7.249.21:90/VerificacionesFisicas/APP_Cobranzas_Fotos/Refinanciamiento/" . $p_cliente_nombres . "/";




        $p_imagen_paths = $this->grabarImagenesEnServer($p_imagen_files, $p_cliente_cedula, $p_refi_operacion, $ruta_imagenes, $ruta_web_imagenes);

        $conectar = parent::conexion();
        parent::set_names();


        $sql = "CALL proc_insert_actualizacion_datos_refinanciamiento_app (
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?
        )";

        $sql = $conectar->prepare($sql);

        $i = 1;
        $sql->bindValue($i++, $p_refi_usuario);
        $sql->bindValue($i++, $p_refi_fecha);
        $sql->bindValue($i++, $p_refi_operacion);
        $sql->bindValue($i++, $p_refi_autorizacion);
        $sql->bindValue($i++, $p_refi_autorizacion_original);
        $sql->bindValue($i++, $p_refi_plazo);
        $sql->bindValue($i++, $p_refi_valor_cuota);
        $sql->bindValue($i++, $p_refi_pago_gastos_admin);
        $sql->bindValue($i++, $p_refi_total_reest);
        $sql->bindValue($i++, $p_refi_total_pagar);
        $sql->bindValue($i++, $p_cliente_cedula);
        $sql->bindValue($i++, $p_cliente_nombres);
        $sql->bindValue($i++, $p_cliente_nacionalidad);
        $sql->bindValue($i++, $p_cliente_ciudad_nacimiento);
        $sql->bindValue($i++, $p_cliente_fecha_nacimiento);
        $sql->bindValue($i++, $p_cliente_sexo);
        $sql->bindValue($i++, $p_cliente_nivel_educativo);
        $sql->bindValue($i++, $p_cliente_profesion);
        $sql->bindValue($i++, $p_cliente_estado_civil);
        $sql->bindValue($i++, $p_cliente_numero_dependientes);
        $sql->bindValue($i++, $p_dir_direccion_exacta);
        $sql->bindValue($i++, $p_dir_provincia);
        $sql->bindValue($i++, $p_dir_canton_ciudad);
        $sql->bindValue($i++, $p_dir_parroquia);
        $sql->bindValue($i++, $p_dir_direccion);
        $sql->bindValue($i++, $p_dir_calle_transversal);
        $sql->bindValue($i++, $p_dir_numero);
        $sql->bindValue($i++, $p_dir_latitud);
        $sql->bindValue($i++, $p_dir_longitud);
        $sql->bindValue($i++, $p_dir_referencia);
        $sql->bindValue($i++, $p_dir_tipo_vivienda);
        $sql->bindValue($i++, $p_dir_tiempo);
        $sql->bindValue($i++, $p_dir_telf_1);
        $sql->bindValue($i++, $p_dir_telf_2);
        $sql->bindValue($i++, $p_dir_email);
        $sql->bindValue($i++, $p_dir_nombre_arrendador);
        $sql->bindValue($i++, $p_dir_telf_arrendador);
        $sql->bindValue($i++, $p_conyuge_cedula);
        $sql->bindValue($i++, $p_conyuge_nombres);
        $sql->bindValue($i++, $p_conyuge_email);
        $sql->bindValue($i++, $p_conyuge_telf_1);
        $sql->bindValue($i++, $p_conyuge_telf_2);
        $sql->bindValue($i++, $p_conyuge_tipo_actividad);
        $sql->bindValue($i++, $p_conyuge_nombre_empresa);
        $sql->bindValue($i++, $p_conyuge_actividad_empresa);
        $sql->bindValue($i++, $p_conyuge_cargo);
        $sql->bindValue($i++, $p_conyuge_telefono_empresa);
        $sql->bindValue($i++, $p_conyuge_ingresos_mensuales);
        $sql->bindValue($i++, $p_ref1_nombres);
        $sql->bindValue($i++, $p_ref1_parentesco);
        $sql->bindValue($i++, $p_ref1_telf_1);
        $sql->bindValue($i++, $p_ref1_telf_2);
        $sql->bindValue($i++, $p_ref2_nombres);
        $sql->bindValue($i++, $p_ref2_parentesco);
        $sql->bindValue($i++, $p_ref2_telf_1);
        $sql->bindValue($i++, $p_ref2_telf_2);
        $sql->bindValue($i++, $p_trabajo_tipo_actividad);
        $sql->bindValue($i++, $p_trabajo_ruc);
        $sql->bindValue($i++, $p_trabajo_nombre);
        $sql->bindValue($i++, $p_trabajo_provincia);
        $sql->bindValue($i++, $p_trabajo_canton);
        $sql->bindValue($i++, $p_trabajo_parroquia);
        $sql->bindValue($i++, $p_trabajo_barrio);
        $sql->bindValue($i++, $p_trabajo_direccion);
        $sql->bindValue($i++, $p_trabajo_numero);
        $sql->bindValue($i++, $p_trabajo_calle_transversal);
        $sql->bindValue($i++, $p_trabajo_ref_ubicacion);
        $sql->bindValue($i++, $p_trabajo_telefono);
        $sql->bindValue($i++, $p_trabajo_antiguedad);
        $sql->bindValue($i++, $p_imagen_paths);


        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    public function grabarImagenesEnServer($p_imagesArray, $cedula, $operacion, $ruta_imagenes, $ruta_web_imagenes)
    {
        $imageGUID = $this->getGUID();
        $rutas = array();

        if (!file_exists($ruta_imagenes)) {
            mkdir($ruta_imagenes, 0777, true);
        }

        $i = 1;
        foreach ($p_imagesArray as $blob) {
            $filename = $ruta_imagenes . "$cedula - $operacion - $imageGUID - $i" . ".png";
            file_put_contents($filename, base64_decode($blob));
            array_push($rutas, str_replace('/', '\\', $filename));
            $i++;
        }

        $concatPaths = $this->ConcatPaths($rutas, $ruta_imagenes, $ruta_web_imagenes);

        return $concatPaths;
    }

}
?>