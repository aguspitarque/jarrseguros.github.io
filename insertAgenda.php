<?php include("Conexion/db.php") ?>

<?php
		if(isset($_GET['idc']))
			{

		$idCliente = $_GET['idc'];

		$queryRevision = "SELECT * FROM clienteagenda WHERE IdUsuario = $idCliente AND PoseeAgenda = 0";

		$resulRevision = mysqli_query($con,$queryRevision);

		$idAgenda = "";

		while ($row = mysqli_fetch_array($resulRevision)) 
			{
				$idAgenda = $row['Id'];
			}


		if(mysqli_num_rows($resulRevision) == 1)
		{

		$queryInsertAgenda = "UPDATE clienteagenda SET PoseeAgenda = 1 WHERE Id = $idAgenda";	
		
		$queryInsertEnero = "INSERT INTO clientepago(IdAgenda,Mes,Pago) VALUES ($idAgenda,'Enero',0)";
		$queryInsertFeb = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Febrero',0)";
		$queryInsertMarzo = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Marzo',0)";
		$queryInsertAbril = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Abril',0)";
		$queryInsertMayo = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Mayo',0)";
		$queryInsertJunio = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Junio',0)";
		$queryInsertJulio = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Julio',0)";
		$queryInsertAgo = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Agosto',0)";
	$queryInsertSep = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Septiembre',0)";
	$queryInsertOctubre = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Octubre',0)";
	$queryInsertNov = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Noviembre',0)";
	$queryInsertDic = " INSERT INTO clientepago(IdAgenda,Mes,Pago) values ($idAgenda,'Diciembre',0)";

		mysqli_query($con, $queryInsertAgenda);
		mysqli_query($con,$queryInsertEnero);
		mysqli_query($con,$queryInsertFeb);
		mysqli_query($con,$queryInsertMarzo);
		mysqli_query($con,$queryInsertAbril);
		mysqli_query($con,$queryInsertMayo);
		mysqli_query($con,$queryInsertJunio);
		mysqli_query($con,$queryInsertJulio);
		mysqli_query($con,$queryInsertAgo);
		mysqli_query($con,$queryInsertSep);
		mysqli_query($con,$queryInsertOctubre);
		mysqli_query($con,$queryInsertNov);
		mysqli_query($con,$queryInsertDic);
		}
		else
		{
			echo "Ya posee Agenda";
		}

		header("Location:iniciocliente.php?id=$idCliente");
			}



?>