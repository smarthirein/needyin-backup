<html>
 <body>
  <head>
   <title>
     SMARTHirein
   </title>
  </head>

   <form method="post">

    <input type="submit" value="screen" name="GO">
   </form>
 </body>
</html>

<?php
	if(isset($_POST['GO']))
	{
        $res = NULL;
        //putenv("PATH=/usr");
        $res = shell_exec('env');
        echo $res;  //2>&1 @comments.KEK
        $res = shell_exec("python3 /var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/custom_t-all_ext.py 2>&1");
        
        echo $res;  //2>&1 @comments.KEK
        if(isset($res)){
            foreach($res as $rowRes){
              echo $rowRes;
            }
        }
	}
?>