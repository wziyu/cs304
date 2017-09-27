F<!DOCTYPE html>
<html>
<?php
include 'execute.php';

$uname = $_COOKIE['uname'];
if(!empty($_GET['username'])) {
    $target_name = $_GET['username'];
    setcookie('target_name',$target_name,time()+3600,'/');
} else {
    $target_name = $_COOKIE['target_name'];
}

function printResult($result) { //prints results from a select statement
    $i = 1;
    while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
        if (oci_field_is_null($result,$i)) {
            echo 0;
        } else {
            echo $row[$i-1]; //or just use "echo $row[0]" 
        }
        $i += $i;
    }
}

function validPwd($pwd) {
}

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$is_streaming = false;
$followed = false;

$result = executeSQL("select id from channels where streamer_username='$target_name'");
$CID = oci_fetch_array($result)[0];
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$donateNotice = $pwdNotice = $pwd="";

if(!empty($_POST["change_pwd"])) {
    if(!empty($_POST['pwd'])) {
        $pwd = $_POST["pwd"];
        
        if (strlen($pwd)<5 or strlen($pwd)>10) {
            $pwdNotice = "Must be between 5 and 10 characters long";
        }
        else if (!preg_match("/^[a-zA-Z0-9]*$/",$pwd)) {
            $pwdNotice = "Only letters and numbers allowed"; 
        } else {
            $cmdstr = "update users set password='$pwd' where username ='$uname'";
            executeSQL($cmdstr);
            $pwdNotice = "Password Successfully Updated";
        }
    } else {
        $pwdNotice = "Please Enter a new Password";
    }
}

if (array_key_exists('donate', $_POST)) {
    $ord = ord(strtolower($_COOKIE['uname'])) - 96 . (time());
    $amount = $_POST['amount'];
    if (is_numeric($amount)) {
        executeSQL("insert into donations values ('$ord', '$uname', '$target_name','$amount')");
        $donateNotice = "Thanks 4 ur support!";
    } else {
        $donateNotice = "*How to donate \$null or \$undefined? :)";
    }
    // header('location: follow.php?username=$target_name');
} else if (array_key_exists('follow', $_POST)) {
        executeSQL("insert into follows values('$uname','$target_name')");
        // header('location: follow.php?username=$target_name');
} else if (array_key_exists('unfollow', $_POST)) {
        executeSQL("delete from follows where follower_username='$uname' and followee_username='$target_name'");
        // header('location: follow.php?username=$target_name');

}

$result = executeSQL("select * from channels where streamer_username='$target_name'");
while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
    if (!oci_field_is_null($result,1)) {
        $is_streaming = true;
    }
}
$result = executeSQL("select * from follows where follower_username='$uname' and followee_username='$target_name'");
while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
    if (!oci_field_is_null($result,1)) {
        $followed = true;
    }
}
?>

<head>
<style>
.error {color: #FF0000;}

body {
    /*text-align: center;*/
    margin: 10% 25% 10% 25%;
}

#user_info {
    /*display:inline-block;*/
    float:left;
}

#container {
    display:inline-block;
    float:right;
}

</style>
</head>

<body>
<p style="font-size:300%;text-align: center;"><strong><?php echo $target_name . "'s Profile"; ?></strong></p>
<div id='user_info'>    
    <p>Username: <?php echo $target_name; ?></p>
    <p>Gender: <?php 
    printResult(executeSQL("select gender from users where username='$target_name'"));
    ?></p>
    <p>RegDate: 
    <?php 
    printResult(executeSQL("select regdate from users where username='$target_name'"));
    ?>
    </p>
    <p>Followers: 
    <?php 
    printResult(executeSQL("select count(*) from follows where followee_username='$target_name'"));
    ?>
    </p>
    <?php
        if ($uname===$target_name) {
            echo '<form method="post" action='.htmlspecialchars($_SERVER["PHP_SELF"]).'>';
            echo '<input type="password" size=8 name="pwd" value="">';
            echo '<input type="submit" name="change_pwd" value="Change Password"><br><br>';
        }
    ?>
    <span class="error"> <?php echo $pwdNotice;?></span>
    </form>
</div>

<div id='container'>
    <div id='channel'>
    <?php
    if ($is_streaming) {
        echo "<form method='post' action='channel.php'>";
        echo "<input type='hidden' name='cid' value='".$CID."'>";
        echo "<input type='submit' name='to_channel' value='Watch Channel'>";
        echo "</form>";
    }
    ?>
    </div>

    <div id='donation_info'>
    <p>Donations Made: $<?php
    printResult(executeSQL("select sum(amount) from donations where donater_username='$target_name'"));
    ?></p>

    <p>Donations Received: $<?php
    printResult(executeSQL("select sum(amount) from donations where donatee_username='$target_name'"));
    ?></p>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
        if (!$followed) {
            echo '<input type="submit" name="follow" value="Follow"><br><br>';
        } else {
            echo '<input type="submit" name="unfollow" value="Unfollow"><br><br>';
        }
      ?>
      $$Amount$$: <input type="text" size=5 name="amount" value="">
      <input type="submit" name="donate" value="Donate"><br>
      <span class="error"> <?php echo $donateNotice;?></span>
    </form>
</div>

</body>

</html>