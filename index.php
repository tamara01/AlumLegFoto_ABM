<?php

require"clases/Alumno.php";
$path = "gestion.php";

Alumno::CrearJSAutocompletar();
Alumno::CrearTablaFacturado();
Alumno::CrearTablaIngresado();

?>
<!doctype html>
<html lang="en-US">
<head>

  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title> Archivos </title>

  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <link rel="stylesheet" type="text/css" href="css/animacion.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
 
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src="js/funcionAutoCompletar.js"></script>
  <!--script type="text/javascript" src="js/currency-autocomplete.js"></script-->
</head>
	<body>
    <div class="CajaUno animated bounceInDown">

            <form action="<?php echo $path; ?>" method="post" enctype="multipart/form-data">
            <input type="text" name="legajo"  id="autocomplete" required pattern="[0-9]{3}" placeholder="Legajo"/>
            <br>
            <input type="text" name="apellido"  id="autocomplete"  placeholder="Apellido"/>
            <br>
            <input type="text" name="nombre"  id="autocomplete"  placeholder="Nombre" />
            <br>
            <input type="file" class="MiBotonUTN" name="archivo" >
            <br>
            <input type="submit" id="botonIngreso" class="MiBotonUTN" value="ingreso"  name="registrar" />
            <br/>
            <input type="submit" class="MiBotonUTNLinea" value="egreso" name="registrar" />
          </form>

<div id="outputbox">
    <p id="outputcontent">...</p>
  </div>

    </div>
      <div class="CajaEnunciado animated bounceInLeft">
      <h2>Alumnos</h2>
     

     <?php 

      include("archivos/tablaEstacionados.php");

     ?>
      
      
    </div>

     <div class="CajaEnunciadoDerecha animated bounceInLeft">
      <h2>Egresados</h2>
     

     <?php 

      include("archivos/tablaFacturacion.php");

     ?>
      
      
    </div>
      		
	</body>
</html>