<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');
// require_once("../config/conexionTest.php");
require_once("../config/conexion.php");
require_once("../models/Refinanciamiento.php");
$refinanciamiento = new Refinanciamiento();
//

$body = json_decode(file_get_contents("php://input"));

switch ($_GET["op"]) {
    case 'getClientesId':
        $datos = $refinanciamiento->get_info_cliente($_GET["id"]);
        if (!empty($datos)) {
            http_response_code(200);
            echo $datos;
        } else {
            http_response_code(400);
            echo "REGISTRO NO INGRESADO";
        }
        break;

    case 'getClientes':
        $datos = $refinanciamiento->get_info_clientes();

        if (!empty($datos)) {
            http_response_code(200);
            echo $datos;
        } else {
            http_response_code(400);
            echo "REGISTRO NO INGRESADO";
        }
        break;

    case 'postDatosRefi':

        if ($body) {

            $p_refi_usuario = filter_var($body->refi_usuario, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_fecha = filter_var($body->refi_fecha, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_operacion = filter_var($body->refi_operacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_autorizacion = filter_var($body->refi_autorizacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_autorizacion_original = filter_var($body->refi_autorizacion_original, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_plazo = filter_var($body->refi_plazo, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_valor_cuota = filter_var($body->refi_valor_cuota, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_pago_gastos_admin = filter_var($body->refi_pago_gastos_admin, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_total_reest = filter_var($body->refi_total_reest, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_refi_total_pagar = filter_var($body->refi_total_pagar, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_cedula = filter_var($body->cliente_cedula, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_nombres = filter_var($body->cliente_nombres, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_nacionalidad = filter_var($body->cliente_nacionalidad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_ciudad_nacimiento = filter_var($body->cliente_ciudad_nacimiento, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_fecha_nacimiento = filter_var($body->cliente_fecha_nacimiento, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_sexo = filter_var($body->cliente_sexo, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_nivel_educativo = filter_var($body->cliente_nivel_educativo, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_profesion = filter_var($body->cliente_profesion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_estado_civil = filter_var($body->cliente_estado_civil, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_cliente_numero_dependientes = filter_var($body->cliente_numero_dependientes, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_direccion_exacta = filter_var($body->dir_direccion_exacta, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_provincia = filter_var($body->dir_provincia, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_canton_ciudad = filter_var($body->dir_canton_ciudad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_parroquia = filter_var($body->dir_parroquia, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_direccion = filter_var($body->dir_direccion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_calle_transversal = filter_var($body->dir_calle_transversal, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_numero = filter_var($body->dir_numero, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_latitud = filter_var($body->dir_latitud, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_longitud = filter_var($body->dir_longitud, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_referencia = filter_var($body->dir_referencia, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_tipo_vivienda = filter_var($body->dir_tipo_vivienda, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_tiempo = filter_var($body->dir_tiempo, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_telf_1 = filter_var($body->dir_telf_1, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_telf_2 = filter_var($body->dir_telf_2, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_email = filter_var($body->dir_email, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_nombre_arrendador = filter_var($body->dir_nombre_arrendador, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_dir_telf_arrendador = filter_var($body->dir_telf_arrendador, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_cedula = filter_var($body->conyuge_cedula, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_nombres = filter_var($body->conyuge_nombres, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_email = filter_var($body->conyuge_email, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_telf_1 = filter_var($body->conyuge_telf_1, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_telf_2 = filter_var($body->conyuge_telf_2, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_tipo_actividad = filter_var($body->conyuge_tipo_actividad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_nombre_empresa = filter_var($body->conyuge_nombre_empresa, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_actividad_empresa = filter_var($body->conyuge_actividad_empresa, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_cargo = filter_var($body->conyuge_cargo, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_telefono_empresa = filter_var($body->conyuge_telefono_empresa, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_conyuge_ingresos_mensuales = filter_var($body->conyuge_ingresos_mensuales, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref1_nombres = filter_var($body->ref1_nombres, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref1_parentesco = filter_var($body->ref1_parentesco, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref1_telf_1 = filter_var($body->ref1_telf_1, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref1_telf_2 = filter_var($body->ref1_telf_2, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref2_nombres = filter_var($body->ref2_nombres, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref2_parentesco = filter_var($body->ref2_parentesco, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref2_telf_1 = filter_var($body->ref2_telf_1, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_ref2_telf_2 = filter_var($body->ref2_telf_2, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_tipo_actividad = filter_var($body->trabajo_tipo_actividad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_ruc = filter_var($body->trabajo_ruc, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_nombre = filter_var($body->trabajo_nombre, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_provincia = filter_var($body->trabajo_provincia, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_canton = filter_var($body->trabajo_canton, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_parroquia = filter_var($body->trabajo_parroquia, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_barrio = filter_var($body->trabajo_barrio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_direccion = filter_var($body->trabajo_direccion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_numero = filter_var($body->trabajo_numero, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_calle_transversal = filter_var($body->trabajo_calle_transversal, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_ref_ubicacion = filter_var($body->trabajo_ref_ubicacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_telefono = filter_var($body->trabajo_telefono, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_trabajo_antiguedad = filter_var($body->trabajo_antiguedad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $p_imagen_files = filter_var_array($body->imagen_files);

            $datos = $refinanciamiento->set_insertFormRefi(
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
                $p_imagen_files,

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
    default:
        http_response_code(400);
        echo "ERROR";
        break;
}



?>