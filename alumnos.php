<?php include('../template/cabecera.php');?>
<?php

//metodos POST para guardar inputs en variables php
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtCodigo=(isset($_POST['txtCodigo']))?$_POST['txtCodigo']:"";
$txtCarrera=(isset($_POST['txtCarrera']))?$_POST['txtCarrera']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtTelefono=(isset($_POST['txtTelefono']))?$_POST['txtTelefono']:"";

$txtBuscar=(isset($_POST['txtBuscar']))?$_POST['txtBuscar']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$accionDos=(isset($_POST['accionDos']))?$_POST['accionDos']:"";
$opcBuscar=(isset($_POST['opcBuscar']))?$_POST['opcBuscar']:"";


include("../config/bd.php");


switch($accion){

        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO alumnos (nombre, codigo, carrera, correo, telefono) VALUES (:nombre, :codigo, :carrera, :correo, :telefono);");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':carrera', $txtCarrera);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->bindParam(':telefono', $txtTelefono);
            $sentenciaSQL->execute();
            break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("UPDATE alumnos SET nombre=:nombre WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE alumnos SET carrera=:carrera WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':carrera', $txtCarrera);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE alumnos SET correo=:correo WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE alumnos SET telefono=:telefono WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':telefono', $txtTelefono);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE alumnos SET codigo=:codigo WHERE nombre=:nombre and correo=:correo");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();

            break;

        case "Cancelar":
            
            break;

        case "Seleccionar":
            
            $sentenciaSQL= $conexion->prepare("SELECT * FROM alumnos WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre=$libro['nombre'];
            $txtCodigo=$libro['codigo'];
            $txtCarrera=$libro['carrera'];
            $txtCorreo=$libro['correo'];
            $txtTelefono=$libro['telefono'];


            break;
        case "Borrar":
            $sentenciaSQL= $conexion->prepare("DELETE FROM alumnos WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();
            break;
            
}

if($accionDos == "Buscar"){

    $longitud=strlen($txtBuscar);

    if($opcBuscar == "codigoBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM alumnos WHERE SUBSTRING(codigo, 1, :lon) = :codigo");
        $sentenciaSQL->bindParam(':codigo', $txtBuscar);
        $sentenciaSQL->bindParam(':lon', $longitud);
        $sentenciaSQL->execute();
        $listaAlumnos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }else if($opcBuscar == "nombreBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM alumnos WHERE LOCATE(:nombre, nombre) > 0");
        $sentenciaSQL->bindParam(':nombre', $txtBuscar);
        $sentenciaSQL->execute();
        $listaAlumnos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }

}else{
    $sentenciaSQL= $conexion->prepare("SELECT * FROM alumnos");
    $sentenciaSQL->execute();
    $listaAlumnos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}


?>


<div class="container-fluid" >
    
    <div class="contenedorLogo">
        <img width="310" src="logo3.png" class="img-t"/>
        <img width="350" src="alumnos.png" class="img-t"/>
    </div>
</div>





<div class="col-md-1">

</div>
<div class="col-md-3">
<br/><br/>
    <div class="card">
        <div class="card-header" >
            Datos del alumno
        </div>

        <div class="card-body">
            <form class="estilo_formAlums" method="POST" enctype="multipart/form-data">
                
                <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNombre":"" ?>"  name="txtNombre" id="txtNombre"  placeholder="Ingrese nombre">
                </div>

                <div class = "form-group">
                <label for="txtCodigo">Codigo:</label>
                <input type="text"  class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCodigo":"" ?>" name="txtCodigo" id="txtCodigo"  placeholder="Ingrese codigo">
                </div>

                <div class = "form-group">
                <label for="txtCarrera">Carrera:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCarrera":"" ?>"  name="txtCarrera" id="txtCarrera"  placeholder="Ingrese carrera">
                </div>

                <div class = "form-group">
                <label for="txtCorreo">Correo:</label>
                <input type="email" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCorreo":"" ?>" name="txtCorreo" id="txtCorreo"  placeholder="Ingrese correo">
                </div>

                <div class = "form-group">
                <label for="txtTelefono">Numero de Telefono:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtTelefono":"" ?>" name="txtTelefono" id="txtTelefono"  placeholder="Ingrese numero Tel">
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
                <th style="width:5%; color:#FFFFFF;">Nombre</th>
                <th style="width:5%; color:#FFFFFF;">Codigo</th>
                <th style="width:5%; color:#FFFFFF;">Carrera</th>
                <th style="width:5%; color:#FFFFFF;">Correo</th>
                <th style="width:5%; color:#FFFFFF;">Telefono</th>
                <th style="width:5%; color:#FFFFFF;">Accion</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($listaAlumnos as $libro) { ?> 
            <tr>
                <td style="width:20%;"><?php echo $libro['nombre'];?></td>
                <td style="width:14%;"><?php echo $libro['codigo'];?></td>
                <td style="width:14%;"><?php echo $libro['carrera'];?></td>
                <td style="width:20%;"><?php echo $libro['correo'];?></td>
                <td style="width:20%;"><?php echo $libro['telefono'];?></td>
                
                <td>


                    <form method="post">                       

                        <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $libro['codigo']; ?>"/>

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
        <?php foreach($listaAlumnos as $libro) { ?> 
            <tr bgcolo="red">
                <td style="width:20%;"><?php echo $libro['nombre'];?></td>
                <td style="width:14%;"><?php echo $libro['codigo'];?></td>
                <td style="width:14%;"><?php echo $libro['carrera'];?></td>
                <td style="width:20%;"><?php echo $libro['correo'];?></td>
                <td style="width:20%;"><?php echo $libro['telefono'];?></td>
                
                <td>


                    <form method="post">

                        <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $libro['codigo']; ?>"/> 

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

