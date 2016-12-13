<?php


if($_POST["action"] == "getQuarterlyCount") {
    getQuarterlyCount($_POST['year']);
} else if($_POST["action"] == "getYearlyCount") {
	getYearlyCount();
} else if($_POST["action"] == "getMontlyCount") {
	getMontlyCount($_POST['year']);
}

//function used to get the Quarterly Count as per the year entered
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

//function used to get the Yearly Count
function getYearlyCount() {

	try {

	$servername = "localhost";
	$username = "root";
	$password = "sesame";
	$dbname = "CMPE226FinalProject";

	$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$results = array();

	foreach($connection->query("SELECT YEAR(Time) as year, COUNT(*) as BATTLE_COUNT FROM battles GROUP BY YEAR(Time)") as $row) {
	    	if($row['year'] != "0") {
	    		 array_push($results,"* Year: ".$row['year']." - ".$row['BATTLE_COUNT']."<br>");
	    	}
	       
	 }

	    header('Content-type: application/json');
	    echo json_encode($results);
	} catch(PDOException $e) {
		echo json_encode( "{error:".$e->getMessage()."}" );
	}
	
}

//function used to get the Monthly Count as per the year entered
function getMontlyCount($year) {

	try {

	$servername = "localhost";
	$username = "root";
	$password = "sesame";
	$dbname = "CMPE226FinalProject";

	$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$results = array();

	foreach($connection->query("SELECT MONTH(Time) as Month, COUNT(*) as BATTLE_COUNT FROM battles WHERE YEAR(Time)='".$year."' GROUP BY MONTH(Time)") as $row) {
	    	//if($row['year'] != "0") {
	    		 array_push($results,"* Month ".$row['Month']." - ".$row['BATTLE_COUNT']."<br>");
	    	//}
	       
	 }

	    header('Content-type: application/json');
	    echo json_encode($results);
	} catch(PDOException $e) {
		echo json_encode( "{error:".$e->getMessage()."}" );
	}
	
}
