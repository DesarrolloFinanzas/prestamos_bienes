<?php

session_start();
$txtAccion =  $_SESSION["txtAccion"];
?>
<html>
    <head>
        <title>SISTEMA DESARROLLO </title>
    </head>
    <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
    <body onload="">
    <table align="center" border="0" width="100%">
            <tr>
                <td width="758px" valign="top">
            <table align="center" border="0" width="758px">
              <tr>
                 <td>
                             <?php 
                                 $txtRutaImagen = "../../comunes";
                                 $txtRutaIndex = "../..";
                             ?> 
              </td>
              </tr>
             </table>
              <table align="center" border="0" width="758px">
                 <tr valign="top">  
                 <td height="80" class="tituloPrincipal" align="center">
                      <br>
                      <label class="label label-default" style="font-size: 35px">SISTEMA PRESTAMO BIENES</label>
                     <br>
                     </td>
                 </tr>
                  <tr>
                          <td class="subtitulo" align="center">
                            <?php 
                                      echo $txtAccion;       
                                 ?>
                                <br><br><br>
                          </td>
                </tr>
                <tr>
                  <td align="center">
                    <img src="<?php echo $_SESSION['txtimagen'];  ?>">   
                  </td>
                </tr>
                <tr>
                          <td class="resultado" align="center">
                                 <a href="./consultarTecnico.php">Consultar Tecnico(a)/Supervisor(a)</a>
                                 <br>
                          </td>
               </tr>
                 </table>         
     </td>
            </tr>
        </table>
    </body>
</html>