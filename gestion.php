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

	//$unalumno = new Alumno($legajo,$apellido,$nombre,$legajo.$nomext[2]);
	$unalumno = new Alumno($legajo,$apellido,$nombre,$foto);


	if($accion=="ingreso")
	{

		$unalumno->Guardar();
	}
	else
	{
		
		$unalumno->Sacar($legajo);
	}

	header("location:index.php");
?>
