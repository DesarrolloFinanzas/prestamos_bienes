<?php
ob_start();
if(!isset($_SESSION)){
    session_start();
}

$RutaDao = "..";
include("../dao/UsuarioDAO.php");
$objUsuarioDAO = new UsuarioDAO();
$txtAccion = $_REQUEST["accion"] ;  
$_SESSION['txtAccion'] = $txtAccion;
if($txtAccion=="EntradaUsuario"){
     $txtlogin = $_REQUEST["username"] ; 
     $txtpassword = $_REQUEST["password"] ; 
 /*    $cedula=conexion_ldap($txtlogin,$txtpassword); 
    //die($cedula);
    if ($cedula > 0) {*/

           
     $txtResultado = $objUsuarioDAO->CheckLoginDAO($txtlogin,$txtpassword);
     $filas = pg_numrows($txtResultado);
     if ($filas > 0) {
        if(pg_result($txtResultado, 0, 10)<>'N') { 
        $_SESSION['idusuario'] = pg_result($txtResultado, 0, 0);
        $_SESSION['tipo'] = pg_result($txtResultado, 0, 1);
        //die($filas.pg_result($txtResultado, 0, 10));
        header("Location: ../../menu.php"); }
        else {
            header("Location: ../../login.php?error=error"); }
     }else{
        header("Location: ../../login.php?error=error");
     }
}
ob_end_flush();
?>