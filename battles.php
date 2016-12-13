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
} else if($_POST["action"] == "registerUser") {
    registerUser($_POST['userId'], $_POST['password'], $_POST['gender'], $_POST['deviceType'], $_POST['paymentMethod']);
} else if($_POST["action"] == "loginUser") {
    loginUser($_POST['user_id'], $_POST['password']);
} else if($_POST["action"] == "buyItems") {
    buyItems($_POST['user_id'], $_POST['eggs'], $_POST['sticks'], $_POST['pokeballs'], $_POST['coins'], $_POST['potions']);
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

function registerUser($name, $gender, $device_type, $payment_method) {

    $servername = "localhost";
    $username = "root";
    $password = "sesame";
    $dbname = "cmpe226_operational";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pokemons = array();

    $max_user = "0";

    foreach($connection->query('SELECT MAX(user_id) as user_id from User') as $row) {
        $max_user = $row['user_id'];
    }    

    $statement = $connection->prepare("INSERT INTO User(user_id, name, gender, device_type, payment_method, level)
    VALUES(:user_id, :name, :gender, :device_type, :payment_method, 0)");
    $statement->execute(array(
        "user_id" => ($max_user+1),
        "name" => $name,
        "gender" => $gender,
        "device_type" => $device_type,
        "payment_method" => $payment_method
    ));

    array_push($pokemons,"Inserted");
    header('Content-type: application/json');
    echo json_encode($pokemons);
}

function loginUser($user_id, $password_sent) {


    $servername = "localhost";
    $username = "root";
    $password = "sesame";
    $dbname = "cmpe226_operational";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pokemons = array();

    //$index = 0;
    foreach($connection->query("SELECT * FROM Login WHERE user_id=".$user_id." AND password='".$password_sent."';") as $row) {

            if($row['user_id'] > 0) {
                array_push($pokemons,"Success");
            } else {
                array_push($pokemons,"Error");  
            }
            
    }

   header('Content-type: application/json');
    echo json_encode($pokemons);
}

function buyItems($user_id, $eggs, $incense_sticks, $pokeballs, $coins, $potions) {
    $servername = "localhost";
    $username = "root";
    $password = "sesame";
    $dbname = "cmpe226_operational";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pokemons = array();

    $max_user = 0;

    foreach($connection->query('SELECT user_id from User_resources WHERE user_id='.$user_id.'') as $row) {
        $max_user = $row['user_id'];
    }    

    if($max_user == 0) {
            $statement = $connection->prepare("INSERT INTO User_resources(user_id, pokeballs, eggs, coins, incense_sticks, potions)
        VALUES(:user_id, :pokeballs, :eggs, :coins, :incense_sticks, :potions)");
        $statement->execute(array(
            "user_id" => $user_id,
            "pokeballs" => $pokeballs,
            "eggs" => $eggs,
            "coins" => $coins,
            "incense_sticks" => $incense_sticks,
            "potions" => $potions
        ));

        array_push($pokemons,"Inserted Successfully");
        header('Content-type: application/json');
        echo json_encode($pokemons);
    } else {
            $update_query = "UPDATE User_resources SET pokeballs=".$pokeballs.", eggs = ".$eggs.", coins=".$coins.", incense_sticks=".$incense_sticks.", potions=".$potions." WHERE user_id=".$user_id."";

            if($connection->query($update_query) == true) {
                array_push($pokemons,"Inserted Successfully");
            } else {
                array_push($pokemons,"Unable to Insert the for the selected user");
            }
        
        header('Content-type: application/json');
        echo json_encode($pokemons);
    }
}