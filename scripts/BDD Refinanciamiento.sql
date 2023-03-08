-- server 210.17.1.100
USE ventaspdv_verificaciones;


CREATE TABLE datos_refinanciamiento_app_tb (
    id int NOT NULL AUTO_INCREMENT,
    refi_usuario varchar(100) DEFAULT NULL,
    refi_fecha varchar(100) DEFAULT NULL,
    refi_operacion varchar(100) DEFAULT NULL,
    refi_autorizacion varchar(100) DEFAULT NULL,
    refi_autorizacion_original varchar(100) DEFAULT NULL,
    refi_plazo varchar(100) DEFAULT NULL,
    refi_valor_cuota varchar(100) DEFAULT NULL,
    refi_fecha_primer_pago varchar(100) DEFAULT NULL,
    refi_pago_gastos_admin varchar(100) DEFAULT NULL,
    refi_total_reest varchar(100) DEFAULT NULL,
    refi_total_pagar varchar(100) DEFAULT NULL,
    cliente_cedula varchar(100) DEFAULT NULL,
    cliente_nombres varchar(100) DEFAULT NULL,
    cliente_nacionalidad varchar(100) DEFAULT NULL,
    cliente_ciudad_nacimiento varchar(100) DEFAULT NULL,
    cliente_fecha_nacimiento varchar(100) DEFAULT NULL,
    cliente_sexo varchar(100) DEFAULT NULL,
    cliente_nivel_educativo varchar(100) DEFAULT NULL,
    cliente_profesion varchar(100) DEFAULT NULL,
    cliente_estado_civil varchar(100) DEFAULT NULL,
    cliente_numero_dependientes varchar(100) DEFAULT NULL,
    dir_direccion_exacta varchar(100) DEFAULT NULL,
    dir_provincia varchar(100) DEFAULT NULL,
    dir_canton_ciudad varchar(100) DEFAULT NULL,
    dir_parroquia varchar(100) DEFAULT NULL,
    dir_direccion varchar(100) DEFAULT NULL,
    dir_calle_transversal varchar(100) DEFAULT NULL,
    dir_numero varchar(100) DEFAULT NULL,
    dir_latitud varchar(100) DEFAULT NULL,
    dir_longitud varchar(100) DEFAULT NULL,
    dir_referencia varchar(100) DEFAULT NULL,
    dir_tipo_vivienda varchar(100) DEFAULT NULL,
    dir_tiempo varchar(100) DEFAULT NULL,
    dir_telf_1 varchar(100) DEFAULT NULL,
    dir_telf_2 varchar(100) DEFAULT NULL,
    dir_email varchar(100) DEFAULT NULL,
    dir_nombre_arrendador varchar(100) DEFAULT NULL,
    dir_telf_arrendador varchar(100) DEFAULT NULL,
    conyuge_cedula varchar(100) DEFAULT NULL,
    conyuge_nombres varchar(100) DEFAULT NULL,
    conyuge_email varchar(100) DEFAULT NULL,
    conyuge_telf_1 varchar(100) DEFAULT NULL,
    conyuge_telf_2 varchar(100) DEFAULT NULL,
    conyuge_tipo_actividad varchar(100) DEFAULT NULL,
    conyuge_nombre_empresa varchar(100) DEFAULT NULL,
    conyuge_actividad_empresa varchar(100) DEFAULT NULL,
    conyuge_cargo varchar(100) DEFAULT NULL,
    conyuge_telefono_empresa varchar(100) DEFAULT NULL,
    conyuge_ingresos_mensuales varchar(100) DEFAULT NULL,
    ref1_nombres varchar(100) DEFAULT NULL,
    ref1_parentesco varchar(100) DEFAULT NULL,
    ref1_telf_1 varchar(100) DEFAULT NULL,
    ref1_telf_2 varchar(100) DEFAULT NULL,
    ref2_nombres varchar(100) DEFAULT NULL,
    ref2_parentesco varchar(100) DEFAULT NULL,
    ref2_telf_1 varchar(100) DEFAULT NULL,
    ref2_telf_2 varchar(100) DEFAULT NULL,
    trabajo_tipo_actividad varchar(100) DEFAULT NULL,
    trabajo_ruc varchar(100) DEFAULT NULL,
    trabajo_nombre varchar(100) DEFAULT NULL,
    trabajo_provincia varchar(100) DEFAULT NULL,
    trabajo_canton varchar(100) DEFAULT NULL,
    trabajo_parroquia varchar(100) DEFAULT NULL,
    trabajo_barrio varchar(100) DEFAULT NULL,
    trabajo_direccion varchar(100) DEFAULT NULL,
    trabajo_numero varchar(100) DEFAULT NULL,
    trabajo_calle_transversal varchar(100) DEFAULT NULL,
    trabajo_ref_ubicacion varchar(100) DEFAULT NULL,
    trabajo_telefono varchar(100) DEFAULT NULL,
    trabajo_antiguedad varchar(100) DEFAULT NULL,
    imagen_path varchar(1000) DEFAULT NULL,
    fecha_proceso varchar(100) DEFAULT NULL,
    PRIMARY KEY (id)
);


CREATE PROCEDURE proc_insert_refinanciamiento_app(
    IN p_refi_usuario varchar(100),
    IN p_refi_fecha varchar(100),
    IN p_refi_operacion varchar(100),
    IN p_refi_autorizacion varchar(100),
    IN p_refi_autorizacion_original varchar(100),
    IN p_refi_plazo varchar(100),
    IN p_refi_valor_cuota varchar(100),
    IN p_refi_fecha_primer_pago varchar(100),
    IN p_refi_pago_gastos_admin varchar(100),
    IN p_refi_total_reest varchar(100),
    IN p_refi_total_pagar varchar(100),
    IN p_cliente_cedula varchar(100),
    IN p_cliente_nombres varchar(100),
    IN p_cliente_nacionalidad varchar(100),
    IN p_cliente_ciudad_nacimiento varchar(100),
    IN p_cliente_fecha_nacimiento varchar(100),
    IN p_cliente_sexo varchar(100),
    IN p_cliente_nivel_educativo varchar(100),
    IN p_cliente_profesion varchar(100),
    IN p_cliente_estado_civil varchar(100),
    IN p_cliente_numero_dependientes varchar(100),
    IN p_dir_direccion_exacta varchar(100),
    IN p_dir_provincia varchar(100),
    IN p_dir_canton_ciudad varchar(100),
    IN p_dir_parroquia varchar(100),
    IN p_dir_direccion varchar(100),
    IN p_dir_calle_transversal varchar(100),
    IN p_dir_numero varchar(100),
    IN p_dir_latitud varchar(100),
    IN p_dir_longitud varchar(100),
    IN p_dir_referencia varchar(100),
    IN p_dir_tipo_vivienda varchar(100),
    IN p_dir_tiempo varchar(100),
    IN p_dir_telf_1 varchar(100),
    IN p_dir_telf_2 varchar(100),
    IN p_dir_email varchar(100),
    IN p_dir_nombre_arrendador varchar(100),
    IN p_dir_telf_arrendador varchar(100),
    IN p_conyuge_cedula varchar(100),
    IN p_conyuge_nombres varchar(100),
    IN p_conyuge_email varchar(100),
    IN p_conyuge_telf_1 varchar(100),
    IN p_conyuge_telf_2 varchar(100),
    IN p_conyuge_tipo_actividad varchar(100),
    IN p_conyuge_nombre_empresa varchar(100),
    IN p_conyuge_actividad_empresa varchar(100),
    IN p_conyuge_cargo varchar(100),
    IN p_conyuge_telefono_empresa varchar(100),
    IN p_conyuge_ingresos_mensuales varchar(100),
    IN p_ref1_nombres varchar(100),
    IN p_ref1_parentesco varchar(100),
    IN p_ref1_telf_1 varchar(100),
    IN p_ref1_telf_2 varchar(100),
    IN p_ref2_nombres varchar(100),
    IN p_ref2_parentesco varchar(100),
    IN p_ref2_telf_1 varchar(100),
    IN p_ref2_telf_2 varchar(100),
    IN p_trabajo_tipo_actividad varchar(100),
    IN p_trabajo_ruc varchar(100),
    IN p_trabajo_nombre varchar(100),
    IN p_trabajo_provincia varchar(100),
    IN p_trabajo_canton varchar(100),
    IN p_trabajo_parroquia varchar(100),
    IN p_trabajo_barrio varchar(100),
    IN p_trabajo_direccion varchar(100),
    IN p_trabajo_numero varchar(100),
    IN p_trabajo_calle_transversal varchar(100),
    IN p_trabajo_ref_ubicacion varchar(100),
    IN p_trabajo_telefono varchar(100),
    IN p_trabajo_antiguedad varchar(100),
    IN p_imagen_path varchar(1000)
)
BEGIN
    INSERT INTO datos_refinanciamiento_app_tb 
    (
        id,
        refi_usuario,
        refi_fecha,
        refi_operacion,
        refi_autorizacion,
        refi_autorizacion_original,
        refi_plazo,
        refi_valor_cuota,
        refi_fecha_primer_pago,
        refi_pago_gastos_admin,
        refi_total_reest,
        refi_total_pagar,
        cliente_cedula,
        cliente_nombres,
        cliente_nacionalidad,
        cliente_ciudad_nacimiento,
        cliente_fecha_nacimiento,
        cliente_sexo,
        cliente_nivel_educativo,
        cliente_profesion,
        cliente_estado_civil,
        cliente_numero_dependientes,
        dir_direccion_exacta,
        dir_provincia,
        dir_canton_ciudad,
        dir_parroquia,
        dir_direccion,
        dir_calle_transversal,
        dir_numero,
        dir_latitud,
        dir_longitud,
        dir_referencia,
        dir_tipo_vivienda,
        dir_tiempo,
        dir_telf_1,
        dir_telf_2,
        dir_email,
        dir_nombre_arrendador,
        dir_telf_arrendador,
        conyuge_cedula,
        conyuge_nombres,
        conyuge_email,
        conyuge_telf_1,
        conyuge_telf_2,
        conyuge_tipo_actividad,
        conyuge_nombre_empresa,
        conyuge_actividad_empresa,
        conyuge_cargo,
        conyuge_telefono_empresa,
        conyuge_ingresos_mensuales,
        ref1_nombres,
        ref1_parentesco,
        ref1_telf_1,
        ref1_telf_2,
        ref2_nombres,
        ref2_parentesco,
        ref2_telf_1,
        ref2_telf_2,
        trabajo_tipo_actividad,
        trabajo_ruc,
        trabajo_nombre,
        trabajo_provincia,
        trabajo_canton,
        trabajo_parroquia,
        trabajo_barrio,
        trabajo_direccion,
        trabajo_numero,
        trabajo_calle_transversal,
        trabajo_ref_ubicacion,
        trabajo_telefono,
        trabajo_antiguedad,
        imagen_path,
        fecha_proceso
    )
    VALUES
    (
        null,
        p_refi_usuario,
        p_refi_fecha,
        p_refi_operacion,
        p_refi_autorizacion,
        p_refi_autorizacion_original,
        p_refi_plazo,
        p_refi_valor_cuota,
        p_refi_fecha_primer_pago,
        p_refi_pago_gastos_admin,
        p_refi_total_reest,
        p_refi_total_pagar,
        p_cliente_cedula,
        p_cliente_nombres,
        p_cliente_nacionalidad,
        p_cliente_ciudad_nacimiento,
        p_cliente_fecha_nacimiento,
        p_cliente_sexo,
        p_cliente_nivel_educativo,
        p_cliente_profesion,
        p_cliente_estado_civil,
        p_cliente_numero_dependientes,
        p_dir_direccion_exacta,
        p_dir_provincia,
        p_dir_canton_ciudad,
        p_dir_parroquia,
        p_dir_direccion,
        p_dir_calle_transversal,
        p_dir_numero,
        p_dir_latitud,
        p_dir_longitud,
        p_dir_referencia,
        p_dir_tipo_vivienda,
        p_dir_tiempo,
        p_dir_telf_1,
        p_dir_telf_2,
        p_dir_email,
        p_dir_nombre_arrendador,
        p_dir_telf_arrendador,
        p_conyuge_cedula,
        p_conyuge_nombres,
        p_conyuge_email,
        p_conyuge_telf_1,
        p_conyuge_telf_2,
        p_conyuge_tipo_actividad,
        p_conyuge_nombre_empresa,
        p_conyuge_actividad_empresa,
        p_conyuge_cargo,
        p_conyuge_telefono_empresa,
        p_conyuge_ingresos_mensuales,
        p_ref1_nombres,
        p_ref1_parentesco,
        p_ref1_telf_1,
        p_ref1_telf_2,
        p_ref2_nombres,
        p_ref2_parentesco,
        p_ref2_telf_1,
        p_ref2_telf_2,
        p_trabajo_tipo_actividad,
        p_trabajo_ruc,
        p_trabajo_nombre,
        p_trabajo_provincia,
        p_trabajo_canton,
        p_trabajo_parroquia,
        p_trabajo_barrio,
        p_trabajo_direccion,
        p_trabajo_numero,
        p_trabajo_calle_transversal,
        p_trabajo_ref_ubicacion,
        p_trabajo_telefono,
        p_trabajo_antiguedad,
        p_imagen_path,
        CURRENT_TIMESTAMP()
    );

    select * from datos_refinanciamiento_app_tb where id = LAST_INSERT_ID();
END;


CREATE PROCEDURE get_historial_usuario(p_usuario_nombre varchar(100))
BEGIN
  SELECT * FROM datos_refinanciamiento_app_tb WHERE refi_usuario = p_usuario_nombre;
END




