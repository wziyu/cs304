<?php

include 'execute.php';
// define variables and set to empty values
$nameErr = "";
$name = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and numbers
    if (!isInChannel) {
      $nameErr = "User not in the channel";
    }
  }

  if ($nameErr=="") {
    // create user
    setcookie("muteName",$name,time()+3600,"/");
    
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <input type="submit" name="mute" value="Mute">
  <span class="error"> <?php echo $nameErr;?></span>
</form>
<br>