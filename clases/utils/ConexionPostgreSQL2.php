<?php
   
class ConexionPostgreSQL2{ 
      
     function IniciarConexion(){
       include("configuracion2.php");
      $conexion = pg_connect("host=$host dbname=$dbname password=$password user=$user");
       return $conexion;
   }
   
   function Agregar($sql){     
      $resultado = "";
      $conexion = self::IniciarConexion();
      if (!$conexion){
              $resultado = "error_conexion";
       }else{
             $resultado_set = pg_Exec ($conexion, $sql);
                if (!$resultado_set) {
                      $resultado = "no_inserto";
                }else{
                      $resultado = "inserto";
                }
             pg_close($conexion);
        }            
      return $resultado;
   }
   
     function Modificar($sql){     
      $resultado = "";
      $conexion = self::IniciarConexion();
      if (!$conexion){
              $resultado = "error_conexion";
       }else{
             $resultado_set = pg_Exec ($conexion, $sql);
              if (!$resultado_set) {
                      $resultado = "no_modifico";
                }else{
                      $resultado = "modifico";
                }
             pg_close($conexion);
        }            
      return $resultado;
   }
   
   
  function Eliminar($sql){     
      $resultado = "";
      $conexion = self::IniciarConexion();
      if (!$conexion){
              $resultado = "error_conexion";
       }else{
             $resultado_set = pg_Exec ($conexion, $sql);
              if (!$resultado_set) {
                      $resultado = "no_elimino";
                }else{
                      $resultado = "elimino";
                }
             pg_close($conexion);
        }            
      return $resultado;
   }
   
  
      function Consultar($sql){     
      $resultado = "";
      $conexion = self::IniciarConexion();
      if (!$conexion){
              $resultado = "error_conexion";
       }else{
             $resultado = pg_Exec ($conexion, $sql);
             pg_close($conexion);
        }            
      return $resultado;
   }

 
    
} 


?>
