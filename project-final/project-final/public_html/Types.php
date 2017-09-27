<!DOCTYPE html>
<html>
<?php


//connect_prepare_execute_fetch_close
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if ($db_conn) {
}
 else {
    echo "cannot connect";
    $e = oci_error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); 
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;
}
?>

<head>
<meta charset="utf-8">
<style>
.error {color: #FF0000;}


#game {
    //display:inline-block;
    float:left; 
    text-align: center;
    color: #017572;
}

#show {
    //display:inline-block;
    float:right; 
    text-align: center;
    color: #017572;
}

</style>
</head>

<body>

<div id='game'>
   
     <?php
    	echo "<strong><em>Game</em></strong>"; 
	$cmdr1="select c.title,g.gname,c.id from channels c,game_channels g where c.ID=g.ID order by gname";
	$statement=executePlainSQL($cmdr1);
	echo '<table>';
  	echo '<tr>';
    echo '<th>Title</th>';
    echo '<th>GameName</th>';
    echo '</tr>';
	while ($row = oci_fetch_array($statement, OCI_BOTH)) {
		echo '<tr>';
		echo '<td> <a href=channel.php?CID='.$row[2].' target="_blank">'.$row[0].'</a></td>' ;
		echo '<td>'.$row[1].'</td>';
		echo '</tr>';
    }
	echo '</table>';
  	 ?>
  
</div>

<div id='show'>
   
    <?php 
	echo "<strong><em>Show</em></strong>"; 
  	$cmdr2="select c.title,s.type,c.id from channels c,show_channels s where c.id=s.id order by type";
	$statement=executePlainSQL($cmdr2);
	echo '<table>';
  	echo '<tr>';
    echo '<th>Title</th>';
    echo '<th>Type</th>';
    echo '</tr>';
	while ($row = oci_fetch_array($statement, OCI_BOTH)) {
		echo '<tr>';
		echo '<td> <a href=channel.php?CID='.$row[2].' target="_blank">'.$row[0].'</a></td>' ;
		echo '<td>'.$row[1].'</td>';
		echo '</tr>';
    }
	echo '</table>';


	?>
</div>

</body>

</html>