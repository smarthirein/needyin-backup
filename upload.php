
<?php
// if(isset($_POST['submit']))
// {
// $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
// $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

// if ((($_FILES["file"]["type"] == "video/mp4")
// || ($_FILES["file"]["type"] == "audio/mp3")
// || ($_FILES["file"]["type"] == "audio/wma")
// || ($_FILES["file"]["type"] == "image/pjpeg")
// || ($_FILES["file"]["type"] == "image/gif")
// || ($_FILES["file"]["type"] == "image/jpeg"))

// && ($_FILES["file"]["size"] < 6000000)
// && in_array($extension, $allowedExts))

//   {
//   if ($_FILES["file"]["error"] > 0)
//     {
//     echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
//     }
//   else
//     {
//     echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//     echo "Type: " . $_FILES["file"]["type"] . "<br />";
//     echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//     echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

//     if (file_exists("videos/" . $_FILES["file"]["name"]))
//       {
//       echo $_FILES["file"]["name"] . " already exists. ";
//       }
//     else
//       {
//       move_uploaded_file($_FILES["file"]["tmp_name"],
//       "videos/" . $_FILES["file"]["name"]);
//       echo "Stored in: " . "videos/" . $_FILES["file"]["name"];
//       }
//     }
//   }
// else
//   {
//   echo "Invalid file";
//   }
// }
?>
<form method="POST" enctype="multipart/form-data">
    <label for="">Upload Your Cv</label><input type="file" name="file">
    <input type="submit" name="upload" value="upload">
</form>
<?php
if(isset($_REQUEST["upload"]))
{
if (isset($_FILES['file'])) {
        $file   = $_FILES['file'];
        // print_r($file);  just checking File properties

        // File Properties
        $file_name  = $file['name'];
        $file_tmp   = $file['tmp_name'];
        $file_size  = $file['size'];
        $file_error = $file['error'];

        // Working With File Extension
        $file_ext   = explode('.', $file_name);
        $file_fname = explode('.', $file_name);

        $file_fname = strtolower(current($file_fname));
        $file_ext   = strtolower(end($file_ext));
        $allowed    = array('txt','pdf','doc','ods');


        if (in_array($file_ext,$allowed)) {
            //print_r($_FILES);


            if ($file_error === 0) {
                if ($file_size <= 5000000) {
                        $file_name_new     =  $file_fname . uniqid('',true) . '.' . $file_ext;
                        $file_name_new    =  uniqid('',true) . '.' . $file_ext;
                        $target_dir = getcwd();
                        $file_destination =  'resumes/' . $file_name_new;
                        // echo $target_dir;
                        echo $file_destination;
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                                echo "Cv uploaded";
                        }
                        else
                        {
                            echo "some error in uploading file";
                        }
//                        
                }
                else
                {
                    echo "size must bne less then 5MB";
                }
            }

        }
        else
        {
            echo "invalid file";
        }
}
}
?>