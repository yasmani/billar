<?php 
//todos los modelos con mayuscula
require "../config/Conexion.php";
date_default_timezone_set('America/La_Paz');
Class Egresos{

  //constructor
	public function __construct()
	{


	}
	//metodo para insertar registros
		public function insertar($nombre,$cantidad,$detalle,$total,$fecha)
	{
		$sql="INSERT INTO egresosadm(nombre,cantidad,detalle,total,fecha,condicion)
		VALUES ('$nombre','$cantidad','$detalle','$total','$fecha','1')";
		return ejecutarConsulta($sql); //retorna 1 si la ejecucion fue correcta
	}
      //metodo para editar registro categoria funcion js 
      public function editar($egresoid,$nombre,$cantidad,$detalle,$total,$fecha)
	{
		$sql="UPDATE egresosadm SET egresoid='$egresoid',nombre='$nombre',cantidad='$cantidad',detalle='$detalle',total='$total'
		,fecha='$fecha' 
		WHERE egresoid='$egresoid'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($egresoid)
	{
		$sql="UPDATE egresosadm SET condicion='0' WHERE egresoid='$egresoid'";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function activar ($egresoid)
	{
		$sql="UPDATE egresosadm SET condicion='1' WHERE egresoid='$egresoid'";
		return ejecutarConsulta($sql); 
	}
  //muestra un tupla 
	public function mostrar($egresoid)
	{

		$sql="SELECT * FROM egresosadm WHERE egresoid='$egresoid'";
		Return ejecutarConsultasimplefila($sql);//retorna valores  
	}
		public function mostrar_print($egresoid)
	{

		$sql="SELECT * FROM egresosadm WHERE egresoid='$egresoid'";
		Return ejecutarConsulta($sql);//retorna valores  
	}
	//sirve para obtener todas las tuplas de la tabla categoria
	public function listar()//mostrar todos los registros
	{
		$fecha=date('Y-m-d');
		$sql="SELECT * FROM egresosadm where fecha='$fecha' and condicion='1'";
		return ejecutarConsulta($sql); //1 o 0
	}
	
	public function listar_fecha2($inicio,$fin)//mostrar todos los registros
	{
		
		$sql="SELECT * FROM egresosadm2 where condicion='0' and fecha between '$inicio' AND '$fin' ORDER BY fecha asc";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function getEgreso($egresoid)//mostrar todos los registros
	{
		$fecha=date('Y-m-d');
		$sql="SELECT * FROM egresosadm where fecha='$fecha' and egresoid='$egresoid' and condicion='1'";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function listar_fecha($inicio,$fin)//mostrar todos los registros
	{
		
		$sql="SELECT * FROM egresosadm where condicion='0' and fecha between '$inicio' AND '$fin' ORDER BY fecha asc";
		return ejecutarConsulta($sql); //1 o 0
	}
	  public function select()//mostrar todos los registros
	{
		$sql="SELECT *FROM egresosadm WHERE condicion=1";
		return ejecutarConsulta($sql); //1 o 0
	}
 
}
 ?>