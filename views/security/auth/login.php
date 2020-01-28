<h1 class="text-center mb-5"><?= $title; ?></h1>


<!-- flash message -->
<?= $flash; ?>



<div class="row form-container bg-primary p-3 rounded">
    <!-- the login form -->
    <?= $form->build($url, "Login", "password_new"); ?>
</div>