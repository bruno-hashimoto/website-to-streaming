<?php
// $uploadDir = 'uploads';
// if (!empty($_FILES)) {
//   $tmpFile = $_FILES['file']['tmp_name'];
//   $filename = $uploadDir.'/'.time().'-'. $_FILES['file']['name'];
//   move_uploaded_file($tmpFile,$filename);
// }
?>


<?php
$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads';

if (!empty($_FILES)) {
  $tempFile = $_FILES['file']['tmp_name'];
  $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;

  $attr = explode('.',$_FILES['file']['name']);
  $exte = strtolower(end($attr));

  $date = new DateTime();
  $newFileName = $date->getTimestamp().rand().'.'.$exte;
  $targetFile =  $targetPath.$newFileName;
  move_uploaded_file($tempFile,$targetFile);

  echo $newFileName;
}
?>