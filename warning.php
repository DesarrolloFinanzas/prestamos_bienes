<?php
 session_start(); 
 $txtMensaje = "Su Sesi&oacute;n Expiro o Esta Tratando de Ingresar al Sistema de Manera Incorrecta Inicie Sesi&oacute;n Nuevamente!!!";     
 $txtimagen ="http://localhost/MFFEDEVIDA/comunes/img/warning01.jpg";
?>
<br><br><br><br><br><br>
<html>
    <script type="text/javascript" src="./comunes/script/manejoMFFEDEVIDA.js"></script>
      <link rel="stylesheet" type="text/css" href="./comunes/css/MFFedevida.css">
    <body>
    <table align="center" border="0" width="15%">
            <tr>
                <td width="400px" valign="top">
              <table align="center" border="0" width="400px">
                 <tr valign="top">  
                 <td height="80" class="tituloPrincipal" align="center">
                      <br>
                      SISTEMA FE DE VIDA
                     <br>
                     </td>
                 </tr>
                <tr>
                  <td align="center">
                     <img src="<?=$txtimagen  ?>">   
                  </td>
                </tr>
                <tr>
                          <td class="resultado" align="center">
                                 <?php 
                                      echo $txtMensaje;       
                                 ?>
                                 <br><br>
                                 <br>
                          </td>
               </tr>
                 </table>         
              </td>
            </tr>
        </table>
    </body>
</html>
<?session_destroy(); ?>
