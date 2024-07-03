<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="<?= base_url() ?>libs/bootstrap/css/bootstrap.min.css">
    <title>Productos</title>
</head>
<body>
<div class="row  mt-4 mb-3">
  <div class="col-1 offset-3">
    <a href="<?= base_url() ?>" class="btn btn-danger">Salir</a>
  </div>
    <div class="col-3 offset-1">
        <h2><?= $title ?></h2>
    </div>
    <?php if (isset($user) && $user['admin'] == true) {?>
      <div class="col-2">
        <button title="Crear nuevo producto" id="btnNewProduct"class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalOperation">Nuevo producto</button>
      </div>
    <?php } ?>
</div>
    <div id="main">
    
    </div>
    <!-- <div id="modalBody"></div> -->
     <div class="row col-3 offset-3">
       <div id="resultadoGeneral" class="alert alert-success"></div> 

     </div>
    

    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="modalOperation" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        ...
      </div>
      <div class="modal-footer">
      <div id="resultadoModal" class="alert alert-success"></div> 

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirm" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirm">Eliminar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        Esta seguro que desea eliminar el producto?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="deleteProduct">Eliminar</button>

      </div>
    </div>
  </div>
</div>

    <script src="<?= base_url() ?>libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>libs/jquery/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>js/products.js"></script>
</body>
</html>