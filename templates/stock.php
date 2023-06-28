<main class="Container_main Main Main_stock">
    <h1 class="Main_title">Stock principal</h1>

    <button class="btnAddBatch" data-text="Ajouter un lot"></button>

    <section class="list_container batch">
        <ul class="grid_container">
            <li>Code-barre</li>
            <li>DLC</li>
            <li>Quantité</li>
            <li>Modifier le</li>
            <li>Image</li>
        </ul>
        <?php if (empty($dataToRender)) : ?>

            <ul class="grid_container">
                <li>Aucun lot à afficher</li>
            </ul>

        <?php else : ?>
            <?php foreach ($dataToRender as $sBarcode => $aGoods) : ?>

                <?php include '_batch.php' ?>

            <?php endforeach; ?>
        <?php endif; ?>

    </section>

    <div class="container_new_batch_form hidden">
        <?php include '_newBatch.php' ?>
    </div>

</main>

<script type="module" src="../assets/js/styleImageStockList.js"></script>
<script type="module" src="../assets/js/newBatch.js"></script>
<script type="module" src="../assets/js/changeBatchInfo.js"></script>
