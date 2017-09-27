<?php
   ob_start();
   session_start();
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
<title>DogeTV</title>
<style type="text/css">
    	

         .r1 {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 30px;
	background-attachment: scroll;
	background-color: #CCC;
	background-image: url(DogeTV2.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	z-index: auto;
	height: 820px;
	width: 1800px;
}
         
         .form-signin {
            max-width: 260px;
            padding: 40px;
            margin: 0 auto;
            color: #BDCE40;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 0px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 20px;
            font-size: 18px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #FFAF40;
	    font-size: 30px;
	    
         }

	h4{
	   margin-top: 30px;
            text-align: center;
            color: #9370DB;
	    font-size: 20px;
	    
         }
	h6{
	   margin-top: 70px;
            text-align: center;
            color: #BDCE40;
	    font-size: 20px;
	    
         }

      </style>
      
   </head>


	
   <body>
<div class="r1" id="r1">
  
    <p>&nbsp;</p>	
      
      <h2>Welcome to DogeTV</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
	       	
		$user = $_POST["username"];  
       		$psw = $_POST["password"];  	
            $db_conn=OCILogon("ora_j8h0b","a56125131","ug");
	    $success = True;
	    $cmdr="select username,password from Users where username='$user' AND password='$psw' ";
            $result = executePlainSQL($cmdr);
		$row = OCI_Fetch_Array($result,OCI_BOTH);
		
	 
           if($row)
            {  
                echo "<script>alert('Logged in');</script>";    
		  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = '$user';
		header("location: hello.php");
		
            }  
            else  
            {  
                $msg = 'Wrong username or password';
            }  
		OCILogoff($db_conn);
                
              
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
	<label for="username">username</label>
            <input type = "text" class = "form-control" 
               name = "username" 
               required autofocus></br>
         <label for="password">password</label>   <input type = "password" class = "form-control"
               name = "password"  required>
	
            <button class = "btn btn-lg btn-primary btn-block"  style="width:150px;height:30px;"  type = "submit" 
		 name = "login">Login</button>
         </form>

	 <h6>Do not have an account? Click here to <a href = "register.php" tite = "Register">Register.</h6> 		
         
      </div> 
      
   </body>





</html>