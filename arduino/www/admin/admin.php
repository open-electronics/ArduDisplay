<?php

	//Controllo se l'utente ha effettuato il login, altrimenti lo rimando indietro

	if(!isset($_COOKIE["Login-ArduDisplay"]) || trim($_COOKIE["Login-ArduDisplay"]) == "") {
		header("Location: index.php");
	}

?>
<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Admin</title>
		<link rel="stylesheet" type="text/css" href="../Common/style.css">		
		<script type = "text/javascript" src="../Common/jquery-1.11.1.min.js"></script>
		<script type = "text/javascript">

			function caricaImpostazioni() {
			
				$.post("funzioni_admin.php", {Comando : "CaricaImpostazioni"}, function(risposta) {

					var impostazioni = risposta.split("|>");
					
					$('#Password').val(impostazioni[0]);
					$('#Durata').val(impostazioni[1]);
					$('#ApprovaFrasi').val(impostazioni[2]);
					$('#FraseDefault').val(impostazioni[3]);
					$('#VelocitaScroll').val(impostazioni[4]);
					$('#CicloFrasi').val(impostazioni[5]);

				});
			
			}
		
			function salvaImpostazioni() {
			
				$.post("funzioni_admin.php", {Comando : "SalvaImpostazioni", Password: $('#Password').val() , Durata : $('#Durata').val(), ApprovaFrasi : $('#ApprovaFrasi').val(), FraseDefault : $('#FraseDefault').val(), VelocitaScroll : $('#VelocitaScroll').val(), CicloFrasi : $('#CicloFrasi').val()}, function(risposta) {

					if(risposta == "Ok") {
						alert("Impostazioni salvate.");
					}

				});
			
			}
			
			function confermaFrase(id) {
			
				$.post("funzioni_admin.php", {Comando : "ConfermaFrase", IDFrase : id}, function(risposta) {

					if(risposta == "Ok") {
						aggiornaFrasi();
					}

				});
			
			}
			
			function eliminaFrase(id) {
			
				$.post("funzioni_admin.php", {Comando : "EliminaFrase", IDFrase : id}, function(risposta) {

					if(risposta == "Ok") {
						aggiornaFrasi();
					}

				});
			
			}
		
			function aggiornaFrasi() {
			
				$.post("funzioni_admin.php", {Comando : "AggiornaFrasi"}, function(risposta) {

					$('#ElencoFrasi').html(risposta);
					
					$.post("funzioni_admin.php", {Comando : "AggiornaCoda"}, function(risposta) {

						$('#Coda').html(risposta);
						refreshAutomatico($('#RefreshAuto').val());
						
					});
					
				});
				


			}
			
			function refreshAutomatico(millis) {

				if(millis != 0) {
					$('#Refresh').attr("disabled", "disabled");
					setTimeout(function() {aggiornaFrasi();}, millis);
				} else {
					$('#Refresh').removeAttr("disabled");
				}
			
			}
		</script>
	</head>
	
	<body onLoad = "aggiornaFrasi(); caricaImpostazioni();">
		
		<br>
	
		<div align = "center">
	
			<table style = "width: 70%; height: 400px;" border = "1">
			
				<tr style = "height: 25px;">
				
					<td style = "width: 70%;" colspan = "2">
						<b>Frasi</b>
						
						&nbsp;&nbsp;&nbsp;&nbsp;

						Refresh automatico:
						<select id = "RefreshAuto" size = "1" onChange = "refreshAutomatico(this.value);">
							<option value = "0">Mai</option>
							<option value = "5000" SELECTED>5 secondi</option>
							<option value = "10000">10 secondi</option>
							<option value = "20000">20 secondi</option>
							<option value = "60000">60 secondi</option>
						</select>
						|
						<input type = "button" id = "Refresh" value = "Refresh manuale" onClick = "aggiornaFrasi();">
					</td>
				
					<td style = "width: 30%;">
						<b>Impostazioni</b>
					</td>
				
				</tr>
				
				<tr>
				
					<td style = "width: 35%; vertical-align: top;">
					
						<b>Frasi da approvare:</b>
					
						<div id = "ElencoFrasi" style = "width: 100%; height: 400px; overflow-y: scroll;"></div>
					
					</td>
					
					<td style = "width: 35%; vertical-align: top;">
					
						<b>Coda di visualizzazione:</b>
					
						<div id = "Coda" style = "width: 100%; height: 400px; overflow-y: scroll;"></div>
					
					</td>
					
					<td style = "width: 30%; vertical-align: top; ">
					
						<br>
						Password admin:	<input type = "text" id = "Password" value = "" size = "10">
						<br>
						Durata frase display:	<input type = "text" id = "Durata" value = "" size = "2"> (Secondi)
						<br>
						Velocit&agrave; scroll:	<select id = "VelocitaScroll" size = "1"><option value = "20">Alta</option><option value = "50">Media</option><option value = "100">Bassa</option></select>
						<br>
						Approva frasi:	<select id = "ApprovaFrasi" size = "1"><option value = "1">S&igrave;</option><option value = "0">No</option></select>
						<br>
						Ciclo frasi:	<select id = "CicloFrasi" size = "1"><option value = "1">S&igrave;</option><option value = "0">No</option></select>
						<br>
						Frase default:	<input type = "text" id = "FraseDefault" value = "" size = "20">
						<br><br>
						<input type = "button" id = "Salva" value = "Salva" onClick = "salvaImpostazioni();">
						<br><br><br><br>
						<p align = "right">
							<input type = "button" id = "Logout" value = "Logout" onClick = "location.replace('logout.php');">
						<p>

					</td>
				
				</tr>
			
			</table>
			
		</div>
		
	</body>
	
</html>