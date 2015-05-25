<?php

	require_once "../Common/db_class.php";
	
	//Riceve la password, se è giusta crea la sessione utente
		
	if(isset($_POST['Password']) && trim($_POST['Password']) != "") {
	
		$password = trim($_POST['Password']);
	
		$db = new DataB();
		$db->OpenDb();	

		$sql = "SELECT Password FROM impostazioni WHERE Password = '".$password."'";
		
		$result = $db->QueryDb($sql);
		
		if($db->CountRows($result) > 0) {

			setcookie("Login-ArduDisplay", time(), time() + (86400 * 30), "/");
		
			echo "Ok";
		
		} else {
		
			echo "Errore";
			
		}
		
		$db->CloseDb();	

	} else {
	
		echo "Errore";
	
	}

?>