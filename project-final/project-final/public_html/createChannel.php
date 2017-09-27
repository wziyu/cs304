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
$titleErr = $typeErr = $descriptionErr =$languageErr= $GameErr=$ShowErr="";
$title = $type = $description =$language=$platform=$gamename=$showtype="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["title"])) {
    $titleErr = "title is required";
  } else {
    $title = test_input($_POST["title"]);
   
     if (strlen($title)>100) {
      $titleErr = "Title must be less than 100 characters";
    }
  }

 if (empty($_POST["description"])) {
    $descriptionErr = "description is required";
  } else {
	$description = test_input($_POST["description"]);
    // check if description is in allowed length
    if (strlen($description)>200) {
      $descriptionErr = "Description Must be less than 200 characters";
    }
  }
  
  if (empty($_POST["type"])) {
    $typeErr = "Type is required";
  } else {
    $type = test_input($_POST["type"]);
  }
 
  if (empty($_POST["language"])) {
    $languageErr = "language is required";
  } else {
    $language = test_input($_POST["language"]);
   
     if (strlen($language)>30) {
      $languageErr = "language must be less than 30 characters";
    }
  }
  
	if ($_POST["type"]=="Game") {
		if ( empty($_POST["platform"])||empty($_POST["gamename"]) ){
   			$GameErr = "GameChannel need to specify platform and gamename";
		} 
		$platform = test_input($_POST["platform"]);
		$gamename = test_input($_POST["gamename"]);
		if (!empty($_POST["showtype"])){
			$ShowErr = "GameChannel does not need showtype";
		}
	}
  	if ($_POST["type"]=="Show") {
 	 	if ( empty($_POST["showtype"]) ){
    		$ShowErr = "ShowChannel need to specify showtype";
		}
		$showtype = test_input($_POST["showtype"]);
		if ( !empty($_POST["platform"])||!empty($_POST["gamename"]) ){
   			$GameErr = "ShowChannel does not need platform and gamename";
		}
    }
    
  



  if ($titleErr==""&&$descriptionErr==""&&$typeErr==""&&$languageErr==""&&$GameErr==""&&$ShowErr=="") {

	    setcookie("title",$title,time()+3600,"/");
	    setcookie("description",$description,time()+3600,"/");
	    setcookie("type",$type,time()+3600,"/");
	    setcookie("language",$language,time()+3600,"/");
	    setcookie("gamename",$gamename,time()+3600,"/");
	    setcookie("platform",$platform,time()+3600,"/");
            setcookie("showtype",$showtype,time()+3600,"/");
    
    
    header("location: NewChannel.php");
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
<h2>Create Channel</h2>

<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  StreamerName :<?php echo $_COOKIE["uname"];?> ;
  <span class="error">* <?php echo $nameErr.($_COOKIE['duplicate_user']==1)?'User Existed':'';?></span>
  <br><br>
  Title: <input type="text" name="title" value="<?php echo $title;?>">
  <span class="error">* <?php echo $titleErr;?></span>
  <br><br>
  Description: <input type="text" name="description" value="<?php echo $description;?>">
  <span class="error">* <?php echo $descriptionErr;?></span>
  <br><br>
  type:
  <input type="radio" name="type" <?php if (isset($type) && $type=="Game") echo "checked";?> value="Game">Game
  <input type="radio" name="type" <?php if (isset($type) && $type=="Show") echo "checked";?> value="Show">Show
  <span class="error">* <?php echo $typeErr;?></span>
  <br><br>
  Language: <input type="text" name="language" value="<?php echo $language;?>">
  <span class="error">* <?php echo $languageErr;?></span>
  <br><br>
  Platform: <input type="text" name="platform" value="<?php echo $platform;?>">
  <span class="error">* <?php echo $GameErr;?></span>
  <br><br>
  GameName: <input type="text" name="gamename" value="<?php echo $gamename;?>">
  <span class="error">* <?php echo $GameErr;?></span>
  <br><br>
  ShowType: <input type="text" name="showtype" value="<?php echo $showtype;?>">
  <span class="error">* <?php echo $ShowErr;?></span>
  <br><br>



  <input type="submit" type="submit" value="Submit">
</form>
<br>
</body>
</html>