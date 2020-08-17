<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="requet.js"></script>
</head>
<body>
	<?php 
 		
		 echo "<table style='border: solid 1px black;'class='Tab'>";
		 echo "<tr><th>Id</th><th>nom</th><th>adresse</th></tr>";

		 class TableRows extends RecursiveIteratorIterator {
		    function __construct($it) {
		        parent::__construct($it, self::LEAVES_ONLY);
		    }

		    function current() {
		        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
		    }

		    function beginChildren() {
		        echo "<tr>";
		    }

		    function endChildren() {
		        echo "</tr>" . "\n";
		    }
		}


		try {
		    $conn = new PDO("mysql:host=localhost;dbname=test", 'root', '');
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT id, name, age, adresse FROM personnes");
		    $stmt->execute();

		    // set the resulting array to associative
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
		        echo $v;
		    }
		}
		catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}
		$conn = null;
		echo "</table>";

 	?>
	 <form method="post" action="controlleur_login2.php">
	 	<label for="name">Nom</label>
	 	<input type="text" name="name" id="name"><br>
	 	<label for="age">Age</label>
	 	<input type="number" name="age" id="age"><br>
	 	<label for="mail">E-mail</label>
	 	<input type="text" name="mail" id="mail"><br>
	 	<input type="submit" name="ajout" value="ajouter">
	 	<!--<input type="button"  onclick="Validation(event)" value="envoyer JS">-->
	 </form>
	 <h3>Suppression et modification</h3>
	 <form method="post" action="modif.php">
	 	<p>Entrer un numero <input type="number" name="ind"></p>
	 	<p>Entrer un nouveau nom <input type="text" name="nom"></p>
	 	<input type="submit" name="modif" value="modifier">
	 	<input type="submit" name="suppr" value="supprimer" id="delete">
	 </form>
	 <input placeholder="Recherche par nom" type="text" id="search" onkeyup="requête(this.value)">	
	 <p id="table_load"></p>

	 <script type="text/javascript">
	 	var bouton= document.getElementById('delete');
	 	bouton.addEventListener('click',changeAction);
	 	function changeAction() {
	 		document.getElementsByTagName('form')[1].action="suppr.php";
	 	}
	 </script>
	 <script type="text/javascript">
	 	var tab= document.querySelector('td');
      	tab.addEventListener('click',changeCouleur);
      	function changeCouleur() {
        	this.style.color= 'orange';
      	}
	 </script>
</body>
</html>