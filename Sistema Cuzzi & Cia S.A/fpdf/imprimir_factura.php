<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');
include ("Numbers/Words.php");
require('fpdf.php');

$pdf=new FPDF();
$pdf->Open();
$pdf->AddPage();

$idfact = '1';
if (isset($_GET['idfac'])) {
  $idfact = $_GET['idfac'];
}  
// begin Recordset
$query_factura = "SELECT * FROM factura f,detallefact df,clientes c  WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and f.idfact='$idfact' ORDER BY iddetfact";
$factura = $cnx_cuzzicia->SelectLimit($query_factura) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_factura = $factura->RecordCount();
// end Recordset

    $fec = strtotime($factura->Fields('fecha'));
	setlocale(LC_TIME,"spanish");
	$fecha=strftime("%d de %B %Y",$fec);
		
	$pdf->SetFillColor(0,0,0);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','',11);	
	
	//cliente
    $pdf->Ln(20);
	$pdf->Cell(9);
    $pdf->Cell(125,4,$factura->Fields('cliente'),0,0,'L',0);
    //direccion
	$pdf->Ln(4.5);
	$pdf->Cell(9);
	$pdf->Cell(125,4,$factura->Fields('direccion'),0,0,'L',0);
    //ruc, pedidos, fecha formato...
	$pdf->Ln(4.5);
	$pdf->Cell(1);
	$pdf->Cell(40,4,$factura->Fields('ruc'),0,0,'L',0);
	$pdf->Cell(35,4,$factura->Fields('pedido'),0,0,'L',0);
	$pdf->Cell(35,4,$fecha,0,0,'L',0);
	//guia remision
    $pdf->Ln(4.5);
	$pdf->Cell(50);
    $pdf->Cell(100,4,$factura->Fields('gremi'),0,0,'L',0);
	$pdf->Ln(7);
    //ahora mostramos las lneas de la factura
	$importe = 0;
	$igv = $factura->Fields('igv');
	$mone = $factura->Fields('moneda');
	while (!$factura->EOF) {
	$pdf->Ln(5);
	$pdf->Cell(-8);
	$pdf->Cell(20,4,$factura->Fields('idorden'),0,0,'L');	
	$cant = $factura->Fields('cantidad');
	if($factura->Fields('und')=='Mill'){
	$pdf->Cell(16,4,number_format($cant,3),0,0,'R');}
	else{$pdf->Cell(16,4,number_format($cant,2),0,0,'R');}
	$pdf->Cell(-1);
	$pdf->Cell(7,4,$factura->Fields('und'),0,0,'L');
	$pdf->MultiCell(115,4,$factura->Fields('descripcion'),0,'L');
	$pdf->Ln(-3);
	if($mone=='dolar'){
	$monto = $factura->Fields('mdolar');}
	else{$monto = $factura->Fields('monto');}
	$pdf->Cell(170,4,number_format($monto,2),0,0,'R');
	$tmonto = number_format($cant*$monto,2);
	$pdf->Cell(27,4,$tmonto,0,0,'R');
	//vamos acumulando el importe
	$importe+=round($cant*$monto,2);
	$factura->MoveNext();
	}
	
	//Calculamos los valores del final de la factura
    $importe4=number_format($importe,2,".",",");	
	$ivai=$igv;
	$impo=$importe*($ivai/100);
	$impo=sprintf("%01.2f", $impo); 
	$total=$importe+$impo; 
	$total=sprintf("%01.2f", $total);
	$impo=number_format($impo,2,".",",");	

    $total=sprintf("%01.2f", $total);
	$total2= number_format($total,2,".",",");	
	
	if($igv == 0){
	$pdf->SetY(110);
	$pdf->Cell(30);
	$pdf->Cell(82,4,utf8_decode("Exonerado del IGV según Ley N° 28086, Art. 19 Ley"),0,0,'L',0);
	$pdf->Ln(5);
	$pdf->Cell(30);
	$pdf->Cell(82,4,utf8_decode("Democratización del Libro y de Fomento a la Lectura."),0,0,'L',0);
	}
	//Calculamos de numero a palabras
	$nw = new Numbers_Words();
	$pdf->SetY(128);
	$pdf->Cell(10);
	
	if($mone == 'dolar'){			
	$pdf->Cell(161);
	$pdf->Cell(5,4,"US$",0,0,'R',0);
    $pdf->Cell(20,4,$importe4,0,0,'R',0);
	$pdf->Ln(4.5);
	//Modificamos esta parte para que tambi�n muestra la parte fraccionaria y M.N.
	$decimales = explode(".",$total);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(147,4,strtoupper($nw->toWords($decimales[0], "es") ." con ".$decimales[1]."/100 Dolares Americanos"),0,0,'L',0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(15,4,$igv."%",0,0,'R',0);
	$pdf->Cell(14,4,"US$",0,0,'R',0);
	$pdf->Cell(20,4,$impo,0,0,'R',0);	
	$pdf->Ln(4.5);
		
	$pdf->Cell(171);
	$pdf->Cell(5,4,"US$",0,0,'R',0);
	$pdf->Cell(20,4,$total2,0,0,'R',0);
	$pdf->Ln(4.5);
	}else{
	$pdf->Cell(161);
	$pdf->Cell(5,4,"S/.",0,0,'R',0);
    $pdf->Cell(20,4,$importe4,0,0,'R',0);
	$pdf->Ln(4.5);
	//Modificamos esta parte para que tambi�n muestra la parte fraccionaria y M.N.
	$decimales = explode(".",$total);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(147,4,strtoupper($nw->toWords($decimales[0], "es") ." con ".$decimales[1]."/100 Nuevos Soles"),0,0,'L',0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(15,4,$igv."%",0,0,'R',0);
	$pdf->Cell(14,4,"S/.",0,0,'R',0);
	$pdf->Cell(20,4,$impo,0,0,'R',0);	
	$pdf->Ln(4.5);
		
	$pdf->Cell(171);
	$pdf->Cell(5,4,"S/.",0,0,'R',0);
	$pdf->Cell(20,4,$total2,0,0,'R',0);
	$pdf->Ln(4.5);
	}
$pdf->Output();
?>
<?php
$factura->Close();
?>