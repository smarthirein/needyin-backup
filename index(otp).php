<?php 	
session_start();
$servername = "localhost";
$username = "root";
$password ="N@edy1n.C0m_D"; 
$dbname = "needyin_phase1_Dev";
// require_once 'class.user.php';
$sql = "SELECT JPhone,JFullName FROM `tbl_jobseeker` ORDER BY JUser_Id DESC LIMIT 1";
$conn = new mysqli($servername, $username, $password, $dbname); 
$result = mysqli_query($conn,$sql);
foreach($result as $row) {
		$fields[] = $row['JPhone'];
		$fields[] = $row['JFullName'];
}
?>
<?php
 session_start();
if(isset($_POST['login'])){
// Account details
	$apiKey = urlencode('TreESbtR4n0-BRdjbXUVKuc841Y9bmIzRoDQWaEBzZ');
	$txtMobile = $_POST['txtMobile'];
	$numbers = array($txtMobile);
	$sender = urlencode('TXTLCL');
	$otp=rand(100000,999999); 
    $_SESSION['otp'] = $otp;
    //setcookie("otp", $otp);
	$message = rawurlencode("Dear ".$row[JFullName].",your OTP is  ".$otp."");
	$numbers = implode(',', $numbers);
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
    
 
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	// echo $response;
	echo "<div class ='main'><span style='color:blue; text-align:center;background-color: white;'>Dear ".$row[JFullName].",your OTP is send successfully, please enter it below</span></div>";
}
if(isset($_POST['ver'])){
$verotp=$_POST['otp'];
//if($verotp==$_COOKIE["otp"]){
if ($verotp == $_SESSION['otp']){
unset($_SESSION['otp']);
$siteurl = $_SESSION['link'];
$id = $_SESSION['id'];
$code = $_SESSION['code'];

// echo"<h3 style='color:#4c4c4c; text-align:center;background-color: white;'>Thank you for Registering, your account is active now.</h3><br><a href=".$siteurl."/verify.php?id=".$id."&code=".$code."><h2 style='color:#0088e8; text-align:right;background-color: white;'> Please click here to login</h3></a>)";
echo"<div class = 'main'> <span  style='color:#4c4c4c; text-align:center;background-color: white;'>Thank you for Registering, your account is active now.Please </span><a href=".$siteurl."/verify.php?id=".$id."&code=".$code."><span class = 'click' style='color:#0088e8; text-align:right;background-color: white;'>click here</a> to login</span></div>";
}else{
  
echo "<div class = 'main'> <span style='color:#ff0000; text-align:center;background-color: white;'>Invalid OTP</div>";

	
} 
}
// require_once'index(otp).php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="OTPstyle.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<title>OTP</title>
</head>
<body>
<div class="container">
	<div class="col-md-12">
		<div class="col-md-4 col-sm-12 col-xs-12 pull-right inner-body">
		      <div class="needy-logo">
			       <img src="final2.png" alt="image" class="img-responsive">
			  </div>
			   <div class="otphaeder">
				   <h2>OTP</h2>
			   </div>
			  <form method="post" action="index(otp).php">
					<div class="form-group">
					  <label class="newText" for="phone">Your Registered Phone Number</label>
					  <input type="text"  class="form-control" name="txtMobile" id= "txtMobile" value = <?php echo $row [JPhone];?> readonly>
					</div>
					<div class="form-group">
					    <button type="submit" name = "login" class="btn btn-success">Send OTP</button>
                     </div>					
					<div class="form-group">
					  <label class="newText" for="enter">Enter OTP</label>
					  <input type="text" name ="otp" class="form-control" id= "txtMobile"> 
					</div>
					<div class="form-group">
				      	<button type="submit" name ="ver" class="btn btn-danger">Verify OTP</button>
								<label class="dnd" for="dnd"><p style="color:red;">* Your Number is in DND, Please check your Email for ActivationLink</p></label>	
          </div>					
			 </form>
		</div>
	</div>
</div>
</body>
</html>
