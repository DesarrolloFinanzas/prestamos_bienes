<?php


ob_start();
session_start();   
if(!isset($_SESSION['idusuario']) and ($_SESSION['idusuario']==null)) {
    header("Location: ../../warning.php");
}

$RutaDao = "../../clases";
$pagina="admPrestamo-agregarBienes";
require ("../../clases/dao/SeguridadDAO.php");
require ("../../clases/dao/UsuarioDAO.php");
$objSeguridadDAO = new SeguridadDAO();
$objUsuarioDAO = new UsuarioDAO();
$Resul_usu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
$filus = pg_numrows($Resul_usu);
if ($filus>0){
    $url='./app/admPrestamo/agregarBienes.php';
    $Resul_Segu = $objSeguridadDAO->ConsultarurlDAO($url,pg_result($Resul_usu, 0, 1));
    $filseg = pg_numrows($Resul_Segu);
    if ($filseg==0){
        header("Location: ../../warning3.php?f=".$pagina);
    }
}

require ("../../clases/dao/InicializarDAO.php");
$objInicializarDAO = new InicializarDAO();  
$ResIn=$objInicializarDAO->Inicializar(); 

require ("../../clases/dao/tecnicoDAO.php");
$objtecnicoDAO = new tecnicoDAO();
$Resultado = $objtecnicoDAO->consultarTecnicoDAO("");
$filas = pg_numrows($Resultado);
?>

<html>
    <head>
        <title>SISTEMA DESARROLLO - Consultar Estado</title>        
        
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_table.css">
        
        <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
        
        
        <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
        
        <script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
        <script>
            function Eliminar(ID,string) {

                Confirmar = confirm("Confirma que desea eliminar a: " + string);

                if(Confirmar){
                document.formConsultaTecnico.tecnico.value = ID;
                document.formConsultaTecnico.accion.value = "EliminarTecnico";
                document.formConsultaTecnico.action = "../../clases/ctrl/tecnicoCTRL.php";
                document.formConsultaTecnico.submit();     
                }            

            }  

            function Modificar(Id) {
                document.formConsultaTecnico.tecnico.value = Id;
                document.formConsultaTecnico.action = "./modificarTecnico.php";
                document.formConsultaTecnico.submit(); 
            }  

        </script> 
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
        <script type="text/javascript" language="javascript" src="../../media/js/jquery.js"></script>
        <script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /*llamado a la funcion para ejecutar el jquery del ordenamiento de la tabla*/
            $(document).ready(function() {
                            $('#example').dataTable( {
                             "sPaginationType": "full_numbers"
                            //	aaSorting": [[ 4, "desc" ]]
                            } );
                    } );
        </script>
    </head>

    
    
        <body id="dt_example">
            <div id="demo">
                <font size=1>
                    <div id="main_table_area" align="center" style="width: 70% !important; margin: auto;" >
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
                                       Consultar Tecnico<br><br><br>
                                </td>
                           </tr>
                        </table>
                        
                        <div style="width: 80%">
                        
                            <table cellpadding="3"   cellspacing="3" border="0" class="display"  id="example" class="table">
                          <thead>
                            <tr>
                              <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                  C&eacute;dula
                              </td>
                              <td class="resultado" bgcolor="#DAD6D6" align="center" width="35%">
                                  Nombre 
                              </td>
                              <td class="resultado" bgcolor="#DAD6D6" align="center" width="35%">
                                  Apellido
                              </td>
                              <td class="resultado" bgcolor="#DAD6D6" align="center" width="10%">
                                  Modificar
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
                                    $id = pg_result($Resultado, $j, 4);
                                    $nombre  = pg_result($Resultado, $j, 2);
                                    $apellido  = pg_result($Resultado, $j, 3);
                                    print(pg_result($Resultado, $j, 1));
                                    print("</td>");
                                    print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 2));
                                    print("</td>");
                                    print("<td  class='formulario' bgcolor='#F6eded'>");
                                    print(pg_result($Resultado, $j, 3));
                                    print("</td>");
                                    print("<td align='center' bgcolor='#F6eded'><img alt='Modificar'  class='imagen' src='../../comunes/img/modificar.png' onClick='javascript:Modificar(".$id.");'></td>");
                                    echo "<td align='center' bgcolor='#F6eded'><img alt='Eliminar'  class='imagen' src='../../comunes/img/eliminar.png' onClick='javascript:Eliminar(".$id.",".'"'.$nombre." ".$apellido.'"'.");'></td>";
                                    print("</tr>");
                                    }
                              }
                                ?>
                            </tbody>
                        </div>
                      </table>
                    </div>
                </font>
                </div>
                <div class="spacer"></div>
                <form name="formConsultaTecnico" action="#" method="post">
                    <input type="hidden" name="tecnico" value="">
                    <input type="hidden" name="accion" value="">
                </form>
        </body>        
</html>   
<? ob_end_flush(); ?>