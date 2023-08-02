<?php

declare(strict_types=1);

use Models\User;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (null === ($user = getUser()))
{
    User::redirectTo('./login.php');
}

echo loadView('index', [

    'pagetitle' => 'Hello ' . $user,
    'user'      => $user,

]);
