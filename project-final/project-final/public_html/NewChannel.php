<?php
include"execute.php";

$username=$_COOKIE['uname'];
$title = $_COOKIE['title'];
$description = $_COOKIE['description'];
$type = $_COOKIE['type'];
$language = $_COOKIE['language'];
$platform = $_COOKIE['platform'];
$gamename = $_COOKIE['gamename'];
$showtype = $_COOKIE['showtype'];
$id= ord(strtolower($_COOKIE['uname'])) - 96 . (time());
$status="online";

//connect_prepare_execute_fetch_close
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if ($db_conn) {
    // add to users table
    $cmdstr = "insert into Channels values('$username','$id','$status', '$language','$description','$title')";
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
        setcookie('duplicate_user',true,time()+3600,'/');
        header("location: createChannel.php");
    }

    if ($success) {
        oci_commit($db_conn);
    }


} else {
    echo "cannot connect";
    $e = oci_error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}



if($type="Game"){
    $cmdstr1 = "insert into game_channels values('$id','$gamename', '$platform')";
    $result=executeSQL($cmdstr1);
  }
    
   
  else if($type="Show"){
    $cmdstr2 = "insert into show_channels values('$id','$showtype')";
    $result=executeSQL($cmdstr2);
  } 
    echo "<a href='channel.php?CID=".$id."'> Go to your page</a>";
    oci_close($db_conn);
   

?>