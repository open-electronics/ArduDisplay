<?php

     Class DataB
     {
         var $mysql_server;
         var $mysql_username;
         var $mysql_pass;
         var $database_name;
         var $dbtype;
		 var $dbid;
         
         function DataB(){
			global $indirizzo_server;
			global $username;	
			global $password;
			global $nome_database;

			$this -> mysql_server = "localhost";
			$this -> mysql_username = "root";
			$this -> mysql_pass = "admin";
			$this -> database_name = "ardudisplay";
			$this -> dbid = "";
         }

         // =============================================
         // Funzione di apertura di una connessione al Db
         // =============================================
         function OpenDb(){
             //error_reporting (0);
             $dbid = mysql_connect($this->mysql_server, $this->mysql_username, $this->mysql_pass);
             if ($dbid == FALSE) {
                 echo    "Errore nella connessione al Database !";
             }
			 $this->dbid=$dbid;
             error_reporting (E_ALL);
         }
         
         // =============================================
         // Funzione di chiusura di una connessione al Db
         // =============================================
         function CloseDb(){
             return mysql_close($this->dbid);
         }
         
         // ================================================
         // Funzione di esecuzione di una query sul database
         // ================================================
         function QueryDb($query){
             error_reporting (0);
             $result = mysql_db_query ($this->database_name, $query, $this->dbid);
             if ($result == FALSE){
                 echo   "Errore nella query : ".$query;
             }
             error_reporting (E_ALL);
             return $result;
         }
         
         // ======================================================
         // Funzione per fare il retrieve dei dati dopo una query
         // restituisce un array con tutti i campi
         // ======================================================
         function FetchArray($dataset)
         {
             error_reporting (0);
             $row = mysql_fetch_array($dataset);
             error_reporting (E_ALL);
             return $row;
         }
         
         
         // ============================================================
         // Funzione che restituisce il numero di record di un recordset
         // ============================================================
         function CountRows($dataset){
             return mysql_num_rows($dataset);
         }

     }
?>
