<form action="#" method="post" id="frmCreateProduct">
    <?= csrf_field() ?>
    <label for="title" class="form-label">Titulo</label>
    <input type="text" class="form-control" name="titulo" required id="title">
    <label for="price" class="form-label">Precio</label>
    <input type="number" class="form-control" name="precio" required id="price">
<br/>
    <input type="submit" class="btn btn-primary" value="Guardar">
</form>