<?php

declare(strict_types=1);

use Models\User;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (getUser())
{
    User::redirectTo('./');
}

if ( ! User::hasUsers())
{
    User::redirectTo('./register.php');
}

if ('POST' === getRequestMethod() && 'login' === getPostdata('action'))
{
    $_SESSION['postdata'] = getPostdata('username', 'password');
    User::redirectTo('./login.php');
}

if (isset($_SESSION['postdata']))
{
    $postdata = $_SESSION['postdata'];
    unset($_SESSION['postdata']);

    $error    = false;

    if (empty($postdata['username']) || empty($postdata['password']))
    {
        $error = true;
        addFlashMessage('Certains champs ne sont pas remplis.', 'danger');
    }

    if ( ! $error)
    {
        if ($user = User::connectUser($postdata['username'], $postdata['password']))
        {
            $_SESSION['USER'] = $user->toArray();
            User::redirectTo('./');
        }

        addFlashMessage('Vos identifiants sont incorrects.', 'danger');
    }
}

echo loadView('login', ['pagetitle' => 'Connection']);
