<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = new mysqli('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
	if (mysqli_connect_errno()) 
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$db->set_charset("utf8mb4");

// REGISTER USER
if (isset($_POST['submit'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['user']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $last = mysqli_real_escape_string($db, $_POST['apellido']);
  
  $contrasena = mysqli_real_escape_string($db, $_POST['clave']);
  $contrasena2 = mysqli_real_escape_string($db, $_POST['clave2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Matricula requerida"); }
  if (empty($name)) { array_push($errors, "Nombre requerido"); }
  if (empty($last)) { array_push($errors, "Apellidos requeridos"); }
  if (empty($contrasena)) { array_push($errors, "Contrasena requerida"); }
  if ($contrasena != $contrasena2) {
	array_push($errors, "Las contrasenas no son iguales");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM usuario WHERE Matricula='$username'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Matricula'] === $username) {
      array_push($errors, "Username already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
	$materia = $_POST['name_subject'];
	$maestro = $_POST['names_maestros'];
	list($first, $lastN) = explode(' ', $maestro);
	$matr_maestro = "SELECT Matricula FROM maestro NATURAL JOIN usuario WHERE Nombre = '$first' AND Apellidos = '$lastN' ";
	$result_maestro = mysqli_query($db, $matr_maestro);
	$row_maestro = mysqli_fetch_array($result_maestro);
	$maestroMatr = $row_maestro['Matricula'];
	$group_code = "SELECT IdGrupo, CodigoMateria FROM grupo WHERE NombreMateria = '$materia' AND MaestroMatricula = '$maestroMatr' ";
	$group_result = mysqli_query($db, $group_code);
	$row_group = mysqli_fetch_array($group_result);
	
	
	$contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
  	$query = "INSERT INTO usuario (Matricula, Nombre, Apellidos, Contrasena) 
				VALUES('$username', '$name', '$last', '$contrasena')";
	
	$query_2= "INSERT INTO tutor (Matricula) 
	VALUES('$username')";
	
	if(mysqli_query($db, $query)){
		
	} else{
		array_push($errors,  "ERROR: Could not able to execute $query. " . mysqli_error($db));

	}
	if(mysqli_query($db, $query_2)){
		
	} else{
		array_push($errors,  "ERROR: Could not able to execute $query. " . mysqli_error($db));

	}
	$_SESSION['user'] = $username;
  	$_SESSION['success'] = "You are now registered in";
      echo '<style type="text/css">
      .temp
      {
          display: flex;
      }
      </style>';
    }else{
	print_r(array_values($errors));
  }
}
?>
<html>

<head>
	<title>Sign-Up</title>
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
				<a href="admin.php" class="logo">
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
					<h1>Registrar al tutor</h1>
				</header>
			<!-- form start  -->
			<form method="post">
							<label for="username">
							<b>Matrícula</b>
							</label>
							<input type="text" placeholder="Enter Username" name="user" id="user" required>
							<label for="password">

							<b>Contraseña</b>
							</label>
							<input type="password" placeholder="Enter Password" name="clave" id="clave" required>
							<label for="nombre">

							<b>Confirma tu Contraseña</b>
							</label>
							<input type="password" placeholder="Enter Password" name="clave2" id="clave2" required>
							<label for="nombre">

							<b>Nombre</b>
							</label>
							<input type="text" placeholder="Enter Name" name="name" id="name" required>
							<label for="nombre">

							<b>Apellido</b>
							</label>
							<input type="text" placeholder="Enter Last Name" name="apellido" id="apellido" required>
							<label for="apellido">

				<button onclick= "window.location.href='admin.php'">
					Back to Main
				</button>
					<tr>
						<td>
							<input type="submit" name="submit" value="Continue">
						</td>
					</tr>
			</form>
			
			</section>
			</div>
		</div>
		<footer id="footer">
			<div class="inner">
			</div>
		</footer>
	</div>
	<script>
		function next() {
			window.location = "index.html";
		}
	</script>
	<script src="assets/js/login.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>
