<?php include('../template/cabecera.php');?>
<?php

//metodos POST para guardar inputs en variables php
$txtNombreProfesor=(isset($_POST['txtNombreProfesor']))?$_POST['txtNombreProfesor']:"";
$txtCodigoProfesor=(isset($_POST['txtCodigoProfesor']))?$_POST['txtCodigoProfesor']:"";
$txtFechaInicio=(isset($_POST['txtFechaInicio']))?$_POST['txtFechaInicio']:"";
$txtFechaDevolucion=(isset($_POST['txtFechaDevolucion']))?$_POST['txtFechaDevolucion']:"";
$txtIDPrestamo=(isset($_POST['txtIDPrestamo']))?$_POST['txtIDPrestamo']:"";

$txtBuscar=(isset($_POST['txtBuscar']))?$_POST['txtBuscar']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$accionDos=(isset($_POST['accionDos']))?$_POST['accionDos']:"";
$opcBuscar=(isset($_POST['opcBuscar']))?$_POST['opcBuscar']:"";


include("../config/bd.php");


switch($accion){

        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO prestamodos (IDPrestamo, FechaInicio, FechaDevolucion, CodigoProfesor, NombreProfesor) VALUES (:IDPrestamo, :FechaInicio, :FechaDevolucion, :CodigoProfesor, :NombreProfesor);");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->bindParam(':FechaInicio', $txtFechaInicio);
            $sentenciaSQL->bindParam(':FechaDevolucion', $txtFechaDevolucion);
            $sentenciaSQL->bindParam(':CodigoProfesor', $txtCodigoProfesor);
            $sentenciaSQL->bindParam(':NombreProfesor', $txtNombreProfesor);
            $sentenciaSQL->execute();
            break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("UPDATE prestamodos SET NombreProfesor=:NombreProfesor WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->bindParam(':NombreProfesor', $txtNombreProfesor);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE prestamodos SET CodigoProfesor=:CodigoProfesor WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->bindParam(':CodigoProfesor', $txtCodigoProfesor);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE prestamodos SET FechaInicio=:FechaInicio WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->bindParam(':FechaInicio', $txtFechaInicio);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE prestamodos SET FechaDevolucion=:FechaDevolucion WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->bindParam(':FechaDevolucion', $txtFechaDevolucion);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE prestamodos SET IDPrestamo=:IDPrestamo WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            //$sentenciaSQL->bindParam(':FechaInicio', $txtFechaInicio);
            $sentenciaSQL->execute();

            break;

        case "Cancelar":
            header("Location:prestamodos.php");
            break;

        case "Seleccionar":
            
            $sentenciaSQL= $conexion->prepare("SELECT * FROM prestamodos WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->execute();
            $prestamo=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombreProfesor=$prestamo['NombreProfesor'];
            $txtCodigoProfesor=$prestamo['CodigoProfesor'];
            $txtFechaInicio=$prestamo['FechaInicio'];
            $txtFechaDevolucion=$prestamo['FechaDevolucion'];
            $txtIDPrestamo=$prestamo['IDPrestamo'];

            break;
        case "Borrar":
            $sentenciaSQL= $conexion->prepare("DELETE FROM prestamodos WHERE IDPrestamo=:IDPrestamo");
            $sentenciaSQL->bindParam(':IDPrestamo', $txtIDPrestamo);
            $sentenciaSQL->execute();
            break;
}

if($accionDos == "Buscar"){

    $longitud=strlen($txtBuscar);

    if($opcBuscar == "codigoBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM prestamodos WHERE SUBSTRING(IDPrestamo, 1, :lon) = :IDPrestamo");
        $sentenciaSQL->bindParam(':IDPrestamo', $txtBuscar);
        $sentenciaSQL->bindParam(':lon', $longitud);
        $sentenciaSQL->execute();
        $listaPrestamos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }
    /* else if($opcBuscar == "nombreBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM alumnos WHERE LOCATE(:nombre, nombre) > 0");
        $sentenciaSQL->bindParam(':nombre', $txtBuscar);
        $sentenciaSQL->execute();
        $listaAlumnos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    } */

}else{
    $sentenciaSQL= $conexion->prepare("SELECT * FROM prestamodos");
    $sentenciaSQL->execute();
    $listaPrestamos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

?>

<div class="container-fluid" >
    
    <div class="contenedorLogo">
        <img width="310" src="logo3.png" class="img-t"/>
        <img width="350" src="profesores.png" class="img-t"/>
    </div>
</div>

<div class="col-md-1">

</div>
<div class="col-md-3">
<br/><br/>
    <div class="card">
        <div class="card-header" >
            Datos del Prestamo
        </div>

        <div class="card-body">
            <form class="estilo_formAlums" method="POST" enctype="multipart/form-data">
                
                <div class = "form-group">
                <label for="txtNombreProfesor">Nombre Profesor:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNombreProfesor":"" ?>"  name="txtNombreProfesor" id="txtNombreProfesor"  placeholder="Ingrese nombre">
                </div>

                <div class = "form-group">
                <label for="txtCodigoProfesor">Codigo Profesor:</label>
                <input type="text"  class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCodigoProfesor":"" ?>" name="txtCodigoProfesor" id="txtCodigoProfesor"  placeholder="Ingrese codigo">
                </div>

                <div class = "form-group">
                <label for="txtFechaInicio">Fecha Inicio:</label>
                <input type="date" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtFechaInicio":"" ?>" name="txtFechaInicio" id="txtFechaInicio"  placeholder="Ingrese fecha inicio">
                </div>

                <div class = "form-group">
                <label for="txtFechaDevolucion">Fecha Devolucion:</label>
                <input type="date" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtFechaDevolucion":"" ?>" name="txtFechaDevolucion" id="txtFechaDevolucion"  placeholder="Ingrese fecha devolucion">
                </div>

                <div class = "form-group">
                <label for="txtIDPrestamo">IDPrestamo:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtIDPrestamo":"" ?>" name="txtIDPrestamo" id="txtIDPrestamo"  placeholder="Ingrese ID Prestamo">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>

        </div>

       
    </div>

    
    
    

</div>


<div class="col-md-3"> 

<div>
    
    </div>
    <br><br>
    <div class="estilo_divAlums">
    
    <table >
        
        <thead style="background-color:#2c637e">
            <tr>
                <th style="width:5%; color:#FFFFFF;">NombreProfesor</th>
                <th style="width:5%; color:#FFFFFF;">CodigoProfesor</th>
                <th style="width:5%; color:#FFFFFF;">FechaInicio</th>
                <th style="width:5%; color:#FFFFFF;">FechaDevolucion</th>
                <th style="width:5%; color:#FFFFFF;">IDPrestamo</th>
                <th style="width:5%; color:#FFFFFF;">Accion</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaPrestamos as $prestamo) { ?> 
            <tr>
                <td style="width:20%;"><?php echo $prestamo['NombreProfesor'];?></td>
                <td style="width:14%;"><?php echo $prestamo['CodigoProfesor'];?></td>
                <td style="width:20%;"><?php echo $prestamo['FechaInicio'];?></td>
                <td style="width:20%;"><?php echo $prestamo['FechaDevolucion'];?></td>
                <td style="width:20%;"><?php echo $prestamo['IDPrestamo'];?></td>
                <td>


                    <form method="post">                       

                        <input type="hidden" name="txtIDPrestamo" id="txtIDPrestamo" value="<?php echo $prestamo['IDPrestamo']; ?>"/>

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>


                    </form>

                </td>

            </tr>
        <?php } ?>
        </tbody>
        
    </table>
    <br/>

    </div>

    <div class="estilo_div2" style="background-color:#FFFFFF">

    <table class="table table-bordered">
        
        <thead>
            
        </thead>
        <tbody>
        <?php foreach($listaPrestamos as $prestamo) { ?> 
            <tr bgcolo="red">
                <td style="width:20%;"><?php echo $prestamo['NombreProfesor'];?></td>
                <td style="width:14%;"><?php echo $prestamo['CodigoProfesor'];?></td>
                <td style="width:20%;"><?php echo $prestamo['FechaInicio'];?></td>
                <td style="width:20%;"><?php echo $prestamo['FechaDevolucion'];?></td>
                <td style="width:20%;"><?php echo $prestamo['IDPrestamo'];?></td>
                <td>


                    <form method="post">

                        <input type="hidden" name="txtIDPrestamo" id="txtIDPrestamo" value="<?php echo $prestamo['IDPrestamo']; ?>"/> 

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                    </form>

                </td>
            

            </tr>
            <?php } ?>
        </tbody>
        
    </table>

    </div>
    <br/><br/>
</div>

<?php include('../template/pie.php');?>