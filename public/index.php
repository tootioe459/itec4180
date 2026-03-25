<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/src/bootstrap.php';

if (!isLoggedIn()) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= e($appConfig['name']) ?></title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="container small">
            <div class="card">
                <h1><?= e($appConfig['name']) ?></h1>
                <p class="subtitle">Enter a username to join the chat room.</p>

                <form action="login.php" method="post" class="stack">
                    <input
                        type="text"
                        name="username"
                        maxlength="50"
                        placeholder="Enter username"
                        required
                    >
                    <button type="submit">Join Chat</button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($appConfig['name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="top-bar">
                <div>
                    <h1><?= e($appConfig['name']) ?></h1>
                    <p class="subtitle">Signed in as <strong><?= e(currentUsername()) ?></strong></p>
                </div>
                <a class="logout-link" href="logout.php">Logout</a>
            </div>

            <div id="chat-box" class="chat-box" aria-live="polite"></div>

            <form id="chat-form" class="chat-form">
                <input
                    type="text"
                    id="message"
                    maxlength="500"
                    placeholder="Type a message..."
                    autocomplete="off"
                    required
                >
                <button type="submit">Send</button>
            </form>

            <p id="status" class="status"></p>
        </div>
    </div>

    <script>
        window.CHAT_CONFIG = {
            messagesUrl: 'api/messages.php',
            sendUrl: 'api/send.php'
        };
    </script>
    <script src="assets/js/chat.js"></script>
</body>
</html>
