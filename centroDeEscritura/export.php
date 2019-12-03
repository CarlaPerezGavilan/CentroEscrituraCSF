<?php

error_reporting(E_ALL); //DEBUG
ini_set('display_errors', 1);  //DEBUG

$enlace = mysqli_connect('127.0.0.1', 'root', 'Car123()', 'CentroEscruitura');
if($enlace){}
    // echo "Conexión exitosa.<br>";
else
    die("Conexión no exitosa.<br>");

$enlace->set_charset("utf8mb4");

if(isset($_GET['export'])){
    if($_GET['export'] == 'true'){
				$query = mysqli_query($enlace, "SELECT distinct cita.Folio, cita.TutorMatricula as tutor, cita.AdministradorMatricula as admin, cita.HorarioCita as Fecha, cita.IdiomaCita as Idioma, alumno_has_cita.Asistencia, alumno_has_cita.Matricula as Alumno
				from 
				cita inner join alumno_has_cita where(cita.Folio = alumno_has_cita.Folio)
				order by cita.Folio;"); // Get data from Database from demo table
 

        $delimiter = ",";
        $filename = "reporteDeCitas_" . date('Ymd') . ".csv"; // Create file name
        
        //create a file pointer
        $f = fopen('php://memory', 'w'); 
        
        //set column headers
        $fields = array('Folio', 'Tutor', 'Admin', 'Fecha', 'Idioma', 'Asistencia', 'Alumno');
        fputcsv($f, $fields, $delimiter);
        
        //output each row of the data, format line as csv and write to file pointer
        while($row = $query->fetch_assoc()){
            
            $lineData = array($row['Folio'], $row['tutor'], $row['admin'], $row['Fecha'], $row['Idioma'], $row['Asistencia'], $row['Alumno']);
            fputcsv($f, $lineData, $delimiter);
        }
        
        //move back to beginning of file
        fseek($f, 0);
        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        fpassthru($f);
                }
            }

            //Este código esta basado en el siguiente tutorial de youtube
            //significanttechno, (2017).Export table data to Excel using PHP - MYSQL without PLUGIN. Recuperado el 02/12/2019 de [video online]  http://significanttechno.com/export-table-data-to-excel-using-php-and-mysql-without-plugin
	?>