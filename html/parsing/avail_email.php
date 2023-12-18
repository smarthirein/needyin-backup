<?php 

require_once 'config.php';

if (isset($_POST) & !empty($_POST)) {
    $txtEmail = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $sql = "SELECT * FROM tbl_jobseeker WHERE JEmail = '$txtEmail'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0)
     {
       
        echo '<div style="color:Red;"><b>'.$txtEmail.'</b>Already Registered<a href = "http://test.needyin.com/job-seeker-login.php">click here to login</a></div>';
    }
    else
    {
        // echo '<div style="color:Green;"><b>'.$txtEmail.'</b> Valid Email</div>';
    }
}
?>