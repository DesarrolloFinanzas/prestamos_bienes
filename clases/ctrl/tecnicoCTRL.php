<?php
ob_start();    
$RutaDao = "..";
$txtAccion="";
include("../dao/tecnicoDAO.php");
$objtecnicoDAO = new tecnicoDAO();
session_start();

    //if ($_SESSION['txtAccion']=='') {
        if(isset($_GET["accion"])){
            $txtAccion = $_GET["accion"];
        }elseif (isset($_POST["accion"])) {
            $txtAccion = $_POST["accion"];   
            } else {
                die("<h1>PROBLEMAS CON LA VARIABLE 'accion'</h1>");
            }
        
            //die("$txtAccion");
        
        switch ($txtAccion){
            
            case "agregarTecnico":   
                
                $cedula = $_POST["cedula"];    
                $nombre = $_POST["nombre"];               
                $apellido= $_POST["apellido"];
                $cargo = $_POST["cargo"];
                $txtResultado = $objtecnicoDAO->agregarTecnicoDAO($cedula, $cargo, $nombre, $apellido);
                if($txtResultado == "ya_existe"){
                    $txtAccion = "Ya existe un tecnico con ese numero de cedula";
                    $txtimagen = "../../comunes/img/warning01.jpg";
                }else{
                    $txtAccion = "Se Agregó el Técnico Correctamente";
                    $txtimagen ="../../comunes/img/exito.jpeg";               
                }
                break;                
                
            case "EliminarTecnico":
                    
                $id = $_POST["tecnico"];
                $txtResultado = $objtecnicoDAO->eliminarTecnicoDAO($id);
                $txtAccion = "Se Eliminó el Técnico Correctamente";
                $txtimagen ="../../comunes/img/exito.jpeg";
                break;
            
            case "ModificaTecnico":
                
                //$cedula = $_POST["cedula"];    
                $nombre = $_POST["nombre"];               
                $apellido= $_POST["apellido"];
                $id_cargo = $_POST["cargo"];
                $id_tecnico = $_POST["tecnico"];
               // $txtResultado = $objtecnicoDAO->modificarTecnicoDAO($cedula, $id_cargo, $nombre, $apellido, $id_tecnico);
                $txtResultado = $objtecnicoDAO->modificarTecnicoDAO($id_cargo, $nombre, $apellido, $id_tecnico);
                $txtAccion = "Se Modificó el Técnico Correctamente";
                $txtimagen ="../../comunes/img/exito.jpeg";
                break;
                            
            default :
                
                die("NO HA LLEGADO NINGUN PARAMETRO CORRECTO AL CONTROLADOR");
                break;
                       
        }
            $_SESSION['txtAccion'] = $txtAccion;
            $_SESSION['txtimagen'] = $txtimagen;
header("Location: ../../app/admUsuario/ValidarResultTecnico.php");        
ob_end_flush();  
?>
