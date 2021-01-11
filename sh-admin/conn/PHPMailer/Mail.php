<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail extends PHPMailer
{
  public function __construct() {
    parent::__construct();

    $sender = 'mandrill@shapeweb.com.br';
    $senderName = _TITULO_;
    $usernameSmtp = 'AKIA2YHKX7LEYEYJJ6WU';
    $passwordSmtp = 'BMOsZroOuYlf62bxtfLpnHGDpatWqUP+2u89f16u8WZv';
    $host = 'email-smtp.us-east-1.amazonaws.com';
    $port = 587;

    $this->isSMTP();
    $this->setFrom($sender, $senderName);
    $this->Username = $usernameSmtp;
    $this->Password = $passwordSmtp;
    $this->Host = $host;
    $this->Port = $port;
    $this->SMTPAuth = true;
    $this->SMTPSecure = 'tls';

    $this->isHTML(true);

    //Linguagem
    $this->setLanguage('br', './language/');
  }

  public function template( $file = '', $vars = array(), $return = false ) {
    $file = str_replace('.php', '', $file);

    $path = dirname(__FILE__).'/../template-emails/'.$file.'.php';
    $result = '';

    if( file_exists( $path ) && is_file( $path ) ) {
      ob_start();

      extract($vars);
      include $path;

      $result = ob_get_contents();

      ob_end_clean();
    }
    else {
      throw new Exception('Template não encontrado');
    }

    if ( $return ) {
      return $result;
    }

    $this->Body = $result;
  }
}
