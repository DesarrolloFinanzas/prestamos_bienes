<?php
ob_start();
if(!isset($_SESSION)){
    session_start();
}          
require_once $RutaDao.'/utils/ConexionPostgreSQL2.php';
class MenuDAO{ 
    function ConsultarMenuDAO($txtsistema){
        
      $objConexionPostgreSQL = new ConexionPostgreSQL2();  
      $sql="SELECT m.* from seguridad.t02_menu as m 
            where m.cid_t02_menu in
            (select p.cid_t02_menu from seguridad.t03_perfil as 
            p where p.c_tipo='".$_SESSION['tipo']."' ) and m.cid_t01_sistema=".$txtsistema."
            and m.c_activo='1'  order by cid_t02_menu;";
        //die($sql);
            $Resultado = $objConexionPostgreSQL->Consultar($sql);
      return $Resultado;
    }   
}
//and m.c_activo='1'
?>

