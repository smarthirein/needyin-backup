<?php
require_once 'class.user.php';
 define(SITEURL,"http://www.dev.needyin.com");
$emp_login = new USER();				  
$stmt = $emp_login->runQuery("SELECT * FROM tbll_emplyer Re							
                              WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$em_id = strval($row['emp_id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$nt_query="select count(id)as sids from tbl_notifications where notification_to='".$_SESSION['empSession']."' and mode='jobseeker'  and notification_read=0";
$nt_res=mysqli_query($con,$nt_query);
$datas_sw=mysqli_fetch_array($nt_res);

?>
<div class="db-recruiter-header">
    <nav class="navbar navbar-static-top">
        <div class="container nopadmob">
            <div class="navbar-header">
                <!-- <a class="navbar-brand" href="dashboard-recruiter.php" id="logo" alt="needyin"><img src="<?php echo SITEURL;?>/img/logo-white.svg" alt="needyin" ></a> -->
            </div>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">smart-screen</button> -->
                <li class="<?php if($activePage == 'upload-index') { echo 'active';}?>" ><a href="#msg-pop"><span class="icon-nav"><i class="fa fa-upload" aria-hidden="true"></i></span>Smart-Screen</a></li>
                    <li class="<?php if($activePage == 'dashboard-recruiter') { echo 'active';}?>" ><a href="dashboard-recruiter.php"><span class="icon-nav"><i class="fa fa-tachometer" aria-hidden="true"></i></span>Dashboard</a></li>
                     <?php if($row['subscription_type'] != 'TRIAL') { ?>
					 <li class="<?php if($activePage == 'dbrecruiter-latest') { echo 'active';} ?>"><a href="http://dev.needyin.com/screened-profles.php"><span class="icon-nav"><i class="fa fa-user-o" aria-hidden="true"></i></span>PROFILES</a></li>
					 <?php } ?>
                    <!-- <li class="<?php if($activePage == 'rec-jobs'){ echo 'active';}?>"><a href="rec-jobs.php"><span class="icon-nav"><i class="fa fa-list-alt" aria-hidden="true"></i></span>JOBS</a></li>
					 <?php if($row['subscription_type'] != 'TRIAL') { ?>
                    <li class="<?php if($activePage == 'list-jobseekers-rec-db') { echo 'active';} ?>"><a href="list-jobseekers-rec-db.php"><span class="icon-nav"><i class="fa fa-search" aria-hidden="true"></i></span>SEARCH</a></li>
					 <?php } ?> -->
                    <li class="dropdown brdleft" > <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-nav"><img class="profile-ic-img" src="<?php if($row['ePhoto']){ echo $row['ePhoto'];}else { ?> ./img/profile-ic.png <?php } ?>"></span><?php echo $row["companyname"]?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="<?php if($activePage == 'view-profile-recruiter') { echo 'active';} ?>"><a href="view-profile-recruiter.php"><i class="fa fa-user-o" aria-hidden="true"></i> View / Edit Profile</a></li>
							<li class="<?php if($activePage == 'employer-profile-recent-activities') { echo 'active';} ?>"><a href="employer-profile-recent-activities.php"><i class="fa fa-clock-o" aria-hidden="true"></i> Recent Activities</a></li>
                            <li class="<?php if($activePage == 'recruiter-profile-update-password') { echo 'active';}?>"><a href="recruiter-profile-update-password.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a></li>
							<li class="<?php if($activePage == 'notifications-emp') { echo 'active';} ?>"><a href="notifications-emp.php"><i class="fa fa-envelope-o" aria-hidden="true"></i> Notifications(<?php echo $datas_sw['sids'] ?>)</a></li>
                            <li class="<?php if($activePage == 'logout') { echo 'active';} ?>"><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </li>
          
                </ul>
            </div>
        </div>
    </nav>
</div>
<div id="msg-pop" class="modal">

<?php
require_once 'config.php';
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
}    
//echo $_SESSION['empPhase2'];              
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer Re WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$emp_id = $row['emp_id'];
?>
	<meta charset="UTF-8" />
	<title>needyin smart screening</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="multiresume-uploader/css/global.css">
</head>
<body><center>

	<form action="resume-upload.php" method="POST" enctype="multipart/form-data" id="upload" class="upload">
	<fieldset>
<legend>Upload for Smart Screening</legend></fieldset>
    <div>										 
    <div>
        <label>SelectJobName<span class="mand">*</span> </label>                                
		<?php
$sql4 = "SELECT DISTINCT Job_Name FROM tbl_jobposted  WHERE emp_id='".$row['emp_id']."'";
$query4 = mysqli_query($con, $sql4);																	;
		?>
        <select class="form-control classic" name="PJobName" id="PJobName" data-live-search="true" data-show-subtext="true" onChange="job_check(this); showArea(this.value);">
		<option value="">Job List</option> 
		<option value="Otherjob">Others</option>														
		<?php
		while($row4 = mysqli_fetch_array($query4)){
			$sql = "SELECT * FROM tbl_jobdesc where id ='".$row4['Job_Name']."'";
			$query = mysqli_query($con, $sql);
			$row2 = mysqli_fetch_array($query);
		?>
		<option value="<?php echo $row2['id']; ?>" <?php if(trim($row2['id'])== "1"){ echo "selected";}else { echo "";}?>><?php echo $row2['Job_Role']; ?></option>

		<?php } ?>
        </select>
        </div></div>
<div>
<label>Source of these files<span class="mand">*</span> </label> 
<select class="form-control classic" name="srcId" id="srcId">
<option value = "">Source List</option>
<option value = "others">Others</option>
<option value = "referrals">Referrals</option>
<option value = "downloads">Downloads</option>
<option value = "internaldb">Internal DB</option>
<option value= "careersite">Career Site</option>
<option value= "agents">Agents</option>
<option value= "drive">Drive</option>
</select>
</div>
<fieldset>
<div class="row">
<div class="file-field input-field">
<div class="btn" style="height=25px"> <span>Upload Your Resumes</span>
<input type="file" id="file" name= "file[]" style="height=25px" required multiple>
</div></div><br>

<div class="row">
<input class="btn btn-primary" type="submit" id = "submit" name = "submit" value="Screen">
</div>
</fieldset>
<div class="bar">
<span class="bar-fill" id="pb"><span class="bar-fill-text" id="pt"></span></span>
</div>
<div id="uploads" class="uploads">
your uploaded file links will appear here.
</div>
</form>
<script src="multiresume-uploader/js/upload.js"></script>
<script>

// $('#file').change(function () {
// 	$('select#PJobName').val();
// 	alert($('select#PJobName').children("option:selected").val());

// });
/*
	var ajaxTime= new Date().getTime();
	var totalTime = new Date().getTime()-ajaxTime;
	*/
		document.getElementById('submit').addEventListener('click', function(e){
			e.preventDefault();

			// var ajaxTime= new Date().getTime();
			// alert("ajaxTime--"+ajaxTime)
			var totalTime;
			var f = document.getElementById('file'),
				pb = document.getElementById('pb'),
				pt = document.getElementById('pt'),
				pjobname=$('select#PJobName').children("option:selected").val(), 
				srcId=$('select#srcId').children("option:selected").val();
				set_unsetajaxData(pjobname,srcId,'set');

			app.uploader({
				files: f,
				progressBar: pb,
				progressText: pt,
				input:pjobname,
				processor: 'resume-upload.php',
				
				finished: function(data){
					var uploads = document.getElementById('uploads'),
						succeeded = document.createElement('div'),
						failed = document.createElement('div'),
						pjobname,
						anchor,
						span,
						x;

					if(data.failed.length){
						failed.innerHTML = '<p>Only pdf,docx files are allowed:</p>'
					}

					uploads.innerText = '';

					for(x = 0; x < data.succeeded.length; x = x + 1){
						anchor = document.createElement('a');
						anchor.href = 'multiresume-uploader/virtualenvironment/project_1/uploads/' + data.succeeded[x].file;
						//parseData(data.succeeded[x].name);
						anchor.innerText = data.succeeded[x].name;
						anchor.target = '_blank';

						succeeded.appendChild(anchor);
						set_unsetajaxData(pjobname,srcId,'unset');
						totalTime = new Date().getTime()-ajaxTime;
						// alert("totalTime--"+totalTime);
					}
					
					for(x = 0; x < data.failed.length; x = x + 1){
						span = document.createElement('span');
						span.innerText = data.failed[x].name;

						failed.appendChild(span);
					}

					uploads.appendChild(succeeded);
					uploads.appendChild(failed);
				},

				error: function(){
					console.log('Not working.');
				}
			});	
			// console.log(totalTime);		
		});
		
		</script> 
	</form>
			
			</div>
<script type="text/javascript">

function set_unsetajaxData(pjobname,srcid,flag)
{	
   
	$.ajax({
                    type: "POST",
                    url: "dashboard-recruiter.php",//url to file # open this page
                    data: {flag:flag,pjobname:pjobname,srcid:srcid},
                    success: function(data){                    
                      }
                    });
}

</script>	
<?php
session_start();
//  if(isset($_POST['flag']) === 'set')
//  {
  $_SESSION['pjobname'] = $_POST['pjobname'];
  $_SESSION['srcid'] = $_POST['srcid'];
//  }
//  else if(isset($_POST['flag']) === 'unset')
//  {
// 	unset($_SESSION['pjobname']);
// 	 unset($_SESSION['srcid']);
//  }
//use session 
?>		