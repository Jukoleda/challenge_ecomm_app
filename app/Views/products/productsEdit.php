
<form action="#" method="post" id="frmUpdateProduct">
    <?= csrf_field() ?>
    <input type="hidden" name="productId" id="id" value="<?= esc($product->id) ?>">
    <label for="title" class="form-label">Titulo</label>
    <input type="text" name="title" class="form-control" id="title" value="<?= esc($product->title) ?>">
    <label for="price" class="form-label">Precio</label>
    <input type="number" name="price" class="form-control" id="price" value="<?= esc($product->price) ?>">
    <label for="created_at" class="form-label">Fecha creacion</label>
    <p id="created_at"><?= esc($product->created_at) ?></p>
    <input type="submit" class="btn btn-primary" value="Guardar">
</form>