<?php 
if(!isset($_COOKIE["usuario"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
} 
 if($tipo=='administrador'){
include_once "encabezado.php";
}
if($tipo=='cajero'){
include_once "encabezado3.php";
}
if($tipo=='ambulante'){
	include_once "encabezado4.php";
}



$usuarios = $base_de_datos->query("SELECT * FROM usuario  ");
$productos = $base_de_datos->query("SELECT * FROM productos ");

?>
      <form name="formulario"   action="./reportes/reporte-ventas-semanal-vendedor.php"
          id="formulario" method="POST">
          <!--div responsivo-->
          <hr>
          <h1>VENTAS DE LA TIENDA POR VENDEDOR  </h1>
         
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <label for="">seleccionar Vendedor</label>
           <select   name="usuario" class="form-control"  >
                 <?php 
                  
                 foreach($usuarios as $usuario){ 
                      
                           echo '<option   value="'.$usuario->id.'" > '.$usuario->usuario.'</option>';
                 }
                 ?>
                </select>
          <br>
      

          <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
          <input  style="color:black"  type="date" id="inicio" name="inicio"
            value="<?php echo date("Y-m-d");?>"
            >
        <input  style="color:black" type="date" id="fin" name="fin"
            value="<?php echo date("Y-m-d");?>">
          <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER ventas  </button>
      </form>	
      <hr>
      <form name="formulario"   action="./reportes/reporte-ventas-semanal-todos.php"
          id="formulario" method="POST">
          <h1>  TODAS LAS VENTAS DE TIENDA  </h1>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
         
          <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
          <input  style="color:black"  type="date" id="inicio" name="inicio"
            value="<?php echo date("Y-m-d");?>"
            >
        <input  style="color:black" type="date" id="fin" name="fin"
            value="<?php echo date("Y-m-d");?>">
          <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER ventas  </button>
      </form>	
      <hr>
         <h3>ventas por producto</h3>
      <form name="formulario"   method="POST" action="./reportes/ventas_por_productos.php">

      <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
          <label for="">seleccionar producto</label>
           <select   name="idproducto" class="form-control"  >
                 <?php 
                 foreach($productos as $prod){ 
                           echo '<option   value="'.$prod->id.'" > '.$prod->codigo.''.$prod->nombre.'</option>';
                 }
                 ?>
                </select>
          <br>
          <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
          <input  style="color:black"  type="date" id="inicio" name="inicio"
            value="<?php echo date("Y-m-d");?>"
            >
        <input  style="color:black" type="date" id="fin" name="fin"
            value="<?php echo date("Y-m-d");?>">
          <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER ventas  </button>
      </form>	
      <!-- <form name="formulario" target="_blank" action="./reportes/reporte-ventas-semanal.php"
          id="formulario" method="POST">
          <h1>TODAS LAS VENTAS  </h1>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h4>FECHA INICIO: &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA FINAL:</h4>
          <input  style="color:black"  type="date" id="inicio" name="inicio"
            value="<?php echo date("Y-m-d");?>"
            >
        <input  style="color:black" type="date" id="fin" name="fin"
            value="<?php echo date("Y-m-d");?>">
          <button class="btn btn-primary"  type="submit" id="btnGuardar"><i class="fa fa-eye"></i>VER ventas (PDF)</button>
      </form>	 -->
