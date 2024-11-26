<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php 
    function checkForWinCombination($board, $player) {
        for ($i = 0; $i < 3; $i++) {
            if ($board[$i][0] === $player && $board[$i][1] === $player && $board[$i][2] === $player) return true;
            if ($board[0][$i] === $player && $board[1][$i] === $player && $board[2][$i] === $player) return true;
        }
        if ($board[0][0] === $player && $board[1][1] === $player && $board[2][2] === $player) return true;
        if ($board[0][2] === $player && $board[1][1] === $player && $board[2][0] === $player) return true;
    
        return false;
    }

    function isBoardFull($board) {
        foreach ($board as $row) {
            foreach ($row as $cell) {
                if (empty($cell)) return false;
            }
        }
        return true;
    }
    ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $board = $_POST['board'];
            $currentPlayer = isset($_SESSION['player']) ? $_SESSION['player'] : 'X';

            if(checkForWinCombination($board, 'X'))
            {
                echo "<h2>Player X wins!</h2>";
                session_destroy();
            }else if(checkForWinCombination($board, 'Y')){
                echo "<h2>Player O wins!</h2>";
                session_destroy();
            }elseif (isBoardFull($board)) {
                echo "<h2>It's a draw!</h2>";
                session_destroy();
            }else {
                $_SESSION['player'] = $currentPlayer === 'X' ? 'O' : 'X';
                echo "<h2>Player {$_SESSION['player']}'s turn!</h2>";
            }
        }
    ?>
    <form action="index.php" method="post">
        <table class="table-auto">
        <?php for ($i=0; $i < 3; $i++) : ?>
            <tr style="border : 1px solid;">
                <?php for ($j=0; $j < 3; $j++) : ?>
                    <td style="border : 1px solid;">
                        <?php //echo $i; echo $j; ?>
                        <input type="text" name="board[<?= $i ?>][<?= $j ?>]" value="<?= isset($_POST['board'][$i][$j]) ? htmlspecialchars($_POST['board'][$i][$j]) : '' ?>" pattern="[XO]" >
                    </td>
                <?php   endfor; ?>
            </tr>
        <?php   endfor; ?>
        </table>

        <br>
        <input type="submit" name="submit" value="Play">
    </form>
</body>
</html>