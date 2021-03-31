<?php

session_start();

//TODO: do not hardcode, get from database
const login = 'admin';
const password = 'admin';
const userArray = [
    
    "org" => '$2y$10$Z0LsFc.Augc.vNuc1rrRM.OYUsEgWtL5KRGCFSLnOrzP2V8NFk6Je',
	"amsys" => '$2y$10$wEnLQSdZCF61/eQ0lA22pOLK3gXV/Mq31mPwhnGv9p369XL/XCE.W',
];

#echo password_hash("#", PASSWORD_DEFAULT);
function checkPassword($passwd, $user) {
	#print_r(userArray);
  if (array_key_exists($user, userArray)) {
	if (password_verify($passwd, userArray[$user])){
		
		return true;
	}
  }
 return false; 
}

if (isset($_POST['login']) && isset($_POST['password'])) //when form submitted
{
	echo checkPassword($_POST['password'],$_POST['login']);
	if (checkPassword($_POST['password'],$_POST['login']) == true){
		
		$_SESSION['login'] = $_POST['login']; //write login to server storage
		header('Location: /dashboard/test.php'); //redirect to main
	}
  
  else
  {
    echo "<script>alert('Wrong login or password');</script>";
    echo "<noscript>Wrong login or password</noscript>";
  }
}

?>
<body style="background-color:black;color:#FFFFFF;">
<div style="padding: 25px 20px 20px 20px;font-size: large;">
<img src="../logo.png"><form method="post">

  Login:<br><input name="login" ><br>
  Password:<br><input name="password" type="password"><br>
  <input type="submit">
</form>
</div>
</body>


