<?php

	require_once "Common/db_class.php";

	//Ricevo la frase e la inserisco nel database
		
	if(isset($_POST['Frase']) && trim($_POST['Frase']) != "") {
	
		$frase = mysql_real_escape_string(trim($_POST['Frase']));
	
		$db = new DataB();
		$db->OpenDb();	

		//Controllo se devo approvare le frasi o no
		
		$stato_frase = 0;
		
		$sql = "SELECT ApprovaFrasi FROM impostazioni LIMIT 1";

		$result = $db->QueryDb($sql);
		
		while($row = $db->FetchArray($result)) {
	
			if($row['ApprovaFrasi'] == "0") {
				$stato_frase = 1;
			}
		
		}
		
		//Inserisco la frase
		
		$sql = "INSERT INTO frasi (Frase, Stato) VALUES ('".$frase."', ".$stato_frase.")";

		$result = $db->QueryDb($sql);
		
		if ($result === FALSE) {
			echo "Errore";
		} else {
			echo "Ok";
		}
		
		$db->CloseDb();	

	} else {
	
		echo "Errore";
	
	}

?>