<?php

declare(strict_types=1);

include 'page/header.php';

?>

<div class="container page d-flex flex-column justify-content-center align-items-center user-select-none">
    <h1>Bonjour <?= $user; ?></h1>
    <div class="w-100 pt-5 d-flex justify-content-end">
        <a href="./logout.php" title="Se déconnecter">Se déconnecter</a>
    </div>
    
</div>


<?php include 'page/footer.php';
