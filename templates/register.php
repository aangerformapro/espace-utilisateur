<?php

declare(strict_types=1);

include 'page/header.php';

?>
<div class="container login-form-container d-flex flex-column justify-content-center align-items-center">
  <div class="card login-card">

    <div class="card-body">


    <h5 class="card-title">Créer un compte</h5>

    <div class="card-text">

      <form method="post" action="./register.php">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $postdata['username']       ?? ''; ?>" required>
          <label for="username">Nom d'utilisateur</label>
        </div>

        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="<?= $postdata['email']                 ?? ''; ?>" required>
          <label for="email">E-mail</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de famille" value="<?= $postdata['lastname'] ?? ''; ?>" required>
          <label for="lastname">Nom de famille</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" value="<?= $postdata['firstname']      ?? ''; ?>" required>
          <label for="firstname">Prénom</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
          <label for="password">Mot de passe</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirmer mot de passe" required>
          <label for="confirm-password">Confirmer mot de passe</label>
        </div>

        <div class="flash-message">
            <?php displayFlashMessages(); ?>

        </div>

        <button type="submit" class="btn btn-outline-primary d-block w-100" name="action" value="register">Créer un compte</button>

      </form>
    </div>
    </div>

  </div>

</div>

<?php include 'page/footer.php';
