<?php

require_once $RutaDao.'/utils/ConexionPostgreSQL.php';
class tecnicoDAO{
    
    function agregarTecnicoDAO($ci, $cargo, $nom, $apell){        
        
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        $sql = "SELECT * FROM srgbp.t61_tecnico_supervisor WHERE cedula_tecnico_supervisor = '".$ci."';";
        $txtResultado1 = $objConexionPostgreSQL->Consultar($sql);
        $filas = pg_numrows($txtResultado1);

        if($filas == 0){
            $sql2="INSERT INTO srgbp.t61_tecnico_supervisor(id_t62_cargo,cedula_tecnico_supervisor,nombre,apellido,id_t64_estatus) VALUES "
                    . "(".  $cargo.",'".$ci."','".strtoupper(trim($nom))."','".strtoupper(trim($apell))."',1"  . ");";
                   //die($sql2);
            $txtResultado = $objConexionPostgreSQL->Agregar($sql2);
        }else{
            $txtResultado = "ya_existe";
        }
        return $txtResultado;
        }
        
    function consultarTecnicoDAO($tecnico){
        if(!$tecnico==""){
        $sql="SELECT * from srgbp.t61_tecnico_supervisor WHERE id_t61_tecnico_supervisor=".$tecnico.";";
             }else{
                $sql="SELECT * from srgbp.t61_tecnico_supervisor;";            
                }
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);

        return $Resultado;
   }    
   
   //function modificarTecnicoDAO($ci, $cargo, $nom, $ape, $tecnico){
   function modificarTecnicoDAO($cargo, $nom, $ape, $tecnico){
       
         // $sql="UPDATE srgbp.t61_tecnico_supervisor SET id_t62_cargo=".$cargo.", cedula_tecnico_supervisor='".$ci
           //       ."', nombre='".strtoupper(trim($nom))."', apellido='".strtoupper(trim($ape))."' WHERE id_t61_tecnico_supervisor='".$tecnico."';";
          $sql="UPDATE srgbp.t61_tecnico_supervisor SET id_t62_cargo=".$cargo.", nombre='".strtoupper(trim($nom))."', apellido='".strtoupper(trim($ape))."' WHERE id_t61_tecnico_supervisor='".$tecnico."';";
          //die($sql);
          $objConexionPostgreSQL = new ConexionPostgreSQL();
          $txtResultado = $objConexionPostgreSQL->Modificar($sql);

      return $txtResultado;
   }
   
   function  eliminarTecnicoDAO($tecnico){
       
        /*para las tablas en donde existe como clave foranea*/
        $sql="SELECT * FROM srgbp.t59_solicitud WHERE id_t61_tecnico_supervisor=".$tecnico.";";
        $objConexionPostgreSQL1 = new ConexionPostgreSQL();
        $txtResultado1 = $objConexionPostgreSQL1->Consultar($sql);
        $filas = pg_numrows($txtResultado1);
          if(!($filas > 0)){
              $sql="DELETE FROM srgbp.t61_tecnico_supervisor WHERE id_t61_tecnico_supervisor=".$tecnico.";";
              $objConexionPostgreSQL = new ConexionPostgreSQL();
              $Resultado = $objConexionPostgreSQL->Eliminar($sql);
          }else{
              $Resultado = "existe_relacion";
          }
            //die($Resultado);          
            //die($sql);
        return $Resultado;
    }
    
    function selectTecnicoDAO(){
        $sql="SELECT id_t61_tecnico_supervisor, nombre, apellido from srgbp.t61_tecnico_supervisor WHERE id_t62_cargo=1 AND id_t64_estatus=1;";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);

        return $Resultado;
    }
    
    function selectSupervisorDAO(){
        $sql="SELECT id_t61_tecnico_supervisor, nombre, apellido from srgbp.t61_tecnico_supervisor WHERE id_t62_cargo=2 AND id_t64_estatus=1;";
        $objConexionPostgreSQL = new ConexionPostgreSQL();
        //die($sql);
        $Resultado = $objConexionPostgreSQL->Consultar($sql);

        return $Resultado;
    }
}
