<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('index.php');
}

$username = cleanUsername((string) ($_POST['username'] ?? ''));

if ($username === '') {
    Response::redirect('index.php');
}

$_SESSION['username'] = $username;

Response::redirect('index.php');
