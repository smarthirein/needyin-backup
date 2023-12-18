<?php
session_start();
 

$expireAfter = 20;
 

if(isset($_SESSION['last_action']))
{
    
   
    $secondsInactive = time() - $_SESSION['last_action'];
    
    
    $expireAfterSeconds = $expireAfter * 60;
    
    
    if($secondsInactive >= $expireAfterSeconds)
    {
        
        session_unset();
        session_destroy();?>
        <script>
        window.location="jobseekar_logout.php";</script>

  <?php   }
    
}
 
$_SESSION['last_action'] = time();
?>