<?php
	/**
	* Función getConexion
	* Guarda en la variable $conexion la conexion 
	* @return $conexion si la conexion esta ok
	*/
	function getConexion(){
		 $servidor = "localhost";
		 $usuario = "usuarioT6";
		 $password = "1234";
		 $bd = "Libros";
		 $conexion = new mysqli($servidor, $usuario, $password, $bd);
		 if ($conexion->connect_error){
			die("Connection failed: " . $conexion->connect_error);
		 }
		 else{
			 $conexion->set_charset("utf8");
			 return $conexion;
		 }
	}
	/**
	* Funcion get_sugerencias
	* Genera una consulta, abre la conexion, lanza la consulta y guarda el resultado.
	* @param $titulo contiene lo introducido en el input del formulario
	* @return $listaTitulos será un array con el resultado de la consulta
	*/
	function get_sugerencias($titulo){
		$consulta = "SELECT titulo FROM libro WHERE titulo LIKE '%$titulo%'";
		$conexion = getConexion();
		$resultado = $conexion->query($consulta);
		if ($resultado->num_rows > 0){
			while($row = $resultado->fetch_assoc()){
				//Guardar datos en un array
				$listaTitulos[] = $row;
			}
		}
		$conexion->close();
		return $listaTitulos;
	}

	if (isset($_GET["titulo"])){
		//Obtener array con sugerencias para ese titulo
		$sugerencias = get_sugerencias($_GET["titulo"]);
		//devolvemos un JSON a partir del array con los resultados
		exit(json_encode($sugerencias));
	}
?>