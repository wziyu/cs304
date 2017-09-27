<h1><em>Search Result</em></h1>
<h2>Users<h2>
<?php
include("execute.php");

function printResult($result) { //prints results from a select statement


    while ($row = oci_fetch_array($result, OCI_BOTH)) {
        echo  $row[0].$row[1].$row[2]. '</br>'; 
    }

}


    $sid=$_COOKIE["searchID"];

    $cmdstr = "select u.username from Users u where u.username like '%$sid%'  ";
    $statement = executeSQL($cmdstr);
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {
        echo'<a href =profile.php?username='.$row[0].' target="_blank"> '.$row[0].'</a> </br>';
    }
    echo'---------------------------------------------------------------------</br>';
    echo '<h2>Channels<h2>';
    $cmdstr = "select ID,streamer_username from Channels  where ID like '%$sid%'or streamer_username like '%$sid%'  ";
    $statement = executeSQL($cmdstr);
    while ($row = oci_fetch_array($statement, OCI_BOTH)) {
        echo'<a href =channel.php?CID='.$row[0].' target="_blank"> '.$row[1].'</a> </br>';
    }


?>