<?php

ob_start();    
$RutaDao = "..";
$txtAccion="";
require('../../comunes/script/fpdf181/fpdf.php');
include("../dao/reporteDAO.php");
$objreporte = new reporteDAO();
session_start();

    //if ($_SESSION['txtAccion']=='') {
        if(isset($_GET["accion"])){
            $txtAccion = $_GET["accion"];
        }elseif (isset($_POST["accion"])) {
            $txtAccion = $_POST["accion"];   
            } else {
                die("<h1>PROBLEMAS CON LA VARIABLE 'accion'</h1>");
            }
        
            //die("$txtAccion");
            
        switch ($txtAccion){

            case "datosBien":
                //die($_GET["codigo"]);
                $result = $objreporte->estatusBien($_GET["codigo"],$_GET["tipo"]);
                $bien = pg_fetch_assoc($result);              
                //die(json_encode($bien));
                if(pg_num_rows($result) === 0){
                    //die("XXXXXXXXXXXXXXXXXX");
                    echo "<div id='noexisteregistro'></div>"; 
                    break;
                }else{
                    echo "<tr id='bien".$bien["id_t26_muebles"]."'>"; 
                    echo "<td bgcolor='#F6eded'>".$bien['descripcion']."</td>";
                    if($bien['recibido']==="t"){
                        echo "<td bgcolor='#F6eded'>Recibido</td>";
                    }else if($bien['recibido']==="f"){
                        echo "<td bgcolor='#F6eded'>Prestado</td>";
                    }                    
                    echo "<td bgcolor='#F6eded'>".date("d/m/Y",strtotime($bien['desde']))."</td>";
                    echo "<td bgcolor='#F6eded'>".date("d/m/Y",strtotime($bien['hasta']))."</td>";
                    echo "<td bgcolor='#F6eded'><button type='button' "
                      ."onclick='detallebien(".'"'.$bien["c_des_catalogo"].'"'.",".'"'.$bien["marca"].'"'.",".'"'.$bien["modelo"].'"'.")'><img src='../../comunes/img/folder1.gif'></button></td>";
                    echo "<input type='hidden' name='bien[]' value='".$bien["id_t26_muebles"]."'>";
                    echo "</tr>";
                    }
                break;
                
            case "unidad_adm":
                
                //die(var_dump($_GET));
                
                $recibido = explode(",", $_GET["recibido"]);

                //die(" ".count($recibido[0]));
                if(isset($_GET["desde"]) && isset($_GET["hasta"]) && isset($_GET["unidad"]) && $_GET["unidad"]!==""){
                //die($_GET["desde"]." ".$_GET["hasta"]." ".gettype($_GET["unidad"]));
                    $result = $objreporte->bienesUnidad($_GET["desde"],$_GET["hasta"],$_GET["unidad"]);
                    
                /*    while ($data = pg_fetch_assoc($result)){
                            $array["bienes"][] = $data;
                                            }
                            die(json_encode($array));*/

                    if(pg_num_rows($result) > 0){         
                            echo '<thead>
                                               <tr>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="5%">N°</th>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Descripción</th>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Serial</th>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Marca</th>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Modelo</th>
                                                    <th class="resultado" bgcolor="#DAD6D6" align="center" width="20%">Bien Nacional</th>
                                                </tr>
                                           </thead>
                                            <tbody>';

                        if(count($recibido) === 2 || ( count($recibido) === 1 && $recibido[0] === "" )){
                            $a = 0;
                            for($i = 0 ; $i < pg_num_rows($result); $i++ ){
                                echo "<tr><td bgcolor='#F6eded'>".++$a."</td>";
                                echo "<td bgcolor='#F6eded'>".pg_result($result,$i,10)."</td>";
                                echo "<td bgcolor='#F6eded'>".pg_result($result,$i,5)."</td>";
                                echo "<td bgcolor='#F6eded'>".pg_result($result,$i,3)."</td>";
                                echo "<td bgcolor='#F6eded'>".pg_result($result,$i,4)."</td>";
                                echo "<td bgcolor='#F6eded'>".pg_result($result,$i,6)."</td></tr>";
                            }
                        }elseif (count($recibido) === 1 && $recibido[0] === "recibido") {
                            $a = 0;
                            for($i = 0 ; $i < pg_num_rows($result); $i++ ){
                                if(pg_result($result,$i,9) === "t"){
                                    echo "<tr><td bgcolor='#F6eded'>".++$a."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,10)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,5)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,3)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,4)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,6)."</td></tr>";
                                }                                
                            }
                        }elseif(count($recibido) === 1 && $recibido[0] === "prestado"){
                            $a = 0;
                            for($i = 0 ; $i < pg_num_rows($result); $i++ ){
                                if(pg_result($result,$i,9) === "f"){
                                    echo "<tr><td bgcolor='#F6eded'>".++$a."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,10)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,5)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,3)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,4)."</td>";
                                    echo "<td bgcolor='#F6eded'>".pg_result($result,$i,6)."</td></tr>";
                                }                                
                            }
                        echo '</tbody><tfoot></tfoot>';   
                        }                   
                    }else{
                        echo "<div id='noexisteregistro'></div>";                    
                    }
                    }else{
                        echo "<h1>NO EXISTE ALGUNA DE LAS VARIABLES NECESARIAS</h1>";
                    }          
                break;  
                
            case "pdf":
                
                
                
                break;
            
            case "default":
                
                die("Problemas Al llegar la variable Accion al Controlador");
                
                //die($_POST["desde"]);
                
                

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}

function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}

$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(30,50,30,40));
srand(microtime()*1000000);
for($i=0;$i<20;$i++)
    $pdf->Row(array(GenerateSentence(),GenerateSentence(),GenerateSentence(),GenerateSentence()));
$pdf->Output();
                break;
        }        
?>