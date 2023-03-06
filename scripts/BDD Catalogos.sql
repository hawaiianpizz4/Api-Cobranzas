CREATE TABLE catalogo_provincia_tb(
    id int NOT NULL AUTO_INCREMENT,
    codigo int NOT NULL,
    nombre varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE catalogo_canton_tb(
    id int NOT NULL AUTO_INCREMENT,
    codigo int NOT NULL,
    nombre varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE catalogo_parroquia_tb(
    id int NOT NULL AUTO_INCREMENT,
    codigo int NOT NULL,
    nombre varchar(255) NOT NULL,
    PRIMARY KEY (id)
);


CREATE PROCEDURE proc_get_nombre_catalogo(
  IN p_codigo int,
  IN p_tabla varchar(50)
)
BEGIN
  IF p_tabla = 'provincia' THEN
    SELECT nombre FROM catalogo_provincia_tb WHERE codigo = p_codigo;
  ELSEIF p_tabla = 'canton' THEN
    SELECT nombre FROM catalogo_canton_tb WHERE codigo = p_codigo;
  ELSEIF p_tabla = 'parroquia' THEN
    SELECT nombre FROM catalogo_parroquia_tb WHERE codigo = p_codigo;
  END IF;
END;
