<?php

declare(strict_types=1);

use Models\User;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (getUser())
{
    User::redirectTo('./');
}

$postdata = [];

if ('POST' === getRequestMethod() && 'register' === getPostdata('action'))
{
    $_SESSION['postdata'] = getPostdata(
        'username',
        'email',
        'lastname',
        'firstname',
        'password',
        'confirm-password'
    );

    User::redirectTo('./register.php');
}

if (isset($_SESSION['postdata']))
{
    $hasempty = $hasSpaces = $error = false;
    $postdata = $_SESSION['postdata'];
    unset($_SESSION['postdata']);

    foreach ($postdata as $key => $value)
    {
        if (empty($value))
        {
            $hasempty = true;
            break;
        }

        if (preg_match('/\s+/', $value))
        {
            if (in_array($key, ['lastname',  'firstname']))
            {
                continue;
            }
            $hasSpaces = true;
        }
    }

    if ($hasSpaces)
    {
        $error = true;
        addFlashMessage('Certains champs contiennent des espaces.', 'danger');
    }

    if ($hasempty)
    {
        $error = true;
        addFlashMessage('Certains champs ne sont pas remplis.', 'danger');
    }

    if ($postdata['password'] !== $postdata['confirm-password'])
    {
        $error = true;
        addFlashMessage('Les mots de passe ne correspondent pas.', 'danger');
    } elseif ( ! isSecurePassword($postdata['password']))
    {
        $error = true;
        addFlashMessage('Votre mot de passe doit contenir au moins un caractère spécial, une majuscule, une minuscule, un chiffre et doit faire au minimum 8 caractères.', 'danger');
    }

    unset($postdata['confirm-password']);

    if ( ! $error)
    {
        if (User::createUser($postdata))
        {
            User::redirectTo('./login.php');
        }
        addFlashMessage("Un utilisateur existe déjà avec ce nom d'utilisateur / Email.", 'danger');
    }
}

echo loadView('register', ['pagetitle' => 'Créer un compte', 'postdata' => $postdata]);
