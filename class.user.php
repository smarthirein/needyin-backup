<?php 
error_reporting(0);
require_once 'dbconfig.php';
require_once 'session.php';
require 'mail/PHPMailer/PHPMailerAutoload.php';
class USER
{	
	private $conn;	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
		$db2 = $database->dbConnectionPhase2();
		$this->conn = $db;
		$this->conn_phase2=$db2;
    }	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}	
		public function register($uname,$email,$upass,$code,$mob,$TEy,$TEm,$PLo,$Np,$CSL,$ESL,$EMSL,$Cloci,$skills,$Rtype,$nri,$sec_skills,$askills,$gender,$area)
	{
		try
		{						
			$password = md5($upass);
			if($nri == "101")
			{
				$nri='N';
			}
			else
			{
				$nri='Y';
			}
			$stmt = $this->conn->prepare("INSERT INTO tbl_jobseeker(JFullName,JEmail,JPwd,JtokenCode,JPhone,JTotalEy,JTotalEm,JPLoc_Id,Job_Skills,jReasonType,nri_status,Sec_Skills,pri_skills,Gender,Area_Id) 
			         VALUES(:user_name, :user_mail, :user_pass, :active_code, :user_phone, :user_TEy, :user_TEm,:user_PLoc,:all_skills,:user_ReasonType,:user_nri,:sec_skills,:user_Skills,:gen,:area)");
			
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":user_phone",$mob);
			$stmt->bindparam(":user_TEy",$TEy);
			$stmt->bindparam(":user_TEm",$TEm);
	
			$stmt->bindparam(":user_PLoc",$PLo);
		
			$stmt->bindparam(":user_Skills",$skills);
			
			$stmt->bindparam(":user_ReasonType",$Rtype);
	
			$stmt->bindparam(":user_nri",$nri);
			$stmt->bindparam(":sec_skills",$sec_skills);
$stmt->bindparam(":all_skills",$askills);
			$stmt->bindparam(":gen",$gender);
			$stmt->bindparam(":area",$area);
		    $stmt->execute();	
			$JUser_Id = $this->conn->lastInsertId();	     		   	   
			$stmt = $this->conn->prepare("INSERT INTO tbl_currentexperience(JUser_Id,NoticePeriod,CurrentSalL,ExpSalL,ExpMaxSalL,Loc_Id) 
			                                                         VALUES(:User_Id, :np, :Csl,  :Esl,:Emsl, :Cloc)");
			$stmt->bindparam(":User_Id",$JUser_Id);		
			$stmt->bindparam(":np",$Np);
			$stmt->bindparam(":Csl",$CSL);		
			$stmt->bindparam(":Emsl",$EMSL);
			$stmt->bindparam(":Esl",$ESL);					
			$stmt->bindparam(":Cloc",$Cloci);
			$stmt->execute();	
			 // $up_dt =  NOW();
			  
			//for status N created date date  
			$stmt = $this->conn->prepare("INSERT INTO tbl_user_admin_curationdts(JUser_Id,N_updt) 
			                                                     VALUES(:User_Id, NOW())");
			$stmt->bindparam(":User_Id",$JUser_Id);
			$stmt->execute();	
			//for status N created date date  
			
			$stmt->execute();

			
			return $stmt;			
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}	
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_jobseeker WHERE JEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);		
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['JuserStatus']=="Y" || $userRow['JuserStatus']=="V" || $userRow['JuserStatus']=="AW" || $userRow['JuserStatus']=="A" || $userRow['JuserStatus']=="IP"|| $userRow['JuserStatus']=="SQ")
				{
					if($userRow['JPwd']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['JUser_Id'];
						return true;
					}
					else
					{
						return false;				
					
					}
				}
				else
				{
					?>
				    
					<script type="text/javascript">
	alert("Thank you for registration!!! We sent an email verification link to your registered email.\nPlease verify before logging to Needyin.");
					 window.location="index.php";</script>
					<?php
				
				}	
			}
			else
			{
				?>
					
					<script type="text/javascript">
					 alert("Invalid Details. Please check the Email ID - Password combination.");																
					 window.location="index.php";
					 </script>
					<?php
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	public function login1($email,$upass)
	{
		try
		{
			$login_emp=$this->conn_phase2->prepare("SELECT * FROM tbl_users WHERE User_Email=:email_id AND User_Type='Employer'");
			$login_emp->execute(array(":email_id"=>$email));
			$login_row=$login_emp->fetch(PDO::FETCH_ASSOC);
			
		$stmt = $this->conn->prepare("SELECT * FROM tbll_emplyer WHERE emp_email=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow1=$stmt->fetch(PDO::FETCH_ASSOC);						
			if($stmt->rowCount() == 1)
			{				
				if(($userRow1['status']==1)||($userRow1['status']==4))
				{
					if($userRow1['emp_password']==md5($upass))
					{
						$_SESSION['empSession'] = $userRow1['emp_id'];	$_SESSION['empPhase2']=$login_row['User_Id'];								
						return true;
					}
					else
					{
						?><script>
								alert("Entered password is incorrect.Please Try again once");	
					</script>
					<?php
						
					}
				}
				else
				{
					?>
					<script>
					 alert("Your Account is InActive. Please contact Administrator.");	
					 window.location="recruiter.php";
					</script>
					<?php 
				}	
			}
			else
			{
				?>
					  <script>				
						 alert("Invalid Details.Please check the Email ID - Password combination.");								
						 window.location="recruiter.php";
					  </script>
				<?php				
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}	
	public function loginadmin($email,$upass)
	{
		try
		{
			
		$stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE email_Id=:email");
			$stmt->execute(array(":email"=>$email));
			$userRows1=$stmt->fetch(PDO::FETCH_ASSOC);		

			if($stmt->rowCount() == 1)
			{	

				if($userRows1['status']==1)
				{
					if($userRows1['password']==md5($upass))
					{
						$_SESSION['adminSession'] = $userRows1['id'];						
						return true;
					}
					else
					{
						?>
						<script>
							alert("Entered password is incorrect.Please Try again once");	
						</script>
					<?php						
					}
				}
				else
				{
					?>
					<script>
						alert("Your Account is InActive. Please contact Administrator.");	
						window.location="admin.php";
					</script>
					<?php 
				}	
			}
			else
			{
				?>
					<script>				
						alert("Invalid Details.Please check the Email ID - Password combination.");								
						window.location="admin.php";
					</script>
				<?php				
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		} else {
			return false;				
	 	}
		if(isset($_SESSION['empSession']))
		{
			return true;
		} else {
			return false;				
		}
		if(isset($_SESSION['adminSession']))
		{
			return true;
		}
		else {
			return false;				
		}
	}	
	public function redirect($url)
	{
		header("Location: $url");
	}	
	public function logout()
	{
		session_destroy();
		unset($_SESSION['userSession']);
	    unset($_SESSION['empSession']);
		unset($_SESSION['adminSession']);
		
	}	
	function send_mail($email,$message,$subject)
	{						
	
		$mail = new PHPMailer;
		$email_to=$email;
		$mail->IsSMTP();


		$mail->Host = 'mail.webmailcommunications.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'support@needyin.com';
		$mail->Password = 'Support@123';
		$mail->SMTPSecure = 'tls';

		$mail->From = 'support@needyin.com';
		$mail->FromName = 'Needyin';
		$mail->addAddress($email_to);

		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $message;

if(!$mail->send()) {
	return false;
 
 } else {
	return true;
}
	 }
	function send_mail2($email,$message,$subject)
	{						
			
		$mail = new PHPMailer;
		$email_to=$email;
		$mail->IsSMTP();


		$mail->Host = 'mail.webmailcommunications.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'support@needyin.com';
		$mail->Password = 'Support@123';
		$mail->SMTPSecure = 'tls';

		$mail->From = 'support@needyin.com';
		$mail->FromName = 'Needyin';
		$mail->addAddress($email_to);

		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		 } else {
			
			return true;
			}	
	}	
	
}
?>
