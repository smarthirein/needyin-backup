<html>
<head>
        <meta charset="utf-8">
        <link href="/static/build/styles/samples.37902ba3b7fe.css" rel="stylesheet" type="text/css"> 
        
        <style type="text/css">
            body {
  font: 14px "Open Sans", "Arial", sans-serif;
}

video {
  margin-top: 2px;
  border: 1px solid black;
}

.button {
  cursor: pointer;
  display: block;
  width: 160px;
  border: 1px solid black;
  font-size: 16px;
  text-align: center;
  padding-top: 2px;
  padding-bottom: 4px;
  color: white;
  background-color: #005eb8;
  text-decoration: none;
}

h2 {
  margin-bottom: 4px;
}

.left {
  margin-right: 10px;
  float: left;
  width: 160px;
  padding: 0px;
}

.right {
  margin-left: 10px;
  float: left;
  width: 160px;
  padding: 0px;
}

.bottom {
  clear: both;
  padding-top: 10px;
}
        </style>
        
        <title>Needyin Video Application</title>
        <?php 
        // include "source.php";
         ?>
    </head>
    <body>
    <?php
// include_once("analyticstracking.php");
// include "postlogin-header-jobseekar.php";?>
            <h3><p>Click the "Start" button to begin video recording for one minute. You can stop
   the video by clicking the creatively-named "Stop" button. The "Download"
   button will download.
</p></h3>
<br>
 <div class="left">
  <div id="startButton" class="button">
    Start
  </div>
  <h2>Preview</h2>
  <video id="preview" width="160" height="120" autoplay="" muted=""></video>
</div>
 <div class="right">
  <div id="stopButton" class="button">
    Stop
  </div>
  <h2>Recording</h2>
  <video id="recording" width="160" height="120" controls="" src="blob:https://www.production.needyin.com/videos"></video>
  <a id="downloadButton" class="button" href="blob:https://www.production.needyin.com/videos" download="RecordedVideo.webm">
    Download
  </a>
</div>
 <div class="bottom">
  <pre id="log">
</pre>
</div>
<form action="upload.php" method="post" enctype="multipart/form-data">
        Upload a File:
        <input type="file" name="myfile" id="fileToUpload">
        <input type="submit" name="submit" value="Upload File Now" >
    </form>
            <script>
                let preview = document.getElementById("preview");
let recording = document.getElementById("recording");
let startButton = document.getElementById("startButton");
let stopButton = document.getElementById("stopButton");
let downloadButton = document.getElementById("downloadButton");
let logElement = document.getElementById("log");

let recordingTimeMS = 60000;
 function log(msg) {
  logElement.innerHTML += msg + "\n";
}
 function wait(delayInMS) {
  return new Promise(resolve => setTimeout(resolve, delayInMS));
}
 function startRecording(stream, lengthInMS) {
  let recorder = new MediaRecorder(stream);
  let data = [];
 
  recorder.ondataavailable = event => data.push(event.data);
  recorder.start();
  log(recorder.state + " for " + (lengthInMS/1000) + " seconds...");
 
  let stopped = new Promise((resolve, reject) => {
    recorder.onstop = resolve;
    recorder.onerror = event => reject(event.name);
  });

  let recorded = wait(lengthInMS).then(
    () => recorder.state == "recording" && recorder.stop()
  );
 
  return Promise.all([
    stopped,
    recorded
  ])
  .then(() => data);
}
 function stop(stream) {
  stream.getTracks().forEach(track => track.stop());
}
 startButton.addEventListener("click", function() {
  navigator.mediaDevices.getUserMedia({
    video: true,
    audio: true
  }).then(stream => {
    preview.srcObject = stream;
    downloadButton.href = stream;
    preview.captureStream = preview.captureStream || preview.mozCaptureStream;
    return new Promise(resolve => preview.onplaying = resolve);
  }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
  .then (recordedChunks => {
    let recordedBlob = new Blob(recordedChunks, { type: "video/webm" });
    recording.src = URL.createObjectURL(recordedBlob);
    downloadButton.href = recording.src;
    downloadButton.download = "RecordedVideo.webm";
    
    log("Successfully recorded " + recordedBlob.size + " bytes of " +
        recordedBlob.type + " media.");
  })
  .catch(log);
}, false); stopButton.addEventListener("click", function() {
  stop(preview.srcObject);
}, false);
            </script>
        
    
</body></html>

    <?php
    require_once("config.php");
    require_once 'class.user.php';
    $reg_user = new USER();
 
    if(isset($_POST['but_upload'])){
       $maxsize = 5242880; // 5MB
 
       $name = $_FILES['file']['name'];
       $target_dir = "videos/";
       $target_file = $target_dir . $_FILES["file"]["name"];
       $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $extensions_arr = array("mp4","avi","3gp","mov","mpeg","webm","html");
       if( in_array($videoFileType,$extensions_arr) ){
 
          if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
            echo "File too large. File must be less than 5MB.";
          }else{
            if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){

              $query = "INSERT INTO videos(name,location,video_type) VALUES('".$name."','".$target_file."')";
              mysqli_query($con,$query);
              echo "Upload successfully.";
            }
          }

       }else{
          echo "Invalid file extension.";
       }
 
     } 
     ?>