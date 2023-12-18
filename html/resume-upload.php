<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');
session_cache_limiter('public'); 
session_start();
require_once 'class.user.php';
require_once 'dbconfig.php';
// require_once 'config.php';   
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');
}  
$database = new Database();
$conn = $database->dbConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	// echo "connected";
}
//calling employer set
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer Re WHERE Re.emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// $em_id = strval($row['emp_id']); // for the purpose of respected employer folder wise
$em_id = $row['emp_id'];
// print_r($em_id);
// $dir_name="emp_id_".$em_id; 



//--------making directory for respected employer----------// 
// mkdir('multiresume-uploader/virtualenvironment/project_1/uploads/'.$dir_name, 0777, true);
// $crtng_uploading_dir = chmod('multiresume-uploader/virtualenvironment/project_1/uploads/'.$dir_name, 0777); 
// $uploading_dir = $crtng_uploading_dir;

// echo $uploading_dir;
//-----making directory for respected employer----------end-//
function get_loc($location){ 
	$database = new Database();
	$loc_conn = $database->dbConnection();
	if ($loc_conn->connect_error) {
		die("Connection failed: " . $loc_conn->connect_error);
	} else {
				
		$sql = "SELECT Loc_Id, Loc_Name FROM tbl_location where Loc_Name='".$location."'";  
		$res = $loc_conn->query($sql); 
	
		if($res->rowCount() > 0){
			$row = $res->fetch(); 
		return $row['Loc_Id'];
		}else{
			return 0;
		}
}
$loc_conn->close();
}
function get_skill($skillarr){ 
	$skill_arr='';$ret_skill_arr='';
	
	$database = new Database();
	$skill_conn = $database->dbConnection();
	if ($skill_conn->connect_error) {
		die("Connection failed: " . $skill_conn->connect_error);
	} else {
		
		$skills=explode(",",$skillarr);
		
			for($i=0; $i < count($skills); $i++){
				
				if($skills[$i]!='' && $skills[$i]!='null')
				{
				$skillsql = "SELECT skill_Id FROM tbl_masterskills WHERE skill_Name= '".$skills[$i]."'";
				$skill_exist = $skill_conn->query($skillsql); 
			
				if($skill_exist->rowCount() > 0)
				{						
				$skillrow = $skill_exist->fetch(); 			
				$ret_skill_arr .= $skillrow['skill_Id'].",";	
				
				}else{
				
				$status=1;$flag=1;
				$ret_skill_arr .= addNewSkills($skills[$i],$status,$flag) . ",";				
				
				}
			}
			// print_r($ret_skill_arr);
		
	}
		
}
return rtrim($ret_skill_arr, ',');
// $skill_conn->close();
}
function addNewSkills($Skillname,$skillstatus,$skillflag)
{
	$insert_db = new Database();
	$insert_conn = $insert_db->dbConnection();
	$skill_Id='';
	if ($insert_conn->connect_error) {
		die("Connection failed: " . $insert_conn->connect_error);
	} else {
		$skillstmt=$insert_conn->prepare("INSERT INTO tbl_masterskills(skill_Name,skill_Status,flag) VALUES (:skill_Name, :skill_Status, :flag)");
		$skillstmt->bindparam(":skill_Name", $Skillname);
		$skillstmt->bindparam(":skill_Status", $skillstatus);
		$skillstmt->bindparam(":flag", $skillflag);
		$skillstmt->execute();
		$skill_Id=$insert_conn->lastInsertId('skill_Id');
		
	}
	return ($skill_Id) ? $skill_Id: '';
}

$uploaded = [];
$allowed = ['pdf', 'docx', 'doc'];

$succeeded = [];
$failed = [];

if(!empty($_FILES['file'])){
	$start_time =microtime(true);
	foreach($_FILES['file']['name'] as $key => $name){
		if($_FILES['file']['error'][$key] === 0){
			$temp = $_FILES['file']['tmp_name'][$key];


			$ext = explode('.', $name);
			$ext = strtolower(end($ext));
	 			
			// $file = md5_file($temp) . time() . '.' . $ext;
			// $em_id = $file;
			$dir_name="emp_id_".$em_id;
			$file = "emp_id_".$em_id."_$name";
			rename($name,$file);
			if(in_array($ext, $allowed) === true && move_uploaded_file($temp, "/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/$file") === true ){
				// /var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/emp_id_$em_id/$file
				// print_r('/var/www/dev.needyin.com/html/multiresume-uploader/uploads/'."emp_id_".$em_id."/".$file);

				$parseVar=(parseData($file)) ? 1 : 0;
				// print_r($parseVar);
				$save_JSON=($parseVar) ?  save_JSONResp($dir_name,$em_id,$file) : 0;
				$endtime=microtime(true);

				$succeeded[] = array(
					'name' => $name,
					'file' => $file,
					'parse'=> $parseVar,
					'save_JOSN'=>$save_JSON,
					'time'=> $start_time-$endtime

				); 
			}else{
				$endtime=microtime(true);
				$failed[] = array(
					'name' => $name,
					'parse'=> 0,
					'save_JOSN'=>0,
					'time'=> $start_time-$endtime
				);
			}
		}
	}
	if(!empty($_POST['ajax'])){
		echo json_encode(array(
			'succeeded' => $succeeded,
			'failed' => $failed
		));
	}


}

	function parseData($input)
	{
		$res = NULL; $return=NULL;
		$res = shell_exec("python3 /var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/custom_t-all_ext.py 2>&1"); //2>&1 @comments.KEK
		if(isset($res))
		{  
			foreach($res as $rowRes)
			{
			}
			$return =1;			
		}
		return $return;
	}	
	
			$locationid=0;
			$skillid=0;
			function save_JSONResp($dirname, $empid, $input_file){
			$database = new Database();
			$conn = $database->dbConnection();
			$extn='josn';
			$query_resp[]='';
			$file_flag='';
			$msg='';
			$return='';			
			$jsonfiledata=array();
			$jsondata='';
			$allowed = ['pdf', 'docx', 'doc'];
			$fullstr=(!empty($input_file)) ? explode(".",$input_file) : ''; 

			if(in_array(strtolower($fullstr[1]),$allowed) === true ){
				$filename=$input_file;
			}else {
				$filename=$fullstr[0];
			}
			$new_filename = pathinfo($filename, PATHINFO_FILENAME);
			// http://dev.needyin.com/multiresume-uploader/virtualenvironment/project_1/uploads
			// $file_path="/multiresume-uploader/virtualenvironment/project_1/uploads/$new_filename.json";
			$file_path_new = "/multiresume-uploader/virtualenvironment/project_1/uploads/$filename";
			$file_path="http://dev.needyin.com/multiresume-uploader/virtualenvironment/project_1/uploads/$new_filename.json";
			if (false!==file($file_path)) echo "Wow! Your files exists\n";
			// else echo "missing\n";
			// if(file_exists($file_path)){
			// if (false!==file($file_path)){
			$json = json_decode(file_get_contents($file_path),true);			
			$jsonfiledata = json_decode(file_get_contents($file_path),true);
			// $insertstmt=$conn->prepare("INSERT INTO tbl_jobseeker(JFullName, JEmail, JPhone, JTotalEy, JTotalEm,JLoc_Name, Job_Skills, profile_summary, Sec_Skills, pri_skills,Jeducation,file_location, upload_emplr_Id ) VALUES (:JFullName, :JEmail, :JPhone, :JTotalEy, :JTotalEm,:JLoc_Name, :Job_Skills, :profile_summary, :Sec_Skills, :pri_skills, :Jeducation, :file_location, :upload_emplr_Id)");
			$insertstmt=$conn->prepare("INSERT INTO tbl_jobseeker(JFullName, JEmail, JPhone, JTotalEy, JTotalEm,JPLoc_Id, JLoc_Name, Job_Skills, profile_summary, Sec_Skills, pri_skills,JSource, upload_emplr_Id, Job_Id,file_location,Jeducation) VALUES (:JFullName, :JEmail, :JPhone, :JTotalEy, :JTotalEm,:JPLoc_Id,:JLoc_Name, :Job_Skills, :profile_summary, :Sec_Skills, :pri_skills, :JSource, :upload_emplr_Id, :Job_Id, :file_location, :Jeducation)");
			$stmt2 = $conn->prepare("INSERT INTO tbl_project_dtls(project_name, project_title, project_client, project_desc, project_duration, project_responsibilities, project_contributions, project_databases, project_software_tools, project_role, computer_proficiency, certifications, upload_emplr_Id, user_id, project_domain) VALUES (:project_name, :project_title, :project_client, :project_desc, :project_duration, :project_responsibilities, :project_contributions, :project_databases, :project_software_tools, :project_role, :computer_proficiency, :certifications, :upload_emplr_Id, :user_id, :project_domain)");		

					
// parsed profiles data validation, if the data is not there in resume it will store null value
			 $upload_emplr_Id=($em_id) ? $em_id : $empid;
			 $jobName = ($jobName) ? $jobName : $jobName;
			 $fileSource = ($fileSource) ? $fileSource : $fileSource;
				// echo "<pre>";
				foreach ($jsonfiledata as $u => $z){					
					foreach ($z as $n => $line){
					// print_r($line);
					$name =(isset($line['NAME'])) ? (is_array($line['NAME'])) ? implode($line['NAME']) : $line['NAME'] : '';            
					$email =(isset($line['EMAIL'])) ? (is_array($line['EMAIL'])) ? implode($line['EMAIL']) : $line['EMAIL'] : '';    
					$mobile=(isset($line['PHONE NUMBER'])) ? (is_array($line['PHONE NUMBER'])) ? implode($line['PHONE NUMBER']) : $line['PHONE NUMBER'] :'';
					$professional_experience = (isset($line['PROFESSIONAL EXPERIENCE'])) ? (is_array($line['PROFESSIONAL EXPERIENCE'])) ? implode($line['PROFESSIONAL EXPERIENCE']) : $line['PROFESSIONAL EXPERIENCE'] : '';
					$relevant_experience = (isset($line['RELEVENT EXPERIENCE'])) ? (is_array($line['RELEVENT EXPERIENCE'])) ? implode($line['RELEVENT EXPERIENCE']) : $line['RELEVENT EXPERIENCE'] : '';
					$work_experience = (isset($line['Work Experience'])) ? (is_array($line['Work Experience'])) ? implode($line['Work Experience']) : $line['Work Experience']: '';
					$job_profile = (isset($line['Job Profile'])) ? (is_array($line['Job Profile'])) ? implode($line['Job Profile']) : $line['Job Profile'] : '';
					$profile_summary = (isset($line['Profile Summary'])) ? (is_array($line['Profile Summary'])) ? implode($line['Profile Summary']) : $line['Profile Summary']:'';
					$internships = (isset($line['INTERNSHIP'])) ? (is_array($line['INTERNSHIP'])) ? implode($line['INETRNSHIP']) : $line['INTERNSHIP'] : '';
					$freelancing = (isset($line['FREELANCING'])) ? (is_array($line['FREELANCING'])) ? implode($line['FREELANCING']) : $line['FREELANCING'] :''; 
					$tchnical_skills = (isset($line['TECHNICAL SKILLS'])) ? (is_array($line['TECHNICAL SKILLS'])) ? implode($line['TECHNICAL SKILLS']) : $line['TECHNICAL SKILLS'] : '';
					$non_technical_skills = (isset($line['NON TECHNICAL SKILLS'])) ? (is_array($line['NON TECHNICAL SKILLS'])) ? implode($line['NON TECHNICAL SKILLS']) : $line['NON TECHNICAL SKILLS'] : '';
					$key_role = (isset($line['KEY ROLE'])) ? (is_array($line['KEY ROLE'])) ? implode($line['KEY ROLE']) : $line['KEY ROLE'] : '';
					$web_technologies = (isset($line['Web Technologies'])) ? (is_array($line['Web Technologies'])) ? implode($line['Web Technologies']) : $line['Web Technologies'] : '';
					$technologies = (isset($line['Technologies'])) ?  (is_array($line['Technologies'])) ? implode($line['Technologies']) : $line['Technologies'] : '';
					$frameworks = (isset($line['Frameworks'])) ?  (is_array($line['Frameworks'])) ? implode($line['Frameworks']) : $line['Frameworks'] : '';
					$servers = (isset($line['SERVER'])) ?  (is_array($line['SERVER'])) ? implode($line['SERVER']) : $line['SERVER'] : '';
					$ides = (isset($line['IDE'])) ?  (is_array($line['IDE'])) ? implode($line['IDE']) : $line['IDE'] : '';
					$environment = (isset($line['ENIVORMENT'])) ?  (is_array($line['ENIVORMENT'])) ? implode($line['ENIVORMENT']) : $line['ENIVORMENT'] : '';
					$programming_languages = (isset($line['Programming_Language'])) ?  (is_array($line['Programming_Language'])) ? implode($line['Programming_Language']) : $line['Programming_Language'] : '';
					$networking = (isset($line['Networking'])) ?  (is_array($line['Networking'])) ? implode($line['Networking']) : $line['Networking'] : '';
					$education = (isset($line['EDUCATION'])) ?  (is_array($line['EDUCATION'])) ? implode($line['EDUCATION']) : $line['EDUCATION'] : '';
					$current_company_wise_duration = (isset($line['CURRENT COMPANY WISE DURATION'])) ?  (is_array($line['CURRENT COMPANY WISE DURATION'])) ? implode($line['CURRENT COMPANY WISE DURATION']) : $line['CURRENT COMPANY WISE DURATION'] : '';
					$previous_company = (isset($line['PREVIOUS COMPANY'])) ?  (is_array($line['PREVIOUS COMPANY'])) ? implode($line['PREVIOUS COMPANY']) : $line['PREVIOUS COMPANY'] : '';
					$role = (isset($line['ROLE'])) ?  (is_array($line['ROLE'])) ? implode($line['ROLE']) : $line['ROLE'] : '';
					$location = (isset($line['LOCATION'])) ?  (is_array($line['LOCATION'])) ? implode($line['LOCATION']) : $line['LOCATION'] : '';
					$projects =  (isset($line['PROJECTS'])) ? (is_array($line['PROJECTS'])) ? implode($line['PROJECTS']) : $line['PROJECTS'] : '';
					$project_name =  (isset($line['Project Name'])) ? (is_array($line['Project Name'])) ? implode($line['Project Name']) : $line['Project Name'] : '';
					$project_title =  (isset($line['Project Title'])) ? (is_array($line['Project Title'])) ? implode($line['Project Title']) : $line['Project Title'] : '';
					$project_client =  (isset($line['Client'])) ? (is_array($line['Client'])) ? implode($line['Client']) : $line['Client'] : '';
					$project_description = (isset($line['Project Description'])) ? (is_array($line['Project Description'])) ? implode($line['Project Description']) : $line['Project Description'] : '';
					$project_details =  (isset($line['Project Details'])) ? (is_array($line['Project Details'])) ? implode($line['Project Details']) : $line['Project Details'] : '';
					$duration =  (isset($line['DURATION'])) ? (is_array($line['DURATION'])) ? implode($line['DURATION']) : $line['DURATION'] : '';
					$hosting_platforms =  (isset($line['Hosting Platforms'])) ? (is_array($line['Hosting Platforms'])) ? implode($line['Hosting Platforms']) : $line['Hosting Platforms'] : '';
					$operating_systems =  (isset($line['Operating System'])) ? (is_array($line['Operating System'])) ? implode($line['Operating System']) : $line['Operating System'] : '';
					$responsibilities =  (isset($line['Responsibilities'])) ? (is_array($line['Responsibilities'])) ? implode($line['Responsibilities']) : $line['Responsibilities'] : '';
					$certification =  (isset($line['CERTIFICATION'])) ? (is_array($line['CERTIFICATION'])) ? implode($line['CERTIFICATION']) : $line['CERTIFICATION'] : '';
					$achievements =  (isset($line['ACHIEVEMENT'])) ? (is_array($line['ACHIEVEMENT'])) ? implode($line['ACHIEVEMENT']) : $line['ACHIEVEMENT'] : '';
					$project_contributions =  (isset($line['CONTRIBUTIONS'])) ? (is_array($line['CONTRIBUTIONS'])) ? implode($line['CONTRIBUTIONS']) : $line['CONTRIBUTIONS'] : '';
					$project_databases =  (isset($line['DATABASE'])) ? (is_array($line['DATABASE'])) ? implode($line['DATABASE']) : $line['DATABASE'] : '';
					$project_tools =  (isset($line['TOOLS'])) ? (is_array($line['TOOLS'])) ? implode($line['TOOLS']) : $line['TOOLS'] : '';
					$computer_proficiency =  (isset($line['Computer Proficiency'])) ? (is_array($line['Computer Proficiency'])) ? implode($line['Computer Proficiency']) : $line['Computer Proficiency'] : '';		
					$project_domain = (isset($line['Domain'])) ? (is_array($line['Domain'])) ? implode($line['Domain']) : $line['Domain'] : '';
// -----------------------------------------------------------------------------------
							$name=($name) ? $name : 'null';
							$email=($email) ? $email : 'null';
							$mobile=($mobile) ? $mobile : '0';
							// ---------------******* new lines***----------       
							$professional_experience =($professional_experience) ? $professional_experience : '0';
							$relevant_experience =($relevant_experience) ? $relevant_experience : '0';
							$work_experience =($work_experience) ? $work_experience : '0';
							$job_profile =($job_profile) ? $job_profile : 'null';
							$profile_summary =($profile_summary) ? $profile_summary : 'null';
							$internships =($internships) ? $internships : 'null';
							$freelancing =($freelancing) ? $freelancing : 'null';
							$tchnical_skills =($tchnical_skills) ? $tchnical_skills : '';
							$non_technical_skills =($non_technical_skills) ? $non_technical_skills : 'null';
							$key_role =($key_role) ? $key_role : 'null';
							$web_technologies =($web_technologies) ? $web_technologies : '';
							$technologies =($technologies) ? $technologies : 'null';
							$frameworks =($frameworks) ? $frameworks : 'null';
							$servers =($servers) ? $servers : 'null';
							$ides =($ides) ? $ides : '0';
							$environment =($environment) ? $environment : 'null';
							// $programming_languages =($programming_languages) ? $programming_languages : '';
							$networking =($networking) ? $networking : 'null';
							$education =($education) ? $education : 'null';
							$current_company_wise_duration =($current_company_wise_duration) ? $current_company_wise_duration : 'null';
							$previous_company =($previous_company) ? $previous_company : 'null';
							$role =($role) ? $role : 'null';
							$location =($location) ? $location : 'null';
							$projects  = ($projects) ? $projects : 'null';
							$project_name = ($project_name) ? $project_name : 'null';
							$project_title = ($project_title) ? $project_title : 'null';
							$project_client = ($project_client) ? $project_client : 'null';
							$project_description = ($project_description) ? $project_description : 'null';
							$project_details = ($project_details) ? $project_details : 'null';
							$duration = ($duration) ? $duration : 'null';
							$hosting_platforms = ($hosting_platforms) ? $hosting_platforms : 'null';
							$operating_systems = ($operating_systems) ? $operating_systems : '';
							$responsibilities = ($responsibilities) ? $responsibilities : 'null';
							$certification = ($certification) ? $certification : 'null';
							$achievements = ($achievements) ? $achievements : 'null';
							$project_contributions = ($project_contributions) ? $project_contributions : 'null';
							$project_databases = ($project_databases) ? $project_databases : '';
							$project_tools = ($project_tools) ? $project_tools : 'null';
							$computer_proficiency = ($computer_proficiency) ? $computer_proficiency : 'null';

							$databases = $hosting_platforms.",".$operating_systems.",".$project_databases.",".$servers;
							$certifications = $certification.",".$achievements;
							$software_tools = $project_tools.",".$operating_systems.",".$frameworks;
							$programming_language = $programming_languages.",".$tchnical_skills.",".$web_technologies.",".$databases;
							// getting location id and skill id's from functions
							$locationid= get_loc($location);				
							//old line// ($programming_language) ? $skillid = get_skill($line['Programming_Language']) : '';
							($programming_language) ? $skillid = get_skill($programming_language) : '';
							$project_domain = ($project_domain) ? $project_domain: 'null';
						
//start------------------********************** --------pdo bindparam----------- 
							$insertstmt->bindparam(":JFullName", $name);	
							$insertstmt->bindparam(":JEmail", $email);	    
							$insertstmt->bindparam(":JPhone", $mobile);	    
							$insertstmt->bindparam(":JTotalEy", $work_experience);	
							$insertstmt->bindparam(":JTotalEm", $professional_experience);
							$insertstmt->bindparam(":JPLoc_Id", $locationid); 	
							$insertstmt->bindparam(":JLoc_Name", $loc_name);
							$insertstmt->bindparam(":Job_Skills", $skillid);	
							$insertstmt->bindparam(":profile_summary", $profile_summary);	
							$insertstmt->bindparam(":Sec_Skills", $non_technical_skills);	
							$insertstmt->bindparam(":pri_skills", $tchnical_skills);	
							$insertstmt->bindparam(":JSource", $_SESSION['srcid']);								
							$insertstmt->bindparam(":upload_emplr_Id", $upload_emplr_Id);
							$insertstmt->bindparam(":Job_Id", $_SESSION['pjobname']);
							$insertstmt->bindparam(":file_location", $file_path_new);													
							$insertstmt->bindparam(":Jeducation", $education);

							$insertstmt->execute();
							$JUser_Id=$conn->lastInsertId('JUser_Id');		

							///////second tbl-----------------
								$stmt2->bindparam(":project_name",$project_name);
								$stmt2->bindparam(":project_title",$project_title);
								$stmt2->bindparam(":project_client",$project_client);
								$stmt2->bindparam(":project_desc",$project_description);
								$stmt2->bindparam(":project_duration",$duration);
								$stmt2->bindparam(":project_responsibilities",$responsibilities);
								$stmt2->bindparam(":project_contributions",$project_contributions);
								$stmt2->bindparam(":project_databases",$project_databases);
								$stmt2->bindparam(":project_software_tools",$project_tools);
								$stmt2->bindparam(":project_role",$role);
								$stmt2->bindparam(":computer_proficiency",$computer_proficiency);
								$stmt2->bindparam(":certifications",$certification);
								$stmt2->bindparam(":upload_emplr_Id",$upload_emplr_Id);
								$stmt2->bindparam(":user_id",$JUser_Id);
								$stmt2->bindparam(":project_domain",$project_domain);
																
							$stmt2->execute(); 
							

//end------------------********************** --------pdo bindparam-----------		
										}
								}
							
							$file_flag=1;

							// } #if file exist -> else 
							// else
								$msg= "exist";
							// 	$file_flag=0;
							return $query_resp=array('file_status'=>$file_flag,'msgs'=>$msg,'locid'=>$locationid,'skillid'=>$skillid,'jobid'=>$_SESSION['pjobname']); exit;
						} 

?>
