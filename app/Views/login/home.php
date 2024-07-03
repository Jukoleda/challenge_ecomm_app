<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="<?= base_url() ?>libs/bootstrap/css/bootstrap.min.css">
    <title>Ingresar</title>
</head>
<body>
<div class="row">
    <div class="col-3 offset-5 mt-4">
        <h2><?= $title ?></h2>
    </div>
    
</div>

<div class="row g-3">
    <form action="#" method="post" id="frmIngresar">
        <?= csrf_field() ?>
      
        <div class="col-3 offset-4">
            <label for="title" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" name="usuario" required id="usuario">
        </div>
        <div class="col-3 mt-3 offset-4">
            
            <label for="price" class="form-label">clave</label>
            <input type="password" class="form-control" name="clave" required id="clave">
        </div>
        <div class="col-3 mt-3 offset-4">
            <input type="submit" class="btn btn-primary" value="Ingresar">
        </div>
        <div class="col-3 mt-3 offset-4">
            <div id="resultadoGeneral" class="alert"></div> 
        </div>
        </form>
</div>
       
            
            
    <script src="<?= base_url() ?>libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>libs/jquery/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>js/users.js"></script>
</body>
</html>