<?php

ob_start();
session_start();   
if(!isset($_SESSION['idusuario']) and ($_SESSION['idusuario']==null)) {
    header("Location: ../../warning.php");
}

$RutaDao = "../../clases";
$pagina="admPrestamo-consultarSolicitud";
require ("../../clases/dao/SeguridadDAO.php");
require ("../../clases/dao/UsuarioDAO.php");
$objSeguridadDAO = new SeguridadDAO();
$objUsuarioDAO = new UsuarioDAO();
$Resul_usu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
$filus = pg_numrows($Resul_usu);
if ($filus>0){
    $url='./app/admPrestamo/consultarSolicitud.php';
    $Resul_Segu = $objSeguridadDAO->ConsultarurlDAO($url,pg_result($Resul_usu, 0, 1));
    $filseg = pg_numrows($Resul_Segu);
    if ($filseg==0){
        header("Location: ../../warning3.php?f=".$pagina);
    }
}


require ("../../clases/dao/InicializarDAO.php");
$objInicializarDAO = new InicializarDAO();  
$ResIn=$objInicializarDAO->Inicializar(); 

require ("../../clases/dao/solicitudDAO.php");
$objSolicitudDAO = new solicitudDAO();
$Resultado = $objSolicitudDAO->consultarSolicitudDAO("");
$filas = pg_numrows($Resultado);

?>

<html>
    <head>
        <title>SISTEMA de Prestamos de Bienes - Consultar Solicitudes</title>
        
        
        <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_table.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
        
        <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
        <script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
        <script>
            function Eliminar(ID,string) {

                Confirmar = confirm("Confirma que desea eliminar la Solicitud: " + string);
                if(Confirmar){
                    document.formConsultaTecnico.solicitud.value = ID;
                    document.formConsultaTecnico.accion.value = "EliminarSolicitud";
                    document.formConsultaTecnico.action = "../../clases/ctrl/solicitudCTRL.php";
                    document.formConsultaTecnico.submit();     
                }
            }

            function Modificar(Id) {
                document.formConsultaTecnico.solicitud.value = Id;
                document.formConsultaTecnico.action = "./modificarSolicitud.php";
                document.formConsultaTecnico.submit(); 
            }
            
            function recibirBienes(id){
                document.formConsultaTecnico.solicitud.value = id;
                document.formConsultaTecnico.action = "./recibirBienes.php";
                document.formConsultaTecnico.submit();                
            }
            
            function imprimirSolicitud(Id){
                document.formConsultaTecnico.solicitud.value = Id;
                document.formConsultaTecnico.accion.value = "imprimirSolicitud";
                document.formConsultaTecnico.action = "../../clases/ctrl/solicitudCTRL.php";
                document.formConsultaTecnico.submit();
            }
            
            
            
            
            
        </script> 
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
        <script type="text/javascript" language="javascript" src="../../media/js/jquery.js"></script>
        <script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>
        
        <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
        <script type="text/javascript" charset="utf-8">
            /*llamado a la funcion para ejecutar el jquery del ordenamiento de la tabla*/
            $(document).ready(function() {
                    var table =    $('#example').dataTable({
                             "sPaginationType": "full_numbers",
                             "aaSorting": [[ 1, "desc" ]]
                            });
                    });
        </script>
    </head>
    
    <body>
        
        <div id="demo">
            <font size=1>
                <div id="main_table_area" style="width: 70% !important; margin: auto;" >
                    <table align="center" border="0" width="100%">
                        <tr valign="top">
                        <td height="80" class="tituloPrincipal" align="center">
                      <br>
                      <label class="label label-default" style="font-size: 35px">SISTEMA PRESTAMO BIENES</label>
                     <br>
                        </td>
                        </tr>
                        <tr>
                            <td class="subtitulo" align="center">
                                   Consultar Solicitud<br><br><br>
                            </td>
                       </tr>
                    </table>
                    <table cellpadding="3"   align="center" cellspacing="3" border="0" class="table"  id="example" >
                        <thead>
                            <tr>
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                    N&uacute;mero de Solicitud
                                </td>
                                <!--<td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                    Técnico
                                </td>-->
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                    Fecha
                                </td>
                                <!--<td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                    Desde
                                </td>-->
                                <!--<td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                    Hasta
                                </td>-->
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="40%">
                                    Unidad Administrativa
                                </td>
                                <!--<td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                    Estatus
                                </td>-->
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                    Recibir Bienes
                                </td>
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                    Modificar
                                </td>
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                    Imprimir
                                </td>
                                </td>
                                <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                    Eliminar
                                </td>
                            </tr>
                        </thead>
                      <tbody>
                      <?php
                        $i = 0;
                        $total = pg_num_rows($Resultado);
                            if($filas > 0){
                                for ($j=0; $j < $filas; $j++) {
                                    print("<tr><td class='formulario' bgcolor='#F6eded'>");
                                    $id = pg_result($Resultado, $j, 0);
                                    print(pg_result($Resultado, $j, 1));
                                    print("</td>");
                                    /*print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 2)." ");
                                    print(pg_result($Resultado, $j, 3));
                                    print("</td>");*/
                                    print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(date("d/m/Y",strtotime(pg_result($Resultado, $j, 8))));
                                    /*print("</td>");
                                    print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 4)." ");
                                    print("</td>");*/
                                    /*print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 5)." ");
                                    print("</td>");
                                    print("</td>");*/
                                    
                                    print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 10)." ");
                                    print("</td>");
                                                                        
                                    /*print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 9)." ");
                                    print("</td>");*/
                                    
                                    print("<td align='center' bgcolor='#F6eded'><botton type='button' onClick='javascript:recibirBienes(".$id.")'><img src='../../comunes/img/recibir.gif'></botton></td>");
                                    print("<td align='center' bgcolor='#F6eded'><img alt='Modificar'  class='imagen' src='../../comunes/img/modificar.png' onClick='javascript:Modificar(".$id.");'></td>");
                                    print("<td align='center' bgcolor='#F6eded'><botton type='button' onClick='javascript:imprimirSolicitud(".$id.")'><img src='../../comunes/img/pdf.ico' width='35px'></botton></td>");
                                    echo "<td align='center' bgcolor='#F6eded'><img alt='Eliminar'  class='imagen' src='../../comunes/img/eliminar.png' onClick='javascript:Eliminar(".$id.",".'"'.pg_result($Resultado, $j, 1).'"'.");'></td>";
                                    print("</tr>");
                                    }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </font>
        </div>
            <form name="formConsultaTecnico" action="#" method="post">
                <input type="hidden" name="solicitud" value="">
                <input type="hidden" name="accion" value="">
            </form>
    </body>
    
</html>