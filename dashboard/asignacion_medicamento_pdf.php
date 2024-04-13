<?php
//session_start(); se usa solo si usamos variables sesiones en el documento
require('vendor/FPDF/fpdf.php');
require_once "../mysqli/conexion.php";
$conecta = new Conexion();  
/*$sql = "SELECT a.idasig idasg,
                a.fecha fe,
                a.descripcion de,
                a.cat_peticion can,
                CONCAT(u2.nombre, ' ', u2.apellido, ' ', u2.cedula) usuari,
                CONCAT(u.nombre, ' ', u.apellido, ' ', u.cedula)  paci,
                s.descripcion sde
        FROM asignacion a
        INNER JOIN usuario u ON a.idusu = u.idusu
        INNER JOIN usuario u2 ON a.usuario = u2.idusu
        INNER JOIN sede s ON u.idsede = s.idsede
        INNER JOIN tipo_persona pe ON u.idtipopersona = pe.idtipopersona
        WHERE pe.idtipopersona = 3";*/

$sql =  "SELECT a.idasig idasg,
                a.fecha fe,
                a.descripcion de,
                a.cat_peticion can,
                CONCAT(u2.nombre, ' ', u2.apellido, ' ', u2.cedula) usuari,
                CONCAT(u.nombre, ' ', u.apellido, ' ', u.cedula)  paci,
                s.descripcion sde
        FROM asignacion a
        INNER JOIN usuario u ON a.idusu = u.idusu
        INNER JOIN usuario u2 ON a.usuario = u2.idusu
        INNER JOIN sede s ON u.idsede = s.idsede
        INNER JOIN tipo_persona pe ON u.idtipopersona = pe.idtipopersona
        WHERE pe.idtipopersona = 3";

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



/*
class pdf extends FPDF {

  var $tablewidths;
  var $footerset;

  function _beginpage($orientation, $size) {
    $this->page++;

    // Resuelve el problema de sobrescribir una página si ya existe.
    if(!isset($this->pages[$this->page])) 
      $this->pages[$this->page] = '';
      $this->state  =2;
      $this->x = $this->lMargin;
      $this->y = $this->tMargin;
      $this->FontFamily = '';

   // Compruebe el tamaño y la orientación.
    if($orientation=='')
      $orientation = $this->DefOrientation;
    else
      $orientation = strtoupper($orientation[0]);
    if($size=='')
      $size = $this->DefPageSize;
    else
      $size = $this->_getpagesize($size);
    if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
    {

      // Nuevo tamaño o la orientación
      if($orientation=='P')
      {
        $this->w = $size[0];
        $this->h = $size[1];
      }
      else
      {
        $this->w = $size[1];
        $this->h = $size[0];
      }
      $this->wPt = $this->w*$this->k;
      $this->hPt = $this->h*$this->k;
      $this->PageBreakTrigger = $this->h-$this->bMargin;
      $this->CurOrientation = $orientation;
      $this->CurPageSize = $size;
    }
    if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
      $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
  }

  public function header(){
    $this->SetFillColor(255, 255,255);
    $this->Rect(0,0, 220, 50, 'F');
    $this->SetY(25);
    $this->SetFont('Arial', 'B', 30);
    $this->Image("../images/logo.png", 20, 22, 40, 18);
    $this->SetMargins(10,30,20,20);
  }


  function Footer() {
   // Compruebe si pie de página de esta página ya existe ( lo mismo para Header ( ) )
    if(!isset($this->footerset[$this->page])) {
      $this->SetFont('Arial', '', 6);
      $this->SetY(-15);
      $this->SetX(20);
      //$this->AliasNbPages();

      // Numero de Pagina
      //$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
      $this->Cell(0, 10, utf8_decode("____________________________________________________________________________________________________________________________________________________________________________"), 0, 0, 'C', 1);
      $this->Ln(7);
      $this->Cell(0, 6, utf8_decode("Dirección: 325 Av. San Martín, Caracas 1020, Distrito Capital"), 0, 0, 'C', 1);
      $this->Ln(9);
      $this->Cell(0, 0, utf8_decode("Teléfono: 0212-4154679"), 0, 0, 'C', 1);

      // Conjunto Footerset
      $this->footerset[$this->page] = true;
    }

  }

  function morepagestable($datas, $lineheight=13) {
   // Algunas cosas para establecer y ' recuerdan '
    $l = $this->lMargin;
    $startheight = $h = $this->GetY();
    $startpage = $currpage = $maxpage = $this->page;

    // Calcular todo el ancho
    $fullwidth = 0;
    foreach($this->tablewidths AS $width) {
      $fullwidth += $width;
    }

    // Ahora vamos a empezar a escribir la tabla
    foreach($datas AS $row => $data) {
      $this->page = $currpage;

      // Escribir los bordes horizontales
      $this->Line($l,$h,$fullwidth+$l,$h);

      // Escribir el contenido y recordar la altura de la más alta columna
      foreach($data AS $col => $txt) {
        $this->page = $currpage;
        $this->SetXY($l,$h);
        $this->MultiCell($this->tablewidths[$col],$lineheight,$txt);
        $l += $this->tablewidths[$col];

        if(!isset($tmpheight[$row.'-'.$this->page]))
          $tmpheight[$row.'-'.$this->page] = 0;
        if($tmpheight[$row.'-'.$this->page] < $this->GetY()) {
          $tmpheight[$row.'-'.$this->page] = $this->GetY();
        }
        if($this->page > $maxpage)
          $maxpage = $this->page;
      }
      // Obtener la altura estábamos en la última página utilizada
      $h = $tmpheight[$row.'-'.$maxpage];
      //Establecer el "puntero " al margen izquierdo
      $l = $this->lMargin;
      // Establecer el "$currpage en la ultima pagina
      $currpage = $maxpage;
    }

    // Dibujar las fronteras
    // Empezamos a añadir una línea horizontal en la última página
    $this->page = $maxpage;
    $this->Line($l,$h,$fullwidth+$l,$h);
    // Ahora empezamos en la parte superior del documento
    for($i = $startpage; $i <= $maxpage; $i++) {
      $this->page = $i;
      $l = $this->lMargin;
      $t  = ($i == $startpage) ? $startheight : $this->tMargin;
      $lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
      $this->Line($l,$t,$l,$lh);
      foreach($this->tablewidths AS $width) {
        $l += $width;
        $this->Line($l,$t,$l,$lh);
      }
    }
    // Establecerlo en la última página , si no que va a causar algunos problemas
    $this->page = $maxpage;
  }
}
*/

$fpdf = new pdf('L','mm','A4');
//$fpdf = new PDF('L','pt');
$fpdf->AliasNbPages();
$fpdf->AddPage();
$fpdf->SetMargins(10,30,20,20);
$fpdf->SetFillColor(255, 255,255);
/* ------ ENCABEZADO ------ */
$fpdf->SetTextColor(0,0,0);
$fpdf->SetFont('Arial', '', 12);
$fpdf->SetY(22);
$fpdf->SetX(120);
$fpdf->Write(5, utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA"));
$fpdf->Ln();
$fpdf->SetX(110);
$fpdf->Write(5, utf8_decode("MINISTERIO DEL PODER POPULAR PARA LA SALUD"));
$fpdf->Ln();
$fpdf->SetX(117);
$fpdf->Write(5, utf8_decode("DIRECCIÓN DE SALUD DEL DISTRITO CAPITAL"));
$fpdf->Ln();
$fpdf->SetX(95);
$fpdf->Write(5, utf8_decode("EJE CENTRO-OESTE DEL ÁREA DE SALUD INTEGRAL COMUNITARIA"));
$fpdf->Ln();
$fpdf->SetX(130);
$fpdf->Write(5, utf8_decode("DISTRITO CAPITAL-CARACAS"));



/*-------------DETALLE--------------*/
$fpdf->SetFont('Arial', '', 15);
$fpdf->SetFillColor(255, 255,255);
$fpdf->SetY(60);
$fpdf->SetX(120);
$fpdf->SetTextColor(0,0,0);
$fpdf->Cell(50, 10, utf8_decode('Asignación de Medicamentos'), 0, 0, 'C', 1);
$fpdf->SetFont('Arial', '', 9);
/*-------------Encabezado--------------*/
$fpdf->SetY(80);
$fpdf->SetTextColor(255,255,255);	
$fpdf->SetFillColor(0,3,178);
$fpdf->Cell(19, 10, 'FECHA', 0, 0, 'C', 1);
$fpdf->Cell(48, 10, 'PACIENTE', 0, 0, 'C', 1);
$fpdf->Cell(75, 10, 'MEDICAMENTO', 0, 0, 'C', 1);
$fpdf->Cell(48, 10, 'TIPO', 0, 0, 'C', 1);
$fpdf->Cell(6, 10, 'CT.', 0, 0, 'C', 1);
$fpdf->Cell(50, 10, 'USUARIO', 0, 0, 'C', 1);
$fpdf->Cell(20, 10, 'SEDE', 0, 0, 'C', 1);
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
	$fe = $fact['fe'];
	$pa = $fact['paci'];
	$id = $fact['idasg'];
	//$tp = $fact['me_tp'];
	$ca = $fact['can'];
	$us = $fact['usuari'];
	$sd = $fact['sde'];
	$str = "SELECT da.idmedi idm,
                     da.idasig ida,
                     m.nombre m_nom,
                     tp.descripcion des
              FROM detalle_asigna da
              INNER JOIN medicamento m ON da.idmedi= m.idmedi
              INNER JOIN tipo_medicamento tp ON m.idtipo= tp.idtipo
              WHERE da.idasig = $id"; 
    $med =  $conecta->fullselect($str);  
    $num = $med->num_rows;
    $me = "";
    $tp = "";
    for ($x=0; $x < $num; $x++) 
    {
      $med->data_seek($num);
      $si = $med->fetch_assoc();
      $me .= $si['des'].",";
      $tp .= $si['m_nom'].",";
    }


	$fpdf->Cell(19, 10, utf8_decode("$fe"), 'B', 0, 'C', 1);
	$fpdf->Cell(48, 10, utf8_decode("$pa"), 'B', 0, 'C', 1);
	$fpdf->Cell(75, 10, utf8_decode("$tp"), 'B', 0, 'C', 1);
	$fpdf->Cell(48, 10, utf8_decode("$me"), 'B', 0, 'C', 1);
	$fpdf->Cell(6, 10, utf8_decode("$ca"), 'B', 0, 'C', 1);
	$fpdf->Cell(50, 10, utf8_decode("$us"), 'B', 0, 'C', 1);
	$fpdf->Cell(20, 10, utf8_decode("$sd"), 'B', 0, 'C', 1);
	$fpdf->Ln();
}

$fpdf->Output('I', "Asignacion_Medicamento.pdf");

