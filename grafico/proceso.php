<?php
// Declaramos el fichero de conexión
include_once("config.php");

	$year = date('Y');
	$total=array();
	for ($month = 1; $month <= 12; $month ++){
		
	$query = $db->prepare("select fecha,total from ventas where  year(fecha)='$year'");
    $query->execute();
    $row = $query->fetch();
	$total[]=$row['total'];
	
	}

	$tjan = $total[0];
	$tfeb = $total[1];
	$tmar = $total[2];
	$tapr = $total[3];
	$tmay = $total[4];
	$tjun = $total[5];
	$tjul = $total[6];
	$taug = $total[7];
	$tsep = $total[8];
	$toct = $total[9];
	$tnov = $total[10];
	$tdec = $total[11];

	$pyear = $year - 1;
	$pnum=array();

	for ($pmonth = 1; $pmonth <= 12; $pmonth ++){		
		$pquery = $db->prepare("select sum(monto) as ptotal from tbl_ventas where month(venta_fecha)='$pmonth' and year(venta_fecha)='$pyear'");
		$pquery->execute();
		$prow = $pquery->fetch();
		$ptotal[]=$prow['ptotal'];
	}
	
	$pjan = $ptotal[0];
	$pfeb = $ptotal[1];
	$pmar = $ptotal[2];
	$papr = $ptotal[3];
	$pmay = $ptotal[4];
	$pjun = $ptotal[5];
	$pjul = $ptotal[6];
	$paug = $ptotal[7];
	$psep = $ptotal[8];
	$poct = $ptotal[9];
	$pnov = $ptotal[10];
	$pdec = $ptotal[11];
?>