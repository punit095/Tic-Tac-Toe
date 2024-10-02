<?php
    require_once("assets/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Tic Tac Toe Implementation in PHP</title>
</head>
<body>
<?php 
    // Initialize or load the game state
    if (!isset($_SESSION['game'])) {
        $_SESSION['game'] = new TicTacToe();
    }

    $game = $_SESSION['game'];
    $message = '';

    // Handle move submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move'])) {
        $move = explode(',', $_POST['move']);
        $row = $move[0];
        $col = $move[1];

        if ($game->makeMove($row, $col)) {
            if ($game->checkWinner()) {
                $message = "<span class='alertSuccess'>Player {$game->currentPlayer} wins!</span>";
                $game->saveGameResult("Player {$game->currentPlayer} wins");
                session_destroy();
            } elseif ($game->isBoardFull()) {
                $message = "It's a draw!";
                $game->saveGameResult("Draw");
                session_destroy();
            } else {
                $game->switchPlayer();
            }
        } else {
            $message = '<span class="redAlert">Invalid move, try again.</span>';
        }
    }
?>

<section>
    <h2 style="text-align: center;">Tic Tac Toe</h2>

    <!-- Game display board -->
    <form method="POST" autocomplete="off">
        <?php displayBoard($game); ?>
    </form>

    <!-- To display the current state of the board after each move -->
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php else: ?>
        <div class="message">Current Player: <?= $game->currentPlayer ?></div>
    <?php endif; ?>
</section>

<aside class="gameHistory">
    <h2>Result History</h2>
    <div class="results">
        <?php displayGameHistory(); ?>
    </div>
</aside>

</body>
</html>
