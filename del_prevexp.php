<?php require_once 'class.user.php';
if($_GET['exp_id']!="")
{   
          $juser_id=$_GET['user_id'];
        $exp_id=$_GET['exp_id'];
           $qq="delete from tbl_experience where JUser_Id='".$juser_id."' and Exp_Id='".$exp_id."'"; 
           $qq_res=mysqli_query($con,$qq);

           if($qq_res!=0)
        {
        ?>  <script>alert("Record deleted Successfully");window.location.href = "jobseeker-profile.php";</script>
      <?php  
         }
       else 
      echo mysqli_error($con);
 } 