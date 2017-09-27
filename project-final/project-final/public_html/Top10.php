<style>
body{
    margin: 10% 15% 10% 15%;
}
#rich, #popular {
    display:inline-block;
    border: 1px solid white;
    outline: green dotted thick;
}
#rich {
    float:right;
}
#popular {
    float:left;
}
</style>

<body>
<?php
function printResult($result) { //prints results from a select statement
    echo '<div id="popular">';
    echo '<h1><em>Top 10 Popular Channels</em></h1>';
   	echo '<table >';
  	echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Title</th>';
    echo '<th>Num of Viewers</th>';
    echo '</tr>';
    while ($row = oci_fetch_array($result, OCI_BOTH)) {
	echo '<tr>';
	echo '<td>'.$row[0].'</td>';
        echo '<td> <a href =channel.php?CID='.$row[0].' target="_blank">'.$row[1]. '</a></td>'; 
	echo '<td>'.$row[2].'</td>';
	echo '</tr>';    
	}
   echo '</table>';
   echo '</div>';
}

function printResult1($result) { //prints results from a select statement
    echo '<div id="rich">';
    echo '<h1><em>Top 10 Rich Channels</em></h1>';
    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Title</th>';
    echo '<th>Total Donations Received</th>';
    echo '</tr>';
    while ($row = oci_fetch_array($result, OCI_BOTH)) {
    echo '<tr>';
    echo '<td>'.$row[0].'</td>';
        echo '<td> <a href =channel.php?CID='.$row[0].' target="_blank">'.$row[1]. '</a></td>'; 
    echo '<td>'.$row[2].'</td>';
    echo '</tr>';    
    }
   echo '</table>';
   echo '</div>';
}

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if ($db_conn) {

    $cmdstr = "select * from (select c.id,c.title,count(w.watcher_username) from Channels c,Watches w where c.id=w.id group by c.id,c.title ORDER BY count(w.watcher_username) desc) where rownum<=10";
    $statement = oci_parse($db_conn, $cmdstr);

    if(!$statement) {
        echo"<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = oci_error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = oci_execute($statement, OCI_COMMIT_ON_SUCCESS);
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

    $cmdstr = "select * from (select c.id,c.title,sum(d.amount) from Donations d,Channels c where c.streamer_username=d.donatee_username group by c.id,c.title ORDER BY sum(d.amount) desc) where rownum<=10";
    $statement = oci_parse($db_conn, $cmdstr);

    if(!$statement) {
        echo"<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = oci_error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = oci_execute($statement, OCI_COMMIT_ON_SUCCESS);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    } else {
        printResult1($statement);
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
</body>