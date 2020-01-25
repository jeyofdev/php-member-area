<h1 class="text-center mb-5"><?= $title; ?></h1>


<!-- flash message -->
<?= $flash; ?>


<div class="row form-container bg-primary p-3 rounded">
    <!-- the registration form -->
    <?= $form->build($url, "Update"); ?>
</div>