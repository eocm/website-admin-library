<!-- Equipo1 -->
<!-- Jhonatan Banda Martinez
Oscar Beltran Villegas
Eric Omar Camarena Miranda
Oscar Fabian Chavez Gomez -->
<!-- Calendario: 2021B
Seccion: D04 -->

<?php 
session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
  }else{
    
    if($_SESSION['usuario']=="ok"){
      $nombreUsuario=$_SESSION['nombreUsuario'];

    }

  }

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css?ts=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="seccion/estilos.css?ts=<?=time()?>">


  </head>
  <body style="background-color:#012233">

        <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>

        
            <ul class="menu" >

                <li><a  href="<?php echo $url;?>/administrador/inicio.php">INICIO</a> </li>

                <li><a  href="<?php echo $url;?>/administrador/seccion/empleados.php">Empleados</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/libros.php">Libros</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/profesores.php">Profesores</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/alumnos.php">Alumnos</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/prestamo.php">Prestamo Alumno</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/prestamodos.php">Prestamo Profesor</a> </li>
                <li><a  href="<?php echo $url;?>/administrador/seccion/cerrar.php">CERRAR SESION</a> </li>

                

                
            </ul>
        

        <div class="container-fluid" >
        <br/>
            <div class="row"  >
                