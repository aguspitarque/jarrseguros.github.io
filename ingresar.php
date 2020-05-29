  	<?php 

  		include("Conexion/db.php");

		if (isset($_POST['ingresar'])) {
			
			$user = $_POST['usuario'];
			$pass = $_POST['pass'];


			$validarUser = "SELECT * FROM usuario WHERE Documento = $user ";

			$resultUser = mysqli_query($con,$validarUser);

			if (mysqli_num_rows($resultUser) == 1) {

				 $password = "";

					while($row = mysqli_fetch_array($resultUser)){
				
						$password =  $row['Password'];
						$idCliente = $row['Id'];
					}

				if ($password != "") {
				$validarPass = "SELECT * FROM usuario WHERE Documento = $user AND Password = '$pass'";

				$resultPass = mysqli_query($con, $validarPass);

				if(mysqli_num_rows($resultPass) == 1){

					header("Location:iniciocliente.php?id=$idCliente");



				}else{
					?>
					<div class="container">
						<br>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							Password incorrecta.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
					</div>
				<?php
				}
				}
				else{
					?>
					<div class="container">	
						<br>
					 <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#ventana">
					 	Crear password
					 </button>
					 <div class="modal fade" id="ventana" data-backdrop="static" tabindex="-1" role="dialog" 
					 aria-labelledby="staticBackdropLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="staticBackdropLabel">Crear Password</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      	<div class="modal-body">
						        <form method="POST" action="cliente.php">
						        	<div class="form-group">
						        		<input type="text" name="documento" value="<?php echo $_POST['usuario'];?>"
						        		class="form-control" readonly>
						        		<br>
							        	<input type="text" name="pass" placeholder="Password" class="form-control">
							        	<br>
							        	<input type="text" name="repitePass" placeholder="Repite Password" 
							        	class="form-control">
						        		<br>
								        <button type="submit" name="guardaPass" class="btn btn-dark btn-block">
								        Guardar
								    	</button>
							    	</div>
						    	</form>
				    		</div>
					    </div>
					  </div>
					</div>
					 </div>
				<?php	
				}
			}
				
			else{
				?>
					<div class="container">
						<br>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							No es un cliente existente.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
					</div>
				<?php
			}
		}


		if(isset($_POST['guardaPass'])){

			$pass = $_POST['pass'];
			$repitePass = $_POST['repitePass'];
			$docu = $_POST['documento'];

			if ($pass == $repitePass) {
				
			$query = "UPDATE usuario SET Password = '$pass' WHERE Documento = $docu";

			mysqli_query($con, $query);

			$query2 = "INSERT INTO clienteagenda (IdUsuario,PoseeAgenda) 
						VALUES ((SELECT Id FROM usuario WHERE Documento = $docu),0)";

			mysqli_query($con,$query2);

				?>
					<div class="container">
						<br>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							Se guardo correctamente la password.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
					</div>
				<?php
			}
			else{
				?>
					<div class="container">
						<br>
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							Asegurese de que las password sean iguales.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
					</div>
				<?php
			}


		}

	 ?>