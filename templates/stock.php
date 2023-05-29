<main class="Container_main Main Main_stock">
    <h1 class="Main_title">Stock principal</h1>

    <div class="elements submit ">
        <button class="btnAddBatch">Ajouter un lot</button>
    </div>

    <section class="list_container batch">

        <ul class="grid_container">
            <li>Code-barre</li>
            <li>DLC</li>
            <li>Quantité</li>
            <li>Modifier le</li>
            <li>Image</li>
        </ul>

        <?php if (empty($pooledDataForBatch)) : ?>

            <ul class="grid_container">
                <li>Aucun lot à afficher</li>
            </ul>

        <?php else : ?>
            <?php foreach ($pooledDataForBatch as $sBarcode => $aGoods) : ?>

                <?php include '_batch.php' ?>

            <?php endforeach; ?>
        <?php endif; ?>

    </section>

    <div class="new_batch_form hidden">
        <?php include '_newBatch.php' ?>
    </div>

</main>

<script type="module" src="../assets/js/styleImageStockList.js"></script>
<script type="module" src="../assets/js/changeBatchInfo.js"></script>
<script type="module" src="../assets/js/newBatch.js"></script>
