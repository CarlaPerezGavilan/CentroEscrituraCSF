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
	
?>
<html>
	<style>
	.btn-secondary.custom-btn{
	background-color: #00aad1 ;
	border-color: #00aad1;
	}
	</style>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
		<title>MIS CITAS- Centro de Escritura</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="icon" href="images/logo.png">

	</head>
	<body class="is-preload">
			<div id="wrapper">
					<header id="header">
						<div class="inner">
								<a href="alumno.php" class="logo">
									<span class="symbol"><img src="images/Tec.png" alt="" /></span><span class="title">Centro de Escritura</span>
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
					<h1>MIS CITAS: </h1>

					<?php
					$matr = $_SESSION['matricula'];
					$query= "SELECT * FROM cita NATURAL JOIN  alumno_has_cita WHERE Matricula='$matr';";
					$result_citas = mysqli_query($db, $query);

					?>
						<div class="inner">
							
							<?php
							while ($row = mysqli_fetch_array($result_citas)) {
								
							?>	
							<?php
								$matr_tutor= $row['TutorMatricula'];
								$query= "SELECT Nombre, Apellidos FROM usuario WHERE Matricula='$matr_tutor';";
								$result_tutor = mysqli_query($db, $query);
								$row_tutor= mysqli_fetch_array($result_tutor)
							?>


							<div class="card" style="width: 18rem;">
							<ul class="list-group">
								<li class="list-group-item-primary"> <?php echo $row['HorarioCita'];?> <br>
								<?php echo $row['IdiomaCita']; ?> <br>
								<?php echo $row_tutor['Nombre']."   ".$row_tutor['Apellidos']; ?>
								</li>
							</ul>
							</div>

							
							
							<?php
							
							}
							?>

							</div>
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
			<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
	
	
	</body>
</html>



