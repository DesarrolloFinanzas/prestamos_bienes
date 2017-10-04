<?php

ob_start();
session_start();   
if(!isset($_SESSION['idusuario']) and ($_SESSION['idusuario']==null)) {
    header("Location: ../../warning.php");
}

$RutaDao = "../../clases";
$pagina="admUsuario-modificarTecnico";
require ("../../clases/dao/SeguridadDAO.php");
require ("../../clases/dao/UsuarioDAO.php");
$objSeguridadDAO = new SeguridadDAO();
$objUsuarioDAO = new UsuarioDAO();
$Resul_usu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
$filus = pg_numrows($Resul_usu);
if ($filus>0){
    $url='./app/admUsuario/consultarTecnico.php';
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
$id_tecnico = $_POST["tecnico"];
$Resultado = $objtecnicoDAO->consultarTecnicoDAO($id_tecnico);

//var_dump($Resultado);
$filas = pg_numrows($Resultado);
?>

<html>
<head>
<title>Agregar Estado</title>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<script type="text/javascript" src="../../comunes/script/generales.js"></script>
    <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">

<script>
    function ValidarForm(e) {
        if(validaForm(e) === false){
            return false;
        }else{
      document.formConsultaTecnico.accion.value = "ModificaTecnico";
      //alert(document.formConsultaTecnico.accion.value);
      document.formConsultaTecnico.action = "../../clases/ctrl/tecnicoCTRL.php";
      document.formConsultaTecnico.submit(); 
     /* return true;
    }*/
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
                         <form name="formConsultaTecnico" action="#" method="post">
                             <table border="0" align="center">
                                    <td class="formulario">    
                                    <div class="form-group">
                                        <div class="label label-danger" style="font-size: 20px">Supervisor (a) / Técnico (a)</div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="cedula" style="width: 150px">Cédula:</label></span>
                                            <input type="text" name="cedula" id="cedula" value="<?php echo pg_result($Resultado, 0, 1); ?>" onkeypress="checkInteger(event)" disabled="" style="width: 90px" class="form-control">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="nombre" style="width: 150px">Nombre:</label></span>
                                            <input type="text" value="<?php echo pg_result($Resultado, 0, 2); ?>" name="nombre" id="nombre" onkeypress="checkCharacter(event)" required="" title="Nombre" style="width: 200px" class="form-control">
                                        </div>
                                        <div class="input-group">
                                             <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="apellido" style="width: 150px">Apellido:</label></span>
                                             <input type="text" value="<?php echo pg_result($Resultado, 0, 3); ?>" name="apellido" id="apellido" onkeypress="checkCharacter(event)" required="" title="Apellido" style="width: 200px" class="form-control">
                                          
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="cargo" style="width: 150px">Apellido:</label></span>
                                            <select name="cargo" id="cargo" required  style=" width:200px" class="form-control">
                                                <option value="1" <?php if(pg_result($Resultado,0,0) === "1") echo " selected"; ?>>Técnico</option>
                                                <option value="2" <?php if(pg_result($Resultado,0,0) === "2") echo " selected"; ?>>Supervisor</option>
                                            </select>
                                        </div>
                                    </td>
                               </tr>                                    

                               <tr valign="top">
                                          <td colspan="2" class="formulario" valign="top" align="center">
                                                <br>
                                                <input type="hidden" id="tecnico" name="tecnico" value="<?php echo $id_tecnico ?>">
                                                <input type="hidden" name="accion" id="accion" value="">                                                
                                                <input class="btn btn-info" type="button" value="Modificar" onclick="ValidarForm(this.form)">
                                                <input class="btn btn-info" type="button" value="Cancelar" onclick="javascript:cancelar(document.formConsultaTecnico,'../../centro.php');">
                                         </td>
                                </tr>
                             </table>
                         </form>
                     </td>    
            </tr>
        </table>
    </body>
</html>
<? ob_end_flush(); ?>