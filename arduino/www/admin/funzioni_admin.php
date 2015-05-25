<?php

	/*
		Gestisce tutte le funzioni della pagina admin.php
		Esempio:
			carica impostazioni
			salva impostazioni
			restituisce la tabella delle frasi da approvare
			conferma frasi
			elimina frasi
	*/

	require_once "../Common/db_class.php";
	
	if(isset($_POST['Comando'])) {
		$Comando = trim($_POST['Comando']);
	} else {
		$Comando = "";
	}
	
	if(isset($_POST['Password'])) {
		$Password = trim($_POST['Password']);
	} else {
		$Password = "";
	}
	
	if(isset($_POST['Durata'])) {
		$Durata = trim($_POST['Durata']);
	} else {
		$Durata = 20;
	}
	
	if(isset($_POST['ApprovaFrasi'])) {
		$ApprovaFrasi = trim($_POST['ApprovaFrasi']);
	} else {
		$ApprovaFrasi = 1;
	}
	
	if(isset($_POST['CicloFrasi'])) {
		$CicloFrasi = trim($_POST['CicloFrasi']);
	} else {
		$CicloFrasi = 0;
	}
	
	if(isset($_POST['FraseDefault'])) {
		$FraseDefault = mysql_real_escape_string(trim($_POST['FraseDefault']));
	} else {
		$FraseDefault = "";
	}
	
	if(isset($_POST['VelocitaScroll'])) {
		$VelocitaScroll = trim($_POST['VelocitaScroll']);
	} else {
		$VelocitaScroll = 0;
	}
	
	if(isset($_POST['IDFrase'])) {
		$IDFrase = trim($_POST['IDFrase']);
	} else {
		$IDFrase = "";
	}

	
	$db = new DataB();
	$db->OpenDb();	
	
	
	if($Comando == "CaricaImpostazioni") {
	
		$sql = "SELECT Password, DurataFraseDisplay, ApprovaFrasi, FraseDefault, VelocitaScroll, CicloFrasi FROM impostazioni LIMIT 1";
		
		$result = $db->QueryDb($sql);
		
		while($row = $db->FetchArray($result)) {
		
			echo $row['Password']."|>".$row['DurataFraseDisplay']."|>".$row['ApprovaFrasi']."|>".$row['FraseDefault']."|>".$row['VelocitaScroll']."|>".$row['CicloFrasi'];
		
		}
	
	}
	
	if($Comando == "SalvaImpostazioni") {
	
		$sql = "UPDATE impostazioni SET Password = '".$Password."', DurataFraseDisplay = '".$Durata."', ApprovaFrasi = '".$ApprovaFrasi."', FraseDefault = '".$FraseDefault."', VelocitaScroll = '".$VelocitaScroll."', CicloFrasi = '".$CicloFrasi."'";
	
		$result = $db->QueryDb($sql);
		
		if ($result === FALSE) {
			echo "Errore";
		} else {
			echo "Ok";
		}
	
	}
	
	if($Comando == "AggiornaFrasi") {
	
		$elenco_frasi = "";
	
		$sql = "SELECT ID, Frase FROM frasi WHERE Stato = '0' ORDER BY ID";
		
		$result = $db->QueryDb($sql);
		
		while($row = $db->FetchArray($result)) {
		
			$elenco_frasi .= "<img src = '../Common/conferma.png' onClick = 'confermaFrase(".$row['ID'].");'>&nbsp;<img src = '../Common/elimina.png' onClick = 'eliminaFrase(".$row['ID'].");'>&nbsp;".$row['Frase']."<br>";
		
		}
		
		echo $elenco_frasi;
	
	}
	
	if($Comando == "AggiornaCoda") {
	
		$elenco_frasi = "";
	
		$sql = "SELECT ID, Frase FROM frasi WHERE Stato = '1' ORDER BY ID";
		
		$result = $db->QueryDb($sql);
		
		while($row = $db->FetchArray($result)) {
		
			$elenco_frasi .= "<img src = '../Common/elimina.png' onClick = 'eliminaFrase(".$row['ID'].");'>&nbsp;".$row['Frase']."<br>";
		
		}
		
		echo $elenco_frasi;
	
	}
	
	if($Comando == "ConfermaFrase") {
	
		$sql = "UPDATE frasi SET Stato = '1' WHERE ID = '".$IDFrase."'";
	
		$result = $db->QueryDb($sql);
		
		if ($result === FALSE) {
			echo "Errore";
		} else {
			echo "Ok";
		}
	
	}
	
	if($Comando == "EliminaFrase") {
	
		$sql = "DELETE FROM frasi WHERE ID = '".$IDFrase."'";
	
		$result = $db->QueryDb($sql);
		
		if ($result === FALSE) {
			echo "Errore";
		} else {
			echo "Ok";
		}
	
	}
	
	
	$db->CloseDb();	

	
?>