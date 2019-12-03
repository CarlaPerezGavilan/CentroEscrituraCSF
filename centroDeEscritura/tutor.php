<?php
	session_start();
	if(!isset($_SESSION['matricula'])){ //if login in session is not set
		header("Location: login.php");
	}
//conectar con base de datos
	$mysqli = new mysqli('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
	if (mysqli_connect_errno()) 
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$mysqli->set_charset("utf8mb4");

	$matricula_tutor =$_SESSION['matricula'];
	$query = "SELECT * FROM alumno_has_cita NATURAL JOIN cita WHERE TutorMatricula= '$matricula_tutor';";
	$result = mysqli_query($mysqli, $query);
	$counter = 0;
	$thing = "thing";
	$folio =0;
	
	if(isset($_POST["asistencia"]) and isset($_POST['check'])){
		foreach($_POST['check'] as $check){
			$arr = str_split($check, 9);
 			$query_asistencia = "UPDATE alumno_has_cita SET Asistencia = '1' WHERE  Folio='$arr[1]' AND Matricula = '$arr[0]' ;";								
			$result_asistencia = mysqli_query($mysqli, $query_asistencia);
		}
		header("Location: tutor.php");
}

?>

<html>

<head>
	<title>Sistema de Tutorías del Centro de Escritura</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
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
				<a href="index.html" class="logo">
					<span class="symbol">
						<img src="images/Tec.png" alt="" />
					</span>
					<span class="title">Centro de Escritura</span>
				</a>
				<nav>
					<ul>
						<li>
							<a href="#menu">Menu</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<nav id="menu">
			<h2>Menú</h2>
			<ul>
				<li>
					<a href="login.php">Inicio</a>
				</li>
				<li>
					<a href="logout.php">Cerrar Sesión</a>
				</li>
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<header>
					<h1>Agenda Mensual</h1>
				</header>
				<section>
				<form method="post">

				<div class="btn-group-toggle" data-toggle="buttons">
				
					<?php
							while ($row = mysqli_fetch_array($result)) {
						$matr_alumno= $row['Matricula'];
						$query_alumno = "SELECT Nombre, Apellidos FROM usuario WHERE Matricula= '$matr_alumno';";
						$result_alumno= mysqli_query($mysqli, $query_alumno);
						$nombres_alumno = mysqli_fetch_array($result_alumno);
					?>
					<div class="card text-white bg-<?php 
						if($row['Asistencia']== 0){
						echo "dark";
						}else{
							echo "success";
						}
					?> mb-3" style="max-width: 18rem;">
  					<div class="card-header"><?php echo $row['Matricula']. "  ".$nombres_alumno['Nombre']." ".$nombres_alumno['Apellidos'];?></div>
  					<div class="card-body">
   					 <h5 class="card-title"><?php $row['Matricula']?> </h5>
   					 <p class="card-text"><?php echo $row['HorarioCita']?> <br> <?php echo $row['IdiomaCita']?> </p>
						<?php
					if($row['Asistencia']== 0){
					?>
						<label class="btn btn-secondary custom-btn">
					
					 
					<input type="checkbox" name= "check[]" value= "<?php echo $row['Matricula'].$row['Folio'];?>"> 
					Asistió
					</label>	
					<?php
					}
					?>
					  </div>
					</div>
					
					<?php
				
					}
					?>
					</div>
				<input type = "submit" name= "asistencia" value= "Tomar Asistencia"/>
				</form>
				
						
						
					
								
				
				</section>
			</div>
		</div>

		<div id="light" class="white_content">
			
			<h1>
				Asistencia
			</h1>
			<div class=checkboxstyle>
			
				<button onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Guardar</button>
			</div>
		</div>
		

		<footer id="footer">
			<div class="inner">
			</div>
		</footer>
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
