<?php
session_start(); 
$RutaDao = "./clases";
require ("./clases/dao/SeguridadDAO.php");
$objSeguridadDAO = new SeguridadDAO();
$txtFuncion = $_REQUEST["f"] ;
$Resul_Segu = $objSeguridadDAO->AgregaripDAO($_SESSION['idusuario'],$txtFuncion);

 ?>
<html>
<head>
 <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Sistema Fe de Vida</title>
</head>
 <link rel="stylesheet" type="text/css" href="./comunes/css/MFFedevida.css">
<br>
<div id="centrale" align="center">

	<table class="centrale" border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" class="centrale">
	<table border="0" width="650px" cellspacing="3" cellpadding="5" align="center">

<tr>
<td valign="top" width="100%" height="225">
 <div align="center">

    <fieldset class="fieldset">
    <legend class="legend"><font color="#0590E6"><b>Area Privada</b></font></legend>
<div  align='center'>
<img src='./comunes/img/noacceso.jpg' border='0'><p class="formulario">
<br>
Tu ip <?php echo $Resul_Segu ?>  quedo registrado, NO lo intentes m&aacute;s gracias....</p>
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
</html>
<?  
    session_destroy(); ?>
