<?php

ob_start();    
$RutaDao = "..";
$txtAccion="";
include("../dao/solicitudDAO.php");
$objSolicitud = new solicitudDAO();

//die("nigga");
session_start();

require ("../../clases/dao/UsuarioDAO.php");
$objUsuarioDAO = new UsuarioDAO();
$Resul_usu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
$usu = pg_fetch_assoc($Resul_usu);
//die(json_encode(pg_fetch_assoc($Resul_usu)));

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
                        
            case "Sigefi":
                if(!isset($usu["id_t06_unidades_administrativas"])){
                    echo "<input type='text' name='nombretrabajador' id='nombretrabajador' value='Su session ha expirado, por favor inicie session nuevamente' readonly style='width:500px'>";
                 }else{
                $cedula = $_GET["cedula"];
                //die(gettype($cedula));
                require '../dao/SigefirrhhDAO.php';
                $objSigefi = new SigefirrhhDAO();
                $resultado = $objSigefi->SigefiPrestamo($cedula);
                //die(json_encode(pg_fetch_assoc($resultado)));
                if(pg_num_rows($resultado)>0){
                    $sigefi = array_map("utf8_encode", pg_fetch_assoc($resultado));
                    echo "<input type='text' class='form-control' name='nombretrabajador' id='nombretrabajador' value='".$sigefi["primer_nombre"]." ".$sigefi["segundo_nombre"]." ".$sigefi["primer_apellido"]." ".$sigefi["segundo_apellido"]."' disabled style='width:300px'>";                                  
                }else{
                    echo "<input type='text'  class='form-control' name='nombretrabajador' id='nombretrabajador' value='No Existe' disabled style='width:300px'>";
                }
                }
                break;
            
            case "listar":
                
                //die("XXXXXXX<br>");
                $bien = $_GET["codigo"];
                $tipo = $_GET["tipo"];
                $objSolicitud  = new solicitudDAO();
                if(!isset($usu["id_t06_unidades_administrativas"])){
                    echo "<td colspan='5'><h1 align='center'> Su session ha expirado, por favor inicie session nuevamente. </h1></td>";
                }else{
                $consulta = $objSolicitud->bien($bien,$tipo,$usu["id_t06_unidades_administrativas"]);
                $resultado = pg_fetch_assoc($consulta);
                $numero = pg_num_rows($consulta);
                if($numero>0){
                    echo "<tr id='bien".$resultado["id_t26_muebles"]."'>"
                            . "<td bgcolor='#F6eded'>"
                            . $resultado["c_des_catalogo"]
                            . "</td>"
                            . "<td bgcolor='#F6eded'>"
                            . $resultado["serial_bien"]
                            . "</td>"
                            . "<td bgcolor='#F6eded'>"
                            . $resultado["marca"]
                            . "</td>"
                            . "<td bgcolor='#F6eded'>"
                            . $resultado["modelo"]
                            . "</td>"
                            . "<td bgcolor='#F6eded'>"
                            . $resultado["codigo_bien"]
                            . "</td>"
                            . "<td bgcolor='#F6eded'>"
                            . "<botton type='button' onclick='eliminarbien(".'"'."#bien".$resultado["id_t26_muebles"].'"'.")'><img src='../../comunes/img/elimina.png'></botton>"
                            . "</td>"
                            . "<td>"
                            . "<input type='hidden' name='bien[]' value='".$resultado["id_t26_muebles"]."'>"
                            . "</td>"
                        . "</tr>";
                }else{
                    echo "<div id='noexisteregistro'></div>";
                }                    
                }
                
                break;
            
            case "AgregarSolicitud":
                /*
                    $id_tecnico = $_POST["tecnico"];
                    $id_supervisor = $_POST["supervisor"];
                    $cedula_solicitantes = $_POST["cedula"];
                    $unidad_administrativa = $_POST["unidad_administrativa"];
                    $desde = $_POST["desde"];
                    $hasta = $_POST["hasta"];
                die("$id_tecnico---$id_supervisor---$cedula_solicitantes---$unidad_administrativa---$desde---$hasta");*/
                
                if(isset($_POST["tecnico"]) && isset($_POST["supervisor"]) && isset($_POST["cedula"]) &&
                        isset($_POST["unidad_administrativa"]) &&
                        isset($_POST["desde"]) && isset($_POST["hasta"]) && isset($_POST["bien"])){
                
                    $id_bien = $_POST["bien"];
                    $id_tecnico = $_POST["tecnico"];
                    $id_supervisor = $_POST["supervisor"];
                    $cedula_solicitantes = $_POST["cedula"];
                    $unidad_administrativa = $_POST["unidad_administrativa"];
                    $desde = $_POST["desde"];
                    $hasta = $_POST["hasta"];
                    $id_usuario = $_SESSION['idusuario'];                

                    ///////////////    A CONTINUACION CREO EL NUMERO DE SOLICITUD      //////////////////////////
                        $palabra = "";
                        $siglas = "";
                        $aux="si";
                        $id_UniAdm = $_POST["unidad_administrativa"];
                        $UniAdm = $objSolicitud->selectUnidadAdministrativaDAO($id_UniAdm);
                        $UniAdm = pg_result($UniAdm,0);

                        //////////////////// CON ESTO ME TRAIGO LO QUE ESTA DENTRO DE PARENTESIS   ///////////////////////////
                        $ddddd = preg_match('/\((.+)\)/', $UniAdm, $siglas);// El primer parametro es una expresion regular. Segundo parametro el el string y el tercero el arreglo donde se guarra el resultado.
                        ///////////////////// TERMINO DE EXTRAER TODO LO QUE ESTA ENTRE PARENTESIS    ////////////////////////

                        $siglas = $siglas[1];

                        //////////////// GENERANDO Siglas //////////////////
                            if(!$siglas){
                                for($i=0;$i<strlen($UniAdm);$i++){
                                    if($UniAdm[$i]!=" " && $aux="si"){
                                        $palabra .= $UniAdm[$i];
                                    } else {
                                        $palabra = "";
                                    }
                                    if( strlen($palabra) == 4){
                                        $siglas .= $palabra[0];
                                        $aux = "no";
                                    }
                            }
                        }               
                        ////////////////// Termino de Generar Siglas //////////////////

                        $nroSolicitud = date('Y').str_pad($siglas, 8, 0, STR_PAD_BOTH).str_pad($id_usuario, 2, 0, STR_PAD_LEFT);

                        $serial = $objSolicitud->serialUnidadDAO($nroSolicitud);
                        $consecutivo = pg_num_rows($serial) + 1;
                        //die("<br>".$consecutivo);
                        $nroSolicitud = $nroSolicitud.str_pad($id_usuario, 2, 0, STR_PAD_LEFT).str_pad($consecutivo,2,0,STR_PAD_LEFT);
                        //die($nroSolicitud);
                    /////////////////// TERMINO DE GENERAR NUMERO DE SOLICITUD /////////////////////

                        $txtResultado = $objSolicitud->agregarSolicitud($nroSolicitud, date('Y-m-d'), $id_tecnico, $cedula_solicitantes, $unidad_administrativa, $desde, $hasta, $id_usuario, $id_supervisor );
                        $id_solicitud = pg_result($txtResultado,0);

                        for ($i=0; $i< count($id_bien); $i++){
                            $txtResultado = $objSolicitud->agregarBien($id_bien[$i],$id_solicitud);
                            }                                     
                            $_SESSION['txtimagen'] ="../../comunes/img/exito.jpeg";
                            $_SESSION['txtAccion'] = "Solicitud Generada Exitosamente";
                            header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                }else{
                    die("Alguna Variable no Existe");
                }
                break;
                
            case "modificarSolicitud":
                
                $id_solicitud = $_POST["solicitud"];
                //$unidad_administrativa = $_POST["unidad_administrativa"];
                //$supervisor = $_POST["supervisor"];
                //$tecnico = $_POST["tecnico"];
                $desde = $_POST["desde"];
                $hasta = $_POST["hasta"];
                $id_bien = $_POST["bien"];
                
                //$objSolicitud->modificarSolicitud($id_solicitud, $supervisor, $tecnico, $desde, $hasta);
                $objSolicitud->modificarSolicitud($id_solicitud, $desde, $hasta);
                                
                for ($i=0; $i< count($id_bien); $i++){
                            $txtResultado = $objSolicitud->agregarBien($id_bien[$i],$id_solicitud);
                            }        
                            $txtimagen ="../../comunes/img/exito.jpeg";
                            $_SESSION['txtAccion'] = "Solicitud modificada exitosamente";
                header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                break;
            
            case "EliminarSolicitud":
                
                if(isset($_POST["solicitud"])){
                    $id = $_POST["solicitud"];
                    $txtResultado = $objSolicitud->eliminarSolicitud($id);
                    
                    $bienesSolicitud = $objSolicitud->bienes_solicitud($id);
                    for( $i=0 ; $i < pg_num_rows($bienesSolicitud) ; $i++){
                        $objSolicitud -> recibirBien ( pg_result($bienesSolicitud,$i,0) , $id );
                    }
                    
                    $txtAccion = "Se Eliminó la Solicitud Correctamente";
                    $txtimagen ="../../comunes/img/exito.jpeg";
                    $_SESSION['txtAccion'] = "Usted eliminó la solicitud Satisfactoriamente"; 
                    $_SESSION['txtimagen'] ="../../comunes/img/eliminado.jpeg";
                    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                    }else{
                    echo "No se encontró el id";
                }
                break;
            
            case "RecibirBienes":
                
                if(isset($_POST["bien"]) &&  isset($_POST["solicitud"]) &&  isset($_POST["recibido"])){
                     $id_bien = $_POST["bien"];
                    $id_solicitud = $_POST["solicitud"];
                    $recibido = $_POST["recibido"];
                    //die(json_encode($id_bien));

                    for ($i=0; $i< count($recibido); $i++){
                                $txtResultado = $objSolicitud->recibirBien($recibido[$i],$id_solicitud);
                                }
                                
                    $_SESSION['txtimagen'] ="../../comunes/img/exito.jpeg";
                    $_SESSION['txtAccion'] = "Bien recibido Exitosamente";    
                    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                }else{
                    $_SESSION['txtAccion'] = "Ninguna opción marcada."; 
                    $_SESSION['txtimagen'] ="../../comunes/img/warning01.jpg";
                    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                }
                break;
                
            case "imprimirSolicitud":
                if(!isset($_POST["solicitud"])){
                    die("problemas con el id de la solicitud");
                }                
                $solicitud = $objSolicitud->consultarSolicitudDAO($_POST["solicitud"]);
                $cedula = pg_result($solicitud,1);
                
                require '../dao/SigefirrhhDAO.php';
                $objSigefi = new SigefirrhhDAO();
                $sigefi = $objSigefi->SigefiPrestamo($cedula);
                $resultado = array_map("utf8_encode", pg_fetch_assoc($sigefi));
                if(pg_num_rows($sigefi)>0){
                    $ciudadano = $resultado["primer_nombre"]." ".$resultado["segundo_nombre"]." ".$resultado["primer_apellido"]." ".$resultado["segundo_apellido"];
                    //die($ciudadano);
                }else{
                    $_SESSION['txtAccion'] = "Error Debido a que no se Encontró en Numero de Cédula en Sigefi."; 
                    $_SESSION['txtimagen'] ="../../comunes/img/warning01.jpg";
                    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");                    
                }
                
                include("../../comunes/script/JasperClient.php");
                // ** Los valores de las variales se agregan en el archivo settings.yml **
                //**desarrollo y calidad**//
                $jasper_url = "http://10.5.13.51:8080/jasperserver/services/repository";
                $jasper_username = "jasperadmin";
                $jasper_password = "jasperadmin";

                $client = new JasperClient($jasper_url, $jasper_username, $jasper_password);
                /**desarrollo**/
                $report_unit = "/BIENES/acta_prestamo";

                $report_params = array('id_solicitud' => $_POST["solicitud"] , 'cedula'=>$cedula,'ciudadano'=>$ciudadano);
                $report_format = "PDF";
                $result = $client->requestReport($report_unit, $report_format,$report_params);
                header("Content-type: application/pdf");
                echo $result;                
                break;

            default :
                
                die("NO HA LLEGADO NINGUN PARAMETRO CORRECTO AL CONTROLADOR");
                
                    break;                       
        }
        
        if($txtAccion=="SDFGHJ"){ 
            $_SESSION['txtAccion'] = $txtAccion;
            $_SESSION['txtResultado'] = $txtResultado;
            
            header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");   
        }
ob_end_flush();  
?>
