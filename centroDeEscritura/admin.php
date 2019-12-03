<?php
session_start();
if(!isset($_SESSION['matricula'])){ //if login in session is not set
	header("Location: login.php");
}else{
	
}
		error_reporting(E_ALL); //DEBUG
		ini_set('display_errors', 1);  //DEBUG

		$enlace = mysqli_connect('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
		if($enlace)
			$message=  "Conexión exitosa.<br>";
		else
			die("Conexión no exitosa.<br>");

		$enlace->set_charset("utf8mb4");

		//NO TOCAR
		if(isset($_POST['buscar'])){
			$folio_buscar= $_POST['folio_buscar'];
			$arr = str_split($folio_buscar, 9);
			$resultado_query = mysqli_query($enlace, "SELECT  Folio, TutorMatricula as tutor, AdministradorMatricula as admin, HorarioCita as Fecha, IdiomaCita as Idioma, Asistencia, Matricula as Alumno from cita natural join alumno_has_cita where Folio = '$arr[1]' and Matricula = '$arr[0]' ");
		
		}else{

		
		$resultado_query = mysqli_query($enlace, "SELECT distinct cita.Folio, cita.TutorMatricula as tutor, cita.AdministradorMatricula as admin, cita.HorarioCita as Fecha, cita.IdiomaCita as Idioma, alumno_has_cita.Asistencia, alumno_has_cita.Matricula as Alumno
		from 
		cita inner join alumno_has_cita where(cita.Folio = alumno_has_cita.Folio)
		order by cita.Folio;");
		}

		if(isset($_POST['eliminar_busqueda'])){
			$resultado_query = mysqli_query($enlace, "SELECT distinct cita.Folio, cita.TutorMatricula as tutor, cita.AdministradorMatricula as admin, cita.HorarioCita as Fecha, cita.IdiomaCita as Idioma, alumno_has_cita.Asistencia, alumno_has_cita.Matricula as Alumno
		from 
		cita inner join alumno_has_cita where(cita.Folio = alumno_has_cita.Folio)
		order by cita.Folio;");
		}

?>		
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">

</head>

<body class="is-preload">




  <div id="wrapper">
    <header id="header">
      <div class="inner">
        <a href="al" class="logo">
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
        <li><a href="logout.php">Cerrar Sesión</a></li>
        <li><a href="admin.php">Inicio</a></li>
      </ul>
    </nav>
    <div id="main">
      <div class="inner">
        <h1>Agenda Mensual</h1>
		<!-- <input type="text" name = "buscar" id="buscar" onkeyup="myFunction()" placeholder="Folio de la cita.."> -->
		<style>
		.btn-secondary.custom-btn {
	background-color: #02c0e6;
	border-color: #02c0e6;
}</style>
<form method="post">
		<table border="1">
		<tr>
			<td>FOLIO</td>
			<td>TUTOR</td>
			<td>ADMINISTRADOR</td>
			<td>FECHA</td>
			<td>IDIOMA</td>
			<td>ASISTENCIA</td>
			<td>ALUMNO</td>
		</tr>

		<?php
			//Query prueba
			$resultado_query_tutor = mysqli_query($enlace, "SELECT distinct cita.TutorMatricula as tutor
		from cita order by cita.Folio;");
			$resultado_query_admin = mysqli_query($enlace, "SELECT distinct cita.AdministradorMatricula as admin
			from cita order by cita.Folio;");

			while($row_asociativo = mysqli_fetch_assoc($resultado_query))
			{
				?>
			<tr>
			<td><?php echo $row_asociativo['Folio'];?></td>
			<td><?php echo $row_asociativo["tutor"];?></td>
			<td><?php echo $row_asociativo['admin'];?></td>
			<td><?php echo $row_asociativo["Fecha"];?></td>
			<td><?php echo $row_asociativo['Idioma'];?></td>
			<td><?php echo $row_asociativo["Asistencia"];?></td>
			<td><?php echo $row_asociativo['Alumno'];?></td>
			
			
			<td>
			<div class="btn-group-toggle" data-toggle="buttons">
			<label class="btn btn-secondary custom-btn">
			<input type="checkbox" name= "check[]" value="<?echo $row_asociativo['Alumno'].$row_asociativo['Folio']?>"> SELECT </td>
			</label>
			</div>

			
		<?php
			echo "</tr>";
			}
		?>
		</form>
		<div>
		<form method="post">
		<input type="submit" name="agregarTutor" id="agregarTutor" value="Agregar tutor">
		</form>
		<?php
			if(isset($_POST['agregarTutor'])){
				echo "<script> location.href='AgregarTutor.php'; </script>";
			}
		?>
		</div>
				<div>
		<form  method="post">
  <p>Matrícula tutor: </p>
  <select name="TutorMatricula" id="TutorMatricula">
 <?php 
  while($row_folio = mysqli_fetch_array($resultado_query_tutor)){
			echo "<option value=".$row_folio['tutor'].">".$row_folio['tutor']."</option>";
		}
		?>
</select>
  <p>Matrícula administrador:</p>
  <select name="AdminMatricula" id="AdminMatricula">
<?php 
  while($row_folio = mysqli_fetch_array($resultado_query_admin)){
			echo "<option value=".$row_folio['admin'].">".$row_folio['admin']."</option>";
		}
		?>
</select>
  <p>Fecha y hora de la cita (2019-12-06 10:00:00)): <input type="text" name="HorarioCita"size="20" ></p>
  <select name="IdiomaCita">
  <option value="ingles">Ingles</option>
  <option value="español">Español</option>
  <option value="Frances">Frances</option>
</select>
  <p>Matrícula alumno: <input type="text" name="MatriculaAlumno"size="9" ></p>
  <p>
    <input type="submit" name="insertar" id="insertar" value="Enviar">
  </p>
</form>

<?php
	$query_buscar = "SELECT Folio, Matricula FROM 
	alumno_has_cita natural join cita;";
	$result_buscar = mysqli_query($enlace, $query_buscar);
?>

<form method="post">
	<select name="folio_buscar">
		<?php
		while($row_folio_buscar = mysqli_fetch_array($result_buscar)){
			$id = $row_folio_buscar['Matricula'].$row_folio_buscar['Folio'];
			echo '<option value='.$id.'>'.$row_folio_buscar['Folio']. ' Alumno: ' .$row_folio_buscar['Matricula']."</option>";
		}
		?>
	</select>
	<input type="submit" name="buscar" id="buscar" value="Buscar">
	<input type="submit" name="eliminar_busqueda" id="buscar" value="Eliminar busqueda">

</form>


	<input type="submit" name="eliminar" id="eliminar" value="Eliminar">

</form>

<?php
	if(isset($_POST["eliminar"]) and isset($_POST['check'])){
	foreach($_POST['check'] as $check){
		$arr = str_split($check, 9);
		$query_asistencia = "DELETE FROM alumno_has_cita WHERE  Folio='$arr[1]' AND Matricula = '$arr[0]' ;";								
		$result_asistencia = mysqli_query($enlace, $query_asistencia);

	}
}
?>
		</div>
		<!-- <input type="submit" name="reporte" id="reporte" value="Generar reporte de citas"> -->
	  </div>
	</div>

	<?php
	if(isset($_POST['insertar'])){
		$TUTOR= $_POST['TutorMatricula'];
		$ADMIN= $_POST['AdminMatricula'];
		$HORARIOCITA= $_POST['HorarioCita'];
		$IDIOMACITA= $_POST['IdiomaCita'];
		$ALUMNO= $_POST['MatriculaAlumno'];
		
		if($TUTOR==NULL or $ADMIN == NULL or $HORARIOCITA == NULL or $IDIOMACITA == NULL or $ALUMNO == NULL){
			echo "Hace falta información";
		}
		else{
			echo "Se ha insertado a la base de datos";
		}
		//echo $CUPO;
		//echo "hola";
		//echo $TUTOR;
		//echo $ADMIN;
		//echo $HORARIOCITA;
		//echo $IDIOMACITA;
		 //echo $ASISTENCIA;
		//echo $ALUMNO;
		$Cupo = 0;
		$Asistencia = 0;
		
		//echo $Folio;
		//$Folio = CAST($Folio as int) + 1;
		
		//echo $Folio;

		$insert_query_cita = mysqli_query($enlace, "INSERT INTO cita (Cupo, TutorMatricula, AdministradorMatricula, HorarioCita,IdiomaCita) VALUES ('$Cupo', '$TUTOR', '$ADMIN', '$HORARIOCITA', '$IDIOMACITA');");
		$result_folio = mysqli_query($enlace, "SELECT MAX(Folio) FROM cita;");
		$row = mysqli_fetch_array($result_folio);
		$folio = $row[0];
		$query_temp = "INSERT INTO alumno_has_cita (Folio, Asistencia, Matricula) VALUES ('$folio', '$Cupo', '$ALUMNO');";
		$insert_query_cita_dos = mysqli_query($enlace, $query_temp);
		//header("Location: admin.php");
		echo "<script>setTimeout(\"location.href = 'admin.php';\",5000);</script>";
		//echo "Se ha insertado a la base de datos";
	}
	
	
	?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
	<script src="assets/js/table.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	
	<a href="export.php?export=true">Generar reporte de citas</a>
	<!-- <p><input type="submit" name="reporte" id="reporte" value="Generar reporte de citas"></p> -->
	<!-- <input type="submit" name="insertar" id="insertar" value="Enviar"> -->
	
	

</body>

</html>


<div class="bg-modal">
  <div class="modal-content">
    <div class="textoPopUps">
      <h1>Envío de Reporte</h1>
      <h10> Se enviaron los reportes de las sesiones seleccionadas al correo del profesor correspondiente</h10>
    </div>
    <div class="close">
      <button onclick="Prueba2()">Aceptar</button>
    </div>
  </div>
</div>

<!-- POP UP para Admin 2
<div class="bg-modalEliminarCita1">
  <div class="modal-contentEliminarCita1">
    <div class="textoPopUps">
      <h1>Cancelación de Sesión</h1>
      <h10> ¿Desea cancelar la sesión impartida por Carla Pérez el 01/07/2019 a las 10:00?</h10>
    </div>
    <div>
      <button onclick="AbrirTercera()">Aceptar</button>
      <button onclick="CerrarCanc()">Cerrar</button>
    </div>
  </div>
</div> -->
<!-- 
POP UP 3 -->
<!-- <div class="bg-modalCancelar">
  <div class="modal-contentCancelar">
    <div class="textoPopUps">
      <h1>Cancelación de Sesión</h1>
      <h10> La sesión fue cancelada, se le enviará un correo al tutor y al alumno como notificación</h10>
    </div>
    <div class="aceptar">
      <button onclick="Aceptar()">Aceptar</button>
    </div>
  </div>
</div> -->

<script>

  function AbrirPrimera(){
			var x = document.querySelector('.bg-modal').style.display = "flex";
			}
			function AbrirSegunda(){
			var y = document.querySelector('.bg-modalEliminarCita1').style.display = "flex";
				}
			function AbrirTercera(){
				var y = document.querySelector('.bg-modalCancelar').style.display = "flex";

			}
</script>



<script>
  function Prueba2(){
			document.querySelector('.bg-modal').style.display = "none";

		}
	</script>



<script>
  function Aceptar(){
			var x = document.querySelector('.bg-modalEliminarCita1').style.display = "none";
			var y = document.querySelector('.bg-modal').style.display = "none";
		}
	</script>

<script>
  function CerrarCanc(){
			var x = document.querySelector('.bg-modalEliminarCita1').style.display = "none";
			var y = document.querySelector('.bg-modal').style.display = "none";
		}
		function Aceptar(){
			var x = document.querySelector('.bg-modalCancelar').style.display = "none";
			var y = document.querySelector('.bg-modal').style.display = "none";
			var z = document.querySelector('.bg-modalEliminarCita1').style.display = "none";
		}
	</script>
<input type='checkbox' />

<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  
  }
</script>
</body>
</html>
