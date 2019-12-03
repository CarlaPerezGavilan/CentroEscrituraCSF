<?php

session_start();

$_SESSION['name'] = $_POST['user'];


if(isset($_POST['submit']))
{
	
	//conectar con base de datos
	$mysqli = new mysqli('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
	if (mysqli_connect_errno()) 
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$mysqli->set_charset("utf8mb4");


	//obtener valores del login 
	$matricula = $_POST['user'];
	$password = $_POST['clave'];
	
	$SESION['idioma'] ="";

	//evitar injecciones de código 
	$matricula = mysqli_real_escape_string($mysqli, $matricula); 
	$password = mysqli_real_escape_string($mysqli, $password); 

	
	$result = $mysqli->prepare("select * from usuario where Matricula = ?");
	$result-> bind_param('s', $matricula);
	$result -> execute();
	$result = $result->get_result();
	$row = $result->fetch_assoc();
	

	
	if(password_verify($_POST['clave'], $row['Contrasena']) or $_POST['clave']==$row['Contrasena'])
	{
		$_SESSION['matricula']= $matricula;
		$result_tutor = $mysqli->query("select * from tutor where Matricula = '$matricula'");
		$result_admin = $mysqli->query("select * from administrador where Matricula = '$matricula'");
		
		if($result_tutor->num_rows !=0)
		{
			header("Location: tutor.php");
		}elseif($result_admin->num_rows !=0)
		{
			header("Location: admin.php");
		}else
		{
			header("Location: alumno.php");
		}
	}
	else
	{

		echo '<style type="text/css">
		.temp
		{
            display: flex;
        }
        </style>';
	}
}

else
{
	echo '<style>
	.temp{
	display:none;
	}
	</style>'; 
}

?>

<html>

<head>
	<title>Log-In</title>
	
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
	<link rel="icon" href="images/logo.png">
</head>


<body class="is-preload">
	<div id="wrapper">
		<header id="header">
			<div class="inner">
				<a href="login.php" class="logo">
					<span class="symbol">
						<img src="images/Tec.png" alt="" />
					</span>
					<span class="title">Centro de Escritura</span>
				</a>
			</div>
		</header>
		<div id="main">
			<div class="inner">
				<header>
					<h1>Ingresa al Sistema</h1>
				</header>
				<section>
		
					<form action ="login.php" method="POST">
						<label for="username">
						<b>Matrícula</b>
						</label>
						<input type="text" placeholder="Enter Username" name="user" id="user" required>
						<label for="password">
						<b>Contraseña</b>
						</label>
						<input type="password" placeholder="Enter Password" name="clave" id="clave" required>
						<input type="submit"  name="submit" class="btn">
					</form>
					<h7 class= "temp" style= 'color: red'> Contraseña  o usuario incorrecto </h7>
				</section>
					<button onclick= "window.location.href='register.php'">
					Sign Up
					</button>
			</div>
		</div>

	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
</body>
<footer id="footer">
	<div class="inner">
	</div>
</footer>
