<?php

require_once $RutaDao.'/utils/ConexionPostgreSQL.php';

class reporteDAO{
        
    function estatusBien($bien,$tp){
        if($tp==="serial_bien"){
            $sql = "
                    SELECT
                      t63_bienes_solicitud.id_t63_bienes_solicitud,   t06_unidades_administrativas.descripcion, 
                      t63_bienes_solicitud.recibido,   t59_solicitud.desde, 
                      t59_solicitud.hasta, t26_muebles.descripcion_estado_bien, t26_muebles.marca, t26_muebles.modelo, 
                      t26_muebles.prestado, t26_muebles.id_t26_muebles, t13_catalogo.c_des_catalogo
                    FROM 
                      srgbp.t06_unidades_administrativas,   srgbp.t26_muebles, 
                      srgbp.t59_solicitud,   srgbp.t63_bienes_solicitud, srgbp.t13_catalogo
                    WHERE 
                      t06_unidades_administrativas.id_t06_unidades_administrativas = t59_solicitud.id_t06_unidades_administrativas AND 
                      t26_muebles.id_t26_muebles = t63_bienes_solicitud.id_t26_muebles AND 
                      t63_bienes_solicitud.id_t59_solicitud = t59_solicitud.id_t59_solicitud AND 
                      t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo AND
                      t26_muebles.serial_bien = '$bien' AND 
                      t63_bienes_solicitud.id_t63_bienes_solicitud in (SELECT 
                                                                            max(t63_bienes_solicitud.id_t63_bienes_solicitud) 
                                                                    FROM 
                                                                            srgbp.t26_muebles, srgbp.t63_bienes_solicitud 
                                                                    WHERE 
                                                                            t26_muebles.serial_bien = '$bien' AND t26_muebles.id_t26_muebles = t63_bienes_solicitud.id_t26_muebles );";
        }else if($tp === "codigo_bien"){
            $sql = "
                    SELECT
                      t63_bienes_solicitud.id_t63_bienes_solicitud,   t06_unidades_administrativas.descripcion, 
                      t63_bienes_solicitud.recibido,   t59_solicitud.desde, 
                      t59_solicitud.hasta, t26_muebles.descripcion_estado_bien, t26_muebles.marca, t26_muebles.modelo,
                      t26_muebles.prestado, t26_muebles.id_t26_muebles, t13_catalogo.c_des_catalogo
                    FROM 
                      srgbp.t06_unidades_administrativas,   srgbp.t26_muebles, 
                      srgbp.t59_solicitud,   srgbp.t63_bienes_solicitud, srgbp.t13_catalogo
                    WHERE 
                      t06_unidades_administrativas.id_t06_unidades_administrativas = t59_solicitud.id_t06_unidades_administrativas AND 
                      t26_muebles.id_t26_muebles = t63_bienes_solicitud.id_t26_muebles AND 
                      t63_bienes_solicitud.id_t59_solicitud = t59_solicitud.id_t59_solicitud AND
                      t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo AND
                      t26_muebles.codigo_bien = '$bien' AND 
                      t63_bienes_solicitud.id_t63_bienes_solicitud in (SELECT 
                                                                            max(t63_bienes_solicitud.id_t63_bienes_solicitud) 
                                                                    FROM 
                                                                            srgbp.t26_muebles, srgbp.t63_bienes_solicitud 
                                                                    WHERE 
                                                                            t26_muebles.codigo_bien = '$bien' AND t26_muebles.id_t26_muebles = t63_bienes_solicitud.id_t26_muebles );";
        }else{
            die("Problema Generando Sql");
        }
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $txtResultado = $objConexionPostgreSQL->Consultar($sql);
        return $txtResultado;
    }
    
    function bienesUnidad($dsd, $hst, $unidad){
        
        $sql = "SELECT
                        t59_solicitud.id_t59_solicitud, t26_muebles.id_t26_muebles, t26_muebles.descripcion_estado_bien,
                        t26_muebles.marca, t26_muebles.modelo, t26_muebles.serial_bien, t26_muebles.codigo_bien, t59_solicitud.desde,
                        t59_solicitud.hasta, t63_bienes_solicitud.recibido, t13_catalogo.c_des_catalogo
                FROM
                        srgbp.t59_solicitud, srgbp.t26_muebles, srgbp.t06_unidades_administrativas, srgbp.t63_bienes_solicitud, srgbp.t13_catalogo
                WHERE
                        t59_solicitud.id_t06_unidades_administrativas = t06_unidades_administrativas.id_t06_unidades_administrativas AND
                        t63_bienes_solicitud.id_t26_muebles = t26_muebles.id_t26_muebles AND
                        t59_solicitud.id_t06_unidades_administrativas = $unidad AND
                        t63_bienes_solicitud.id_t59_solicitud = t59_solicitud.id_t59_solicitud AND
                        t13_catalogo.cid_t13_catalogo = t26_muebles.cid_t13_catalogo AND
                        t59_solicitud.fecha_solicitud BETWEEN '$dsd' AND '$hst'
                        ORDER BY id_t26_muebles;";
        //die($sql);
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $txtResultado = $objConexionPostgreSQL->Consultar($sql);
        return $txtResultado;
    }
        
}
?>