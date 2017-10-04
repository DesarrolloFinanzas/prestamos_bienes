<?php
if(!isset($_SESSION)){
ob_start(); 
session_start();  
} 
class InicializarDAO{  
function Inicializar(){
    unset($_SESSION['txtAccion']);
    ob_end_flush();
    return true;
    }
}
?>
