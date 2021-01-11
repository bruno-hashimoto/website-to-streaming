<?php
include '../../conn/funcoes.php';
files('../../../files/');
// files('uploads/');

$_FILES['Filedata'] =
array(
  'name'=>array($_FILES['file']['name']),
  'type'=>array($_FILES['file']['type']),
  'tmp_name'=>array($_FILES['file']['tmp_name']),
  'error'=>array($_FILES['file']['error']),
  'size'=>array($_FILES['file']['size'])
);

echo upload('Filedata',_FILES_,2);
?>


<?php
// $ds = DIRECTORY_SEPARATOR;
// $storeFolder = 'uploads';

// if (!empty($_FILES)) {
//   $tempFile = $_FILES['file']['tmp_name'];
//   $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;

//   $attr = explode('.',$_FILES['file']['name']);
//   $exte = strtolower(end($attr));

//   $date = new DateTime();
//   $newFileName = $date->getTimestamp().rand().'.'.$exte;
//   $targetFile =  $targetPath.$newFileName;
//   move_uploaded_file($tempFile,$targetFile);

//   echo $newFileName;
// }
?>