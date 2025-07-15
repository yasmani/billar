<?php 
//todos los modelos con mayuscula
require "../config/Conexion.php";
date_default_timezone_set('America/La_Paz');
Class Cingreso{

  //constructor
	public function __construct()
	{


	}
	//metodo para insertar registros
		public function insertar($nombre,$detalle,$total,$fecha)
	{
		$sql="INSERT INTO cingresos(nombre,detalle,total,fecha,condicion)
		VALUES ('$nombre','$detalle','$total','$fecha','1')";
		return ejecutarConsulta($sql); //retorna 1 si la ejecucion fue correcta
	}
      //metodo para editar registro categoria funcion js 
      public function editar($ingresoid,$nombre,$detalle,$total,$fecha)
	{
		$sql="UPDATE cingresos SET ingresoid='$ingresoid',nombre='$nombre',detalle='$detalle',total='$total'
		,fecha='$fecha' 
		WHERE ingresoid='$ingresoid'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($ingresoid)
	{
		$sql="UPDATE cingresos SET condicion='0' WHERE ingresoid='$ingresoid'";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function activar ($ingresoid)
	{
		$sql="UPDATE cingresos SET condicion='1' WHERE ingresoid='$ingresoid'";
		return ejecutarConsulta($sql); 
	}
  //muestra un tupla 
	public function mostrar($ingresoid)
	{

		$sql="SELECT * FROM cingresos WHERE ingresoid='$ingresoid'";
		Return ejecutarConsultasimplefila($sql);//retorna valores  
	}
		public function mostrar_print($ingresoid)
	{

		$sql="SELECT * FROM cingresos WHERE ingresoid='$ingresoid'";
		Return ejecutarConsulta($sql);//retorna valores  
	}
	//sirve para obtener todas las tuplas de la tabla categoria
	public function listar()//mostrar todos los registros
	{
		$fecha=date('Y-m-d');
		$sql="SELECT * FROM cingresos where fecha='$fecha' and condicion='1'";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function getIngreso($ingresoid)//mostrar todos los registros
	{
		$fecha=date('Y-m-d');
		$sql="SELECT * FROM cingresos where fecha='$fecha' and ingresoid='$ingresoid' and condicion='1'";
		return ejecutarConsulta($sql); //1 o 0
	}
	public function listar_fecha($inicio,$fin)//mostrar todos los registros
	{
		
		$sql="SELECT * FROM cingresos where condicion=1 and fecha between '$inicio' AND '$fin' ORDER BY fecha asc";
		return ejecutarConsulta($sql); //1 o 0
	}
	  public function select()//mostrar todos los registros
	{
		$sql="SELECT *FROM cingresos WHERE condicion=1";
		return ejecutarConsulta($sql); //1 o 0
	}
 
}
 ?>