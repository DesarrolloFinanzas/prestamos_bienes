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

//die(print_r(pg_fetch_assoc($solicitud)));

if(pg_result($solicitud,10)==4){
    
    $_SESSION['txtimagen'] ="../../comunes/img/warning01.jpg";
    $_SESSION['txtAccion'] = "Esta Solicitud ya Recibio Todos Los Bienes";
    header("Location: ../../app/admPrestamo/ValidarResultSolicitud.php");
}
//print_r(pg_fetch_array($result_bienes));
//die(pg_result($solicitud,0))
//die(print_r($bienes));
//$filas = pg_numrows($Resultado);
//die(pg_result($solicitud,1));
?>

<html>
<head>
<title>Agregar Bienes</title>
<script type="text/javascript" src="../../comunes/script/manejomfestandar.js"></script>
<script type="text/javascript" src="../../comunes/script/ajax.js"></script>
    <script>
        function recibirBienes(){  
            $("input[type='checkbox']").attr("disabled",false);
            
            document.formRecibirBienes.action="../../clases/ctrl/solicitudCTRL.php";
            document.formRecibirBienes.submit();
        }   
    </script>

    <link rel="stylesheet" type="text/css" href="../../comunes/css/mpfsrgbp.css">
    <link href="../../comunes/css/bootstrap.css" rel="stylesheet" media="screen">
        
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

</head>   
    <body>
        <form name="formRecibirBienes" action="#" method="post">
            <div id="demo">
                <font size=1>
                    <div id="main_table_area">
                        <table align="center" border="0" width="100%">
                            <tr valign="top">
                            <td height="80" class="tituloPrincipal" align="center">
                      <br>
                      <label class="label label-default" style="font-size: 35px">SISTEMA PRESTAMO BIENES</label>
                     <br>
                            </td>
                            </tr>
                            <tr>
                                <td class="subtitulo" align="center">
                                    Recibir Bienes de la Solicitud: <?php echo pg_result($solicitud,2); ?><br><br><br>
                                </td>
                           </tr>
                        </table>
                        <table cellpadding="3"   align="center" cellspacing="3" border="0" class="display table"  id="example">
                            <thead>
                                <tr>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        Descipción
                                    </td>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        Serial
                                    </td>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        marca Modelo
                                    </td>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        Modelo
                                    </td>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        Bien Nacional
                                    </td>
                                    <td class="resultado" bgcolor="#DAD6D6" align="center" width="20%">
                                        Recibido
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(pg_num_rows($result_bienes)>0){
                                        for($j=0; $j < pg_num_rows($result_bienes); $j++){
                                            //echo "<option value='".pg_result($result_bienes,$j,4)."'>".pg_result($supervisor,$j,2)." ".pg_result($supervisor,$j,3)."</option>";
                                            echo "<tr id='bien".pg_result($result_bienes,$j,0)."'>"
                                                . "<td  bgcolor='#F6eded'>"
                                                . pg_result($result_bienes,$j,7)
                                                . "</td>"
                                                . "<td bgcolor='#F6eded'>"
                                                . pg_result($result_bienes,$j,2)
                                                . "</td>"
                                                . "<td bgcolor='#F6eded'>"
                                                . pg_result($result_bienes,$j,3)
                                                . "</td>"
                                                . "<td bgcolor='#F6eded'>"
                                                . pg_result($result_bienes,$j,4)
                                                . "</td>"
                                                . "<td bgcolor='#F6eded'>"
                                                . pg_result($result_bienes,$j,5)
                                                . "</td>";
                                            echo "<td bgcolor='#F6eded'>"
                                                . "<input type='checkbox' name='recibido[]' ";
                                            if(pg_result($result_bienes,$j,6) === "t"){
                                                echo " checked value='".pg_result($result_bienes,$j,0)."' disabled ";
                                            }else{
                                                echo " value='".pg_result($result_bienes,$j,0)."' ";
                                            }                                                        
                                            echo "></td>";
                                            echo "<td>"
                                                . "<input type='hidden' name='bien[]' value='".pg_result($result_bienes,$j,0)."'>"
                                                . "</td>"
                                            . "</tr>";
                                            echo "<td>"
                                                . "<input type='hidden' name='solicitud' value='".pg_result($result_bienes,$j,6)."'>"
                                                . "</td>"
                                            . "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </font>
            </div>
            <div align="center">
              <input class="btn btn-info" type="button" value="Guardar" onclick="recibirBienes()">
                <input class="btn btn-info" type="button" value="Cancelar" onclick="javascript:cancelar(document.formRecibirBienes,'../../centro.php');">
                <input type="hidden" name="solicitud" value="<?php echo pg_result($solicitud,0) ?>">
                <input type="hidden" name="accion" value="RecibirBienes">            
            </div>
        </form>        
    </body>
</html>