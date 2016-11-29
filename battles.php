<?php
/**
 * Created by PhpStorm.
 * User: stealz
 * Date: 11/28/16
 * Time: 5:23 PM
 */


//$servername = "localhost";
//$username = "root";
//$password = "sesame";
//$dbname = "cmpe226_assignment7";
//
//$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//
//$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_POST["action"] == "getWinner") {
    getWinner($_POST['user1'],$_POST['user2'],$_POST['pokemon1'],$_POST['pokemon2']);
} else if($_POST["action"] == "fetchUser") {
    fetchUser($_POST['user1']);
} else if($_POST["action"] == "fetchUserData") {
    fetchUserData($_POST['user1'], $_POST['pokemon1']);
}

function getWinner($user1, $user2, $pokemon1, $pokemon2) {

    $users = array($user1, $user2);

    $key = array_rand($users);

    $winner = array('winner'=>$users[$key]);

    // try {

    //     $servername = "localhost";
    //     $username = "root";
    //     $password = "sesame";
    //     $dbname = "cmpe226_assignment7";

    //     $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //     // $stmt = $connection->prepare("INSERT INTO battles (Pokemon1_Id, Pokemon2_Id, User1_Id, User2_Id, Time)
    //     // VALUES (:pokemon1, :pokemon2, :user1, :user2, :time)");
    //     // $stmt->bindParam(':pokemon1', $user1);
    //     // $stmt->bindParam(':pokemon2', $user2);
    //     // $stmt->bindParam(':user1', $pokemon1);
    //     // $stmt->bindParam(':user2', $pokemon2);
    //     // $now = new DateTime();
    //     // $now = $now->format('d/m/Y');
    //     // $stmt->bindParam(':time', $now);

    //     // $stmt->execute();


    //     $servername = "localhost";
    //     $username = "root";
    //     $password = "sesame";
    //     $dbname = "cmpe226_operational";

    //     $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $stmt = $connection->prepare("INSERT INTO battles (pokemon1_Id, pokemon2_Id, user1_Id, user2_Id, time)
    //     VALUES (:pokemon1, :pokemon2, :user1, :user2, :time)");
    //     $stmt->bindParam(':pokemon1', $pokemon1);
    //     $stmt->bindParam(':pokemon2', $pokemon2);
    //     $stmt->bindParam(':user1', $user1);
    //     $stmt->bindParam(':user2', $user2);
    //     $now = new DateTime();
    //     $now = $now->format('d/m/Y');
    //     $stmt->bindParam(':time', $now);

    //     $stmt->execute();

    //     header('Content-type: application/json');
    //     echo json_encode( $winner );

    // } catch (PDOException $e) {
    //     echo json_encode( "{error:".$e->getMessage()."}" );

    // }

    echo json_encode( $winner );
    //return json_encode($winner);
}

function fetchUser($user_id) {


    $servername = "localhost";
    $username = "root";
    $password = "sesame";
    $dbname = "cmpe226_operational";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pokemons = array();

    //$index = 0;
    foreach($connection->query('SELECT * FROM User_Pokedex WHERE user_id='.$user_id.'') as $row) {
        //echo '<tr><td>'.$row['pokemon_id'].'</td><td>'.$row['Level'].'</td></tr><br>';
        //$pokemons[$index] = $row['pokemon_id'];
       // $index++;
        array_push($pokemons,$row['pokemon_id']);
    }

    header('Content-type: application/json');
    echo json_encode($pokemons);
}

function fetchUserData($user_id, $pokemon_id) {


    $servername = "localhost";
    $username = "root";
    $password = "sesame";
    $dbname = "cmpe226_operational";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pokemons = array();

    //$index = 0;
    foreach($connection->query('SELECT p.pokemon_name as pokemon_name, u.name as name FROM User_Pokedex upx, User u, Pokemons p WHERE upx.pokemon_id=p.pokemon_id AND u.user_id = upx.user_id AND upx.pokemon_id='.$pokemon_id.' AND upx.user_id='.$user_id.'') as $row) {
        //echo '<tr><td>'.$row['pokemon_id'].'</td><td>'.$row['Level'].'</td></tr><br>';
        //$pokemons[$index] = $row['pokemon_id'];
       // $index++;
        array_push($pokemons,$row['pokemon_name']);
        array_push($pokemons,$row['name']);
    }

    header('Content-type: application/json');
    echo json_encode($pokemons);
}