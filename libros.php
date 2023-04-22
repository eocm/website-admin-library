<?php include('../template/cabecera.php');?>
<?php

//metodos POST para guardar inputs en variables php
$txtTitulo=(isset($_POST['txtTitulo']))?$_POST['txtTitulo']:"";
$txtISBN=(isset($_POST['txtISBN']))?$_POST['txtISBN']:"";
$txtAutor=(isset($_POST['txtAutor']))?$_POST['txtAutor']:"";
$txtEditorial=(isset($_POST['txtEditorial']))?$_POST['txtEditorial']:"";
$txtNumEjem=(isset($_POST['txtNumEjem']))?$_POST['txtNumEjem']:"";
$txtYear=(isset($_POST['txtYear']))?$_POST['txtYear']:"";

$txtBuscar=(isset($_POST['txtBuscar']))?$_POST['txtBuscar']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";
$accionDos=(isset($_POST['accionDos']))?$_POST['accionDos']:"";
$opcBuscar=(isset($_POST['opcBuscar']))?$_POST['opcBuscar']:"";


include("../config/bd.php");


switch($accion){

        case "Agregar":
            $sentenciaSQL= $conexion->prepare("INSERT INTO libros (titulo, isbn, autor, editorial, num_ejemplar, yearPub) VALUES (:titulo, :isbn, :autor, :editorial, :num_ejemplar, :yearPub);");
            $sentenciaSQL->bindParam(':titulo', $txtTitulo);
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':autor', $txtAutor);
            $sentenciaSQL->bindParam(':editorial', $txtEditorial);
            $sentenciaSQL->bindParam(':num_ejemplar', $txtNumEjem);
            $sentenciaSQL->bindParam(':yearPub', $txtYear);
            $sentenciaSQL->execute();
            break;

        case "Modificar":

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET titulo=:titulo WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':titulo', $txtTitulo);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET autor=:autor WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':autor', $txtAutor);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET editorial=:editorial WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':editorial', $txtEditorial);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET num_ejemplar=:num_ejemplar WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':num_ejemplar', $txtNumEjem);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET yearPub=:yearPub WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->bindParam(':yearPub', $txtYear);
            $sentenciaSQL->execute();

            $sentenciaSQL= $conexion->prepare("UPDATE libros SET isbn=:isbn WHERE titulo=:titulo and editorial=:editorial");
            $sentenciaSQL->bindParam(':titulo', $txtTitulo);
            $sentenciaSQL->bindParam(':editorial', $txtEditorial);
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->execute();

            break;

        case "Cancelar":
            
            break;

        case "Seleccionar":
            
            $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtTitulo=$libro['titulo'];
            $txtISBN=$libro['isbn'];
            $txtAutor=$libro['autor'];
            $txtEditorial=$libro['editorial'];
            $txtNumEjem=$libro['num_ejemplar'];
            $txtYear=$libro['yearPub'];


            break;
        case "Borrar":
            $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE isbn=:isbn");
            $sentenciaSQL->bindParam(':isbn', $txtISBN);
            $sentenciaSQL->execute();
            break;
            
}

if($accionDos == "Buscar"){

    $longitud=strlen($txtBuscar);

    if($opcBuscar == "codigoBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE SUBSTRING(isbn, 1, :lon) = :isbn");
        $sentenciaSQL->bindParam(':isbn', $txtBuscar);
        $sentenciaSQL->bindParam(':lon', $longitud);
        $sentenciaSQL->execute();
        $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }else if($opcBuscar == "nombreBus"){

        $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE LOCATE(:titulo, titulo) > 0");
        $sentenciaSQL->bindParam(':titulo', $txtBuscar);
        $sentenciaSQL->execute();
        $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    }

}else{
    $sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}


?>


<div class="container-fluid" >
    
    <div class="contenedorLogo">
        <img width="310" src="logo3.png" class="img-t"/>
        <img width="350" src="libros.png" class="img-t"/>
    </div>
    <br/><br/> 
</div>




<div class="col-md-1">
</div>
<div class="col-md-3">
<br/><br/>  
    <div class="card">
        <div class="card-header" >
            Datos del libro
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                
                <div class = "form-group">
                <label for="txtTitulo">Titulo:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtTitulo":"" ?>"  name="txtTitulo" id="txtTitulo"  placeholder="Ingrese Titulo">
                </div>

                <div class = "form-group">
                <label for="txtISBN">ISBN:</label>
                <input type="text"  class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtISBN":"" ?>" name="txtISBN" id="txtISBN"  placeholder="Ingrese ISBN">
                </div>

                <div class = "form-group">
                <label for="txtAutor">Autor:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtAutor":"" ?>"  name="txtAutor" id="txtAutor"  placeholder="Ingrese Autor">
                </div>

                <div class = "form-group">
                <label for="txtEditorial">Editorial:</label>
                <input type="tel" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtEditorial":"" ?>" name="txtEditorial" id="txtEditorial"  placeholder="Ingrese Editorial">
                </div>

                <div class = "form-group">
                <label for="txtNumEjem">Numero de ejemplar:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtNumEjem":"" ?>" name="txtNumEjem" id="txtNumEjem"  placeholder="Ingrese numero de ejemplar">
                </div>

                <div class = "form-group">
                <label for="txtYear">Año de publicación:</label>
                <input type="text" required class="form-control" value="<?php echo ($accion=="Seleccionar")?"$txtYear":"" ?>" name="txtYear" id="txtYear"  placeholder="Ingrese Año de publicación">
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
        <div class="card-body">
                

        </div>
    </div>
    
    <div class="estilo_div">

    <table >
        
        <thead style="background-color:#2c637e">
            <tr>
                <th style="width:20%; color:#FFFFFF;">Titulo</th>
                <th style="width:14%; color:#FFFFFF;">ISBN</th>
                <th style="width:14%; color:#FFFFFF;">Autor</th>
                <th style="width:14%; color:#FFFFFF;">Editorial</th>
                <th style="width:14%; color:#FFFFFF;">Num Ejem</th>
                <th style="width:14%; color:#FFFFFF;">Año de publicación</th>
                <th style="width:14%; color:#FFFFFF;">Accion</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($listaLibros as $libro) { ?> 
            <tr>
                <td style="width:20%;"><?php echo $libro['titulo'];?></td>
                <td style="width:14%;"><?php echo $libro['isbn'];?></td>
                <td style="width:14%;"><?php echo $libro['autor'];?></td>
                <td style="width:14%;"><?php echo $libro['editorial'];?></td>
                <td style="width:14%;"><?php echo $libro['num_ejemplar'];?></td>
                <td style="width:14%;"><?php echo $libro['yearPub'];?></td>
                <td>


                    <form method="post">                       

                        <input type="hidden" name="txtISBN" id="txtISBN" value="<?php echo $libro['isbn']; ?>"/>

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
        <?php foreach($listaLibros as $libro) { ?> 
            <tr bgcolo="red">
                <td style="width:18%;"><?php echo $libro['titulo'];?></td>
                <td style="width:14%;"><?php echo $libro['isbn'];?></td>
                <td style="width:14%;"><?php echo $libro['autor'];?></td>
                <td style="width:14%;"><?php echo $libro['editorial'];?></td>
                <td style="width:14%;"><?php echo $libro['num_ejemplar'];?></td>
                <td style="width:14%;"><?php echo $libro['yearPub'];?></td>
                <td>


                    <form method="post">

                        <input type="hidden" name="txtISBN" id="txtISBN" value="<?php echo $libro['isbn']; ?>"/> 

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

