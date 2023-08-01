<?php

declare(strict_types=1);

use Models\User;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (getUser())
{
    header('Location: ./');

    exit;
}

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

    header('Location: ./register.php');

    exit;
}

if (isset($_SESSION['postdata']))
{
    $hasempty = $error = false;
    $postdata = $_SESSION['postdata'];
    unset($_SESSION['postdata']);

    foreach ($postdata as $value)
    {
        if (empty($value))
        {
            $hasempty = true;
            break;
        }
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
        addFlashMessage('Votre mot de passe doit contenir au moins un caractère spécial, une majuscule, une minuscule, un chiffre et doit faire au minimum 8 caractère.', 'danger');
    }

    unset($postdata['confirm-password']);

    if ( ! $error)
    {
        if (User::createUser($postdata))
        {
            header('Location: ./login.php');

            exit;
        }
        addFlashMessage("Un utilisateur existe déjà avec ce nom d'utilisateur / Email.", 'danger');
    }
}

echo loadView('register', ['pagetitle' => 'Créer un compte']);
