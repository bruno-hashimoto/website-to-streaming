<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Contato</title>
    </head>
    <body>
        <table width="98%" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody bgcolor="#F0F0F0" style="border:solid 1px #CCCCCC;">
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="97%" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody bgcolor="#FFFFFF" style="border:solid 1px #C6C6C6;font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-weight:400;color:#333333;">
                                <tr>
                                   <td>
                                       <a href="<?php echo _BASE_;?>" target="_blank">
                                            <img src="<?php echo _BASE_.'assets/images/logo.png';?>" style="border:none;margin: 10px;" />
                                       </a>
                                   </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="97%" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody bgcolor="#FFFFFF" style="border:solid 1px #C6C6C6;font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-weight:400;color:#333333;">
                                <tr>
                                    <td style="padding:10px;">

                                        <p>
                                            <strong>Nome: </strong> <?php echo $nome;?>
                                        </p>

                                        <p>
                                            <strong>E-mail: </strong> <?php echo $email;?>
                                        </p>

                                        <?php
                                            if ( !empty($celular) ) {
                                        ?>
                                            <p>
                                                <strong>Celular: </strong> <?php echo $celular;?>
                                            </p>
                                        <?php
                                            }
                                        ?>

                                        <p>
                                            <?php echo $mensagem;?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td height="20"></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>