<?php

class Login{
    private $email;
    private $senha; 

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($e) {
        $email = filter_var($e, FILTER_SANITIZE_EMAIL);
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($s) {
        return $this->senha = $s;
    }


    public function Logar(){
        if($this->email == "bruno@bruno.com" and $this->senha == "123"):
            echo "logado";
        else: 
            echo "dados inválidos";
        endif;
      }
    }

$logar = new Login();
$logar->setEmail("bruno@bruno.com");
$logar->setSenha("123");
$logar-> Logar();

echo "<br/>";
echo $logar->getEmail();
echo $logar->getSenha();