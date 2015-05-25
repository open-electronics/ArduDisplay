<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="../Common/style.css">		
		<script type = "text/javascript" src="../Common/jquery-1.11.1.min.js"></script>
		<script type = "text/javascript">
			function login() {
			
				document.getElementById("Login").disabled = true;
				
				$.post("login.php", {Password : $('#psw').val()}, function(risposta) {

					if(risposta == "Ok") {
					
						location.replace("admin.php");
					
					} else {
					
						$('#messaggio').html("<h2>Password non corretta.</h2>");
						document.getElementById("Login").disabled = false;
					
					}

				});
				
			}

			function controllaInvio() {
				var tasto = window.event.keyCode;
				if (tasto == 13) {
					login();
				}
			}
		</script>
	</head>
	
	<body>
	
		<div id = "content" align = "center">
			
			<input type = "password" id = "psw" value = "" size = "20" onKeyDown = "controllaInvio();">
			<br><br>
			<input type = "button" id = "Login" value = "Login" onClick = "login();">

		</div>
		
		<br>
		
		<div id = "messaggio" align = "center"></div>
		
	</body>
	
</html>