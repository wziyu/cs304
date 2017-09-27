<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php

// define variables and set to empty values
$nameErr = $genderErr = $pwdErr = "";
$name = $gender = $pwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and numbers
    if (!preg_match("/^[a-zA-Z0-9]*$/",$name)) {
      $nameErr = "Only letters and numbers allowed"; 
    }
  }

  if (empty($_POST["pwd"])) {
    $pwdErr = "Password is required";
  } else {
    // check if pwd only contains 5-10 letters and numbers
    $pwd = test_input($_POST["pwd"]);
    if (strlen($pwd)<5 or strlen($pwd)>10) {
      $pwdErr = "Must be between 5 and 10 characters long";
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/",$pwd)) {
      $pwdErr = "Only letters and numbers allowed"; 
    }
  }
  
  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if ($nameErr==""&&$pwdErr==""&&$genderErr=="") {
    // create user
    setcookie("duplicate_user",0,time()-10,"/");
    setcookie("uname",$name,time()+3600,"/");
    setcookie("pwd",$pwd,time()+3600,"/");
    setcookie("gender",$gender,time()+3600,"/");
    
    header("location: create_user.php");
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h1><em>Doge TV</em></h1>
<h2>Sign-Up</h2>

<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr.($_COOKIE['duplicate_user']==1)?'User Existed':'';?></span>
  <br><br>
  Password: <input type="password" name="pwd">
  <span class="error">* <?php echo $pwdErr;?></span>
  <br><br>
  Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Female") echo "checked";?> value="Female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Male") echo "checked";?> value="Male">Male
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>
<br
>
</body>
</html>