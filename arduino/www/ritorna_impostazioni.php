<?php

	/*
		File PHP richiamato da Arduino tramite Process,
		ritorna impostazioni per display frase.	
	*/
	
	require_once "Common/db_class.php";

	$impostazioni = "";
	
	
	$db = new DataB();
	$db->OpenDb();	
	
	//Eseguo query su database per leggere impostazioni
	
	$sql = "SELECT DurataFraseDisplay, VelocitaScroll FROM impostazioni LIMIT 1";
	
	$result = $db->QueryDb($sql);
	
	while($row = $db->FetchArray($result)) {
	
		$impostazioni = $row['DurataFraseDisplay']."|".$row['VelocitaScroll'];
	
	}

	$db->CloseDb();	
	
	//Ritorno impostazioni
	
	echo $impostazioni;
	
?>