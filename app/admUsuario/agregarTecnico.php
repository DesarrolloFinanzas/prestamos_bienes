<?php

ob_start();
session_start();   
if(!isset($_SESSION['idusuario']) and ($_SESSION['idusuario']==null)) {
    header("Location: ../../warning.php");
}

$RutaDao = "../../clases";
$pagina="admUsuario-AgregarTecnico";
require ("../../clases/dao/SeguridadDAO.php");
require ("../../clases/dao/UsuarioDAO.php");
$objSeguridadDAO = new SeguridadDAO();
$objUsuarioDAO = new UsuarioDAO();
$Resul_usu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
$filus = pg_numrows($Resul_usu);
if ($filus>0){
    $url='./app/admUsuario/agregarTecnico.php';
    $Resul_Segu = $objSeguridadDAO->ConsultarurlDAO($url,pg_result($Resul_usu, 0, 1));
    $filseg = pg_numrows($Resul_Segu);
    if ($filseg==0){
        header("Location: ../../warning3.php?f=".$pagina);
    }
}

require ("../../clases/dao/InicializarDAO.php");
$objInicializarDAO = new InicializarDAO();  
$ResIn=$objInicializarDAO->Inicializar(); 
?>

<html>
<head>
<title>Agregar Estado</title>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
    <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">

<script>
    
    function ValidarForm(e) {
        if(validaForm(e) === false){
            return false;
        }else{
        document.formAgregarTecnico.action = "../../clases/ctrl/tecnicoCTRL.php";
        document.formAgregarTecnico.submit();
    } 
   }
</script>
    </head>
    <body>
        <table align="center" border="0" width="100%">
            <tr>
            <td width="758px" valign="top">
             <table align="center" border="0" width="100%">
              <tr valign="top">
                 <td>
                             <?php 
                                 $txtRutaImagen = "../../comunes";
                                 $txtRutaIndex = "../..";
                             ?> 
              </td>
              </tr>
             </table>
             <table align="left" border="0" width="100%">
                 <tr valign="top">  
                 <td height="80" class="tituloPrincipal" align="center">
                      <br>
                      <label class="label label-default" style="font-size: 35px">SISTEMA PRESTAMO BIENES</label>
                     <br>
                     </td>
                 </tr>
                 </table>      
                         <form name="formAgregarTecnico" action="#" method="post">
                         <input type="hidden" name="accion" value="agregarTecnico">
                             <table border="0" align="center">                                   
                               <tr>
                                <td class="formulario">    
                                    <div class="form-group">
                                        <div class="label label-danger" style="font-size: 20px">Supervisor (a) / Técnico (a)</div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="cedula" style="width: 150px">Cédula:</label></span>
                                            <input type="text" name="cedula" id="cedula" value="" onkeypress="checkInteger(event)" title="Cédula" required="" maxlength="8" style="width: 90px" class="form-control">
                                       </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="nombre" style="width: 150px">Nombre:</label></span>
                                            <input type="text" name="nombre" id="nombre" value="" onkeypress="checkCharacter(event)" title="Nombre" required="" maxlength="21" style="width: 180px" class="form-control">
                                       </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="apellido" style="width: 150px">Apellido:</label></span>
                                            <input type="text" name="apellido" id="apellido" value="" onkeypress="checkCharacter(event)" title="Nombre" required="" maxlength="21" style="width: 180px" class="form-control">
                                       </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="cargo" style="width: 150px">Tipo:</label></span>
                                         
                                              <select name="cargo" id="cargo" required="" title="Cargo" style=" width:180px" class="form-control">
                                                  <option value="">Seleccione</option>
                                                  <option value="1">Técnico</option>
                                                  <option value="2">Supervisor</option>
                                              </select>
                                        </div>
                                    </div> 
                                </td>

                               <tr valign="top">
                                          <td colspan="2" class="formulario" valign="top" align="center">
                                                <br>
                                                <input type="button" class="btn btn-info" onclick="ValidarForm(this.form)" value="Agregar">
                                                <input class="btn btn-info" type="button" value="Cancelar" onclick="javascript:cancelar(document.formAgregarTecnico,'../../centro.php');">
                                         </td>
                                </tr>
                             </table>
                         </form>
                     </td>    
            </tr>
        </table>
    </body>
    
<script type="text/javascript" src="../../comunes/script/generales.js"></script>
    
</html>