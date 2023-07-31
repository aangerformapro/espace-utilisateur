<?php

declare(strict_types=1);

include 'page/header.php';

?>

<div class="card login-card">

<div class="card-body">

<form method="post" action="./login.php">
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
  <label for="username">Nom d'utilisateur</label>
</div>
<div class="form-floating">
  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  <label for="password">Mot de passe</label>
</div>

</form>


</div>

</div>





<?php include 'page/footer.php';
