<h1><em>Select Channels in chinese</em></h1>
<?php
echo "<p>".$_SESSION['time']."</p>";
print_r($_SESSION);

function printResult($result) { //prints results from a select statement
    echo "<table>";
    echo "<tr><th>Streamer_Name</th><th>ID</th><th>NumOfViewrs</th><th>Status</th><th>Language</th><th>Description</th><th>Title</th><th>Type</th></tr>";

    while ($row = oci_fetch_array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["STREAMER_NAME"] . "</td><td>" . $row["ID"] . "</td><td>" . $row["NUMOFVIEWRS"] . "</td><td>" . $row["STATUS"] . "</td><td>" . $row["LANGUAGE"] . "</td><td>" . $row["DESCRIPTION"] . "</td><td>" . $row["TITLE"] . "</td><td>" . $row["TYPE_NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
    }
    echo "</table>";
}

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if ($db_conn) {
	$country = 'Chinese';

    $cmdstr = "select * from channels where language='$country'";
    $statement = oci_parse($db_conn, $cmdstr);

    if(!$statement) {
        echo"<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = oci_error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = oci_execute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    } else {
        printResult($statement);
    }

    if ($success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        // header("location: demo.php");
    }

    //Commit to save changes...
    oci_close($db_conn);
} else {
    echo "cannot connect";
    $e = oci_error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}
?>