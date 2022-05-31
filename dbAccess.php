<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=football", "root", "");

function showLeague()
{
    global $db;
    $statement = $db->query("SELECT DISTINCT `league` FROM team");
    while ($data = $statement->fetch()) {
        echo "<option value='$data[0]'>$data[0]</option>";
    }
}

function showPlayers()
{
    global $db;
    $statement = $db->query("SELECT `name` FROM player");
    while ($data = $statement->fetch()) {
        echo "<option value='$data[0]'>$data[0]</option>";
    }
}

function findLeague($league)
{
    global $db;
    $statement = $db->prepare("SELECT `name`, league, coach FROM team WHERE league=?");
    $statement->execute([$league]);
    $str = "<table>";
    $str .= " <tr>
     <th> Title  </th>
     <th> League </th>
     <th> Coach </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        $str .= " <tr>
         <th> {$data['name']}  </th>
         <th> {$data['league']} </th>
         <th> {$data['coach']} </th>
        </tr> ";
    }
    $str .= "</table>";
    echo $str;
}

function findGames($start, $stop)
{
    global $db;
    $statement = $db->prepare("
    SELECT `date`, `place`, score, a.name as 'team1', b.name as 'team2'
    FROM game INNER JOIN team as a on FID_Team1 = a.ID_Team
    INNER JOIN team as b on FID_Team2 = b.ID_Team
    WHERE `date` BETWEEN ? AND ?
    ");
    $statement->execute([$start, $stop]);
    $str = "<table>";
    $str .= " <tr>
     <th> Date  </th>
     <th> Place  </th>
     <th> Score </th>
     <th> Team One </th>
     <th> Team Two </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        $str .= " <tr>
         <th> {$data['date']}  </th>
         <th> {$data['place']}  </th>
         <th> {$data['score']} </th>
         <th> {$data['team1']} </th>
         <th> {$data['team2']} </th>
        </tr> ";
    }
    $str .= "</table>";
    echo json_encode($str);
}

function findPlayer($player)
{
    global $db;
    $statement = $db->prepare("
    SELECT player.name as 'name', a.name as 'title', league, `date`, place 
    FROM player INNER JOIN team as a ON FID_Team = ID_Team
    INNER JOIN game ON (ID_Team = FID_Team1 OR ID_Team = FID_Team2)
    WHERE  player.name = ?");
    $statement->execute([$player]);
    $str = "<table>";
    $str .= " <tr>
     <th> Name  </th>
     <th> Title  </th>
     <th> League </th>
     <th> Date </th>
     <th> Place </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        $str .= " <tr>
         <th> {$data['name']}  </th>
         <th> {$data['title']}  </th>
         <th> {$data['league']} </th>
         <th> {$data['date']} </th>
         <th> {$data['place']} </th>
        </tr> ";
    }
    $str .= "</table>";
    echo $str;
}


if (isset($_POST["league"])) {
    findLeague($_POST["league"]);
} elseif (isset($_POST["start"])) {
    findGames($_POST["start"], $_POST["stop"]);
} elseif (isset($_POST["player"])) {
    findPlayer($_POST["player"]);
}
