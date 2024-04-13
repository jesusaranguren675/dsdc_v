<?php
//session_start(); se usa solo si usamos variables sesiones en el documento
require('vendor/FPDF/fpdf.php');
require_once "../mysqli/conexion.php";
$conecta = new Conexion();  
$sql =  "SELECT m.nombre m_nom, m.cantidad m_can, tpm.descripcion des
		FROM medicamento m
		INNER JOIN tipo_medicamento tpm ON m.idtipo = tpm.idtipo ";

$tbt =  $conecta->fullselect($sql);  
$row = $tbt->num_rows;


class pdf extends FPDF
{
	public function header()
	{
		$this->SetFillColor(255, 255,255);
		$this->Rect(0,0, 220, 50, 'F');
		$this->SetY(25);
		$this->SetFont('Arial', 'B', 30);
		$this->Image("../images/logo.png", 20, 22, 40, 18);
		$this->SetMargins(10,30,20,20);
	}

	public function footer()
	{
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial', '', 6);
		$this->SetY(-25);
		$this->SetX(20);
		$this->AliasNbPages();
		$this->Cell(0, 10, utf8_decode("____________________________________________________________________________________________________________________________________________________________________________"), 0, 0, 'C', 1);
		$this->Ln(7);
		$this->Cell(0, 6, utf8_decode("Dirección: 325 Av. San Martín, Caracas 1020, Distrito Capital"), 0, 0, 'C', 1);
		$this->Ln(9);
		$this->Cell(0, 0, utf8_decode("Teléfono: 0212-4154679"), 0, 0, 'C', 1);

	}
}


$fpdf = new pdf('P','mm','letter',true);
$fpdf->AddPage('portrait', 'letter');
$fpdf->SetMargins(10,30,20,20);
$fpdf->SetFillColor(255, 255,255);
/* ------ ENCABEZADO ------ */
$fpdf->SetTextColor(0,0,0);
$fpdf->SetFont('Arial', '', 9);
$fpdf->SetY(22);
$fpdf->SetX(95);
$fpdf->Write(5, utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA"));
$fpdf->Ln();
$fpdf->SetX(88);
$fpdf->Write(5, utf8_decode("MINISTERIO DEL PODER POPULAR PARA LA SALUD"));
$fpdf->Ln();
$fpdf->SetX(93);
$fpdf->Write(5, utf8_decode("DIRECCIÓN DE SALUD DEL DISTRITO CAPITAL"));
$fpdf->Ln();
$fpdf->SetX(75);
$fpdf->Write(5, utf8_decode("EJE CENTRO-OESTE DEL ÁREA DE SALUD INTEGRAL COMUNITARIA"));
$fpdf->Ln();
$fpdf->SetX(105);
$fpdf->Write(5, utf8_decode("DISTRITO CAPITAL-CARACAS"));



/*-------------DETALLE--------------*/
$fpdf->SetFont('Arial', '', 15);
$fpdf->SetFillColor(255, 255,255);
$fpdf->SetY(60);
$fpdf->SetX(85);
$fpdf->SetTextColor(0,0,0);
$fpdf->Cell(50, 10, utf8_decode('Medicamentos'), 0, 0, 'C', 1);
$fpdf->SetFont('Arial', '', 9);
/*-------------Encabezado--------------*/
$fpdf->SetY(80);
$fpdf->SetTextColor(255,255,255);	
$fpdf->SetFillColor(0,3,178);
$fpdf->Cell(70, 10, 'MEDICAMENTO', 0, 0, 'C', 1);
$fpdf->Cell(60, 10, 'CANTIDAD', 0, 0, 'C', 1);
$fpdf->Cell(70, 10, 'TIPO', 0, 0, 'C', 1);
$fpdf->Ln();
$fpdf->SetLineWidth(0.5);
$fpdf->SetTextColor(0,0,0);
$fpdf->SetFillColor(255,255,255);
$fpdf->SetDrawColor(80,80,80);
/*-------------Datos--------------*/

for ($j=1; $j <= $row; $j++) 
{
	$tbt->data_seek($row);
	$fact = $tbt->fetch_assoc();
	$m_nom = $fact['m_nom'];
	$m_can = $fact['m_can'];
	$des = $fact['des'];
	$fpdf->Cell(70, 10, utf8_decode("$m_nom"), 'B', 0, 'C', 1);
	$fpdf->Cell(60, 10, utf8_decode("$m_can"), 'B', 0, 'C', 1);
	$fpdf->Cell(70, 10, utf8_decode("$des"), 'B', 0, 'C', 1);
	$fpdf->Ln();
}

$fpdf->Output('I', "Medicamentos.pdf");

