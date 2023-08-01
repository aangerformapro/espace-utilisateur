<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

unset($_SESSION['USER']);
header('Location: ./');
