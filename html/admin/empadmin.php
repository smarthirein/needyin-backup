<?php 
session_start();
require_once("../config.php");
require_once '../class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['adminSession']))
{
	$user_home->redirect('index-recruiter.php');
   
} 	
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


  if(isset($_POST['comapprovals'])){	 
		 $cnameapp=$_POST['cnameapp'];
		 $cnamere=$_POST['cnamere'];
		$curlapp=$_POST['curlapp'];
		$comurlre=$_POST['comurlre'];	 
		$rocapp=$_POST['rocapp'];
	    $comrocre=$_POST['comrocre'];
	    $ctypeapp=$_POST['ctypeapp'];
	    $comtypere=$_POST['comtypere'];
		$indtypeapp=$_POST['indtypeapp'];
		$indtypere=$_POST['indtypere'];
		$cyorapp=$_POST['cyorapp'];		
		$cyorre=$_POST['cyorre'];
		$desigapp=$_POST['desigapp'];
		$desingre=$_POST['desingre'];
		$empid=$_POST['empid'];
		
		// code for concatenating approval and reason 
		 $cnamear = $cnameapp . '@' . $cnamere;
		$urlar = $curlapp . '@' . $comurlre;
		$comroc = $rocapp . '@' . $comrocre;
		$comtypear = $ctypeapp . '@' . $comtypere;
		$indtypear = $indtypeapp . '@' . $indtypere;
		$cyorar = $cyorapp . '@' . $cyorre;
		$desigar = $desigapp . '@' . $desingre;		
		
		// code for concatenating above fields

		$empapdet = 'cname^'.$cnamear . '#curl^' . $urlar . '#croc^' . $comroc . '#ctype^' . $comtypear . '#indtype^' . $indtypear . '#cyor^' . $cyorar . '#desig^' . $desigar;
		
					$ss="update tbll_emplyer SET adminstatus='".$empapdet."',status='6',updatedapp=NOW() where emp_id='".$empid."'";
				$ss_res=mysqli_query($con,$ss);	
				
				
				?>
				<script>alert("Successfully updated");
				window.location.href = "employer-detail-recruiter.php?uid=<?php echo $empid  ?>";</script>
				<?php
  }
  
  if(isset($_POST['jseekerapprovals'])){
		$unameapp=$_POST['unameapp'];
		$unamere=$_POST['unamere'];
		$uphoneapp=$_POST['uphoneapp'];
		$uphonere=$_POST['uphonere'];	 
		$uexpapp=$_POST['uexpapp'];
	    $uexpre=$_POST['uexpre'];
	    $udobapp=$_POST['udobapp'];
	    $udobre=$_POST['udobre'];
		$ugenapp=$_POST['ugenapp'];
		$ugenre=$_POST['ugenre'];
		$ucsalapp=$_POST['ucsalapp'];		
		$ucsalre=$_POST['ucsalre'];
		$udojapp=$_POST['udojapp'];
		$udojre=$_POST['udojre'];		
		$payslipapp=$_POST['payslipapp'];		
		$payslipre=$_POST['payslipre'];
		$updatecvapp=$_POST['updatecvapp'];
		$updatecvre=$_POST['updatecvre'];		
		$uemailapp=$_POST['uemailapp'];		
		$uemailre=$_POST['uemailre'];
		$reasonattapp=$_POST['reasonattapp'];
		$reasonattre=$_POST['reasonattre'];		
		$plocapp=$_POST['plocapp'];		
		$plocre=$_POST['plocre'];
		$cautapp=$_POST['cautapp'];
		$cautre=$_POST['cautre'];		
		$fnameapp=$_POST['fnameapp'];		
		$fnamere=$_POST['fnamere'];
		$psumapp=$_POST['psumapp'];
		$psumre=$_POST['psumre'];		
		$rtypeapp=$_POST['rtypeapp'];		
		$rtypere=$_POST['rtypere'];
		$rsumapp=$_POST['rsumapp'];
		$rsumre=$_POST['rsumre'];		
		$comnameapp=$_POST['comnameapp'];
		$comnamere=$_POST['comnamere'];
		
		
		$juserid=$_POST['juserid'];
		
		// code for concatenating approval and reason 
		$unamear = $unameapp . '@' . $unamere;
		$uphonear = $uphoneapp . '@' . $uphonere;
		$uexpar = $uexpapp . '@' . $uexpre;
		$udobar = $udobapp . '@' . $udobre;
		$ugenar = $ugenapp . '@' . $ugenre;
		$ucsalar = $ucsalapp . '@' . $ucsalre;
		$udojar = $udojapp . '@' . $udojre;
		$payslipar = $payslipapp . '@' . $payslipre;
		$updatecvar = $updatecvapp . '@' . $updatecvre;
		$uemailar = $uemailapp . '@' . $uemailre;			
		$plocar = $plocapp . '@' . $plocre;
		$cautar = $cautapp . '@' . $cautre;
		$fnamear = $fnameapp . '@' . $fnamere;
		$psumar = $psumapp . '@' . $psumre;
		$rtypear = $rtypeapp . '@' . $rtypere;
		$rsumar = $rsumapp . '@' . $rsumre;
		$reasonattar = $reasonattapp . '@' . $reasonattre;	
		$comnamear = $comnameapp . '@' . $comnamere;		
		// code for concatenating above fields
		$userapdet = 'uname^'.$unamear . '#uphone^' . $uphonear . '#uexp^' . $uexpar . '#udob^' . $udobar . '#ugen^' . $ugenar . '#ucsal^' . $ucsalar . '#udoj^' . $udojar. '#upayslip^' . $payslipar. '#updatedcv^' . $updatecvar. '#uemail^' . $uemailar. '#ploc^' . $plocar. '#cauth^' . $cautar. '#fname^' . $fnamear. '#psum^' . $psumar. '#rtype^' . $rtypear. '#rsum^' . $rsumar. '#reattach^' . $reasonattar.'#comname^' . $comnamear;
		$ss="update tbl_jobseeker SET adm_status='".$userapdet."',JuserStatus='IP',updated_adm_date=NOW() where JUser_Id='".$juserid."'";
		$ss_res=mysqli_query($con,$ss);					
				?>
				<script>alert("Successfully updated");
				window.location.href = "jobseeker-detail-recruiter.php?uid=<?php echo $juserid  ?>";</script>
				<?php
  }
 
?>

					

		