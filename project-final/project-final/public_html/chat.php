<!DOCTYPE html>
<html>
<head>
<style>
#chat {
    display:inline-block;
    border: 1px solid white;
    outline: green dotted thick;
}
#chatmsg {
    overflow-y: scroll;
    height:400px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$( document ).ready(function() {
	$('#chatmsg').scrollTop($('#chatmsg')[0].scrollHeight);
});
</script>
</head>

<div id='chat'>
<div id='chatmsg'>
<?php

if(!empty($_GET['CID'])) {
    $CID = $_GET['CID'];
    setcookie('CID',$CID,time()+3600,'/');
} else {
    $CID = $_COOKIE['CID'];
}

if (array_key_exists('sends', $_POST)) {
    $uname = $_COOKIE['uname'];
    $chatId = ord(strtolower($_COOKIE['uname'])) - 96 . (time());
    $content = $_POST['message'];
    exesql("insert into chat_messages values ('$uname', '$CID', '$chatId', systimestamp,'$content')");
    // header('location: follow.php?username=$username');
}

$statement = exesql("select sender_username, content from chat_messages where channelid=".$CID." order by time asc");

echoRows($statement);

function echoRows($statement) {
    $i=0;
    while($r = oci_fetch_assoc($statement)) {
        echo '<a href ="profile.php?username='.$r['SENDER_USERNAME'].'">'.$r['SENDER_USERNAME'].'</a>: ';
        echo $r['CONTENT'];
        echo "<br>";
    }
}
function exesql($cmdstr) {
    //connect_prepare_execute_fetch_close
    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = oci_connect("ora_f3v9a", "a53854121", "dbhost.ugrad.cs.ubc.ca:1522/ug");
    
    if ($db_conn) {

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
        }

        if ($success) {
            //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
            // header("location: demo.php");
        }

        //Commit to save changes...
        oci_close($db_conn);
        return $statement;
        
    } else {
        echo "cannot connect";
        $e = oci_error(); // For OCILogon errors pass no handle
        echo htmlentities($e['message']);
    }
}
?>
</div>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <br>
  Message: <input type="text" name="message" value="">
  <input type="submit" name="sends" value="Send">
</form>
</div>

</html>