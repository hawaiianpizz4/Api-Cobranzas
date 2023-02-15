<?php    
    class Categoria extends Conectar{
        public function get_informacion_supervisores($nombre){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="CALL gestion_terreno.proc_consulta_gestor_usuario(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$nombre);
            $sql->execute();    
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } 
        public function insertForm($ci,$credito,$tipoG,$gCobranza,$tipoCont,$lat,$longi,$useIn,$locali,$obsDetalle,$plazoNuevo,$valorRenegociar){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="call gestion_terreno.proc_insert_gestion_cobros('$ci','$credito','$tipoG','$gCobranza','$tipoCont','$lat','$longi','$useIn','$locali',POINT($lat,$longi),'$obsDetalle','$plazoNuevo','$valorRenegociar','1')";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        public function historialXusuario($nombre){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="call gestion_terreno.proc_historial_usuario(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$nombre);
            $sql->execute();    
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>


