<?php
require_once $RutaDao.'/utils/ConexionPostgreSQL2.php';
class SeguridadDAO{  

    
      function ConsultarurlDAO($url,$tipo){
          
       $sql="SELECT * from seguridad.t02_menu as a,seguridad.t03_perfil as b
           where a.cid_t02_menu=b.cid_t02_menu and 
           a.c_pagina='".$url."' and b.c_tipo='".$tipo."' and a.cid_t01_sistema=21;";
      //die($sql); 
      $objConexionPostgreSQL2 = new ConexionPostgreSQL2();
       
       $Resultado = $objConexionPostgreSQL2->Consultar($sql);

      return $Resultado;
      
   }      
   
function AgregaripDAO($ip,$txtFuncion){
    
    if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\\./',
                  '/^127\\.0\\.0\\.1/',
                  '/^192\\.168\\..*/',
                  '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                  '/^10\\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   $IP_del_visitante=$client_ip;
    

      $sql="INSERT INTO seguridad.t04_ip(cid_t04_ip, cid_t01_sistema,
          cid_t14_usuario, c_ip, c_registro,c_funcion)
   VALUES (NEXTVAL('seguridad.t04_ip_cid_t04_ip_seq'),21,".$ip.", 
       '".$IP_del_visitante."', localtimestamp(0),'".$txtFuncion."');";
      $objConexionPostgreSQL2 = new ConexionPostgreSQL2();
      //die($sql);
      $txtResultado = $objConexionPostgreSQL2->Agregar($sql);
      
      return $txtResultado;
   }
   
  
   function ConsultaripDAO(){
    
    if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\\./',
                  '/^127\\.0\\.0\\.1/',
                  '/^192\\.168\\..*/',
                  '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                  '/^10\\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   $IP_del_visitante=$client_ip;
      
      return $IP_del_visitante;
   }
   
   
}
?>


