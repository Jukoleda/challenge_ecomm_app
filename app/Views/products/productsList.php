<div class="row">
    <div class="col-6 offset-3">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Filtros de Búsqueda
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <div class="row">


                            <div class="container">
                                <h2 class="mb-2"></h2>
                                <form id="frmSearch">
                                    <div class="mb-2">
                                        <label for="tituloProducto" class="form-label">Título de producto</label>
                                        <input type="text" class="form-control" id="tituloProducto" placeholder="Ingrese el título del producto">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Rango de precio</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Desde</span>
                                            <input type="number" class="form-control" id="precioMinimo" placeholder="Precio mínimo">
                                            <span class="input-group-text">Hasta</span>
                                            <input type="number" class="form-control" id="precioMaximo" placeholder="Precio máximo">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fechaCreacion" class="form-label">Fecha de creación</label>
                                        <input type="date" class="form-control" id="fechaCreacion" max="">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if (isset($paginator['data']) && ($paginator['totalCount']) > 0) { ?>


            <div id="table_products">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- <th><input type="checkbox" id="cbSelectAll"/></th> -->
                            <!-- <th>Id</th> -->
                            <th>Titulo</th>
                            <th>Precio</th>
                            <th>Fecha Creacion</th>
                            <?php if (isset($user) && $user['admin'] == true) { ?>
                                <th>Acciones</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($paginator['data'] as $product) { ?>
                            <tr class="product" data-idproduct="<?= esc($product->id) ?>">
                                <!-- <td><input type="checkbox" class="cbProducts" value="<= esc($product->id) ?>"/></td> -->
                                <!-- <td><= esc($product->id) ? esc($product->id) : "-- --" ?></td> -->
                                <td><?= esc($product->title) ? esc($product->title) : "-- --" ?></td>
                                <td>$<?= esc($product->price) ? esc($product->price) : "-- --" ?></td>
                                <td><?= esc($product->created_at) ? esc($product->created_at) : "-- --" ?></td>
                                <?php if (isset($user) && $user['admin'] == true) { ?>
                                    <td>
                                        <button title="Modificar Producto" data-productid="<?= esc($product->id) ?>" class="btn btn-success btn-sm btnProductModif">Modificar</button>
                                        <button title="Eliminar Producto" data-productid="<?= esc($product->id) ?>" class="btn btn-danger btn-sm btnProductRemove">Eliminar</button>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <div id="pagination">
                <nav aria-label="...">
                    <input type="hidden" id="page" value="<?= $paginator['page'] ?>">
                    <ul class="pagination">
                        <li class="page-item <?= $paginator['page'] == 1 ? "disabled" : "" ?>"><a class="page-link" href="#" <?= $paginator['page'] == 1 ? "" : 'onclick="getPageWithFilters(' . $paginator['page'] - 1 . ')"' ?> <?= $paginator['page'] == 1 ? 'tabindex="-1" aria-disabled="true"' : "" ?>>Previous</a></li>

                        <?php for ($i = 1; $i <= $paginator['totalPages']; $i++) {

                            if ($i == $paginator['page']) {
                        ?>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="#"><?= $i ?></a>
                                </li>
                            <?php } else { ?>

                                <li class="page-item"><a class="page-link" href="#" onclick="getPageWithFilters(<?= $i ?>)"><?= $i ?></a></li>

                        <?php }
                        } ?>
                        <li class="page-item <?= $paginator['page'] == $paginator['totalPages'] ? "disabled" : "" ?>"><a class="page-link" href="#" <?= $paginator['page'] == $paginator['totalPages'] ? "" : 'onclick="getPageWithFilters(' . $paginator['page'] + 1 . ')"' ?> <?= $paginator['page'] == $paginator['totalPages'] ? 'tabindex="-1" aria-disabled="true"' : "" ?>>Previous</a></li>

                    </ul>
                </nav>
            </div>
        <?php } else { ?>
            <div class="row justify-content-md-center">
                <div class="col alert alert-warning mt-4">
                    <h4>No hay productos para mostrar</h4>
                </div>
            </div>
        <?php } ?>
    </div>
</div>