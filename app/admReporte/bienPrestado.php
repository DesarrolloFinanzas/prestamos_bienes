<?php
ob_start();
session_start();   
//die(json_encode($_SESSION));

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
<script src="../../comunes/script/jquery-1.12.4.min.js"></script>
<script src="../../comunes/script/jquery.ui.core.js"></script>
<script src="../../comunes/script/jquery.ui.widget.js"></script>
<script src="../../comunes/script/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascipt" src="../../media/js/jquery.dataTables.js"></script>

    <script type="text/javascript" src="../../comunes/script/bootstrap.js"></script>
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
<script>
    
    
    
    
    function listarbien(e){
            //validaForm(e);
            var patt = new RegExp("^[A-Za-z0-9]+$");//expresion regular para permitir solo carateres alfanumericos
            var mmm = document.formBienPrestado.serial.value;
            if(!patt.test(mmm)){
                alert("El serial Introducido tiene que alfanumerico (No Permite Caracteres Especiales)");
                document.getElementById("serial").value="";
                return false;
            }        
            $("#noexisteregistro").remove();       
            $.get('../../clases/ctrl/reporteCTRL.php?accion=datosBien&codigo='+document.formBienPrestado.serial.value+"&tipo="+document.formBienPrestado.tipo.value,
                function(bien){
                /////////////////// Esto me Borra los Registros Predeterminados de Datatable ///////////////////  
                    if(document.getElementById("bienes").getElementsByTagName("input").length === 0){
                        $("#bienes").empty();
                ///////////////////   ////////////////////   ////////////////////   ////////////////////  
                    }
                                        
                    $("#bienes").append(bien);
                ///////////////////   ////////////////////   ////////////////////   ////////////////////
                    if(document.getElementById("bienes").getElementsByTagName("tr").length === 0){
                         alert("No Existe un Bien con el código Ingresado ó Nunca ha Sido Prestado");
                        return false;
                    }else{
                        $("#tabla_wrapper").show(650);
                    }
                ///////////////////   ////////////////////   ////////////////////   ////////////////////
                    var error = document.getElementById("noexisteregistro");
                    validarLista();
                    
                    if(error !== null){
                        alert("No Existe un Bien con el código Ingresado ó Nunca ha Sido Prestado");
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
        
        function detallebien(descripcion, marca, modelo){
            $("#descripcion").val(descripcion);
            $("#marca").val(marca);
            $("#modelo").val(modelo);
            $("#myModal").show(255);;
    }
    
      $(function() {
       }); 
       
        /*llamado a la funcion para ejecutar el jquery del ordenamiento de la tabla*/
        $(document).ready(function() {
                        $('#tabla').dataTable( {
                         "sPaginationType": "full_numbers",
                         "bDestroy": true
                        //	aaSorting": [[ 4, "desc" ]]
                        });
                        $("#tabla_wrapper").hide();
               });
    
    </script>
    
</head>
   
    
    <body>
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
                <form name="formBienPrestado" action="#" method="post" >
                             <input type="hidden" name="accion" value="AgregarSolicitud">
                             <table border="0" align="center">
                                <tr>
                                    <td colspan="1" align="left">
                                        <div class="label label-danger" style="font-size: 20px;">Bienes Prestados:</div>
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
                               
                               <tr>                                   
                                   <!-- <input type="button" value="Guardar" onclick="generar_solicitud()"> -->
                                <!-- <input type="button" value="Cancelar" onclick="javascript:cancelar(document.formBienPrestado,'../../centro.php');">  -->
                               </tr>
                               
                               
                             </table>
                             <div style="width: 75%; margin: auto" id="lacra">
                                   
                                   
                                   <table width="100%" id="tabla" >
                                        <thead>
                                            <tr>
                                                 <th rowspan="2" class="resultado" bgcolor="#DAD6D6" align="center" width="40%">Unidad Administrativa</th>
                                                 <th rowspan="2"  class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Estatus</th>
                                                 <th colspan="2" class="resultado" bgcolor="#DAD6D6" align="center" width="40%">Fecha del Prestamo</th>
                                                 <th rowspan="2"  class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Detalle</th>
                                             </tr>
                                             <tr>
                                                 <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Desde</th>
                                                 <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">hasta</th>
                                             </tr>
                                        </thead>

                                         <tbody  id="bienes">
                                         </tbody>
                                         
                                         <tfoot></tfoot>
                                    </table> 
                                   
                                </div>
                               <div> 
                         </form>

<!-- Trigger/Open The Modal -->
<!--<button id="myBtn">Open Modal</button>-->

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" id="modal-content">
      <span class="close">&times;</span><br>
      <h2 align="center" class="label label-default" style="font-size: 30px">Detalle del Bien</h2>
    
      <br>
      
      <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon " style="width: 100px"><h2 class="label label-primary">Descripcion:</h2></span>
                <input type="text" id="descripcion" disabled="" class="form-control">
                </div>
            <div class="input-group">
                <span class="input-group-addon" style="width: 100px"><h2 class="label label-primary">Marca:</h2></span>
                <input type="text" id="marca" disabled="" class="form-control">
                </div>
            <div class="input-group">
                <span class="input-group-addon" style="width: 100px"><h2 class="label label-primary">Modelo:</h2></span>
                <input type="text" id="modelo" disabled="" class="form-control">

            </div>
        </div>
        
</div>

</div>
    <script>        
        var span = document.getElementsByClassName("close")[0];
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            $("#myModal").hide(355);
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == document.getElementById("myModal")) {
                $("#myModal").hide(255);
            }
        }
    </script>
    
    </body>
    <script type="text/javascript" src="../../comunes/script/generales.js"></script>
</html>