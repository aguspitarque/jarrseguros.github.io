<?php include("Conexion/db.php") ?>

<?php include("includes/header.php") ?>
		
	
	<div class="container">
		<div class="row">
			<form class="form">
				<div class="form-group">
					<input class="form-control" type="text" name="" placeholder="Nombre">
					<input class="form-control" type="text" name="" placeholder="Marca">
					<input class="form-control" type="text" name="" placeholder="Modelo">
				</div>
				<div class="form-group">
					<input type="submit" name="enviar" value="Enviar" class="btn btn-secondary">
				</div>		
			</form>	
		</div>
	</div>

	<section class="cotizaSection">
		<!-- <h2 class="titleCotiza fa fa-shield-alt">JAAR Asesores de Seguros</h2> -->
	</section>

<?php include("includes/footer.php") ?>