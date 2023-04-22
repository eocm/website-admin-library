<?php include('../template/cabecera.php');?>
<?php


//metodos POST para guardar inputs en variables php
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtNSS=(isset($_POST['txtNSS']))?$_POST['txtNSS']:"";
$txtFechaCon=(isset($_POST['txtFechaCon']))?$_POST['txtFechaCon']:"";
$txtTel=(isset($_POST['txtTel']))?$_POST['txtTel']:"";
$txtDomicilio=(isset($_POST['txtDomicilio']))?$_POST['txtDomicilio']:"";
$txtFechaNac=(isset($_POST['txtFechaNac']))?$_POST['txtFechaNac']:"";

$txtBuscar=(isset($_POST['txtBuscar']))?$_POST['txtBuscar']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$accionDos=(isset($_POST['accionDos']))?$_POST['accionDos']:"";
$opcBuscar=(isset($_POST['opcBuscar']))?$_POST['opcBuscar']:"";


include("../config/bd.php");


switch($accion){

        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO empleados (nombre, nss, fecha_contra, telefono, domicilio, fecha_nac) VALUES (:nombre, :nss, :fechaCon, :telefono, :domicilio, :fechaNac);");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':fechaCon', $txtFechaCon);
            $sentenciaSQL->bindParam(':telefono', $txtTel);
            $sentenciaSQL->bindParam(':domicilio', $txtDomicilio);
            $sentenciaSQL->bindParam(':fechaNac', $txtFechaNac);
            $sentenciaSQL->execute();
            break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET nombre=:nombre WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET fecha_contra=:fechaCon WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':fechaCon', $txtFechaCon);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET telefono=:telefono WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':telefono', $txtTel);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET domicilio=:domicilio WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':domicilio', $txtDomicilio);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET fecha_nac=:fechaNac WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->bindParam(':fechaNac', $txtFechaNac);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE empleados SET nss=:nss WHERE telefono=:telefono and nombre=:nombre and domicilio=:domicilio");
            $sentenciaSQL->bindParam(':telefono', $txtTel);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':domicilio', $txtDomicilio);
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->execute();

            break;

        case "Cancelar":
            
            break;

        case "Seleccionar":
            
            $sentenciaSQL= $conexion->prepare("SELECT * FROM empleados WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->execute();
            $empleado=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre=$empleado['nombre'];
            $txtNSS=$empleado['nss'];
            $txtFechaCon=$empleado['fecha_contra'];
            $txtTel=$empleado['telefono'];
            $txtDomicilio=$empleado['domicilio'];
            $txtFechaNac=$empleado['fecha_nac'];


            break;
        case "Borrar":
            $sentenciaSQL= $conexion->prepare("DELETE FROM empleados WHERE nss=:nss");
            $sentenciaSQL->bindParam(':nss', $txtNSS);
            $sentenciaSQL->execute();
            break;
        
        

}

if($accionDos == "Buscar"){

    $longitud=strlen($txtBuscar);

    if($opcBuscar == "nssBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM empleados WHERE SUBSTRING(nss, 1, :lon) = :nss");
        $sentenciaSQL->bindParam(':nss', $txtBuscar);
        $sentenciaSQL->bindParam(':lon', $longitud);
        $sentenciaSQL->execute();
        $listaEmpleados=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }else if($opcBuscar == "nombreBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM empleados WHERE LOCATE(:nombre, nombre) > 0");
        $sentenciaSQL->bindParam(':nombre', $txtBuscar);
        $sentenciaSQL->execute();
        $listaEmpleados=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }

}else{
    $sentenciaSQL= $conexion->prepare("SELECT * FROM empleados");
    $sentenciaSQL->execute();
    $listaEmpleados=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}


?>


<div class="container-fluid" >
    
    <div class="contenedorLogo">
        <img width="310" src="logo3.png" class="img-t"/>
        <img width="370" src="empleados.png" class="img-t"/>
    </div>
    
</div>




<div class="col-md-1">
</div>
<div class="col-md-3">
<br/><br/>  
    <div class="card">
        <div class="card-header" >
            Datos de empleado
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                
                <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNombre":"" ?>"  name="txtNombre" id="txtNombre"  placeholder="Ingrese nombre">
                </div>

                <div class = "form-group">
                <label for="txtNSS">NSS:</label>
                <input type="text" class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNSS":"" ?>" name="txtNSS" id="txtNSS"  placeholder="Ingrese NSS">
                </div>

                <div class = "form-group">
                <label for="txtFechaCon">Fecha de contratacion:</label>
                <input type="date" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtFechaCon":"" ?>"  name="txtFechaCon" id="txtFechaCon"  placeholder="Ingrese fecha de contratacion">
                </div>

                <div class = "form-group">
                <label for="txtTel">Telefono:</label>
                <input type="tel" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtTel":"" ?>" name="txtTel" id="txtTel"  placeholder="Ingrese Telefono">
                </div>

                <div class = "form-group">
                <label for="txtDomicilio">Domicilio:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtDomicilio":"" ?>" name="txtDomicilio" id="txtDomicilio"  placeholder="Ingrese domicilio">
                </div>

                <div class = "form-group">
                <label for="txtFechaNac">Fecha de nacimiento:</label>
                <input type="date" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtFechaNac":"" ?>" name="txtFechaNac" id="txtFechaNac"  placeholder="Ingrese Fecha de nacimiento">
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
                <th style="width:20%; color:#FFFFFF;">Nombre</th>
                <th style="width:14%; color:#FFFFFF;">NSS</th>
                <th style="width:14%; color:#FFFFFF;">Fecha de contratacion</th>
                <th style="width:14%; color:#FFFFFF;">Telefono</th>
                <th style="width:14%; color:#FFFFFF;">Domicilio</th>
                <th style="width:14%; color:#FFFFFF;">Fecha de nacimiento</th>
                <th style="width:14%; color:#FFFFFF;">Accion</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($listaEmpleados as $empleado) { ?> 
            <tr>
                <td style="width:20%;"><?php echo $empleado['nombre'];?></td>
                <td style="width:14%;"><?php echo $empleado['nss'];?></td>
                <td style="width:14%;"><?php echo $empleado['fecha_contra'];?></td>
                <td style="width:14%;"><?php echo $empleado['telefono'];?></td>
                <td style="width:14%;"><?php echo $empleado['domicilio'];?></td>
                <td style="width:14%;"><?php echo $empleado['fecha_nac'];?></td>
                <td>


                    <form method="post">                       

                        <input type="hidden" name="txtNSS" id="txtNSS" value="<?php echo $empleado['nss']; ?>"/>

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
        <?php foreach($listaEmpleados as $empleado) { ?> 
            <tr bgcolo="red">
                <td style="width:18%;"><?php echo $empleado['nombre'];?></td>
                <td style="width:14%;"><?php echo $empleado['nss'];?></td>
                <td style="width:14%;"><?php echo $empleado['fecha_contra'];?></td>
                <td style="width:14%;"><?php echo $empleado['telefono'];?></td>
                <td style="width:14%;"><?php echo $empleado['domicilio'];?></td>
                <td style="width:14%;"><?php echo $empleado['fecha_nac'];?></td>
                <td>


                    <form method="post">

                        <input type="hidden" name="txtNSS" id="txtNSS" value="<?php echo $empleado['nss']; ?>"/> 

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

