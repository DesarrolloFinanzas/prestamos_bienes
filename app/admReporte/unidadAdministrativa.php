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
$tecnico = $objtecnicoDAO->selectTecnicoDAO();
$supervisor = $objtecnicoDAO->selectSupervisorDAO();

require ("../../clases/dao/solicitudDAO.php");
$solicitud = new solicitudDAO();
$unidad = $solicitud->selectUnidadAdministrativaDAO("");
//var_dump($Resultado);
//$filas = pg_numrows($Resultado);
?>

<html>
    
<head>
<title>Agregar Bienes</title>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<script type="text/javascript" src="../../comunes/script/ajax.js"></script>
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="../../media/css/demo_table.css">
        <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
        <script type="text/javascript" src="../../comunes/script/ajax.js"></script>
        <script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
        <link rel="stylesheet" type="text/css" href="../../comunes/css/demos.css">
        <link rel="stylesheet" type="text/css" href="../../comunes/css/jquery-ui.css">
        <script src="../../comunes/script/jquery-1.5.1.js"></script>
        <script src="../../comunes/script/jquery.ui.core.js"></script>
        <script src="../../comunes/script/jquery.ui.widget.js"></script>
        <script src="../../comunes/script/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>
        
        <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
    <script>
        
    function pdf(){
        document.formReporteGeneral.action = "../../clases/ctrl/reporteCTRL.php";
        document.formReporteGeneral.submit();
    }
        
    function asignarfecha(e){
            var hoy = "<?php echo date("Y/m/d"); ?>";//Aqui tiene que ir año mes dia porque para comparar si una es mayor que otra necesito este formato
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            desde = desde.substring(6,10)+"-"+desde.substring(3,5)+"-"+desde.substring(0,2);//añadiendo formato para poder comparar con hoy
            hasta = hasta.substring(6,10)+"-"+hasta.substring(3,5)+"-"+hasta.substring(0,2);//añadiendo formato para poder comparar con hoy
            //alert(desde);alert(hasta);
                if (desde > hasta ) {
                    alert("La fecha ingresada Desde no puede ser superior al Hasta.");
                    document.getElementById("hasta").value = "";
                    e.focus();
                }
            }

        function listarbien(e){
            var recibido = new Array();
                $('input[name="recibido"]:checked').each(function() {
                recibido.push(this.value);
                });                
            if(validaForm(e) === false){
                return false;
            }            
            $("#noexisteregistro").remove();       
            $.get('../../clases/ctrl/reporteCTRL.php?accion=unidad_adm&unidad='+document.formReporteGeneral.unidad_administrativa.value+"&desde="+document.formReporteGeneral.desde.value+"&hasta="+document.formReporteGeneral.hasta.value+"&recibido="+recibido,
                function(bien){
                /////////////////// Esto me Borra los Registros Predeterminados de Datatable ///////////////////  
                //    if(document.getElementById("bienes").getElementsByTagName("input").length === 0){
                  //      $("#bienes").empty();
                ///////////////////   ////////////////////   ////////////////////   //////////////////// 
                    $("#tabla_wrapper").remove();
                    $("#delimiter").html('<table width="100%" id="tabla"></table>');
                    $("#tabla").html(bien);
                    var error = document.getElementById("noexisteregistro");
                    if(error !== null){
                        alert("La unidad administrativa seleccionada, no ha pedido prestado ningun bien en el rango de fecha seleccionado");
                        $("#delimiter").hide(650);
                        }else{
                            document.getElementById("delimiter").style.display = "none";
                            $('#tabla').dataTable( {
                                "sPaginationType": "full_numbers",
                                "bDestroy": true
                               //aaSorting": [[ 4, "desc" ]]
                             });
                             $("#delimiter").show(650);
                        }
                    });
        }        
        
        $(function() {
                            
                $.datepicker.regional['es'] =
	  {
	  closeText: 'Cerrar',
	  prevText: 'Previo',
	  nextText: 'Próximo',
	   
	  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
	  'Jul','Ago','Sep','Oct','Nov','Dic'],
	  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
	  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
	  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
	  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
          dateFormat: 'dd/mm/yy', firstDay: 0,
	  initStatus: 'Selecciona la fecha', isRTL: false};
	 $.datepicker.setDefaults($.datepicker.regional['es']);
	               
               $("#desde").datepicker({ dateFormat: "dd/mm/yy",changeMonth: true, changeYear: true }).val();
               $("#hasta").datepicker({ dateFormat: "dd/mm/yy",changeMonth: true, changeYear: true }).val();
       }); 
        
    </script>
    
</head>
   
    
<body>
        <table align="center" border="0" width="100%">
            <tr>
            <td width="758px" valign="top">
             <table align="center" border="0" width="758px">
              <tr valign="top">
                 <td><?php  
                        $txtRutaImagen = "../../comunes";
                        $txtRutaIndex = "../..";
                ?></td>
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
            </table>      
                         <form name="formReporteGeneral" action="#" method="post">
                             <input type="hidden" name="accion" value="pdf">
                             <table border="0" align="center">
                                <tr>
                                   
                                    <td colspan="1" align="left">
                                        <div class="label label-danger" style="font-size: 20px;">Fecha Prestamo:</div>
                                    </td>
                               </tr>
                               
                               
                               <tr>
                                   <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" ><label for="desde" style="width: 150px">Desde:</label></span>
                                                <input type="text" id="desde" name="desde"  title="Desde" required readonly="" style=" width:120px" class="form-control">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px"><label for="hasta">Hasta:</label></span>
                                                <input type="text" id="hasta" name="hasta"  title="Hasta" required readonly="" style=" width:120px" class="form-control">
                                           </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" ><label style="width: 150px">Unidad Administrativa:</label></span>
                                                <select id="unidad_administrativa" name="unidad_administrativa"  style=" width:200px" required="" title="Unidad Administrativa" class="form-control">
                                                    <option value="">Seleccione </option>
                                                     <?php
                                                       if(pg_num_rows($unidad)>0){
                                                           for($j=0; $j < pg_num_rows($unidad); $j++){                                                    
                                                              echo "<option value='".pg_result($unidad,$j,0)."'>".pg_result($unidad,$j,1)."</option>";
                                                           }
                                                       }                                            
                                                     ?>
                                                </select>
                                                <span class="input-group-addon" >Prestado</span>
                                                <span class="input-group-addon" ><input type="checkbox" name="recibido" value="prestado" checked="" onclick="listarbien(this.form)"></span>
                                                <span class="input-group-addon" >Recibido</span>
                                                <span class="input-group-addon" ><input type="checkbox" name="recibido" value="recibido" onclick="listarbien(this.form)"></span>
                                           </div>
                                            <div class="input-group " style="margin: auto !important;">
                                                <br><input type="button" value="Agregar a la Lista" class="btn btn-primary input-group" onclick="listarbien(this.form)" >
                                            </div>
                                        </div>
                                   </td>    
                               </tr>
                            </table>
                             
                             <div style="width: 70%; min-width: 888px; margin: auto" id="delimiter"> 
                                <table width="100%" id="tabla" class="table" style="width: 70% !important">
                                </table>
                            </div>
                                <div align="center">
                                    <!-- <input type="button" value="Guardar" onclick="generar_solicitud()">   -->
                                 <!--   <input type="button" class="btn btn-info" value="Buscar" onclick="listarbien(this.form)">   -->
                                   <!-- <input class="boton" type="button" value="Cancelar" onclick="javascript:cancelar(document.formReporteGeneral,'../../centro.php');"> -->
                                 <!--   <input class="btn btn-info" type="button" value="P D F" onclick="pdf()">   -->
                                </div>
                             
                         </form>
                
                <div id="pdf"></div>
    </body>
        <script type="text/javascript" src="../../comunes/script/generales.js"></script>
</html>