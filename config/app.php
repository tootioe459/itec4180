<?php
declare(strict_types=1);

$env = require dirname(__DIR__) . '/env.php';

return [
    'name' => $env['APP_NAME'] ?? 'Simple PHP Chat',
];
