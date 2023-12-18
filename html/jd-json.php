<?php 
// define('HOSTNAME','localhost');
// define('DB_USERNAME','root');
// define('DB_PASSWORD','N@edy1n.C0m_D');
// define('DB_NAME', 'needyin_phase1_dev');
// $con = mysqli_connect(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("error");
// // Check connection
// if(mysqli_connect_errno($con))  echo "Failed to connect MySQL: " .mysqli_connect_error();
// echo 'connected';

// $data = file_get_contents('http://www.dev.needyin.com/Job_discriptions.json'); 
// $array = json_decode($data, true);
// foreach($array as $row){
// $sql = "INSERT INTO tbl_newjd(Job_Role,Job_brief,Required_skills,Duties_and_responsibilities) VALUES('".$row["Job_Role"]."','".$row["Job_brief"]."','".$row["Required_skills"]."','".$row["Duties_and_responsibilities"]."')";
// mysqli_query($connect,$sql);

// }
// echo "JD Inserted";
$string = "Hello Arjun...c.s.ds.ds.ds.d.sd.s";
?>
<body>
    <p>the string will appear in 30 seconds:</p>
	
    <p id="string" hidden="hidden"><?php echo $string; ?></p>
</body>
<script>
$( document ).ready(function() {
    $("#string").delay(30000).show();
});
</script>