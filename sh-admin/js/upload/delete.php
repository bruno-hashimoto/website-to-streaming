<?php
$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads'; 

$fileList = $_POST['fileList'];
$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;

if(isset($fileList)){
  unlink($targetPath.$fileList);
}
?>