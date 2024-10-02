<?php
session_start();

class TicTacToe {
    public $board;
    public $currentPlayer;
    public $moves;

    public function __construct() {
        $this->board = [['', '', ''], ['', '', ''], ['', '', '']];
        $this->currentPlayer = 'X';
        $this->moves = [];
    }

    public function makeMove($row, $col) {
        if ($this->board[$row][$col] === '') {
            $this->board[$row][$col] = $this->currentPlayer;
            // Record the move
            $this->moves[] = "Player {$this->currentPlayer} moved to ({$row}, {$col})";
            return true;
        }
        return false;
    }

    public function checkWinner() {
        for ($i = 0; $i < 3; $i++) {
            if ($this->board[$i][0] === $this->currentPlayer && $this->board[$i][1] === $this->currentPlayer && $this->board[$i][2] === $this->currentPlayer) return true;
            if ($this->board[0][$i] === $this->currentPlayer && $this->board[1][$i] === $this->currentPlayer && $this->board[2][$i] === $this->currentPlayer) return true;
        }
        if ($this->board[0][0] === $this->currentPlayer && $this->board[1][1] === $this->currentPlayer && $this->board[2][2] === $this->currentPlayer) return true;
        if ($this->board[0][2] === $this->currentPlayer && $this->board[1][1] === $this->currentPlayer && $this->board[2][0] === $this->currentPlayer) return true;
        return false;
    }

    public function isBoardFull() {
        foreach ($this->board as $row) {
            if (in_array('', $row)) return false;
        }
        return true;
    }

    public function switchPlayer() {
        $this->currentPlayer = ($this->currentPlayer === 'X') ? 'O' : 'X';
    }

    // save game history to a file
    public function saveGameResult($outcome) {
        $history = implode("\n", $this->moves);
        $result = "Outcome: " . $outcome . "\n\n";
        file_put_contents('assets/result.txt', $history . "\n" . $result, FILE_APPEND);
    }
}

// Display board and message
function displayBoard($game) {
    echo '<table>';
        for ($row = 0; $row < 3; $row++) {
            echo '<tr>';
                for ($col = 0; $col < 3; $col++) {
                    $cell = $game->board[$row][$col];
                    $value = $cell === '' ? '&nbsp;' : $cell;
                    echo "<td><button name='move' value='{$row},{$col}'>{$value}</button></td>";
                }
            echo '</tr>';
        }
    echo '</table>';
}

// Read the contents of game_history.txt
function displayGameHistory() {
    $historyFile = 'assets/result.txt';
    if (file_exists($historyFile)) {
        $history = file_get_contents($historyFile);
        echo '<pre>' . htmlspecialchars($history) . '</pre>';
    } else {
        echo '<p>Game not have been played yet.</p>';
    }
}