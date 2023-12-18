<?php
require_once 'config.php';
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
}  
$servername = "localhost";
$username = "root";
$password = "N@edy1n.C0m_D";
$dbname = "ni_screening_db";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 $sql = "SELECT * from tbl_jobseeker"

/* -----------------below method is working that's why this code commented------------------
         $file_path='/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/';

        $dyanamic_file='emp_id_10_samplee7.json';
        $jsonfiledata=array(); $jsondata='';
        $extn='';
        $extn=!empty($dyanamic_file) ? explode(".",$dyanamic_file)[1] : '';        
        if(file_exists($file_path.''.$dyanamic_file)) {
            if($extn === 'json'){
                // $jsondata = json_decode(file_get_contents($file_path.''.$dyanamic_file), true);
                // $jsonfiledata = json_decode($jsondata, true); 
                $jsonfiledata = file_get_contents($file_path.''.$dyanamic_file);
            }        } else {
            # not found statement;
        }   
          
          $jsonfiledata = json_decode($jsonfiledata, true); 
          $json_resp=array();
          if(!empty($jsonfiledata)){
            foreach ($jsonfiledata as $u => $z){  
                foreach ($z as $n => $line){
                    $json_resp[$n]=$line;
                }
            }
          }else { 
              echo "false";
        }
*/
if(isset($_POST['submit']))
{    
   $jobname =  $_POST['PJobName'];
   $source = $_POST['source'];
        foreach (new DirectoryIterator('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/') as $file) {
          $files[] = $file;

           if ($file->getExtension() === 'json') {  
            foreach ($file as $files ) {

                    // $array = json_decode(file_get_contents($file->getPathname()), true);
                    $jsondata = json_decode(file_get_contents($file->getPathname()), true);
// $data = json_decode($jsondata, true);  
//  $jsonfiles = array('/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/emp_id_10_samplee7.json', '/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/emp_id_10_sample13.json', '/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads/emp_id_10_sample15.json');
//     foreach ( $array as $jsonfile ) {
//         $jsondata = file_get_contents($jsonfile);      
//         $data = json_decode($jsondata, true); 
//     foreach ( $array as $jsonfile )
//     {
//         $jsondata = json_decode(file_get_contents($array->getPathname()), true);
//         $data = json_decode($jsondata, true);
//     }
// } 
// $stmt = mysqli_prepare($conn, 'INSERT INTO tbl_jobseeker(JFullName, JEmail, JPhone, JTotalEy, JTotalEm,JLoc_Name, Job_Skills, profile_summary, Sec_Skills, pri_skills) VALUES (?,?,?,?,?,?,?,?,?,?)');    
$stmt = $conn->prepare("INSERT INTO tbl_jobseeker(JFullName, JEmail, JPhone, JTotalEy, JTotalEm,JLoc_Name, Job_Skills, profile_summary, Sec_Skills, pri_skills,Jeducation) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$stmt2 = $conn->prepare("INSERT INTO tbl_project_dtls(project_name, project_title, project_client, project_desc, project_duration, project_responsibilities, project_contributions, project_databases, project_software_tools, project_role, computer_proficiency,certifications) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        foreach ($jsondata as $u => $z){  
            foreach ($z as $n => $line){

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
$programming_languages = (isset($line['Programing_Language'])) ?  (is_array($line['Programing_Language'])) ? implode($line['Programing_Language']) : $line['Programing_Language'] : '';
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
            $tchnical_skills =($tchnical_skills) ? $tchnical_skills : 'null';
            $non_technical_skills =($non_technical_skills) ? $non_technical_skills : 'null';
            $key_role =($key_role) ? $key_role : 'null';
            $web_technologies =($web_technologies) ? $web_technologies : 'null';
            $technologies =($technologies) ? $technologies : 'null';
            $frameworks =($frameworks) ? $frameworks : 'null';
            $servers =($servers) ? $servers : 'null';
            $ides =($ides) ? $ides : '0';
            $environment =($environment) ? $environment : 'null';
            $programming_languages =($programming_languages) ? $programming_languages : 'null';
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
            $operating_systems = ($operating_systems) ? $operating_systems : 'null';
            $responsibilities = ($responsibilities) ? $responsibilities : 'null';
            $certification = ($certification) ? $certification : 'null';
            $achievements = ($achievements) ? $achievements : 'null';
            $project_contributions = ($project_contributions) ? $project_contributions : 'null';
            $project_databases = ($project_databases) ? $project_databases : 'null';
            $project_tools = ($project_tools) ? $project_tools : 'null';
            $computer_proficiency = ($computer_proficiency) ? $computer_proficiency : 'null';

            $databases = $hosting_platforms.",".$operating_systems.",".$project_databases.",".$servers;
            $certifications = $certification.",".$achievements;
            $software_tools = $project_tools.",".$operating_systems.",".$frameworks;
            // end------------------------------------
            $stmt->bind_param("sssssssssss", $name,$email,$mobile,$work_experience,$professional_experience,$location,$programming_languages,$profile_summary, $non_technical_skills, $tchnical_skills, $education);
            // mysqli_stmt_bind_param($stmt, 'ssssssssss', $name,$email,$mobile,$work_experience,$professional_experience,$location,$programming_languages,$profile_summary, $non_technical_skills, $tchnical_skills);                
     
            $stmt2->bind_param("ssssssssssss", $project_name, $project_title, $project_client, $project_description, $duration, $responsibilities, $project_contributions, $databases, $software_tools, $role, $computer_proficiency, $certifications);

            // if (!$stmt->execute()) {
            // $msg = "Something went wrong";
            // }else{
            //     $msg = "inserted";
            // }
            // $stmt->close();
            // if(!$stmt2->execute())
            // {
            //     $msgs = "Something went wrong when project details uploading";
            //     else
            //     {
            //         $msgs = "Successfully Inserted";
            //     }
            // }
            // $stmt2->close();
            if ($stmt->execute() == false)
            {
                echo 'First query failed: ' . $conn->error;
            }
            $stmt->close();
            if ($stmt2->execute() == false)
            {
                echo 'Second query failed: ' . $conn->error;
            }
            else{
                header("Location: http://dev.needyin.com/recruiter.php")
            }
            $stmt2->close();
        }}}}} }
        // echo $msg;echo $msgs
?>
