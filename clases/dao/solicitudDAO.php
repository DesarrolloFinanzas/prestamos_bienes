<?php

require_once $RutaDao.'/utils/ConexionPostgreSQL.php';

class solicitudDAO{ 
        
    function selectTecnicoDAO(){
        $sql="SELECT id_t61_tecnico_supervisor, nombre, apellido from srgbp.t61_tecnico_supervisor WHERE id_t62_cargo=1 AND id_t64_estatus=1;";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }
    
    function selectSupervisorDAO(){
        $sql="SELECT id_t61_tecnico_supervisor, nombre, apellido  from srgbp.t61_tecnico_supervisor WHERE id_t62_cargo=2 AND id_t64_estatus=1;";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }
    
    function selectUnidadAdministrativaDAO($UniAdm){
        if($UniAdm != ""){
            $sql="SELECT descripcion from srgbp.t06_unidades_administrativas WHERE id_t06_unidades_administrativas=$UniAdm;";
        }else{          
            $sql="SELECT id_t06_unidades_administrativas,descripcion,codigo from srgbp.t06_unidades_administrativas WHERE c_activo = 'S' ORDER BY descripcion;";
        }       
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }
    
    function bien($codigo,$tp,$uni){
        if($tp == "codigo_bien"){
            $sql="SELECT id_t26_muebles,descripcion_estado_bien,serial_bien,marca,modelo,codigo_bien, t13_catalogo.c_des_catalogo from srgbp.t26_muebles, srgbp.t13_catalogo WHERE codigo_bien='".$codigo."' AND prestado<>TRUE AND t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo AND id_t06_unidades_administrativas=$uni;";
        }else if($tp == "serial_bien"){
            $sql="SELECT id_t26_muebles,descripcion_estado_bien,serial_bien,marca,modelo,codigo_bien, t13_catalogo.c_des_catalogo from srgbp.t26_muebles, srgbp.t13_catalogo WHERE serial_bien='".$codigo."' AND prestado<>TRUE AND t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo AND id_t06_unidades_administrativas=$uni;";  
        }else{
            die("No se ha podido crear el sql correctamente");
        }
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }
    
    function agregarSolicitud($solicitud, $fecha, $tecnico, $cedula, $uniadm, $dsd, $hst, $usuario, $supervisor){
        
        $sql = "INSERT INTO srgbp.t59_solicitud(nro_solicitud,fecha_solicitud,id_t61_tecnico,cedula_solicitante,id_t06_unidades_administrativas,desde,hasta,id_t60_usuario_prestamo,id_64_estatus,id_t61_supervisor)"
                . " VALUES('$solicitud', '$fecha', $tecnico, '$cedula', $uniadm, '$dsd', '$hst', $usuario , 3, $supervisor);"
                . ""
                . "SELECT currval('srgbp.t59_solicitud_id_t59_solicitud_seq');";
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $txtResultado = $objConexionPostgreSQL->Consultar($sql);
        return $txtResultado;
    }
    
    function serialUnidadDAO($nro){
        $sql = "SELECT nro_solicitud FROM srgbp.t59_solicitud WHERE substring(nro_solicitud for 14) = '$nro';";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }
    
    function agregarBien($bien, $solicitud){
        $sql = "INSERT INTO srgbp.t63_bienes_solicitud(id_t26_muebles, id_t59_solicitud, recibido)"
                ."VALUES($bien, $solicitud, FALSE);";
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $Resultado = $objConexionPostgreSQL->Agregar($sql);
        if($Resultado!=="no_inserto"){
            $sql2 = "UPDATE srgbp.t26_muebles SET prestado=TRUE WHERE id_t26_muebles=$bien;";
            $objConexionPostgreSQL = new ConexionPostgreSQL();
            $txtResultado = $objConexionPostgreSQL->Modificar($sql2);
        }
        return $Resultado;
    }
    
    function consultarSolicitudDAO($solicitud){
        
        if($solicitud==""){
            $sql = "SELECT 
                            t59_solicitud.id_t59_solicitud, t59_solicitud.nro_solicitud, t61_tecnico_supervisor.nombre, 
                            t61_tecnico_supervisor.apellido, t59_solicitud.desde, t59_solicitud.hasta, 
                            t59_solicitud.id_t06_unidades_administrativas, t59_solicitud.cedula_solicitante,fecha_solicitud, 
                            t64_estatus.estatus, t06_unidades_administrativas.descripcion
                    FROM 
                            srgbp.t59_solicitud,srgbp.t61_tecnico_supervisor, srgbp.t64_estatus, srgbp.t06_unidades_administrativas 
                    WHERE 
                            t61_tecnico_supervisor.id_t61_tecnico_supervisor = t59_solicitud.id_t61_tecnico AND 
                            t64_estatus.id_t64_estatus = t59_solicitud.id_64_estatus AND 
                            t06_unidades_administrativas.id_t06_unidades_administrativas = t59_solicitud.id_t06_unidades_administrativas AND
                            srgbp.t59_solicitud.id_64_estatus = 3 
                            ORDER BY fecha_solicitud DESC;";
            }else{
                //die($solicitud);
                $sql = "SELECT "
                . "t59_solicitud.id_t59_solicitud, t59_solicitud.cedula_solicitante, t59_solicitud.nro_solicitud,
                    t61_tecnico_supervisor.nombre, t61_tecnico_supervisor.apellido, t59_solicitud.desde, t59_solicitud.hasta,
                    t59_solicitud.id_t06_unidades_administrativas,t59_solicitud.id_t61_tecnico,t59_solicitud.id_t61_supervisor, t59_solicitud.id_64_estatus "
             . "FROM "
                . "srgbp.t59_solicitud,srgbp.t61_tecnico_supervisor"
             . " WHERE "
                . "t61_tecnico_supervisor.id_t61_tecnico_supervisor = t59_solicitud.id_t61_tecnico AND t59_solicitud.id_t59_solicitud = $solicitud;";            
            }        
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        return $Resultado;
    }   
    
    function bienes_solicitud($solicitud){
       $sql = "SELECT
        	t26_muebles.id_t26_muebles, t26_muebles.descripcion_estado_bien, t26_muebles.serial_bien, t26_muebles.marca, t26_muebles.modelo, t26_muebles.codigo_bien, t63_bienes_solicitud.recibido, t13_catalogo.c_des_catalogo 
            FROM
        	srgbp.t63_bienes_solicitud, srgbp.t26_muebles, srgbp.t13_catalogo
            WHERE
        	t63_bienes_solicitud.id_t59_solicitud = $solicitud AND
        	t63_bienes_solicitud.id_t26_muebles = t26_muebles.id_t26_muebles AND t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo;";
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $Resultado = $objConexionPostgreSQL->Consultar($sql);
        //die(var_dump(pg_fetch_array($Resultado)));
        return $Resultado;
    }
        
    function eliminarSolicitud($solicitud){
       
        $sql="UPDATE srgbp.t59_solicitud SET id_64_estatus=". 2 ." WHERE id_t59_solicitud=$solicitud;";
          //die($sql);
          $objConexionPostgreSQL = new ConexionPostgreSQL();
          $txtResultado = $objConexionPostgreSQL->Modificar($sql);
        
        return $txtResultado;
        }
                
   // function modificarSolicitud($solicitud, $super, $tecn, $dsd, $hst){
    function modificarSolicitud($solicitud, $dsd, $hst){
        
        //$sql  = "UPDATE srgbp.t59_solicitud SET id_t61_supervisor=$super, id_t61_tecnico=$tecn, desde='$dsd', hasta='$hst' WHERE id_t59_solicitud=$solicitud";
        $sql  = "UPDATE srgbp.t59_solicitud SET desde='$dsd', hasta='$hst' WHERE id_t59_solicitud=$solicitud";
        
        $Dsql = "DELETE FROM srgbp.t63_bienes_solicitud WHERE id_t59_solicitud=$solicitud;";
        
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        
        $txtResultado = $objConexionPostgreSQL->Modificar($sql);                
        $Resultado = $objConexionPostgreSQL->Eliminar($Dsql);
        
        return $txtResultado.", ".$Resultado;
    }   
    
    function recibirBien($bien,$solicitud){
        
        $sql = "UPDATE srgbp.t63_bienes_solicitud SET recibido=true WHERE id_t26_muebles=$bien AND id_t59_solicitud=$solicitud;";
        $sql2 = "UPDATE srgbp.t26_muebles SET prestado=false WHERE id_t26_muebles=$bien;";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $txtResultado = $objConexionPostgreSQL->Modificar($sql);
        $objConexionPostgreSQL->Modificar($sql2);
        $sqlSolicitud = "SELECT * FROM srgbp.t63_bienes_solicitud WHERE t63_bienes_solicitud.id_t59_solicitud=$solicitud;";
        $Solicitudes = $objConexionPostgreSQL->Consultar($sqlSolicitud);
        $sqlBienesRecibidos = "SELECT * FROM srgbp.t63_bienes_solicitud WHERE t63_bienes_solicitud.id_t59_solicitud=$solicitud AND t63_bienes_solicitud.recibido=TRUE;";
        $BienesRecibidos = $objConexionPostgreSQL->Consultar($sqlBienesRecibidos);
        
        if(pg_num_rows($Solicitudes) == pg_num_rows($BienesRecibidos)){
            $sqlCerrar = "UPDATE srgbp.t59_solicitud SET id_64_estatus=4 WHERE id_t59_solicitud=$solicitud;";
            $txtResultado = $objConexionPostgreSQL->Modificar($sqlCerrar);
        }
        
        return $txtResultado;
        }
        
    function estatusBien($bien){
        $sql = "SELECT 
                        t63_bienes_solicitud.id_t63_bienes_solicitud, t06_unidades_administrativas.descripcion, t63_bienes_solicitud.recibido, t59_solicitud.desde, t59_solicitud.hasta
                FROM 
                        srgbp.t06_unidades_administrativas, srgbp.t26_muebles, srgbp.t59_solicitud, srgbp.t63_bienes_solicitud
                WHERE
                        t06_unidades_administrativas.id_t06_unidades_administrativas = t59_solicitud.id_t06_unidades_administrativas AND
                        t26_muebles.id_t26_muebles = t63_bienes_solicitud.id_t26_muebles AND
                        t63_bienes_solicitud.id_t59_solicitud = t59_solicitud.id_t59_solicitud AND
                        t26_muebles.serial_bien = '161024A50270SP0009' AND
                        t63_bienes_solicitud.id_t63_bienes_solicitud 
                        in (SELECT max(t63_bienes_solicitud.id_t63_bienes_solicitud)
                            FROM srgbp.t26_muebles, srgbp.t63_bienes_solicitud 
                            WHERE t26_muebles.serial_bien = '161024A50270SP0009');";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $txtResultado = $objConexionPostgreSQL->Consultar($sql);
        return $txtResultado;
    }
        
}      
    
?>