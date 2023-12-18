    <?php
    ?>


    <?php 
  require_once 'config.php';

    if (isset($_POST) & !empty($_POST)) {
        $txtMobile = mysqli_real_escape_string($conn, $_POST['txtMobile']);
        $sql = "SELECT * FROM tbl_jobseeker WHERE JPhone = '$txtMobile'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0)
        {
        
            echo '<div style="color:Red;"><b>*'.$txtMobile.'</b>Number is already existed</div>';
        }
        else
        {
            // echo '<div style="color:Green;"><b>'.$txtMobile.'</b> Not Registered</div>';
        }   
    }
    ?>