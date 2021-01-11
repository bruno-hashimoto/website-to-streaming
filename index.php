<?php
$url   = isset($_GET['a']) ? $_GET['a'] : '';

include 'sh-admin/conn/config.php';
include 'sh-admin/conn/funcoes.php';
include 'sh-admin/conn/class/Banco.class.php';
include 'sh-admin/conn/class/Paginacao.class.php';
include 'sh-admin/conn/PHPMailer/autoload.php';
include 'sh-admin/conn/class/Validate.class.php';

$sql  = new Banco();
$sql->setChar('utf8');

//Configurações das páginas
include 'configuracoes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>

    <link rel="stylesheet" href="./assets/css/main.css">

    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="libs/slick/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="libs/slick/slick/slick.css" />

    <!--  OwlCarousel -->
    <link rel="stylesheet" href="libs/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="libs/owlcarousel/dist/assets/owl.theme.default.min.css">

</head>

<body>

    <?php
    include "topo.php";
    include (!empty($url) && file_exists($url . '.php') && is_file($url . '.php')) ? $url . '.php' : 'home.php';
    include "rodape.php";
    ?>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6e07d76513.js" crossorigin="anonymous"></script>

    <!-- OwlCarousel -->
    <script src="libs/owlcarousel/dist/owl.carousel.js"></script>

    <!-- Slick -->
    <script type="text/javascript" src="libs/slick/slick/slick.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

</body>

</html>