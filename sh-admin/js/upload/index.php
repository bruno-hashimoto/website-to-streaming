<!DOCTYPE html>
<html>
<head>
  <title>Upload</title>
  
  <link href="dropzone.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">

  <script src="jquery-1.12.0.min.js"></script>
  <script src="dropzone.js?12"></script>
</head>
<body>

<form action="upload.php" enctype="multipart/form-data" class="dropzone" id="image-upload">
  <div>
    <!-- <h3>Clique aqui para fazer o upload</h3> -->
  </div>
</form>

<script type="text/javascript">
  // Dropzone.options.imageUpload = {
  //   maxFilesize: 10,
  //   acceptedFiles: ".jpeg,.jpg,.png,.gif"
  // };

  $(document).ready(function() {
    Dropzone.autoDiscover = false;
    var fileList = new Array();
    var i = 0;
    var allFotos = 0;

    $("#image-upload").dropzone({
      addRemoveLinks: false,
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        fileList = [];

        this.on("success", function(file, serverFileName) {
          fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
          i++;
        });

        this.on("queuecomplete", function(file, serverFileName) {
          console.log(fileList);
          $.ajax({
            url: "salva.php",
            type: "POST",
            data: {
              "fileList": fileList,
              "id_modulo": '<?php echo $_GET['id_modulo'] ?>',
              "modulo": '<?php echo $_GET['modulo'] ?>',
              "id_user": '<?php echo $_SESSION['id_user']; ?>',
            },
          }).done(function( result ) {
            console.log(result);
            if(result == true) {
              $("input[type='hidden'][name='up-fotos']",parent.document).val(++allFotos);
            }
          });
        });

        this.on("removedfile", function(file) {
          var rmvFile = "";
          for(var f = 0; f < fileList.length; f++){
            if(fileList[f].fileName == file.name) {
              rmvFile = fileList[f].serverFileName;
            }
          }

          if (rmvFile){
            $.ajax({
              url: "delete.php",
              type: "POST",
              data: { "fileList" : rmvFile }
            });
          }
        });
      },
    });
  });
</script>

</body>
</html>


