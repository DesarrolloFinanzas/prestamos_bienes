<?php
ob_start();   
session_start(); 
if(!isset($_SESSION['idusuario']) and ($_SESSION['idusuario']==null)) {
    header("Location: ./blanco.html");
}

$RutaDao = "./clases";
require ("./clases/dao/MenuDAO.php");
require ("./clases/dao/UsuarioDAO.php");
$objMenuDAO = new MenuDAO();
$objUsuarioDAO = new UsuarioDAO();

$resultado = $objMenuDAO->ConsultarMenuDAO(21);
$filas = pg_numrows($resultado);

$resusu = $objUsuarioDAO->ConsultarDatosUsuarioDAO($_SESSION['idusuario']);
//die(json_encode(pg_fetch_assoc($resusu)));


?>
<html>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <head>
	<script type="text/javascript" src="./comunes/script/dtree.js"></script>
        <script type="text/javascript" src="./comunes/script/manejomfestandar.js"></script>
       
	<link rel="StyleSheet" href="./comunes/css/dtree.css" type ="text/css"/>	
    </head>
<body>
<?php if ($_SESSION['tipo']==1) {
		 $menu='Admin. Total';
                  } ?>

	<div class="dtree">	
        <p><img src="./comunes/img/users.gif" width="20" height="20" title="usuario"> Usuario:<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="1"><strong><? echo substr(pg_result($resusu, 0, 5),0,27); ?></strong></font>
        </p> 
        
	<script type="text/javascript">

             
                
                d = new dTree('d');
             	d.add(0,-1,'<?echo $menu; ?>' );
             
             <?php     
		while($row=pg_fetch_row($resultado)){
			echo "d.add(".$row[0].", ".$row[4].", '".$row[2]."', '".$row[3]."', '','centro');";
			}
		?>
		document.write(d);
	</script>
	</div>
       <table border=0 width=100%> 
         <tr>
         <td align=right>
           <a class="boton2" href="./CerrarSesion.php" target="centro"><img src="./comunes/img/exit.png" width="35" height="35" title="Cerrar Sesion" align="left"></a> 
         </td>
         </tr>
       </table>
       
</body>
</html>
