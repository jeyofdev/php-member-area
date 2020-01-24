<h1 class="text-center mb-5"><?= $title; ?></h1>


<!-- flash message -->
<?= $flash; ?>


<p class="text-center text-primary mb-4">Indicate in the form below the email corresponding to your user account.</p>

<div class="row form-container bg-primary p-3 rounded">
    <!-- the forget form -->
    <?= $form->build($url, "Submit"); ?>
</div>