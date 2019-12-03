<?php
            error_reporting(0);

			ini_set('display_errors', 1);  //DEBUG

			$enlace = mysqli_connect("127.0.0.1", "root", "Car123()", "CentroEscruitura");
			if($enlace)
				// echo "Conexión exitosa.<br>";
				;
			else
				die("Conexión no exitosa.<br>");

			$enlace->set_charset("utf8mb4");
	session_start();
	if(!isset($_SESSION['matricula'])){ //if login in session is not set
		header("Location: login.php");
	}

	if(isset($_POST['submit']) and isset($_POST['cita'])){
		foreach($_POST['cita'] as $cita){

		$query_cupo = mysqli_query($enlace, "select cupo from cita where Folio = '$cita';");
		$cupo_var = mysqli_fetch_array($query_cupo);
		$cupo_var[0] = $cupo_var[0] - 1;
		$update = mysqli_query($enlace, "update cita set Cupo = '$cupo_var[0]' WHERE Folio = '$cita';");
		$matr = $_SESSION['matricula'];
		$query_insertar = "INSERT INTO alumno_has_cita (Asistencia, Matricula, Folio) VALUES ('0', '$matr', '$cita');";
		$insertar = mysqli_query($enlace, $query_insertar);
	}
	header("Location: confirmar.php?folio=$cita");
	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Tutorías en <?php echo $_SESSION['idioma']; ?> - Centro de Escritura</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/main.css" />
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
								<li><a href="alumno.php">Inicio</a></li>
								<li><a href="logout.php">Cerrar Sesión</a></li>
						</ul>
					</nav>
					<div id="main">
						<div class="inner">
							<header>
								<?php
									if ($_SESSION['idioma']=="ingles") {
										?>
									<h1>English Tutoring Sessions</h1>
									<?php
									}
									elseif ($_SESSION['idioma']=="español") {
										?>
									<h1>Sesiones de Tutoría en Español</h1>
									<?php
									}
									elseif ($_SESSION['idioma']=="frances") {
										?>
									<h1>Sessions de Tutorat en Français</h1>
									<?php
									}
									?>

							</header>
							
							  	<!-- fetch sessions -->
				<?php
				$idioma = $_SESSION['idioma'];
				$query = "SELECT * FROM cita HAVING IdiomaCita LIKE '$idioma';";
				$result_maestro = mysqli_query($enlace, $query);

				
				?>
					<div class="btn-group-toggle" data-toggle="buttons">
					<form method="post">
					<?php
					while ($row = mysqli_fetch_array($result_maestro)) {
						if($row['Cupo']>0){
						$matr_tutor= $row['TutorMatricula'];
						$query_tutor = "SELECT Nombre, Apellidos FROM usuario WHERE Matricula = '$matr_tutor';";
						$result_tutor = mysqli_query($enlace, $query_tutor);
						$row_tutor= mysqli_fetch_array($result_tutor)
					?>
 							<label class="btn btn-secondary custom-btn">

    						<input type="checkbox" name= "cita[]" value= " <?php echo $row['Folio']; ?> "> 

							<?php echo $row['HorarioCita']. " ".$row_tutor['Nombre']. " ". $row_tutor['Apellidos'];?> 
  							</label>
							  
						
					<?php
					}
					}
					?>
					</div>
							
							
						</div>
							<input type="submit" name='submit'>

						</form>
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

				
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
