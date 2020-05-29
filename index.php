<?php include("Conexion/db.php") ?>

<?php include("includes/header.php") ?>


<?php 

  if (isset($_POST['guardar'])) {   
      if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { 
     
     
        // creamos las variables para subir a la db
          $ruta = "upload/"; 
          $nombrefinal= trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
          //$nombrefinal= ereg_replace (" ", "", $nombrefinal);//Sustituye una expresión regular
          $upload= $ruta . $nombrefinal;  



          if(move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion 
        
                     $nombre  = $_POST["nombre"]; 
                     $email = $_POST['email'];
                     $tel = $_POST['telefono'];
                     $docu = $_POST['documento'];
                     $ano = $_POST['ano'];
                     $mym = $_POST['modelo'];
                     $cp = $_POST['cp'];


                     $query = "INSERT INTO archivo (Nombre,Ruta,Tipo,Size,Email,Telefono,Documento,MarcaYModelo,Ano,CodigoPostal) 
                  VALUES ('$nombre','".$nombrefinal."','".$_FILES['fichero']['type']."','".$_FILES['fichero']['size']."','$email','$tel',$docu,'$mym','$ano','$cp')"; 
                      


                mysqli_query($con,$query) or die(mysql_error()); 
                      
                        // echo "<b>Upload exitoso!. Datos:</b><br>";  
                        // echo "Nombre: <i><a href=\"".$ruta . $nombrefinal."\">".$_FILES['fichero']['name']."</a></i><br>";
                        // echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";  
                        // echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";  
                        // echo "<br><hr><br>";  

                        $_SESSION['message'] = 'El Archivo ' . $_FILES['fichero']['name'] . ' se cargo de forma correcta.';
                        $_SESSION['message_type'] = 'success';
              
          }  
      }  
  } 

 ?>

	<section class="first-section">
			<div class="container">	
				<div class="row">
					<div class="col-md-6 col-sm-12">	

					</div>
					<div class="col-md-6 col-sm-12">	
						<h2 class="title fa fa-shield-alt">JAAR</h2>
						<span class="pieTitulo">Asesores de seguros</span>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					</div>
					<div class="col-md-6">
						<nav class="nav">
							<ul class="nav justify-content-end listaNav">
							  <li class="nav-item">
							    <a class="nav-link btn btn-dark" href="#" type="button" data-toggle="modal" 
							    data-target=".bd-example-modal-lg">Cotiza Tu Seguro</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link btn btn-dark" href="conocenos.php">Conocenos</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link btn btn-dark" href="cliente.php">Soy Cliente</a>
							  </li>
							</ul>
						</nav>
						<br>
						 <?php if(isset($_SESSION['message'])){ ?>
		                    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
		                      <?= $_SESSION['message'] ?> 
		                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                        <span aria-hidden="true">&times;</span>
		                      </button>
		                    </div>
                  		<?php session_unset(); } ?>
					</div>
				</div>
			</div>

				<!-- MODAL -->
			<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Envianos tus datos y te cotizamos de inmediato</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
			        	<input type="text" name="nombre" placeholder="Nombre" class="form-control" required="required">
			        	<br>
			        	<input type="text" name="documento" placeholder="Documento" class="form-control" required="required">
			        	<br>
			        	<input type="email" name="email" placeholder="Email" class="form-control" required="required">
			        	<br>
			        	<input type="text" name="telefono" placeholder="Telefono" class="form-control" required="required">
			        	<br>
			        	<input type="text" name="modelo" placeholder="Marca Y Modelo del vehiculo" class="form-control" required="required">
			        	<br>
			        	<input type="text" name="ano" placeholder="Ano del vehiculo" class="form-control" required="required">
			        	<br>
			        	<input type="text" name="cp" placeholder="Codigo Postal" class="form-control" required="required">
			        	<br>
			        	<label>Seleccione un archivo pdf con las fotos del vehiculo:
			        	Los dos costados, foto trasera, foto delantera y de el desgaste de los neumaticos.
			        	Muy importante las ventanillas cerradas.</label>
			        	<input type="file" name="fichero" class="form-control" style="border-style: none;">
			        	<br>
			        	<div class="modal-footer">
			        		<button type="submit" class="btn btn-block btn-dark" name="guardar">Enviar</button>
			      		</div>
			        </form>
			      </div>
			      

			    </div>
			  </div>
			</div>
			<!-- FIN MODAL -->

	</section>
<?php include("includes/footer.php") ?>	