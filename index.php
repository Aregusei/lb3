<?php
require_once __DIR__ . "/dbAccess.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="script.js"></script>
    <title>AJAX</title>
</head>
<body style="display: flex">

<div class="forms">
    <form action="dbAccess.php" method="post" id="league">
        <select name="league">
            <?php
            showLeague();
            ?>
        </select>
        <input type="submit" value="Submit"><br>
    </form>
    <br>
    <form action="dbAccess.php" method="post" id="games">
        <label>Choose the time interval:</label>
        <input type="datetime-local" name="start">
        <input type="datetime-local" name="stop">
        <input type="submit" value="Submit"><br>
    </form>
    <br>
    <form action="dbAccess.php" method="post" id="player">
        <select name="player">
            <?php
            showPlayers();
            ?>
        </select>
        <input type="submit" value="Submit"><br>
    </form>
</div>

<div id="content" style="display: block; border: 1px solid black; margin-left: 300px; padding: 20px">

</div>
</body>
</html>
