<?php include('../template/cabecera.php');?>
<?php


//metodos POST para guardar inputs en variables php
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtCodigo=(isset($_POST['txtCodigo']))?$_POST['txtCodigo']:"";
$txtCarrera=(isset($_POST['txtCarrera']))?$_POST['txtCarrera']:"";
$txtTel=(isset($_POST['txtTel']))?$_POST['txtTel']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtGrado=(isset($_POST['txtGrado']))?$_POST['txtGrado']:"";

$txtBuscar=(isset($_POST['txtBuscar']))?$_POST['txtBuscar']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$accionDos=(isset($_POST['accionDos']))?$_POST['accionDos']:"";
$opcBuscar=(isset($_POST['opcBuscar']))?$_POST['opcBuscar']:"";


include("../config/bd.php");


switch($accion){

        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO profesores (nombre, codigo, carrera, telefono, correo, grado_estudio) VALUES (:nombre, :codigo, :carrera, :telefono, :correo, :grado_estudio);");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':carrera', $txtCarrera);
            $sentenciaSQL->bindParam(':telefono', $txtTel);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->bindParam(':grado_estudio', $txtGrado);
            $sentenciaSQL->execute();
            break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET nombre=:nombre WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET carrera=:carrera WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':carrera', $txtCarrera);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET telefono=:telefono WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':telefono', $txtTel);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET correo=:correo WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET grado_estudio=:grado_estudio WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->bindParam(':grado_estudio', $txtGrado);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE profesores SET codigo=:codigo WHERE nombre=:nombre and correo=:correo");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();

            break;

        case "Cancelar":
            
            break;

        case "Seleccionar":
            
            $sentenciaSQL= $conexion->prepare("SELECT * FROM profesores WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();
            $empleado=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre=$empleado['nombre'];
            $txtCodigo=$empleado['codigo'];
            $txtCarrera=$empleado['carrera'];
            $txtTel=$empleado['telefono'];
            $txtCorreo=$empleado['correo'];
            $txtGrado=$empleado['grado_estudio'];


            break;
        case "Borrar":
            $sentenciaSQL= $conexion->prepare("DELETE FROM profesores WHERE codigo=:codigo");
            $sentenciaSQL->bindParam(':codigo', $txtCodigo);
            $sentenciaSQL->execute();
            break;
        
        

}

if($accionDos == "Buscar"){

    $longitud=strlen($txtBuscar);

    if($opcBuscar == "codigoBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM profesores WHERE SUBSTRING(codigo, 1, :lon) = :codigo");
        $sentenciaSQL->bindParam(':codigo', $txtBuscar);
        $sentenciaSQL->bindParam(':lon', $longitud);
        $sentenciaSQL->execute();
        $listaProfesores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }else if($opcBuscar == "nombreBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM profesores WHERE LOCATE(:nombre, nombre) > 0");
        $sentenciaSQL->bindParam(':nombre', $txtBuscar);
        $sentenciaSQL->execute();
        $listaProfesores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }

}else{
    $sentenciaSQL= $conexion->prepare("SELECT * FROM profesores");
    $sentenciaSQL->execute();
    $listaProfesores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}


?>


<div class="container-fluid" >
    
    <div class="contenedorLogo">
        <img width="310" src="logo3.png" class="img-t"/>
        <img width="400" src="profesores.png" class="img-t"/>
    </div>
    
</div>




<div class="col-md-1">
</div>
<div class="col-md-3">
<br/><br/>  
    <div class="card">
        <div class="card-header" >
            Datos del profesor
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                
                <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNombre":"" ?>"  name="txtNombre" id="txtNombre"  placeholder="Ingrese nombre">
                </div>

                <div class = "form-group">
                <label for="txtCodigo">codigo:</label>
                <input type="text" class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCodigo":"" ?>" name="txtCodigo" id="txtCodigo"  placeholder="Ingrese codigo">
                </div>

                <div class = "form-group">
                <label for="txtCarrera">Carrera:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCarrera":"" ?>"  name="txtCarrera" id="txtCarrera"  placeholder="Ingrese Carrera">
                </div>

                <div class = "form-group">
                <label for="txtTel">Telefono:</label>
                <input type="tel" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtTel":"" ?>" name="txtTel" id="txtTel"  placeholder="Ingrese Telefono">
                </div>

                <div class = "form-group">
                <label for="txtCorreo">correo:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtCorreo":"" ?>" name="txtCorreo" id="txtCorreo"  placeholder="Ingrese correo">
                </div>

                <div class = "form-group">
                <label for="txtGrado">Grado de estudios:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtGrado":"" ?>" name="txtGrado" id="txtGrado"  placeholder="Ingrese Grado de estudios">
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
    <div class="estilo_div">

    <table >
        
        <thead style="background-color:#2c637e">
            <tr>
                <th style="width:15%; color:#FFFFFF;">Nombre</th>
                <th style="width:14%; color:#FFFFFF;">codigo</th>
                <th style="width:14%; color:#FFFFFF;">Carrera</th>
                <th style="width:14%; color:#FFFFFF;">Telefono</th>
                <th style="width:14%; color:#FFFFFF;">correo</th>
                <th style="width:14%; color:#FFFFFF;">Grado de estudios</th>
                <th style="width:14%; color:#FFFFFF;">Accion</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($listaProfesores as $empleado) { ?> 
            <tr>
                <td style="width:17%;"><?php echo $empleado['nombre'];?></td>
                <td style="width:14%;"><?php echo $empleado['codigo'];?></td>
                <td style="width:10%;"><?php echo $empleado['carrera'];?></td>
                <td style="width:18%;"><?php echo $empleado['telefono'];?></td>
                <td style="width:10%;"><?php echo $empleado['correo'];?></td>
                <td style="width:12%;"><?php echo $empleado['grado_estudio'];?></td>
                <td>


                    <form method="post">                       

                        <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $empleado['codigo']; ?>"/>

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
        <?php foreach($listaProfesores as $empleado) { ?> 
            <tr bgcolo="red">
                <td style="width:18%;"><?php echo $empleado['nombre'];?></td>
                <td style="width:14%;"><?php echo $empleado['codigo'];?></td>
                <td style="width:14%;"><?php echo $empleado['carrera'];?></td>
                <td style="width:14%;"><?php echo $empleado['telefono'];?></td>
                <td style="width:14%;"><?php echo $empleado['correo'];?></td>
                <td style="width:14%;"><?php echo $empleado['grado_estudio'];?></td>
                <td style="width:14%;">


                    <form method="post">

                        <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $empleado['codigo']; ?>"/> 

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

