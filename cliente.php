<?php include("Conexion/db.php") ?>

<?php include("includes/header.php") ?>

	<section class="section-cliente">
		<div class="row">
			<div class="col-md-3">
				<!-- <a href="index.php">
					<button class="btn btn-dark btn-volver-cliente">
						<span class="span-volver-cliente">Volver <i class="fa fa-arrow-circle-left"></i></span>
					</button>
				</a> -->
			</div>
			<div class="col-md-6">	
				<form class="form-cliente" action="cliente.php" method="POST">	
					<h3 class="title-cliente">Inicia Session</h3>
					<input type="text" name="usuario" class="form-control item-form-cliente" placeholder="Documento">
					<input type="password" name="pass" class="form-control item-form-cliente" placeholder="Password">
					<input type="submit" name="ingresar" class="btn btn-dark btn-block" value="Ingresar">
					<?php  include("ingresar.php") ?>					
				</form>
			</div>
			<div class="col-md-3">
				
			</div>	
		</div>
	</section>

<?php include("includes/footer.php") ?>