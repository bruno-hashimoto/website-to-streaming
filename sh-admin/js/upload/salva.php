<?php
include '../../conn/session.php';
include '../../conn/autenticacao.php';
include '../../conn/config.php';
include '../../conn/class/Banco.class.php';
include '../../conn/funcoes.php';

$sql = new Banco(true);
$vPrincipal = '';
$p = 0;
$cadastro = null;

$user = empty($_POST['id_user']) ? '1' : $_POST['id_user'];

(!empty($_POST['id_modulo']) && !empty($_POST['modulo']) && !empty($_POST['fileList'])) or exit();

$vPrincipal = $sql->select("
  SELECT * FROM `sh_file` 
  WHERE id_modulo = '".$_POST['id_modulo']."' 
    AND modulo = '".$_POST['modulo']."' 
    AND principal= 1 
    AND status = 1 
    AND excluido = 0
");

$tmp = 0;

foreach ($vPrincipal as $key => $item) {
  if ($item['principal'] == 1) {
    $tmp += 1;
  }
}

$a_insert = array();

if(!empty($_POST['fileList'])) {
  foreach ($_POST['fileList'] as $key => $item) {
    if ($tmp == 0 && $key == count($_POST['fileList']) - 1) {
      $p = 1;
    }
    array_push($a_insert, "(".$_POST['id_modulo'].",'".$_POST['modulo']."',$p,'".trim($item['serverFileName'])."','".data()."' ,1,".$user.",0)");
  }
}

// print_r("
//   INSERT INTO `sh_file` (`id_modulo`, `modulo`, `principal`,`img`,`data`, `status`,`iduser`,`ordem`) 
//   VALUES ".implode(',', $a_insert)); die;

$cadastro = $sql -> query("
  INSERT INTO `sh_file` (`id_modulo`, `modulo`, `principal`,`img`,`data`, `status`,`iduser`,`ordem`) 
  VALUES ".implode(',', $a_insert));

echo $cadastro;
?>