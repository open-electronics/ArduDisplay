<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Scrivi!</title>
		<link rel="stylesheet" type="text/css" href="Common/style.css">		
		<script type = "text/javascript" src="Common/jquery-1.11.1.min.js"></script>
		<script type = "text/javascript">
			function inviaFrase() {
			
				document.getElementById("Invia").disabled = true;
				
				$.post("invia_frasi.php", {Frase : $('#frase').val()}, function(risposta) {

					if(risposta == "Ok") {
					
						$('#content').html("<h1>Messaggio inviato correttamente.</h1><br><input type = 'button' id = 'Invia' value = 'Invia altri messaggi' onClick = \"location.replace('index.php');\" >");
					
					} else {
					
						$('#content').html("<h1>Errore di invio.</h1>");
					
					}

				});
				
			}
			
			function controllaInvio() {
				var tasto = window.event.keyCode;
				if (tasto == 13) {
					inviaFrase();
				}
			}
		</script>
	</head>
	
	<body>
	
		<div id = "content" align = "center">
			
			<br><br>			
			<input type = "text" id = "frase" value = "" size = "40" maxlength = "50" placeholder = "Scrivi qui il tuo messaggio!" onKeyDown = "controllaInvio();">
			<br><br><br><br>
			<input type = "button" id = "Invia" value = "Invia" onClick = "inviaFrase();" >

		</div>
		
	</body>
	
</html>