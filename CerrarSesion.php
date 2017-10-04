<?php
 session_start(); 
 $txtMensaje = "Su Sesi&oacute;n se Cerro Correctamente!!!";     
 $txtimagen ="./comunes/img/exito.jpeg";
?>
<script>
function salir()
{
window.open('./blanco.html', 'menu');
} 
</script>
<html>
<head>
 <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>SISTEMA REGISTRO GENERAL DE BIENES P&Uacute;BLICOS</title>
</head>
 <link rel="stylesheet" type="text/css" href="./comunes/css/mpfsrgbp.css">
<body onload="javascript:salir()" >
<br><br><br><br><br><br>
<div id="centrale" align="center">

	<table class="centrale" width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" class="centrale">
	<table border="0" width="650px" cellspacing="3" cellpadding="5" align="center">

<tr>
<td valign="top" width="100%" height="225">
 <div align="center">

    <fieldset class="fieldset">
    <legend class="legend"><font color="#0590E6"><b>SALIDA DEL SISTEMA</b></font></legend>
<div  align='center'>
<img src='./comunes/img/SalirSistema.png' border='0'><p>
<br>
Su sesi&oacute;n se cerr&oacute; correctamente.<p>
<p>&nbsp;</p>
</div>
    </fieldset>

  </div>
</td>
</tr>
	</table>
	
	</td>
	</tr>
		</table>
</div>
</body>
</html>
<?  
    session_destroy(); ?>