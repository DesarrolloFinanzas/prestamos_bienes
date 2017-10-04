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

/*while ($data = pg_fetch_assoc($unidad)){
            $array["unidades administrativas"][] = $data;
                            }
            die(json_encode($array));*/

//die(json_encode(pg_fetch_assoc($Resul_usu)));

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
<script src="../../comunes/script/jquery-1.12.4.min.js"></script>
<script src="../../comunes/script/jquery-1.5.1.js"></script>
<script src="../../comunes/script/jquery.ui.core.js"></script>
<script src="../../comunes/script/jquery.ui.widget.js"></script>
<script src="../../comunes/script/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>

    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">

    <script>
        /*function ValidarForm() {
        if (!campoRequerido(document.formAgregarEstado.c_descripcion_estado,"Nombre")){return false;}
        else{
          document.formAgregarEstado.action = "../../clases/ctrl/EstadoCTRL.php";
          document.formAgregarEstado.submit(); 
          return true;
        }
       }*/
    
    function autocomplete(){
        var input = document.getElementsByTagName('input');
            for (var i = 0; i < input.length; i++) {
                input[i].autocomplete = "off";
            }         
    } 
    
    function asignarfecha(){
            var hoy = "<?php echo date("Y/m/d"); ?>";//Aqui tiene que ir año mes dia porque para comparar si una es mayor que otra necesito este formato
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            desde = desde.substring(6,10)+"-"+desde.substring(3,5)+"-"+desde.substring(0,2);//añadiendo formato para poder comparar con hoy
            hasta = hasta.substring(6,10)+"-"+hasta.substring(3,5)+"-"+hasta.substring(0,2);//añadiendo formato para poder comparar con hoy
            //alert(desde);
            //alert(hasta);
                if (desde > hasta ) {
                    alert("La Fecha Ingresada Desde no puede ser superior al Hasta.");
                    document.getElementById("hasta").value = "";
                }
            }

        function eliminarbien(id){
                $(id).remove();
        }

        function generar_solicitud(){ 
                
                if(validaForm(formAgregarBien) === false){
                    return false;
                }else if(document.getElementById("bienes").getElementsByTagName('input').length<1){
                        alert("A la solicitud a generar no se le ha agregago ningun bien a prestar");
                        document.getElementById("serial").focus();
                        document.getElementById("serial").style.borderColor = "red";
                        document.getElementById("serial").style.borderStyle = "dashed";
                        return false;
                }else if(document.formAgregarBien.nombretrabajador.value === "No Existe"){
                    alert("Por favor introduce un numero de cedula valido");
                    document.formAgregarBien.cedula.focus();
                    document.formAgregarBien.cedula.style.borderColor = "red";
                    document.formAgregarBien.cedula.style.borderStyle = "dashed";
                    return false;
                }else{
                    var cambio = confirm("Confirma de los Datos Ingresados al Generar la Solicitud son Correctos");
                    if(cambio){
                        $("#cedula").attr("disabled",false);
                        document.formAgregarBien.action="../../clases/ctrl/solicitudCTRL.php";
                        document.formAgregarBien.submit();
                    }
                }
            }
                
        function Sigefi(){

            var cedula = document.formAgregarBien.cedula.value;
            
            if(cedula.length > 4 ){

                if(document.formAgregarBien.nombretrabajador.value === "No Existe"){
                    //alert("El Numero de Cedula Ingresado no Existe en Nuestra Base de Datos");
                    document.formAgregarBien.nombretrabajador.value = "";
                }
                if ($("#buscar span").hasClass("glyphicon-search")===true) {
                        $('#buscar span').removeClass('glyphicon-search');
                        $('#buscar span').addClass('glyphicon-folder-close');
                        $('#cedula').attr('disabled',true);
                    cargar('ajaxSigefi','../../clases/ctrl/solicitudCTRL.php?accion=Sigefi&cedula='+cedula);
                    if(cedula.length > 7){
                    }
                    }else if($("#buscar span").hasClass("glyphicon-folder-close")===true){
                            $('#buscar span').removeClass('glyphicon-folder-close');
                            $('#buscar span').addClass('glyphicon-search');
                            $('#cedula').attr('disabled',false);
                            document.formAgregarBien.reset();
                            $('#nombretrabajador').val("");
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
                    if(document.getElementById("bienes").getElementsByTagName("input").length === 0){
                        $("#bienes").empty();
                    }
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
                    if( texts.length > 1 && texts[i].type === 'hidden' && texts[i].value == texts[endPos].value){
                        alert("El codigo del bien ingresado ya se encuentra en el listado");
                        $("#bien"+texts[endPos].value).remove();
                        break;
                    }            }        }      
        ///////////////// FIN DE LA FUNCION QUE VALIDA SI HAY ALGUN ELEMENTO REPETIDO EN EL LISTADO  /////////////////////////////////////
        
    </script>
    
    

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
       
       
       
            /*llamado a la funcion para ejecutar el jquery del ordenamiento de la tabla*/
          /*  $(document).ready(function() {
                            $('#tabla').dataTable( {
                                "sPaginationType": "full_numbers",
                                "bDestroy": true
                            //	aaSorting": [[ 4, "desc" ]]
                            });
                        });*/
    
</script>
    
</head>
   
    
<body onload="autocomplete()">
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
                         <form name="formAgregarBien" action="#" method="post">
                             <input type="hidden" name="accion" value="AgregarSolicitud">
                             <table border="0" align="center">
                                <tr>
                                    <td colspan="2" class="subtitulo" align="left">
                                           Agregar Bienes<br><br><br>
                                    </td>
                               </tr>
                               
                               <tr>
                                    <td colspan="1" align="left">
                                    </td>
                                 </tr>
                             
                               <tr>
                                    <td class="formulario">
                                            <h4 class="label label-danger" style="font-size: 20px">Trabajador(a)</h4>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Cedula:</span>
                                                <input type="text" name="cedula" id="cedula" value=""  onkeypress="checkInteger(event)" onpaste="Sigefi()"  style=" width:90px" maxlength="8" required title=" Cédula" class="form-control">
                                                <button type="button" class="form-control" onclick="Sigefi()" style="width:45px" id="buscar"><span class="glyphicon glyphicon-search"></span> </button>
                                            
                                            </div>
                                            
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Nombre:</span>
                                                <div id="ajaxSigefi">
                                                    <input type='text' class="form-control" name='nombretrabajador' id='nombretrabajador' value="" disabled title=" Nombre" style="width:300px">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px">Unidad Administrativa:</span>                                                  
                                                <select id="unidad_administrativa" name="unidad_administrativa" style=" width:300px" required title="Unidad Administrativa"  class="form-control">
                                                    <option value="">Seleccione </option>
                                                      <?php
                                                        if(pg_num_rows($unidad)>0){
                                                            for($j=0; $j < pg_num_rows($unidad); $j++){
                                                                if(pg_result($Resul_usu,11) !== pg_result($unidad,$j,0)){
                                                                    echo "<option value='".pg_result($unidad,$j,0)."'>".pg_result($unidad,$j,1)."</option>";
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
                                                <select id="supervisor" name="supervisor" style=" width:300px" required title="Supervisor" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <?php
                                                        if(pg_num_rows($supervisor)>0){
                                                        for($j=0; $j < pg_num_rows($supervisor); $j++){
                                                            echo "<option value='".pg_result($supervisor,$j,0)."'>".pg_result($supervisor,$j,1)." ".pg_result($supervisor,$j,2)."</option>";
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
                                                  
                                                <select id="tecnico" name="tecnico" style=" width:300px" title="Técnico" required class="form-control">
                                                   <option value="">Seleccione</option>
                                                     <?php
                                                       if(pg_num_rows($tecnico)>0){
                                                           for($j=0; $j < pg_num_rows($tecnico); $j++){                                                    
                                                              echo "<option value='".pg_result($tecnico,$j,0)."'>".pg_result($tecnico,$j,1)." ".pg_result($tecnico,$j,2)."</option>";
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
                                                <input type="text" id="desde" name="desde"  title="Desde" required readonly="" style=" width:100px" class="form-control">
                                                <span class="input-group-addon">*</span><span class="input-group-addon" style="width: 150px"><label for="hasta">Hasta:</label></span>
                                                <input type="text" id="hasta" name="hasta"  title="Hasta" required readonly="" style=" width:100px" class="form-control">
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

                            <table id="tabla" align="center" class="table" style="width: 70% !important">

                                <thead>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Descipción</th>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="15%">Serial</th>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="10%">Marca</th>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Modelo</th>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="15%">Bien Nacional</th>
                                        <th class="resultado" bgcolor="#DAD6D6" align="center" width="10%">Eliminar</th>
                                 </thead>

                                 <tbody  id="bienes">
                                 </tbody>
                                 <tfoot></tfoot>
                            </table>
                            <div  align="center">
                                <input type="button" class="btn btn-info" value="Guardar" onclick="generar_solicitud()">
                              <input type="button"  class="btn btn-info" value="Cancelar" onclick="javascript:cancelar(document.formAgregarBien,'../../centro.php');">
                            </div>                              
                          </table>
                      </form>
    </body>
<script type="text/javascript" src="../../comunes/script/generales.js"></script>
</html>