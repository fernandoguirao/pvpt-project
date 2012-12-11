<!DOCTYPE html>
<!--[if lt IE 7]>	<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>	<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>	<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" lang="es"> <!--<![endif]-->

		<!-- 0. HEAD -->
		
		<head> 

			<!-- 0.1. METAS -->

			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<title></title>
			<meta name="description" content="">
			<meta name="viewport" content="width=device-width">

			<!-- 0.2. ICONOS PARA SMARTPHONE -->

			<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/smarticons/apple-touch-icon-144x144-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/smarticons/apple-touch-icon-114x114-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/smarticons/apple-touch-icon-72x72-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/smarticons/apple-touch-icon-57x57-precomposed.png">
			<link rel="apple-touch-icon-precomposed" href="img/smarticons/apple-touch-icon-precomposed.png">

			<!-- 0.3. ESTILOS -->
			
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<style>
					body {
							padding-top: 60px;
							/* padding-bottom: 40px; */
					}
			</style>
			<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
			<link rel="stylesheet" href="css/main.css">
			<!--[if IE]>
				<link rel="stylesheet" type="text/css" href="css/ie.css" />
			<![endif]-->
			<!--[if lt IE 9]>
				<link rel="stylesheet" type="text/css" href="css/ie8.css" />
			<![endif]-->
			<!--[if lt IE 8]>
				<link rel="stylesheet" type="text/css" href="css/ie7.css" />
			<![endif]-->
			<link rel="stylesheet" href="css/main-responsive.css">

			<!-- PRIMEROS SCRIPTS -->
			<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

			<script src="js/vendor/bootstrap.min.js"></script>
			<script src="js/vendor/queryloader2.js" type="text/javascript"></script>

		</head>

		<body>

				<!--[if lt IE 7]>
						<p class="chromeframe">Estás utilizando un navegador <strong>muy anticuado</strong>. Por favor <a href="http://browsehappy.com/">actualiza tu navegador</a> o si te resulta muy incómodo <a href="http://www.google.com/chromeframe/?redirect=true">activa esta aplicación de Google</a> para que tu navegador sea más seguro.</p>
				<![endif]-->


<!-- <div class="pixelperfect" style="opacity:0.4;position:absolute;top:0px;"><img src="fondo.png" alt=""></div> -->

				<!-- 1. HEADER -->

				<header class="jumbotron subhead" id="overview">

					<!-- 1.1. BARRA DE NAVEGACIÓN SUPERIOR. -->
					<div class="superior">
						<div class="navbar navbar-inverse navbar-fixed-top">
								 <div class="navbar-inner">
										 <div class="container">
												 <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
														 <span class="icon-bar"></span>
														 <span class="icon-bar"></span>
														 <span class="icon-bar"></span>
												 </a>
												 <a class="brand" href="#">Acceso alumno</a>
												 <div class="nav-collapse collapse">
														 <ul class="nav">
																 <li class="dropdown"><a href="programa.php" class="liprograma">Programa</a></li>
																 <li class="dropdown"><a href="material.php" class="limaterial">Material</a></li>
																 <li><a href="valoracion.php" class="livaloracion">Valoración</a></li>
																 <li><a href="contacto-profesor.php" class="licontactoconelprofesor">Contacto con el profesor</a></li>
																 <li><a href="mi-calendario.php" class="limicalendario">Mi calendario</a></li>
														 </ul>
	
														 <a class="btn btn-inverse pull-right nav-cerrar hidden-phone hidden-tablet" href="#">
														 	<i class="icon-off icon-white"></i> Cerrar sesión
														 </a>
	<!--
														 <form class="navbar-form pull-right">
																 <input class="span2" type="text" placeholder="Email">
																 <input class="span2" type="password" placeholder="Contraseña">
																 <button type="submit" class="btn">Sign in</button>
														 </form>
	-->
												 </div><!--/.nav-collapse -->
										 </div>
								 </div>
						 </div>
					 </div><!-- / FIN BARRA DE NAVEGACIÓN SUPERIOR -->

					<!-- 1.2. CONTENIDO CABECERA-->

					<div class="container">

						<!-- 1.2.1. BARRA DE MENÚ -->
						
						<div class="menu-sup">
							<div class="navbar">
								<div class="navbar-inner">
									<a class="brand" href="index.php"><img src="img/sprites/logo-header.png" alt="Pivot Point"></a>
									<ul class="nav pull-right">
										<!-- class="active" -->
										<li class="liquienessomos"><a href="quienes-somos.php">Quiénes somos</a></li>
										<li class="licursos"><a href="cursos.php">Cursos</a></li>
										<li class="licalendario"><a href="calendario.php">Calendario</a></li>
										<li class="linoticias"><a href="noticias.php">Noticias</a></li>
										<li class="liformadores"><a href="formadores.php">Formadores</a></li>
										<li class="libolsadetrabajo"><a href="bolsa-de-trabajo.php">Bolsa de trabajo</a></li>
									</ul>
								</div>
							</div>
						</div> <!-- / FIN DE BARRA DE MENÚ -->

					</div> <!-- / FIN DE CONTENIDO CABECERA -->
					
					<!-- MENÚ SCROLL -->
					
					<div class="menuscroll visible-desktop">
						<div class="container">
							<div class="menu-sup">
								<div class="navbar">
									<div class="navbar-inner">
										<a class="brand" href="index.php"><img src="img/sprites/logo-header.png" alt="Pivot Point"></a>
										<ul class="nav pull-right">
											<!-- class="active" -->
											<li><a href="quienes-somos.php">Quiénes somos</a></li>
											<li><a href="cursos.php">Cursos</a></li>
											<li><a href="calendario.php">Calendario</a></li>
											<li><a href="noticias.php">Noticias</a></li>
											<li><a href="formadores.php">Formadores</a></li>
											<li><a href="bolsa-de-trabajo.php">Bolsa de trabajo</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- FIN MENÚ SCROLL -->

				</header> <!-- / FIN DE CABECERA -->