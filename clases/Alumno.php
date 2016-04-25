<?php

class Alumno
{
	public $nombre;
	public $apellido;
	public $legajo;
	public $foto;

	function __construct($legajo,$apellido,$nombre,$foto){
		$this->legajo = $legajo;
		$this->apellido = $apellido;
		$this->nombre = $nombre;
		$this->foto = $foto;
	}	

	private function Mostrar()
	{
		echo "<br>".$this->nombre." ".$apellido;
	}
			
	public static function MostrarAlumno($unAlumno)
	{
		$unAlumno->Mostrar();
	}

	public function Guardar()
	{
		$nombreFoto = $this->legajo."_".$this->apellido."_".$this->nombre.".".pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
		move_uploaded_file($_FILES['archivo']['tmp_name'], "Fotitos/$nombreFoto");
		$archivo=fopen("archivos/estacionados.txt", "a");//para escritura, escribe al final	
		
		$renglon=$this->legajo."=>".$this->apellido."=>".$this->nombre."=>".$nombreFoto."\n";
		
		fwrite($archivo, $renglon); 		 
		fclose($archivo);	
	}


	

	public  function Sacar($legajo) //
	{
			$listado = Alumno::Leer(); //leo los estacionados.txt, y me retorna una lista(array)
			$estaAdentro = array();
			foreach ($listado as $alumno ) 
			{
				if($alumno[0] == trim($legajo))
				{					
					Alumno::GuardarAlumno($alumno[0],$alumno[1],$alumno[2],$alumno[3]);
				}
				else
				{
					$estaAdentro[] = $alumno;					
				}
			}
			
			Alumno::GuardarListado($estaAdentro);		
	}

	public static function GuardarListado($listado) 
	{
		$archivo = fopen("archivos/estacionados.txt","w"); //Abre archivo para escritura. Si no existe, crea 1. Si existe, borra el contenido.

			foreach ($listado as $alu) 
			{
				if(trim($alu[0]) != "")
				{
					$reglon = $alu[0] . "=>" . $alu[1] . "=>" . $alu[2]. "=>" . $alu[3]. "\n"; //
					fwrite($archivo, $reglon);
				}
			}
		fclose($archivo);	
	}

	public static function GuardarAlumno($leg,$ape,$nom,$foto)
	{
		$archivo=fopen("archivos/facturacion.txt", "a");
		 
		$renglon=$leg."=>".$ape."=>".$nom."=>".$foto."\n";
		fwrite($archivo, $renglon); 		 
		fclose($archivo);
	}
		
	public static function Leer()
	{
		$ListaDeAutosLeida=   array();
		$archivo=fopen("archivos/estacionados.txt", "r");//Abre un archivo para sólo lectura

			
		while(!feof($archivo))
		{
			$renglon=fgets($archivo);
			//http://www.w3schools.com/php/func_filesystem_fgets.asp
			$auto=explode("=>", $renglon);
			//http://www.w3schools.com/php/func_string_explode.asp
			$auto[0]=trim($auto[0]);
			if($auto[0]!="")
				$ListaDeAutosLeida[]=$auto;
		}

		fclose($archivo);
		return $ListaDeAutosLeida;
	}


	public static function CrearTablaIngresado()//
	{
		
			if(file_exists("archivos/estacionados.txt"))
			{
				$cadena=" <table border=1><th> Legajo </th><th> Apellido </th><th> Nombre </th><th> Foto </th>";

				$archivo=fopen("archivos/estacionados.txt", "r");

			    while(!feof($archivo))
			    {
				      $archAux=fgets($archivo);
				      $alum=explode("=>", $archAux);
				      $alum[0]=trim($alum[0]);
				      if($alum[0]!="")
				       $cadena =$cadena."<tr> <td> ".$alum[0]."</td> <td>  ".$alum[1] ."</td><td>  ".$alum[2] ."</td> <td> <img src=Fotitos/".$alum[3]." height=50px width=50px /></td> </tr>" ; 
				}

		   		$cadena =$cadena." </table>";
		    	fclose($archivo);

				$archivo=fopen("archivos/tablaEstacionados.php", "w");
				fwrite($archivo, $cadena);
			}	else
			{
				$cadena= "no hay facturación";

				$archivo=fopen("archivos/tablaEstacionado.php", "w");
				fwrite($archivo, $cadena);
			}
	}

	public static function CrearJSAutocompletar()
	{		
			$cadena="";

			$archivo=fopen("archivos/estacionados.txt", "r");

		    while(!feof($archivo))
		    {
			      $archAux=fgets($archivo);
			      //http://www.w3schools.com/php/func_filesystem_fgets.asp
			      $auto=explode("=>", $archAux);
			      //http://www.w3schools.com/php/func_string_explode.asp
			      $auto[0]=trim($auto[0]);

			      if($auto[0]!="")
			      {
			      	 $auto[1]=trim($auto[1]);
			      $cadena=$cadena." {value: \"".$auto[0]."\" , data: \" ".$auto[1]." \" }, \n"; 
			      }
			}
		    fclose($archivo);

			 $archivoJS="$(function(){
			  var patentes = [ \n\r
			  ". $cadena."
			   
			  ];
			  
			  // setup autocomplete function pulling from patentes[] array
			  $('#autocomplete').autocomplete({
			    lookup: patentes,
			    onSelect: function (suggestion) {
			      var thehtml = '<strong>patente: </strong> ' + suggestion.value + ' <br> <strong>ingreso: </strong> ' + suggestion.data;
			      $('#outputcontent').html(thehtml);
			         $('#botonIngreso').css('display','none');
      						console.log('aca llego');
			    }
			  });
			  

			});";
			
			$archivo=fopen("js/funcionAutoCompletar.js", "w");
			fwrite($archivo, $archivoJS);
	}

		public static function CrearTablaFacturado()
	{
			if(file_exists("archivos/facturacion.txt"))
			{
				$cadena=" <table border=1><th> Legajo </th><th> Apellido </th><th> Nombre </th><th> Foto </th>";

				$archivo=fopen("archivos/facturacion.txt", "r");

			    while(!feof($archivo))
			    {
				      $archAux=fgets($archivo);
				      //http://www.w3schools.com/php/func_filesystem_fgets.asp
				      $auto=explode("=>", $archAux);
				      //http://www.w3schools.com/php/func_string_explode.asp
				      $auto[0]=trim($auto[0]);
				      if($auto[0]!="")
				       $cadena =$cadena."<tr> <td> ".$auto[0]."</td> <td>  ".$auto[1] ."</td><td>  ".$auto[2] ."</td> <td> <img src=Fotitos/".$auto[3]." height=50px width=50px /></td> </tr>" ; 
				}

		   		$cadena =$cadena." </table>";
		    	fclose($archivo);

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);




			}	else
			{
				$cadena= "no hay facturación";

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);
			}

	}


}


?>