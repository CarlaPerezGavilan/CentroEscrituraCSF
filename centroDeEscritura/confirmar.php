<?php
session_start();


			error_reporting(E_ALL); //DEBUG
			ini_set('display_errors', 1);  //DEBUG

			$enlace = mysqli_connect("127.0.0.1", "root", "Car123()", "CentroEscruitura");
			if($enlace)
				// echo "Conexión exitosa.<br>";
				;
			else
				die("Conexión no exitosa.<br>");

			$enlace->set_charset("utf8mb4");
			if(!isset($_SESSION['matricula'])){ //if login in session is not set
				header("Location: login.php");
			}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tutorías - Centro de Escritura</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <script type="text/javascript">
    function close_window() {
      if (confirm("¿Seguro que quieres salir de esta ventana?")) {
        close();
            }
      }
    </script>
		<link rel="icon" href="images/logo.png">

	</head>

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
								<li><a href="alumno.php">Inicio</a></li>
								<li><a href="logout.php">Cerrar Sesión</a></li>
						</ul>
					</nav>
					<div id="main">
						<div class="inner">
							<header>
									<h1>Confimación de cita para tutoría</h1>
							</header>
							<form>
							  <div align="center">
                  <?php
                  $folio_cita = $_GET['folio'];
                  $resultado_query = mysqli_query($enlace, "select cupo, Nombre, Apellidos, DATE(HorarioCita), TIME(HorarioCita), IdiomaCita from cita inner join usuario on (TutorMatricula=Matricula) where folio = '".$folio_cita."';");
                  $row = mysqli_fetch_array($resultado_query, MYSQLI_NUM);
                  echo "Has agendado sesión con $row[1] $row[2] el día $row[3] a las $row[4]hrs. en $row[5]"
                  ?>
                  <br> <br>
                  <a href="alumno.php">Volver a Inicio</a>
							</form>
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


