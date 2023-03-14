<?php
require_once("../config/conexion.php");
require_once("../utils/dotenv.php");
require_once("../utils/Utils.php");

(new DotEnv('../.env'))->load();

$utils = new Utils();
$proceso = 'Verificacion';

class Verificacion extends Conectar
{
    public function getClientesParaReservar()
    {
        $conectar = parent::conexion();
        $sql = "SELECT vf_nombre_cliente, vf_lugar_a_verificar, dndlD_direccion_domiciliaria, dndlN_direccion_trabajo, vf_nombre_tienda, ";
        $sql = $sql . "dndlN_telefonocelular, vf_cedula_cliente, estado, latitud, longitud FROM verificaciones_usuarios_tb_pruebas WHERE estado=0 AND verificado=0";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = $sql->fetchAll(PDO::FETCH_OBJ);

        return $sql;
    }

    public function getClientesParaVerificar($nombreGestor)
    {
        $conectar = parent::conexion();
        $sql = "SELECT vf_nombre_cliente, vf_lugar_a_verificar, dndlD_direccion_domiciliaria, dndlN_direccion_trabajo, vf_nombre_tienda, ";
        $sql = $sql . "dndlN_telefonocelular, vf_cedula_cliente, estado, fechaIngreso_reserva, latitud, longitud FROM verificaciones_usuarios_tb_pruebas WHERE estado=1 AND verificado=0 AND nombre_gestor = '$nombreGestor' ";
        $sql = $sql . "order by fechaIngreso_reserva asc";
        // $sql = "SELECT * FROM verificaciones_usuarios_tb_pruebas WHERE estado=1 AND verificado=0";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getClientesVerificados($nombreGestor)
    {
        $conectar = parent::conexion();
        $sql = "SELECT
                    id,
                    cedulaCliente,
                    nombreCliente,
                    codigoVerificacion,
                    direccionDomiciliaria,
                    tipoVivienda,
                    personaQuienRealizaLaVerificacion,
                    residenciaMinimaTresMeses,
                    localTerrenoPropio,
                    localTerrenoArrendado,
                    planillaServicioBasico,
                    planillaServicioBasicoImagen,
                    seguridadPuertasVentanas,
                    muebleriaBasica,
                    materialCasa,
                    periodicidadActividadesLaborales,
                    confirmacionInfoVecinos,
                    nombreInfoVecino,
                    celularInfoVecino,
                    estabilidadLaboraSeisMesesImagen,
                    facturasProveedoresUltimosTresMesesImagen,
                    fachadaDelNegocioImagen,
                    interiorDelNegocioImagen,
                    clienteDentroDelNegocioImagen,
                    clienteFueraDelNegocioImagen,
                    tituloPropiedaGaranteOCodeudorImagen,
                    impuestoPredialImagen,
                    respaldoIngresosImagen,
                    certificadoLaboralImagen,
                    interiorDomicilioImagen,
                    latitud,
                    longitud,
                    vf_nombre_tienda,
                    nombreGestor,
                    fechaverificacion
                FROM checklist_verifica_domicilio_app_tb;
                WHERE nombreGestor = '$nombreGestor' order by id desc ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getClienteVerificadoId($cedula)
    {
        $conectar = parent::conexion();
        $sql = "SELECT * FROM checklistverificadomicilio_tb WHERE cedulaCliente='$cedula'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function setClienteReservado($cedula, $nombreGestor, $latitud, $longitud)
    {
        $longitud = (float) $longitud;
        $latitud = (float) $latitud;



        $nombreGestor = trim($nombreGestor);
        // echo $nombreGestor;
        $conectar = parent::conexion();
        $sql = "UPDATE verificaciones_usuarios_tb_pruebas SET estado='1', nombre_gestor='$nombreGestor', latitud_reserva_gestor=$latitud, ";
        $sql = $sql . "longitud_reserva_gestor=$longitud, coordenas_reserva_gestor = POINT($latitud, $longitud), fechaIngreso_reserva = CURRENT_TIMESTAMP() ";
        $sql = $sql . "WHERE vf_cedula_cliente='$cedula'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $sql = "SELECT ROW_COUNT()";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function setClienteVerificado($jsonBody)
    {
        global $utils, $proceso;

        $conectar = parent::conexion();
        $imageName = $jsonBody->cedulaCliente;
        $params = $utils->filterEntries($jsonBody);

        $dbParams = $utils->exportImagesFromParams(
            $params,
            $imageName,
            $proceso,
            $jsonBody->nombreCliente
        );

        $sql = "CALL proc_insert_checklist_verificacion_app (
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,?,?,
            ?,?,?
        )";

        $sql = $conectar->prepare($sql);

        $i = 1;
        foreach ($dbParams as $key => $value) {
            $sql->bindValue($i++, strtoupper($value));
        }

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enviarSMS($number)
    {
        global $utils;

        $code = $utils->randomSmsCode();
        $number = "593" . substr($number, 1);
        // $number = "593969838598";

        // echo $number;
        // return;
        $urlParams = array(
            'username' => getenv('SMS_USERNAME'),
            'mensajeid' => getenv('SMS_MSGID'),
            'telefono' => $number,
            'tipo' => getenv('SMS_TIPO'),
            'datos' => $code,
        );
        $urlParams = http_build_query($urlParams);

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
                    'Authorization: ' . getenv('SMS_URL_AUTH'),
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
?>