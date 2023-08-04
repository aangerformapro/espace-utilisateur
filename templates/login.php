<?php

declare(strict_types=1);

include 'page/header.php';

?>
<div class="container login-form-container d-flex flex-column justify-content-center align-items-center">
  <div class="card login-card">

    <div class="card-body">

    <h5 class="card-title">Connection</h5>

    <div class="card-text">
      <form method="post" action="./login.php">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
          <label for="username">Nom d'utilisateur</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          <label for="password">Mot de passe</label>
        </div>

        <div class="flash-message">
          <?php displayFlashMessages(); ?>
        </div>

        <button type="submit" class="btn btn-outline-primary d-block w-100" name="action" value="login">Se Connecter</button>
        <hr>

        <div class="mb-3 text-center">
          Vous n'avez pas de compte ? 
          <a href="./register.php" title="Créer un compte">Créer un compte</a>
        </div>

      </form>

    </div>
    </div>

  </div>

</div>



<?php include 'page/footer.php';
