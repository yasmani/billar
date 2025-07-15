<?php
	require "../fpdf181/fpdf.php";
	require "fechaspanish.php";
	
	class PDF extends FPDF
	{
		function Header()
		{
			// '../files/usuarios/".$reg->imagen."
		//  $this->Image('../web/img/logo sociedad cientifica de medicina general.jpg', 5, 5, 30 );
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			date_default_timezone_set("America/La_Paz");
			$this->Cell(250,10,utf8_decode(fechaCastellano(date("d-m-Y H:i:s"))),0,1,'C');
// 			$this->Cell(250,10,utf8_decode("miercoles 17 de octubre de 2018"),0,1,'C');
			$this->Cell(180,10, '           REPORTE DE TODAS LAS COMPRAS',0,0,'C');
			
			$this->Ln(20);
		}
		
		function Footer()
		{
		$this->SetY(-20);
			$this->SetX(50);
			$this->SetFont('Arial','I', 12);
			$this->Cell(50,6,'----------',0,1,'C',0);
			$this->SetX(50);
			$this->Cell(50,6,'entrega conforme',0,0,'C',0);
			$this->SetY(-20);			  
			$this->SetX(90);
	
			//$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
			// $this->Cell(0,5, 'control  ',0,0,'C' );
		}		
	}
?>