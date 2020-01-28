<h1 class="text-center mb-5"><?= $title; ?></h1>


<!-- flash message -->
<?= $flash; ?>


<?php if (!is_null($form)) : ?>
    <div class="row form-container bg-primary p-3 rounded">
        <!-- the reset form -->
        <?= $form->build($url, "Update"); ?>
    </div>
<?php endif; ?>