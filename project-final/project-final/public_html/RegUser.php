<?php
    $uname = $_COOKIE["uname"];
    include "execute.php";

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




<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
	

?>

<html>
<head>
<title>DogeTV_RegistedUser</title>
<style type="text/css">
    	

         .r1 {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 30px;
	background-attachment: scroll;
	background-color: #CCC;
	background-image: url(DogeTV2.jpg);
	//background-repeat: no-repeat;
	background-position: center center;
	z-index: auto;
	height: 840px;
	width: 1860px;
	
 
	}

	.r2{
	position:absolute;
	top:120px;
	left:40px;
 	height: 100px;
	width: 300px;
	background-image: url(DogeTV2.jpg);
	
	}


         
         form-signin {
	  
            width: 360px;
            padding: 40px;
           
            color: #BDCE40;
         }
         
         form-signin .form-signin-heading,
         .form-signin .checkbox {
	
            margin-bottom: 0px;
         }
         
         form-signin .checkbox {
	
            font-weight: normal;
         }
         
         form-signin .form-control {
	
            position: relative;
            height: 40px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 20px;
            font-size: 18px;
         }
         
         form-signin .form-control:focus {
            z-index: 2;
         }
         
         form-signin input[type="text"] {
	
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         
         
         h2{
	    text-align:center;
            position:absolute;
		top:0px;
		left:440px;
            color: #FFAF40;
	    font-size: 60px;
	    z-index: 3;
         }




    </style>

    </head>


	
   <body>
<div class="r1" id="r1">
 
    <p>&nbsp;</p>	
      
      <h2><?php   echo"Hello ".$uname." "; ?></h2> 
      <div class = "container form-signin">
         
         <?php
            
            if (isset($_POST['search']) && !empty($_POST['CHID']) ) {
	       	
		$chid = $_POST["CHID"];  	
		setcookie("searchID",$chid,time()+3600,"/"); 
		header("location: SearchResult.php");
	
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      <div style="position:absolute;left:1200px;top:50px;">
         <form class = "form-signin" role = "form" 
             action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method = "post">
	
	
            <input type = "text" class = "form-control" 
               name = "CHID" 
               required autofocus>
       
	
            <button class = "btn btn-lg btn-primary btn-block"  style="width:200px;height:40px;"  type = "submit" 
		 name = "search">search</button>
	</div>
         </form>		
      </div> 

<div class="r2" id="r2">  
<div style="margin-left:50px;margin-top:30px">
 <?php $u=$_COOKIE["uname"];
 echo'<a href ="profile.php?username='.$u.' ">   PersonalProfile </a> '
?>
</div> 
</div> 

<div style="position:absolute;left:1060px;top:150px;">
<iframe src="Types.php" height="640" width="670">
</iframe>
</div>

<div style="position:absolute;left:40px;top:260px;">
<iframe src=Top10.php height="510" width="360">
</iframe>
</div>

<div style="position:absolute;left:140px;top:40px;">
<?php

$cmdstr = "select count(*) from channels where streamer_username='$uname'";
$statement = executeSQL($cmdstr);
$has_channel = (oci_fetch_array($statement)[0]==0)?false:true;
if(!$has_channel) {
    echo
    '<div style=" position:absolute;left:480px;top:630px; "> 
        <form method="post" action="createChannel.php">
    	
            <button class = "btn btn-lg btn-primary btn-block"  
            style="width:400px;height:50px;"  
            type = "submit" 
            name = "crcs">
            Start Streaming</button>
    	
        </form>
    </div>';
} else {
    $cmdstr = "select status, id from channels where streamer_username='$uname'";
    $statement = executeSQL($cmdstr);
    $r = oci_fetch_array($statement);
    $status = trim($r["STATUS"]);
    $CID = $r["ID"];
    if($status!=trim('online')&$status!=trim('banned')) {
        echo '<div id="start_btn" style="position:absolute;width:500px;height:180px;">';
        echo '<form method="post" action="channel.php">';
        echo '<input type="hidden" name="cid" value="'.$CID.'">';
        echo '<input type="submit" name="start" value="Start Stream"><br>';
        echo '</form><br>';
        echo '</div>';
    }
}
?>
</div>

<div style=" position:absolute;left:710px;top:730px; "> 
 <form method="post" action="login2.php" 

   if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}>
	
       <button class = "btn btn-lg btn-primary btn-block"  style="width:240px;height:45px;"  type = "submit" 
		 name = "crcs">Logout</button>
	
    </form>
</div>


      
   </body>


</html>