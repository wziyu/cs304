<?php

$uname = $_COOKIE['uname'];
$pwd = $_COOKIE['pwd'];
$gender = $_COOKIE['gender'];

//connect_prepare_execute_fetch_close
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if ($db_conn) {
    // add to users table
    $cmdstr = "insert into users values('$uname','$gender', sysdate, '$pwd')";
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
        header("location: register.php");
    }

    if ($success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        oci_commit($db_conn);
        header("location: RegUser.php");
    }

    //Commit to save changes...
    oci_close($db_conn);
} else {
    echo "cannot connect";
    $e = oci_error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>