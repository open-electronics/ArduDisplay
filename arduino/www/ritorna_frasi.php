<?php

	/*
		File PHP richiamato da Arduino tramite Process,
		Arduino la chiama passandogli ID della frase corrente,
		ritorna ID_Nuova_Frase|Nuova_Frase
	*/
	
	require_once "Common/db_class.php";
	
	$db = new DataB();
	$db->OpenDb();	
	
	//Leggo impostazioni: CicloFrasi, FraseDefault
	
	$ciclo_frasi = "0";
	$frase_default = "";
	
	$sql = "SELECT CicloFrasi, FraseDefault FROM impostazioni";
	
	$result = $db->QueryDb($sql);
	
	while($row = $db->FetchArray($result)) {

		$ciclo_frasi = trim($row['CicloFrasi']);
		$frase_default = trim($row['FraseDefault']);
		
	}
	
	//Estraggo la prima frase oppure estraggo la frase successiva a quella appena mostrata sul display
	
	$id_frase = "";
	$frase = "";
	
	if($ciclo_frasi == "0") {
		$sql = "SELECT ID, Frase FROM frasi WHERE Stato = '1' ORDER BY ID LIMIT 1";
	} else {
		$sql = "SELECT ID, Frase FROM frasi WHERE Stato = '1' AND ID > '".$argv[1]."' ORDER BY ID LIMIT 1";
	}
	
	$result = $db->QueryDb($sql);
	
	while($row = $db->FetchArray($result)) {
	
		$id_frase = trim($row['ID']);
		$frase = trim($row['Frase']);
	
	}
	
	//Se trovo una frase la restituisco, altrimenti restituisco frase default
	
	if(trim($id_frase) == "" || trim($frase) == "") {
		
		$id_frase = -1;
		$frase = $frase_default;

	}
	
	//Se trovo una frase e il ciclo frasi non è attivo, cancello la frase
	
	if($ciclo_frasi == "0") {
	
		$sql = "DELETE FROM frasi WHERE ID = '".$id_frase."'";	
		$result = $db->QueryDb($sql);

	}
	
	//Restituisco nuova frase convertendo i caratteri accentati in caratteri normali con apostrofi
	
	echo convertiCaratteri($id_frase."|".$frase);
	
	$db->CloseDb();	
	
	
	
	
	
	
	function convertiCaratteri($frase) {
		$frase = str_replace("à", "a'", $frase);
		$frase = str_replace("è", "e'", $frase);
		$frase = str_replace("ì", "i'", $frase);
		$frase = str_replace("ò", "o'", $frase);
		$frase = str_replace("ù", "u'", $frase);
		return $frase;
	}

?>