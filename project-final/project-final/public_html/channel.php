<!DOCTYPE html>
<html>
<?php
include 'execute.php';
date_default_timezone_set('America/Los_Angeles');
$uname = $_COOKIE['uname'];

if(!empty($_POST['cid'])) {
    $CID = $_POST['cid'];
    setcookie('CID',$CID,time()+3600,'/');
    $cmdstr = "update channels set status='online' where id='$CID'";
    executeSQL($cmdstr);
} else if(!empty($_GET['CID'])) {
    $CID = $_GET['CID'];
    setcookie('CID',$CID,time()+3600,'/');
} else {
    $CID = $_COOKIE['CID'];
}

include 'updateMutes.php';

$followed=false;
$amountError=false;

// get channel info
$statement = executeSQL("select * from channels where id='$CID'");
$r = oci_fetch_assoc($statement);
$streamer_name = $r['STREAMER_USERNAME'];
$title = $r['TITLE'];
$language = $r['LANGUAGE'];
$status = $r['STATUS'];
$description =$r['DESCRIPTION'];
// get # viewer and detail
$statement = executeSQL("select count(id) from game_channels where id='$CID'");
$is_game = (oci_fetch_array($statement)[0]==0)?false:true;
if ($is_game) { // game_channels
    $statement = executeSQL("select * from game_channels where id='$CID'");
    $r = oci_fetch_assoc($statement);
    $gname = $r["GNAME"];
    $platform = $r["PLATFORM"];
} else { // show_channels
    $statement = executeSQL("select * from show_channels where id='$CID'");
    $r = oci_fetch_assoc($statement);
    $type = $r["TYPE"];
}

$statement = executeSQL("select count(id) from watches where id='$CID'");
$viewer_num = oci_fetch_array($statement)[0];
$statement = executeSQL("select count(follower_username) from follows where followee_username='$streamer_name'");
$follower_num = oci_fetch_array($statement)[0];

$is_streamer = trim($uname)==trim($streamer_name);

$statement = executeSQL("select count(*) from grants_privilege where streamer_username='$streamer_name' and moderator_username='$uname'");
$is_moderator = (oci_fetch_array($statement)[0]==0)?false:true;
$grantNotice = $muteNotice = $unmuteNotice = "";
$promote_target = $mute_target = $unmute_target = "";
if(!empty($_POST["grants"])) {
    // grants privilege
    $promote_target = $_POST["moderator_name"];
    $cmdstr = "select count(*) from grants_privilege where streamer_username='".$streamer_name."' and moderator_username='".$promote_target."'";
    $statement = executeSQL($cmdstr);
    $duplicate = (oci_fetch_array($statement)[0]>0) ? true : false;

    $cmdstr = "select count(*) from watches where watcher_username='".$promote_target."' and id='".$CID."'";
    $statement = executeSQL($cmdstr);
    $exist_user = (oci_fetch_array($statement)[0]>0) ? true : false;

    if($duplicate) {
        $grantNotice = "Duplicate Requests";
    } else if(!$exist_user) {
        $grantNotice = "User Not in the Channel";
    } else {
        $statement = executeSQL("insert into grants_privilege values('".$streamer_name."','".$promote_target."')");
        $grantNotice = "Successfully Promoted!";
    }
}

if(!empty($_POST["mutes"])) {
    // mutes
    $mute_target = $_POST["mute_name"];
    $end_date = time()+$_POST["mute_duration"];
    $end_date_str = date('Y/m/d H:i:s',$end_date);
    $cmdstr = "select count(*) from mutes where streamer_username='".$streamer_name."' and mutee_username='".$mute_target."'";
    $statement = executeSQL($cmdstr);
    $duplicate = (oci_fetch_array($statement)[0]>0) ? true : false;

    $cmdstr = "select count(*) from watches where watcher_username='".$mute_target."' and id='".$CID."'";
    $statement = executeSQL($cmdstr);
    $exist_user = (oci_fetch_array($statement)[0]>0) ? true : false;

    if($duplicate) {
        $muteNotice = $mute_target." has been already muted";
    } else if(!$exist_user) {
        $muteNotice = "User is not in the Channel";
    } else {
        $cmdstr = "insert into mutes values('".$uname."','".$streamer_name."','".$target."',TO_DATE('".$end_date_str."','YYYY/MM/DD HH24:MI:SS'))";
        $statement = executeSQL($cmdstr);
        $muteNotice = "Successfully Muted";
    }
}

if(!empty($_POST["unmutes"])) {
    // mutes
    $unmute_target = $_POST["unmute_name"];

    $cmdstr = "select count(*) from mutes where mutee_username='".$unmute_target."' and streamer_username='".$streamer_name."'";
    $statement = executeSQL($cmdstr);
    $exist_user = (oci_fetch_array($statement)[0]>0) ? true : false;

    if(!$exist_user) {
        $unmuteNotice = "User is not muted in the Channel";
    } else {
        $cmdstr = "delete from mutes where mutee_username='".$unmute_target."'";
        $statement = executeSQL($cmdstr);
        $unmuteNotice = "Successfully Unmuted";
    }
}

if (array_key_exists('donate', $_POST)) {
    $ord = ord(strtolower($_COOKIE['uname'])) - 96 . (time());
    $amount = $_POST['amount'];
    if (is_numeric($amount)) {
        executeSQL("insert into donations values ('$ord', '$uname', '$streamer_name','$amount')");
    } else {
        $amountError = "*Please Enter A Number";
    }
    // header('location: follow.php?username=$streamer_name');
} else if (array_key_exists('follow', $_POST)) {
        executeSQL("insert into follows values('$uname','$streamer_name')");
        // header('location: follow.php?username=$streamer_name');
} else if (array_key_exists('unfollow', $_POST)) {
        executeSQL("delete from follows where follower_username='$uname' and followee_username='$streamer_name'");
        // header('location: follow.php?username=$streamer_name');
}

$result = executeSQL("select * from follows where follower_username='$uname' and followee_username='$streamer_name'");
while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
    if (!oci_field_is_null($result,1)) {
        $followed = true;
    }
}

?>

<head>
<meta charset="utf-8">
<style>
.error {color: #FF0000;}

#screen {
    background: #3f9fdf;
    width: 400px;
    height: 300px;
}

#channel_info {
    display:inline-block;
    float:left;
}

#container {
    display:inline-block;
    float:right;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	

function loadNowPlaying(){
  $("#chatmsg").load("chat.php?chanId="+<?php echo $CID; ?>+" #chatmsg", function(){
  	$(this).children(':first').unwrap();
  	$('#chatmsg').scrollTop($('#chatmsg')[0].scrollHeight);
  });
}
setInterval(function(){
    loadNowPlaying();
}, 1000);

function confirmLeave() {
    if (confirm("You are leaving the channel") == true) {
        //remove from watches
        <?php
        $cmdstr = "delete from watches where id='$CID' and watcher_username='$uname'";
        executeSQL($cmdstr);
        ?>
        window.location.replace("RegUser.php");
    } else {
        //do nothing
    }
}

function confirmEnd() {
    if (confirm("You are ending the stream") == true) {
        //remove from watches
        <?php
        $cmdstr = "update channels set status='offline' where id='$CID'";
        executeSQL($cmdstr);
        ?>
        window.location.replace("RegUser.php");
    } else {
        //do nothing
    }
}
</script>

</head>

<body>

<div id='channel_info'>
    <div id='screen'>Placeholder for Screen</div>
    
    <p><?php echo $title; ?></p>
    <button onclick="confirmLeave()">Leave</button>
    <p><?php echo $streamer_name; ?></p>
    <table>
      <tr>
        <td><strong>#Viewers:</strong></td>
        <td><?php echo $viewer_num; ?></td>
        <td><strong>#Followers:</strong></td>
        <td><?php echo $follower_num; ?></td>
      </tr>
        <?php
            if($is_game) {
                echo '<tr>';
                echo '<td><strong>Game:</strong></td>';
                echo '<td>'.$gname.'</td>';
                echo '<td><strong>Platform:</strong></td>';
                echo '<td>'.$platform.'</td>';
                echo '</tr>';
            } else {
                echo '<tr>';
                echo '<td><strong>Type:</strong></td>';
                echo '<td>'.$type.'</td>';
                echo '</tr>';
            }    
        ?>
        <tr>
            <td><strong>Language</strong></td>
            <td><?php echo $language; ?></td>
            <td><strong>Status</strong></td>
            <td><?php echo $status; ?></td>
        </tr>
    </table>
    <?php echo $description; ?>
</div>

<div id='container'>
    <div id='admin'>
    <?php
    if ($is_streamer) {
        echo 
        '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">  
        UserName: <input type="text" name="moderator_name" value="'.$promote_target.'">
        <input type="submit" name="grants" value="Promote!"><br>
        <span class="error">'.$grantNotice.'</span>
        </form><br>';

        echo '<button onclick="confirmEnd()">End Stream</button><br><br>';
    } 
    if ($is_moderator) {
        // Mute Form
        echo 
        '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">  
        Mutes: <input type="text" name="mute_name" value="'.$mute_target.'"><br>
        Mute Duration:
        <input type="number" name="mute_duration" min="10" max="999999" style="margin-top:5px;">
        <input type="submit" name="mutes" value="Mute"><br>
        (between 10s and 999999s)<br>
        <span class="error">'.$muteNotice.'</span>
        </form>
        <br>';
        // Unmute Form
        echo 
        '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">  
        Unmutes: <input type="text" name="unmute_name" value="'.$unmute_target.'">
        <input type="submit" name="unmutes" value="Unmute"><br><br>
        <span class="error">'.$unmuteNotice.'</span>
        </form>
        <br>';
    }
    ?>
    </div>

    <div id='chat'>
    <?php
        include 'chat.php';
    ?>
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
      <span class="error"> <?php echo $amountError;?></span>
      <input type="submit" name="donate" value="Donate">
    </form>
</div>

</body>

</html>