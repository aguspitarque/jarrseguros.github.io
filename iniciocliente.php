<?php include("Conexion/db.php") ?>

<?php include("includes/header.php") ?>

<?php 

	if (isset($_GET['id'])) {
		
		$IdCliente = $_GET['id'];

		$query = "SELECT * FROM usuario WHERE Id = $IdCliente";

		$result = mysqli_query($con,$query);


		while ($row = mysqli_fetch_array($result)) {
			
			$nombreCliente = $row['Nombre'];
			$docCliente = $row['Documento'];
		}

		$queryAgenda = "SELECT * FROM clienteagenda WHERE IdUsuario = $IdCliente";

		$resultAgenda = mysqli_query($con,$queryAgenda);


		while ($row = mysqli_fetch_array($resultAgenda)) {
			
			$poseeAgenda = $row['PoseeAgenda'];
		}


		$classAgendabtn1 = "";
		$classAgendabtn2 = "";

		if($poseeAgenda == "1")
		{
			$classAgendabtn1 = "agenda-hide";
			$classAgendabtn2 = "agenda-appear";
		}
		else
		{
			$classAgendabtn1 = "agenda-appear";
			$classAgendabtn2 = "agenda-hide";
		}
	}

 ?>

	<div class="fondo-inicio-cliente">
		<div class="container">
			<div class="row header-inicio-cliente">
				<div class="col-md-8">
					<h3 class="title-inicio-cliente">Hola <?php echo $nombreCliente;?>
					</h3>
					<div class="row">
						<a href="insertAgenda.php?idc=<?php echo $IdCliente;?>" 
							class="btn btn-dark buton-crear-agenda <?php echo $classAgendabtn1?>">
							Crear Agenda
						</a>
					</div>
					<div class="row">
						<button class="btn btn-dark <?php echo $classAgendabtn2?>"
							data-toggle="modal" data-target="#ventanaModAgenda">
							Modificar Agenda
						</button>

						<div class="modal fade" id="ventanaModAgenda" data-backdrop="static" tabindex="-1" role="dialog" 
							 aria-labelledby="staticBackdropLabel" aria-hidden="true">
						  	<div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="staticBackdropLabel">Modificar Agenda</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      	<div class="modal-body">
								        <form method="POST" action="modifAgenda.php">
								        	<div class="form-group">
								        		<input class="form-control" type="text" name="idCliente" 
								        		value="<?php echo $IdCliente?>" readonly>
								        		<br>
								       			<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="enero">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Enero">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="febrero">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Febrero">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="marzo">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Marzo">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="abril">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Abril">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="mayo">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Mayo">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="junio">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Junio">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="julio">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Julio">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="agosto">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Agosto">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="septiembre">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Septiembre">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="octubre">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Octubre">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="noviembre">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Noviembre">
												</div>
												<div class="input-group mb-3">
												  <div class="input-group-prepend">
												    <div class="input-group-text">
												      <input type="checkbox" name="diciembre">
												    </div>
												  </div>
												  <input type="text" class="form-control" readonly value="Diciembre">
												</div>
								        		<br>
										        <button type="submit" name="guardarAgenda" class="btn btn-dark btn-block">
										        Guardar
										    	</button>
									    	</div>
								    	</form>
						    		</div>
							    </div>
						  	</div>
						</div>

						<?php include("modifAgenda.php") ?>

					</div>
					<?php include("insertAgenda.php") ?>
				</div>
				<div class="col-md-4">
					<div class="recordatorio-head">
						<h4 class="title-rec-head">Recordatorio de pagos</h4>
						<span class="fa-4x span-rec-head"><i class="fa fa-money-check-alt"></i></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 box-archivos">
					<div class="row">
						<div class="col-md-4">
							<div class="obj-archivo">
								<a href="">
									<span class="fa-stack fa-4x">
							            <i class="fas fa-circle fa-stack-2x obj-archivo-circle"></i>
							            <i class="fas fa-file-pdf fa-stack-1x fa-inverse"></i>
						          	</span>
					          	</a>
				          	</div>
			          	</div>
			          	<div class="col-md-8 obj-archivo-title">
			          		<span><i class="fa fa-arrow-left"></i></span>
			          		<h4>Descargar Poliza de Seguros</h4>
			          	</div>
		          	</div>
		          	<div class="row">
		          		<div class="col-md-4">
							<div class="obj-archivo">
								<a href="">
									<span class="fa-stack fa-4x">
							            <i class="fas fa-circle fa-stack-2x obj-archivo-circle"></i> 
							            <i class="fas fa-file-pdf fa-stack-1x fa-inverse"></i>
						          	</span>
					          	</a>
							</div>
						</div>
						<div class="col-md-8 obj-archivo-title">
							<span><i class="fa fa-arrow-left"></i></span>
							<h4>Descarga tu Archivo</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="obj-archivo">
								<a href="">
									<span class="fa-stack fa-4x">
							            <i class="fas fa-circle fa-stack-2x obj-archivo-circle"></i>
							            <i class="fas fa-file-pdf fa-stack-1x fa-inverse"></i>
						          	</span>
					          	</a>
							</div>
						</div>
						<div class="col-md-8 obj-archivo-title">
							<span><i class="fa fa-arrow-left"></i></span>
							<h4>Descarga tu Archivo</h4>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="recordatorio-body">
						<table class="tabla-agenda">
							<thead>
								<tr>
									<th class="item-table-head-mes">Mes</th>
									<th class="item-table-head-pago">Pago</th>
								</tr>
							</thead>
							<tbody>
							<?php 

								$queryRevision2 = "SELECT * FROM clienteagenda WHERE IdUsuario = $IdCliente AND PoseeAgenda = 1";

								$resulRevision2 = mysqli_query($con,$queryRevision2);

								$idAgenda = "";

								while ($row = mysqli_fetch_array($resulRevision2)) 
									{
										$idAgenda = $row['Id'];
									}

								if(mysqli_num_rows($resulRevision2) == 1){

								$query = "SELECT * from clientepago WHERE IdAgenda = $idAgenda";
								$result_tareas = mysqli_query($con, $query);

									$pago = "";

								while ($row = mysqli_fetch_array($result_tareas)) { 

										if($row['Pago'] == "on")
										{
											$pago = "SI";
										}
										else
										{
											$pago = "NO";
										}			
									?>
									<tr>
										<td class="item-table-body-mes"><?php echo $row['Mes'] ?></td>
										<td class="item-table-body-pago item-check-<?php echo $pago?>" id="pago-check"><?php echo $pago?></td>
									</tr>									

						 	<?php } }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--  <script type="text/javascript">

	function colorPago(rta)
	{
	 var img = document.getElementById("pago-check");

	 if (rta == "SI") 
	 {
	 	img.classList.remove("item-check-no");
	 	img.classList.add("item-check-ok");
	 }
	 else
	 {
	 	img.classList.remove("item-check-ok");
	 	img.classList.add("item-check-no");
	 }

	}

</script>	 -->

<?php include("includes/footer.php") ?>