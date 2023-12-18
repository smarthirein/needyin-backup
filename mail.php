<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
$my_folder = "./uploads/";
if(isset($_POST['submit']))
{
	$my_folder = "uploads/";
if (move_uploaded_file($_FILES['file']['tmp_name'], $my_folder . $_FILES['file']['name'])) {
    echo 'Received file' . $_FILES['file']['name'] . ' with size ' . $_FILES['file']['size'];
} else {
    echo 'Upload failed!';
   
}
}
?>
<!DOCTYPE html>    
    <body>
        <form action="#" 
              method="post" 
              enctype="multipart/form-data">
            <label for="file">
                Filename:
            </label>
            <input type="file" 
                   name="file" 
                   id="file"><br />
            <input type="submit" name="submit"
                   value="submit">
        </form>
    </body>
</html>
