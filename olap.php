<?php


if($_POST["action"] == "getQuarterlyCount") {
    getQuarterlyCount($_POST['year']);
    //getWinner($_POST['user1'],$_POST['user2'],$_POST['pokemon1'],$_POST['pokemon2']);
}


function getQuarterlyCount($year) {

	try {

	$servername = "localhost";
	$username = "root";
	$password = "sesame";
	$dbname = "CMPE226FinalProject";

	$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 $results = array();

	    foreach($connection->query("SELECT YEAR(Time) as Year, QUARTER(Time) as Quarter, COUNT(*) as BATTLE_COUNT FROM battles WHERE YEAR(Time)='".$year."' GROUP BY YEAR(Time), QUARTER(Time)") as $row) {
	        //echo '<tr><td>'.$row['pokemon_id'].'</td><td>'.$row['Level'].'</td></tr><br>';
	        //$pokemons[$index] = $row['pokemon_id'];
	       // $index++;
	        array_push($results,$row['BATTLE_COUNT']);
	    }

	    header('Content-type: application/json');
	    echo json_encode($results);
	} catch(PDOException $e) {
		echo json_encode( "{error:".$e->getMessage()."}" );
	}
	
}

function getYearlyCount($year) {

	try {

	$servername = "localhost";
	$username = "root";
	$password = "sesame";
	$dbname = "CMPE226FinalProject";

	$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 $results = array();

	    foreach($connection->query("SELECT YEAR(Time) as year, COUNT(*) as BATTLE_COUNT FROM battles GROUP BY YEAR(Time)") as $row) {
	        //echo '<tr><td>'.$row['pokemon_id'].'</td><td>'.$row['Level'].'</td></tr><br>';
	        //$pokemons[$index] = $row['pokemon_id'];
	       // $index++;
	        array_push($results,$row['BATTLE_COUNT']);
	    }

	    header('Content-type: application/json');
	    echo json_encode($results);
	} catch(PDOException $e) {
		echo json_encode( "{error:".$e->getMessage()."}" );
	}
	
}
