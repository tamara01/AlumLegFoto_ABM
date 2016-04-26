<?php
	require"clases/Alumno.php";

	$legajo=$_POST['legajo'];
	$apellido=$_POST['apellido'];
	$nombre=$_POST['nombre'];
	$foto=$_FILES['archivo']['name'];
	$accion=$_POST['registrar'];

	/*
	$nomext=explode(".", $foto);//me devuelve un array con el nombre y la extension
	array(2) { [0]=> string(9) "foto1 (5)" [1]=> string(3) "jpg" }
	var_dump($nomext);
	die();	
	*/

	
	$nombreFoto = $legajo."_".$apellido."_".$nombre.".".pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	//var_dump($nombreFoto);die(); string(20) "555_Dente_andres.jpg"
	//$unalumno = new Alumno($legajo,$apellido,$nombre,$legajo.$nomext[2]);
	$unalumno = new Alumno($legajo,$apellido,$nombre,$foto);


	if($accion=="ingreso")
	{

		$unalumno->Guardar();
	}
	elseif ($accion == "modificacion") {

		//Alumno::Modificar($unalumno);
		$unalumno->Modificar($legajo,$apellido,$nombre,$nombreFoto);

	}
	else
	{
		
		$unalumno->Sacar($legajo);
	}

	header("location:index.php");
?>
