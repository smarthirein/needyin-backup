
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>needyin smart screening</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="multiresume-uploader/css/global.css">
</head>
<body><center>
<!-- resume-upload.php -->
	<form action="#" method="POST" enctype="multipart/form-data" id="upload" class="upload">
		<fieldset>
			<legend>Upload for Smart Screening</legend>
			<input type="file" id="file" name="file[]" >
			<input type="submit" id="submit" name="submit" value="Upload">
			<input type = "submit" id="parse" name = "parse" value = "Screen">
			<input type = "submit" id = "export" name = "export" value = "ImporttoDB">
		</fieldset>
		<div class="bar">
			<span class="bar-fill" id="pb"><span class="bar-fill-text" id="pt"></span></span>
		</div>
		<div id="uploads" class="uploads">
			your uploaded file links will appear here.
		</div>

		<!-- <script src="multiresume-uploader/js/upload.js"></script> -->
		<script>

		// document.getElementById('submit').addEventListener('click', function(e){/
			e.preventDefault();

			var f = document.getElementById('file'),
				pb = document.getElementById('pb'),
				pt = document.getElementById('pt');

			app.uploader({
				files: f,
				progressBar: pb,
				progressText: pt,
				processor: 'resume-upload.php',

				finished: function(data){
					var uploads = document.getElementById('uploads'),
						succeeded = document.createElement('div'),
						failed = document.createElement('div'),

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
						anchor.innerText = data.succeeded[x].name;
						anchor.target = '_blank';

						succeeded.appendChild(anchor);
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
		});
		
		</script>
	</form></center>
	<?php
	if(isset($_POST['parse']))
	{
        $res = NULL;
        exec("python3 /var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/custom_t.py 2>&1" ,$res); //2>&1 @comments.KEK
        if(isset($res)){
            foreach($res as $rowRes){
            }
            echo "successfully screened your data";
        }
	}
?>
</body>
</html>
