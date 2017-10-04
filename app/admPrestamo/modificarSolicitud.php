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
$objSolicitudDAO = new solicitudDAO();
$unidad = $objSolicitudDAO->selectUnidadAdministrativaDAO("");
//die($_POST["solicitud"]);
$result_bienes = $objSolicitudDAO->bienes_solicitud($_POST["solicitud"]);
$solicitud = $objSolicitudDAO->consultarSolicitudDAO($_POST["solicitud"]);
$id_solicitud = $_POST["solicitud"];
if(pg_result($solicitud,10)==4){
    
    $_SESSION['txtimagen'] ="../../comunes/img/warning01.jpg";
    $_SESSION['txtAccion'] = "No se Puede Modificar La Solicitud Debido a que ya Pasó al Estatus 'Cerrado'";
    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
                
}
//die(print_r($bienes));
//$filas = pg_numrows($Resultado);

//die(pg_result($solicitud,1));

?>

<html>
<head>
<title>Agregar Bienes</title>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<script type="text/javascript" src="../../comunes/script/ajax.js"></script>
<script type="text/javascript" language="javascript" src="../../media/js/jquery.js"></script>
<script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="../../media/css/demo_page.css">
<link rel="stylesheet" type="text/css" href="../../media/css/demo_table.css">

    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">

    <style>        
        .subtitulo_Solicitud{
           font-size: 14px; color: #E72B2B; font-style: normal; font-family: Arial
        }
    </style>

    <script>
               
        
        /*function ValidarForm() {
        if (!campoRequerido(document.formAgregarEstado.c_descripcion_estado,"Nombre")){return false;}
        else{
          document.formAgregarEstado.action = "../../clases/ctrl/EstadoCTRL.php";
          document.formAgregarEstado.submit(); 
          return true;
        }
       }*/
    
        function asignarfecha(){
            var hoy = "<?php echo date("Y/m/d"); ?>";//Aqui tiene que ir año mes dia porque para comparar si una es mayor que otra necesito este formato
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            desde = desde.substring(6,10)+"-"+desde.substring(3,5)+"-"+desde.substring(0,2);//añadiendo formato para poder comparar con hoy
            hasta = hasta.substring(6,10)+"-"+hasta.substring(3,5)+"-"+hasta.substring(0,2);//añadiendo formato para poder comparar con hoy
            //alert(desde);
            //alert(hasta);
                if (desde > hasta ) {
                    alert("La fecha ingresada Desde no puede ser superior al Hasta.");
                    document.getElementById("hasta").value = "";
                }
            }
    
    

        function eliminarbien(id){
            var eliminar = confirm("Seguro que desea eliminar el bien");
                if(eliminar){
                    $(id).remove();
                }
        }

        function Modificar_solicitud(){
            if(document.getElementById("nombretrabajador").value === ""){
                alert("Por favor complete el campo 'Cédula'");
                return false;
                }
                else if(document.getElementById("unidad_administrativa").value === ""){
                    alert("Por favor seleccione una 'Unidad Administrativa'");
                    return false;
                }
                else if(document.getElementById("supervisor").value === ""){
                    alert("Por favor seleccione un 'Supervisor'");
                    return false;
                }
                else if(document.getElementById("tecnico").value === ""){
                    alert("Por favor seleccione un 'Tecnico'");
                    return false;
                }
                else if(document.getElementById("desde").value === ""){
                    alert("Por favor complete el campo 'Desde'");
                    return false;
                }
                else if(document.getElementById("hasta").value === ""){
                    alert("Por favor complete el campo 'hasta'");
                    return false;
                }else if(document.getElementById("bienes").getElementsByTagName('input').length<1){
                        alert("A La Solicitud a Generar no se le ha Agregago Ningun Bien a Prestar");
                        return false;
                }else{
                    var cambio = confirm("Acepta guardar los cambios efectuados a La Solicitud");
                    if(cambio){
                        document.formAgregarBien.action="../../clases/ctrl/solicitudCTRL.php";
                        document.formAgregarBien.submit();
                    }
                }
            }
            

        function Sigefi(){

            var cedula = document.formAgregarBien.cedula.value;
            if(cedula.length > 6){
                cargar('ajaxSigefi','../../clases/ctrl/solicitudCTRL.php?accion=Sigefi&cedula='+cedula);
                if(cedula.length > 7){
                }
            }
        }

        function listarbien(){
            var patt = new RegExp("^[A-Za-z0-9]+$");//expresion regular para permitir solo carateres alfanumericos
            var mmm = document.formAgregarBien.serial.value;
            if(!patt.test(mmm)){
                alert("El serial Introducido tiene que alfanumerico (No Permite Caracteres Especiales)");
                document.getElementById("serial").value="";
                return false;
            }               
            if(document.formAgregarBien.tipo.value == ""){
                alert("por favor seleccione");
                return false;
            }
            $("#noexisteregistro").remove();       
            $.get('../../clases/ctrl/solicitudCTRL.php?accion=listar&codigo='+document.formAgregarBien.serial.value+"&tipo="+document.formAgregarBien.tipo.value,
                function(bien){
                    $("#bienes").append(bien);
                    var error = document.getElementById("noexisteregistro");
                    validarLista();
                    if(error !== null){
                        alert("No Existe un Bien con el código Ingresado ó Se Encuentra Prestado");
                        }
                    });
            document.getElementById("serial").value="";
            //cargar('bienes','../../clases/ctrl/solicitudCTRL.php?accion=listar&codigo='+document.formAgregarBien.serial.value)    
        }


        /////////////// LA SIGUIENTE FUNCION SI SE METE EN JQUERY TIENE QUE IR DENTRO DE LOS PARENTESIS QUE VA EN EL METODO(generalemnte .get) QUE SE HACE EL AJAX ///////////
        function validarLista(){
            //Esta funcion trabaja comparando un campo de tipo hidden que tiene el id del bien traido por ajax.
            //Si el value de este hidden se repite, esta elimina la fila que tiene como nombre la cadena de texto 'bien' mas el 'id' del bien traido con ajax.
            var texts = document.getElementById("bienes").getElementsByTagName('input');
            var endPos = texts.length-1;
                for (var i = 0; i < endPos; i++) {
                    if( texts.length > 2 && texts[i].type === 'hidden' && texts[i].value == texts[endPos].value){
                        alert("El codigo del bien ingresado ya se encuentra en el listado");
                        $("#bien"+texts[endPos].value).remove();
                        break;
                    }            }        }      
        ///////////////// FIN DE LA FUNCION QUE VALIDA SI HAY ALGUN ELEMENTO REPETIDO EN EL LISTADO  /////////////////////////////////////
    </script>
</head>
    <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    
        
<script type="text/javascript" src="../../comunes/script/ajax.js"></script>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<link rel="stylesheet" type="text/css" href="../../comunes/css/demos.css">
<link rel="stylesheet" type="text/css" href="../../comunes/css/jquery-ui.css">
<script src="../../comunes/script/jquery-1.5.1.js"></script>
<script src="../../comunes/script/jquery.ui.core.js"></script>
<script src="../../comunes/script/jquery.ui.widget.js"></script>
<script src="../../comunes/script/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../comunes/script/generales.js"></script>

<script>
    
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





    
    
     <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    
        
<script type="text/javascript" src="../../comunes/script/ajax.js"></script>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<link rel="stylesheet" type="text/css" href="../../comunes/css/demos.css">
<link rel="stylesheet" type="text/css" href="../../comunes/css/jquery-ui.css">
<script src="../../comunes/script/jquery-1.5.1.js"></script>
<script src="../../comunes/script/jquery.ui.core.js"></script>
<script src="../../comunes/script/jquery.ui.widget.js"></script>
<script src="../../comunes/script/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../comunes/script/generales.js"></script>
        <script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>

<script>
    
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




    
<body onload="Sigefi()">
        <table align="center" border="0" width="100%">
            <tr>
            <td width="758px" valign="top">
            <table align="center" border="0" width="758px">
                <tr valign="top">
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
            </table>      
                         <form name="formAgregarBien" action="#" onSubmit="return ValidarForm()" method="post">
                         <input type="hidden" name="accion" value="modificarSolicitud">
                         <input type="hidden" name="solicitud" value="<?php echo pg_result($solicitud,0) ?>">
                             <table border="0" align="center">
                                <tr>
                                    <td colspan="2"  align="left">
                                        <b class="subtitulo">Modificar Solicitud:</b> <?php echo "<span class='subtitulo_Solicitud'>". pg_result($solicitud,2) . "</span>"; ?><br><br><br>
                                    </td>
                                </tr>                               
                                <tr>
                                    <td colspan="1" class="subtitulo" align="left">
                                        <h4 class="label label-danger" style="font-size: 20px">Trabajador(a)</h4>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Cedula:</span>
                                                <input type="text" name="cedula" id="cedula" value="<?php echo pg_result($solicitud,1); ?>" onkeyup="Sigefi()" onkeypress="checkInteger(event)" onpaste="Sigefi()" autocomplete="off" disabled="" class="form-control" style=" width:90px">
                                                <button type="button" class="form-control" style="width:45px"> <img src="../../comunes/img/search.svg" width="20px" height="20px" alt="search"/> </button>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Nombre:</span>
                                                <div id="ajaxSigefi">
                                                    <input type='text' name='nombretrabajador' id='nombretrabajador'value="" disabled class="form-control">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Nombre:</span>
                                                <select id="unidad_administrativa" name="unidad_administrativa"  style=" width:300px" disabled="" class="form-control">
                                                     <option value="">Seleccione </option>
                                                      <?php
                                                        if(pg_num_rows($unidad)>0){
                                                            for($j=0; $j < pg_num_rows($unidad); $j++){                                                    
                                                               echo "<option value='".pg_result($unidad,$j,0);
                                                               if(pg_result($unidad,$j,0) === pg_result($solicitud,7)){
                                                                   //die(pg_result($solicitud,7));
                                                                   echo "' selected";
                                                                    echo ">".pg_result($unidad,$j,1)."</option>";
                                                               }else{
                                                                   echo "'  >".pg_result($unidad,$j,1)."</option>";
                                                               }

                                                            }
                                                        }                                            
                                                      ?>
                                                 </select>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                                
                               
                               <tr>
                                    <td colspan="1" align="left">
                                        <h4 class="label label-danger" style="font-size: 20px">Supervisor(a)</h4>
                                    </td>
                                 </tr>
                                <tr>
                                    <td colspan="1" class="subtitulo" align="left"> 
                                        
                                          
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Supervisor:</span>  
                                                <select id="supervisor" name="supervisor" style=" width:300px" required title="Supervisor" class="form-control" disabled="">
                                                    <option value="">Seleccione</option>
                                                    <?php                                            
                                                        if(pg_num_rows($supervisor)>0){
                                                            for($j=0; $j < pg_num_rows($supervisor); $j++){
                                                                echo "<option value='".pg_result($supervisor,$j,0);
                                                                if(pg_result($supervisor,$j,0) === pg_result($solicitud,9)){
                                                                    echo "' selected";
                                                                    echo ">".pg_result($supervisor,$j,1)." ".pg_result($supervisor,$j,2)."</option>";
                                                                }else{
                                                                  echo "' >".pg_result($supervisor,$j,1)." ".pg_result($supervisor,$j,2)."</option>";
                                                                }                                            
                                                            }
                                                        }
                                                    ?>
                                                </select>                                         
                                        </div>
                                        
                                    </td>  
                                 </tr>
                                 
                                 <tr>
                                    <td colspan="1" align="left">
                                        <div class="label label-danger" style="font-size: 20px;">Tecnico(a)</div>
                                    </td>
                                 </tr>
                               <tr>
                                    <td colspan="1" class="subtitulo" align="left"> 
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Tecnico:</span>  
                                                  
                                                <select id="tecnico" name="tecnico" style=" width:300px" title="Técnico" required class="form-control" disabled="">
                                                   <option value="">Seleccione</option>
                                                     <?php                                            
                                                        if(pg_num_rows($tecnico)>0){
                                                            for($j=0; $j < pg_num_rows($tecnico); $j++){
                                                                echo "<option value='".pg_result($tecnico,$j,0);
                                                                if(pg_result($tecnico,$j,0) === pg_result($solicitud,8)){
                                                                    echo "' selected";
                                                                    echo ">".pg_result($tecnico,$j,1)." ".pg_result($tecnico,$j,2)."</option>";
                                                                }else{
                                                                    echo "'>".pg_result($tecnico,$j,1)." ".pg_result($tecnico,$j,2)."</option>";
                                                                }
                                                                                                                                                                 }
                                                        }                                            
                                                        ?>
                                                </select>                                         
                                        </div>                                        
                                    </td>  
                                 </tr>
                                
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
                                                <input type="text" id="desde" name="desde"  title="Desde" required readonly="" style=" width:100px" class="form-control"  value="<?php echo pg_result($solicitud,5)?>">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px"><label for="hasta">Hasta:</label></span>
                                                <input type="text" id="hasta" name="hasta"  title="Hasta" required readonly="" style=" width:100px" class="form-control" value="<?php echo pg_result($solicitud,6)?>" >
                                           </div>
                                        </div>
                                   </td> 
                                   <td>
                                   </td>    
                               </tr>
                               
                               <tr>
                                <td>
                                     <div class="form-group">
                                         <div class="input-group">
                                             <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px"><label for="serial_bien">Serial:</label></span>
                                             <span class="input-group-addon"><input type="radio" name="tipo" value="serial_bien" id="serial_bien" checked></span>

                                             <span class="input-group-addon" style="width: 150px"><label for="codigo_bien">Código:</label></span>
                                             <span class="input-group-addon"><input type="radio" name="tipo" value="codigo_bien" id="codigo_bien"></span>
                                             <input type="text" name="serial" id="serial" pattern="^[A-Za-z0-9]+$" class="form-control" style="width: 150px">

                                             <input type="button" class="form-control btn btn-primary" value="Agregar a Lista" onclick="listarbien()" style="width: 150px">

                                         </div>
                                     </div>
                                </td> 
                            </tr>
                            <table width="100%" id="tabla"  class="table" style="width: 70% !important; margin: auto;">

                             <thead>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Descipción</th>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Serial</th>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Marca</th>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Modelo</th>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Bien Nacional</th>
                                     <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Acción</th>
                              </thead> 
                            <tbody  id="bienes">
                                 <?php
                                     if(pg_num_rows($result_bienes)>0){
                                         for($j=0; $j < pg_num_rows($result_bienes); $j++){

                                             //echo "<option value='".pg_result($result_bienes,$j,4)."'>".pg_result($supervisor,$j,2)." ".pg_result($supervisor,$j,3)."</option>";

                                             echo "<tr id='bien".pg_result($result_bienes,$j,0)."'>"
                                                 . "<td   class='formulario' bgcolor='#F6eded'>"
                                                 . pg_result($result_bienes,$j,7)
                                                 . "</td>"
                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . pg_result($result_bienes,$j,2)
                                                 . "</td>"
                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . pg_result($result_bienes,$j,3)
                                                 . "</td>"
                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . pg_result($result_bienes,$j,4)
                                                 . "</td>"
                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . pg_result($result_bienes,$j,5)
                                                 . "</td>"
                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . "<input type='button' value='Eliminar' onclick='eliminarbien(".'"'."#bien".pg_result($result_bienes,$j,0).'"'.")' disabled>"
                                                 . "</td>"

                                                 . "<td  class='formulario' bgcolor='#F6eded'>"
                                                 . "<input type='hidden' name='bien[]' value='".pg_result($result_bienes,$j,0)."'>"
                                                 . "</td>"
                                             . "</tr>";
                                         }
                                     }
                                 ?>
                             </tbody>
                             <tfoot>

                             </tfoot>
                         </table>
                               <div align="center">
                                   <input type="button" class="btn btn-info" value="Modificar Solicitud" onclick="Modificar_solicitud()">
                                 <input class="btn btn-info" type="button" value="Cancelar" onclick="javascript:cancelar(document.formAgregarBien,'../../centro.php');">
                               </div>                              
                             </table>
                         </form>
    </body>
</html>