<?php

declare(strict_types=1);

use Models\User;
use voku\helper\AntiXSS;

session_start();

require_once __DIR__ . '/constants.php';

function loadView(string $view, array $data = []): string
{
    ob_start();

    $cwd  = getcwd();

    if ( ! str_ends_with($view, '.php'))
    {
        $view .= '.php';
    }

    $file = TEMPLATES . DIRECTORY_SEPARATOR . $view;

    if (is_file(TEMPLATES . DIRECTORY_SEPARATOR . $view))
    {
        chdir(dirname($file));
        extract($data);

        include $view;
        chdir($cwd);
    }

    return ob_get_clean() ?: '';
}

function formatTime(DateTime $date): string
{
    return $date->format('Y-m-d') . 'T' . $date->format('H:i');
}

function formatTimeSQL(DateTime $date): string
{
    return $date->format('Y-m-d G:i:s');
}
/**
 * @return string|string[]
 */
function getPostdata(string ...$keys)
{
    static $xss;
    $xss ??= new AntiXSS();

    $values = [];

    if ( ! count($keys))
    {
        $keys = array_keys($_POST);
    }

    foreach ($keys as $key)
    {
        if ( ! isset($_POST[$key]))
        {
            $values[$key] = null;
            continue;
        }
        $values[$key] = $xss->xss_clean($_POST[$key]);
    }

    if (1 === count($keys))
    {
        return $values[$keys[0]];
    }

    return $values;
}

function isExpired(string $date)
{
    return date_create('now')->getTimestamp() > date_create($date)->getTimestamp();
}

// function getPdoConnection(): PDO
// {
//     static $pdo;

//     if ($pdo)
//     {
//         return $pdo;
//     }

//     $config = require_once __DIR__ . '/config.php';

//     $pdo    = new \PDO(
//         sprintf(
//             'mysql:host=localhost;dbname=%s',
//             $config['db']
//         ),
//         $config['user'],
//         $config['password']
//     );

//     $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

//     return $pdo;
// }

function getUser(): ?User
{
    static $user;

    if ($user)
    {
        return $user;
    }

    if (isset($_SESSION['USER']))
    {
        return $user = new User($_SESSION['USER']);
    }
    return null;
}

function renderFlashMessage(array $messageData)
{
    $type    = $messageData['type'];
    $message = $messageData['message'];

    return sprintf('<div class="alert alert-%s" role="alert">%s</div>', $type, $message);
}

function displayFlashMessages()
{
    $result = [];

    foreach ($_SESSION['flash'] ?? [] as $item)
    {
        $result[] = renderFlashMessage($item);
    }
    unset($_SESSION['flash']);

    echo implode('', $result);
}

function addFlashMessage(string $message, string $type = 'info')
{
    $_SESSION['flash'] ??= [];
    $_SESSION['flash'][] = [
        'type'    => $type,
        'message' => $message,
    ];
}

function getRequestMethod(): string
{
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
}
