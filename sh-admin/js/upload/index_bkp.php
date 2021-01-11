<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>

  <script src="jquery-1.12.0.min.js?<?php echo rand(); ?>" type="text/javascript"></script>
  <link href="dropzone.css?<?php echo rand(); ?>" rel="stylesheet" type="text/css">
  <script src="dropzone.js?<?php echo rand(); ?>" type="text/javascript"></script>
  <link href="style.css?<?php echo rand(); ?>" rel="stylesheet" type="text/css">

  <script>
    Dropzone.autoDiscover = false;
    $(function() {
      var myDropzone = new Dropzone("#uploader");
      // myDropzone.on("queuecomplete", function(file) {
      myDropzone.on("complete", function(file) {
        alert(file);
      });
    });
  </script>
</head>

<body>
  <div class="container" >
    <div class='content'>
      <form action="upload.php" class="dropzone" id="uploader" enctype="multipart/form-data"></form>
    </div> 
  </div>
</body>
</html>