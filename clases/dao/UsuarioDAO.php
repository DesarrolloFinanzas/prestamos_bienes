<?php
require_once $RutaDao.'/utils/ConexionPostgreSQL.php';
class UsuarioDAO{  

function ConsultarDatosUsuarioDAO($txtidUsuario){

    $objConexionPostgreSQL = new ConexionPostgreSQL();

    $sql="SELECT * FROM srgbp.t60_usuario_prestamo"
            . " WHERE cid_t60_usuario_prestamo=".$txtidUsuario.";";
    
    //die($sql);
    $Resultado = $objConexionPostgreSQL->Consultar($sql);

    return $Resultado;
}

function CheckLoginDAO($txtlogin,$txtpassword){

  $objConexionPostgreSQL = new ConexionPostgreSQL(); 

  $sql="SELECT * FROM srgbp.t60_usuario_prestamo 
       WHERE c_login='".strtoupper(trim($txtlogin))."' 
       and c_clave='".strtoupper($txtpassword)."';";
  //die($sql);
  $Resultado = $objConexionPostgreSQL->Consultar($sql);
  //die($Resultado);
  return $Resultado;
} 

function CheckLogin2DAO($txtcedula){

  $objConexionPostgreSQL = new ConexionPostgreSQL(); 
  
  $sql="SELECT * FROM t60_usuario_prestamo 
       WHERE c_cedula='".trim($txtcedula)."';";
  
  //die($sql);
  $Resultado = $objConexionPostgreSQL->Consultar($sql);
  return $Resultado;
}
}
?>