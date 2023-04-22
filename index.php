<?php
session_start();

if($_POST){
    if(($_POST['usuario']=="admin")&&($_POST['contrasenia']=="1234")){
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="admin";
        header('Location:inicio.php'); 
    }
    else{
        $mensaje="Error: el usuario y/o contraseña son incorrectos";

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
    <link rel="stylesheet" type="text/css" href="seccion/estilos.css?ts=<?=time()?>">
  </head>
  <body>
    
     
    <div class="container-fluid">
        <div class="row">

        
            <div class="col-md-1"></div>
            <div class="col-md-4">
            <img width="500" src="seccion/logo3.png" class="img-t"/>
<br/><br/><br/>
                <div class="card">
                    <div class="card-header">
                        Inicio de sesion
                    </div>
                    <div class="card-body">
                        
                    <?php if(isset($mensaje)) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje;?>
                        </div>
                    <?php } ?>
                        <form method="POST">


                        <div class = "form-group">
                        <label >Usuario</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                        
                        </div>

                        <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasenia"  placeholder="Escribe tu contraseña">

                        </div>

                        <button type="submit" class="btn btn-primary">Entrar al sistema</button>

                        </form> 

                    </div>
                </div>
                
            </div>
            
        </div>
    </div>  


    
  </body>
</html>