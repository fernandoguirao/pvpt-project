*Para crear páginas nuevas basadas en la plantilla con una imagen y un titular en la cabecera:

<?php include ('header.php'); ?>

				<div id="cuerpo" class="quienes-somos">
				<div class="container">
					<div class="captionimg">
						<h2>
							Este es el titular.
						</h2>
						<div class="masinfo">
							<a href="">Esto es un botón</a>
						</div>
					</div>
					</div> 
					<img src="img/contenidos/diapositiva.png" alt="" width="100%" />
					
					<div id="contenido" class="container">
					</div>
				</div>

<?php include ('footer.php'); ?>

*Para crear páginas nuevas sin imagen en la cabecera:

<?php include ('header.php'); ?>

				<div id="cuerpo" class="quienes-somos">					
					<div id="contenido" class="container">
					</div>
				</div>

<?php include ('footer.php'); ?>

*Para crear thumbs tipo pinterest:

							<ul class="thumbnails">

								<li class="span3">
									<a href="" class="thumbnail th1">
										<div class="mascara">
											<img src="imagen del thumb" width="100%" alt="">
										</div>
										<div class="texto-th">
											<h2>Titular</h2>
											<p>Texto. </p>
										</div>
									</a>
								</li>

							</ul>
							
//Nota: todos los de una misma columna deben incluirse dentro del 'li' de esa columna (dentro de sucesivas etiquetas 'a').

*Si queremos una imagen con el título de la página previa al contenido

					<div class="mini-header imgbarra">
						<div class="container">
							<div class="captionimg">
								<h2>
									Bolsa de trabajo
								</h2>
							</div>
						</div> 
						<div class="imagen-main">
						</div>
					</div>
