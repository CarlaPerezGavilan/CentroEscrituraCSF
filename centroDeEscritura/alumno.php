<?php
session_start();
if(!isset($_SESSION['matricula'])){ //if login in session is not set
    header("Location: login.php");
}
	
$db = new mysqli('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
if (mysqli_connect_errno()) 
{
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$db->set_charset("utf8mb4");

if (isset($_GET['French'])){
	$_SESSION['idioma']="frances";
	header("Location: sesiones.php");
}
if (isset($_GET['Spanish'])){
	$_SESSION['idioma']="español";
	header("Location: sesiones.php");
}
if (isset($_GET['English'])){
	$_SESSION['idioma']="ingles";
	header("Location: sesiones.php");
}

?>
<html>
	<head>
		<title> Sistema de Registro para Tutorías del Centro de Escritura</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="icon" href="images/logo.png">

	</head>
	<style>
.btn-secondary.custom-btn {
	background-color: #02c0e6;
	border-color: #02c0e6;
}
</style>
	<body class="is-preload">
			<div id="wrapper">
					<header id="header">
						<div class="inner">
								<a href="alumno.php" class="logo">
									<span class="symbol"><img src="images/Tec.png" alt="" /></span><span class="symbol"><img src="images/CDE.png" alt="" />
								</a>
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>
						</div>
					
					</header>
					
					<nav id="menu">
						<h2>Menú</h2>
						<ul>
							<li><a href="index.html">Inicio</a></li>
							<li><a href="logout.php">Cerrar Sesión</a></li>
							<li><a href="citas.php">Mis Citas</a></li>
						</ul>
					</nav>
					<div id="main">
						<div class="inner">
							<header>
								<h1>Sistema de Registro para Tutorías</h1>
								<h2>Bienvenido Alumno: <?php echo $_SESSION['matricula'] ?> </h2>

								<p>
								¡Bienvenido al Centro de Escritura! Donde pordrás recibir asesorías 
								en cualquier tema que tenga que ver con redacción, ortografía, gramática 
								y sintáxis. Para continuar y agendar tu cita con uno de nuestros tutores, 
								selecciona el idioma:
								</p>
							</header>
						</p>
							<section method= "post" class="tiles">
								
								<article class="style2">
									<span class="image">
										<img src="images/Main_Back.png" alt="" />
									</span>
									<a href="?Spanish">
										<h2>Español</h2>
										<div class="content">
											<p>Agendar una sesión para tutoría</p>
										</div>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="images/Main_Back.png" alt="" />
									</span>
									<a href="?English">

										<h2>English</h2>
										<div class="content">
											<p>Schedule a tutoring session</p>
										</div>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="images/Main_Back.png" alt="" />
									</span>
									<a href="?French">
										<h2>François</h2>
										<div class="content">
											<p>Planifier une session de tutorat</p>
										</div>
									</a>
								</article>
							</section>
						</div>
					</div>
	
					<footer id="footer">
						<div class="inner">
						</div>
					</footer>

			</div>

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>




