<!-- 
    Created on : 25/08/2010, 08:27:01 PM
    Author     : jose luis camacho ramirez
-->
<script>
window.onload=function(){
    top.centro.location='centro.php';
}

    
    function CheckLogin()
          {                
               document.form.action = "./clases/ctrl/UsuarioCTRL.php";
               document.form.submit(); 
          }
</script>	
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>  
<html>    
<head>
     <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
    <link rel="stylesheet" type="text/css" href="./comunes/css/mpfsrgbp.css">
    <body>
        <form name="form" method="post">
        <input type="hidden" name="accion" value="EntradaUsuario">
    <br><br><br><br>
     <table class="formulario" align="center" border="0">
                 <tr>  
                 <td class="formulario">
                    Usuario 
                 </td>
                 </tr>
                 <tr>
                 <td class="formulario">
                    <input id="username" name="username" autocomplete=off  type="text" size="12">
                 </td>
                    
                 </tr>
                 <tr>  
                 <td class="formulario">
                    Contrase&ntilde;a  
                 </td>   
                 </tr>
                 <tr>
                 <td class="formulario">
                    <input id="password" name="password" type="password" size="12">
                 </td>   
                </tr> 
                <tr>
                <td align="center" class="formulario">
                    <input class="boton" type="button" value="Iniciar Sesi&oacute;n" onClick="CheckLogin()">
                </td>    
                </tr>
      </table>  
      <?
      $valor = isset($_REQUEST['error']) ? $_REQUEST['error'] : NULL;  
      if ($valor<>NULL) { ?>  
    <br><br><br>
      <table class="formulario" align="center" border="0">
      <tr><td  align=center>
      <FONT color=red face=Arial size=2> <strong>El nombre de usuario o la contrase&ntilde;a no son válidos</strong></FONT>  
      </td>
      </tr>
      </table>
      <?}          
      ?>
      </form>
    </body>
</html>