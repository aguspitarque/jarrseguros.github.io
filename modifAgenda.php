<?php 	include("Conexion/db.php"); ?>


<?php 
	if(isset($_POST['guardarAgenda']))
	{

		$enero = $_POST['enero'];
		$febrero = $_POST['febrero'];
		$marzo = $_POST['marzo'];
		$abril = $_POST['abril'];
		$mayo = $_POST['mayo'];
		$junio = $_POST['junio'];
		$julio = $_POST['julio'];
		$agosto = $_POST['agosto'];
		$septiembre = $_POST['septiembre'];
		$octubre = $_POST['octubre'];
		$noviembre = $_POST['noviembre'];
		$diciembre = $_POST['diciembre'];

		if ($enero != "on") {
			$enero = "off";
		}
			if ($febrero != "on") {
			$febrero = "off";
		}
			if ($marzo != "on") {
			$marzo = "off";
		}
			if ($abril != "on") {
			$abril = "off";
		}
			if ($mayo != "on") {
			$mayo = "off";
		}
			if ($junio != "on") {
			$junio = "off";
		}
			if ($julio != "on") {
			$julio = "off";
		}
			if ($agosto != "on") {
			$agosto = "off";
		}
			if ($septiembre != "on") {
			$septiembre = "off";
		}
			if ($octubre != "on") {
			$octubre = "off";
		}
			if ($noviembre != "on") {
			$noviembre = "off";
		}
			if ($diciembre != "on") {
			$diciembre = "off";
		}

		$idCliente = $_POST['idCliente'];


		$query = "SELECT * FROM clienteagenda WHERE IdUsuario = $idCliente";

		$result = mysqli_query($con,$query);

		$idAgenda = "";

		while ($row = mysqli_fetch_array($result)) 
		{
			$idAgenda = $row['Id'];
		}

		$updEnero = "UPDATE clientepago SET Pago = '$enero' WHERE IdAgenda = $idAgenda AND Mes = 'Enero'";
		$updFebrero = "UPDATE clientepago SET Pago = '$febrero' WHERE IdAgenda = $idAgenda AND Mes = 'Febrero'";
		$updMarzo = "UPDATE clientepago SET Pago = '$marzo' WHERE IdAgenda = $idAgenda AND Mes = 'Marzo'";
		$updAbril = "UPDATE clientepago SET Pago = '$abril' WHERE IdAgenda = $idAgenda AND Mes = 'Abril'";
		$updMayo = "UPDATE clientepago SET Pago = '$mayo' WHERE IdAgenda = $idAgenda AND Mes = 'Mayo'";
		$updJunio = "UPDATE clientepago SET Pago = '$junio' WHERE IdAgenda = $idAgenda AND Mes = 'Junio'";
		$updJulio = "UPDATE clientepago SET Pago = '$julio' WHERE IdAgenda = $idAgenda AND Mes = 'Julio'";
		$updAgosto = "UPDATE clientepago SET Pago = '$agosto' WHERE IdAgenda = $idAgenda AND Mes = 'Agosto'";
		$updSeptiembre = "UPDATE clientepago SET Pago = '$septiembre' WHERE IdAgenda = $idAgenda AND Mes = 'Septiembre'";
		$updOctubre = "UPDATE clientepago SET Pago = '$octubre' WHERE IdAgenda = $idAgenda AND Mes = 'Octubre'";
		$updNoviembre = "UPDATE clientepago SET Pago = '$noviembre' WHERE IdAgenda = $idAgenda AND Mes = 'Noviembre'";
		$updDiciembre = "UPDATE clientepago SET Pago = '$diciembre' WHERE IdAgenda = $idAgenda AND Mes = 'Diciembre'";


		mysqli_query($con,$updEnero);
		mysqli_query($con,$updFebrero);
		mysqli_query($con,$updMarzo);
		mysqli_query($con,$updAbril);
		mysqli_query($con,$updMayo);
		mysqli_query($con,$updJunio);
		mysqli_query($con,$updJulio);
		mysqli_query($con,$updAgosto);
		mysqli_query($con,$updSeptiembre);
		mysqli_query($con,$updOctubre);
		mysqli_query($con,$updNoviembre);
		mysqli_query($con,$updDiciembre);


		header("Location:iniciocliente.php?id=$idCliente");
	}
		
	

 ?>
