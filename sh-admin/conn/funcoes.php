<?php
    function showMessage( $messages = array(), $close = true ) {

        if ( empty( $messages ) && !empty( $_SESSION['flashdata']['messages'] ) ) {
            $messages = $_SESSION['flashdata']['messages'];
        }

        if ( !empty( $messages ) ) {

            $messages_success = '';
            $messages_alert   = '';
            $messages_error   = '';
            $messages_info    = '';
            $messages_container = '';
            $btn_close = '';

            if ( $close ) {
                $btn_close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            }

            foreach ( $messages as $message ) {

                if ( $message['type'] == 'success' ) {
                    $messages_success .= $message['message'].'<br>';
                }
                elseif ( $message['type'] == 'alert' ) {
                    $messages_alert .= $message['message'].'<br>';
                }
                elseif ( $message['type'] == 'error' ) {
                    $messages_error .= $message['message'].'<br>';
                }
                elseif ( $message['type'] == 'info' ) {
                    $messages_info .= $message['message'].'<br>';
                }
            }

            if ( !empty( $messages_success ) ) {
                $messages_container .= '<div class="alert alert-success" role="alert"> '.$btn_close.$messages_success.'</div>';
            }

            if ( !empty( $messages_alert ) ) {
                $messages_container .= '<div class="alert alert-warning" role="alert"> '.$btn_close.$messages_alert.'</div>';
            }

            if ( !empty( $messages_error ) ) {
                $messages_container .= '<div class="alert alert-danger" role="alert"> '.$btn_close.$messages_error.'</div>';
            }

            if ( !empty( $messages_info ) ) {
                $messages_container .= '<div class="alert alert-info" role="alert"> '.$btn_close.$messages_info.'</div>';
            }

            return $messages_container;
        }
    }

    function number( $value = 0 ) {

        return number_format( $value, 2, '.', '' );
    }

    function cleanHtml( $str = '' ) {

        // Convertendo todas as entidades HTML para os seus caracteres
        $str = html_entity_decode( $str, ENT_COMPAT, 'ISO-8859-1');
        // Retirando as tags HTML e PHP
        $str = strip_tags( $str );

        return $str;
    }

    function traco($str = '') {

        return !empty($str) ? $str: '--' ;
    }

    /**
     * Gera um token
     * @return [type] [description]
     */
    function token(){
        return md5(uniqid(mt_rand(),true));
    }

    /**
     * Verifica e retorna uma posição do array caso exista
     * @param  string $position index
     * @param  [type] $array    array
     * @return posição do array
     */
    function submited($position = '',$array = NULL){

        if(!$array){
            $array = $_POST;
        }

        if(isset($array[$position])){
            return $array[$position];
        }

        return false;
    }

    function bvalor($v = 0)
    {
        $v = preg_replace('/[^\d,]/','',$v);
        return str_replace(',','.',$v);
    }

    function isCnpj($cnpj) {

        if (strlen($cnpj) <> 18) return 0;

        $soma1 = ($cnpj[0] * 5) +

        ($cnpj[1] * 4) +
        ($cnpj[3] * 3) +
        ($cnpj[4] * 2) +
        ($cnpj[5] * 9) +
        ($cnpj[7] * 8) +
        ($cnpj[8] * 7) +
        ($cnpj[9] * 6) +
        ($cnpj[11] * 5) +
        ($cnpj[12] * 4) +
        ($cnpj[13] * 3) +
        ($cnpj[14] * 2);
        $resto = $soma1 % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;
        $soma2 = ($cnpj[0] * 6) +

        ($cnpj[1] * 5) +
        ($cnpj[3] * 4) +
        ($cnpj[4] * 3) +
        ($cnpj[5] * 2) +
        ($cnpj[7] * 9) +
        ($cnpj[8] * 8) +
        ($cnpj[9] * 7) +
        ($cnpj[11] * 6) +
        ($cnpj[12] * 5) +
        ($cnpj[13] * 4) +
        ($cnpj[14] * 3) +
        ($cnpj[16] * 2);
        $resto = $soma2 % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
    }

    function isCpf($cpf){
        // determina um valor inicial para o digito $d1 e $d2
        // pra manter o respeito ;)
        $d1 = 0;
        $d2 = 0;
        // remove tudo que não seja número
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        // lista de cpf inválidos que serão ignorados
        $ignore_list = array(
        '00000000000',
        '01234567890',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
        );
        // se o tamanho da string for dirente de 11 ou estiver
        // na lista de cpf ignorados já retorna false
        if(strlen($cpf) != 11 || in_array($cpf, $ignore_list)){
            return false;
        } else {
            // inicia o processo para achar o primeiro
            // número verificador usando os primeiros 9 dígitos
            for($i = 0; $i < 9; $i++){
              // inicialmente $d1 vale zero e é somando.
              // O loop passa por todos os 9 dígitos iniciais
              $d1 += $cpf[$i] * (10 - $i);
            }
            // acha o resto da divisão da soma acima por 11
            $r1 = $d1 % 11;
            // se $r1 maior que 1 retorna 11 menos $r1 se não
            // retona o valor zero para $d1
            $d1 = ($r1 > 1) ? (11 - $r1) : 0;
            // inicia o processo para achar o segundo
            // número verificador usando os primeiros 9 dígitos
            for($i = 0; $i < 9; $i++) {
              // inicialmente $d2 vale zero e é somando.
              // O loop passa por todos os 9 dígitos iniciais
              $d2 += $cpf[$i] * (11 - $i);
            }
            // $r2 será o resto da soma do cpf mais $d1 vezes 2
            // dividido por 11
            $r2 = ($d2 + ($d1 * 2)) % 11;
            // se $r2 mair que 1 retorna 11 menos $r2 se não
            // retorna o valor zeroa para $d2
            $d2 = ($r2 > 1) ? (11 - $r2) : 0;
            // retona true se os dois últimos dígitos do cpf
            // forem igual a concatenação de $d1 e $d2 e se não
            // deve retornar false.
            return (substr($cpf, -2) == $d1 . $d2) ? true : false;
        }
    }

    function diasemana($day = '',$sort = false)
    {
        $d = NULL;

        if(!empty($day) | is_numeric($day))
        {
            $len = strlen($day);

            if($len == 10 | $len == 19)
            {
                $dataArr = array();
                $dataArr = explode(' ',$day);
                $data    = reset($dataArr);

                if(!preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$data,$arr))
                {
                    $data = data($data);
                }

                $d = strftime('%w',strtotime($data));
            }
            else
            {
                $d = (string) strtolower($day);
            }
        }
        else
        {
            $d = date('w');
        }

        switch($d)
        {
            case 'sunday':
            case '0':
                $diasemana = $sort ? 'Dom':'Domingo';
            break;
            case 'monday':
            case '1':
                $diasemana = $sort ? 'Seg':'Segunda-Feira';
            break;
            case 'tuesday':
            case '2':
                $diasemana = $sort ? 'Ter':'Terça-Feira';
            break;
            case 'wednesday':
            case '3':
                $diasemana = $sort ? 'Qua':'Quarta-Feira';
            break;
            case 'thursday':
            case '4':
                $diasemana = $sort ? 'Qui':'Quinta-Feira';
            break;
            case 'friday':
            case '5':
                $diasemana = $sort ? 'Sex':'Sexta-Feira';
            break;
            case 'saturday':
            case '6':
                $diasemana = $sort ? 'Sáb':'Sábado';
            break;
            default:
                $mes = 'Dia da semana Indefinido';
        }

        return $diasemana;
    }

    function mes($day,$short = false)
    {
        $m = NULL;

        if(!empty($day) | is_numeric($day))
        {
            $len = strlen($day);

            if($len == 10 | $len == 19)
            {
                $dataArr = array();
                $dataArr = explode(' ',$day);
                $data    = reset($dataArr);

                if(!preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$data,$arr))
                {
                    $data = data($data);
                }

                $m = strftime('%m',strtotime($data));
            }
            else
            {
                $m   = (string)strtolower($day);
            }
        }
        else
        {
            $m = date('m');
        }

        switch($m)
        {
            case '1':
            case '01':
            case 'jan':
                $mes = $short ? 'Jan':'Janeiro';
            break;
            case '2':
            case '02':
            case 'feb':
                $mes = $short ? 'Fev':'Fevereiro';
            break;
            case '3':
            case '03':
            case 'mar':
                $mes = $short ? 'Mar':'Março';
            break;
            case '4':
            case '04':
            case 'apr':
                $mes = $short ? 'Abr':'Abril';
            break;
            case '5':
            case '05':
            case 'may':
                $mes = $short ? 'Mai':'Maio';
            break;
            case '6':
            case '06':
            case 'jun':
                $mes = $short ? 'Jun':'Junho';
            break;
            case '7':
            case '07':
            case 'jul':
                $mes = $short ? 'Jul':'Julho';
            break;
            case '8':
            case '08':
            case 'aug':
                $mes = $short ? 'Ago':'Agosto';
            break;
            case '9':
            case '09':
            case 'sep':
                $mes = $short ? 'Set':'Setembro';
            break;
            case '10':
            case 'oct':
                $mes = $short ? 'Out':'Outubro';
            break;
            case '11':
            case 'nov':
                $mes = $short ? 'Nov':'Novembro';
            break;
            case '12':
            case 'dec':
                $mes = $short ? 'Dez':'Dezembro';
            break;
            default:
                $mes = 'Mês Indefinido';
        }

        return $mes;
    }

    function video($V ='',$wh='', $attr = '',$iframe = false)
    {
        $idV = idMovieYT($V);

        if(!empty($idV))
        {
            $wh = explode('x',$wh);

            if($iframe===true)
            {
                $html = '<iframe '.$attr.' width="'.$wh[0].'" height="'.$wh[1].'" src="http://www.youtube.com/embed/'.$idV.'" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {
                $html = '<img src="//i4.ytimg.com/vi/'.$idV.'/0.jpg" width="'.$wh[0].'" height="'.$wh[1].'" '.$attr.' />';
            }

            return $html;
        }
    }

    function lightbox($img = '',$wh = '100x100',$attr = '',$crop = false,$attrA ='')
    {
        $rImg = image($img,$wh,$attr,$crop);
        return !empty($rImg) ? '<a '.$attrA.' href="'._URL_FILES_.$img.'" rel="lightbox">'.$rImg.'</a>':'';
    }

    function files($dir = '')
    {
        return define('_FILES_',$dir);
    }

    function fvalor($valor = 0,$span = true)
    {
        return ($span === true ? '<span>R$ </span>':'').number_format($valor, 2, ',', '.');
    }

    function image($img = "",$wh = "100x100",$attr = "",$crop = false)
    {
        $wh = explode("x",$wh);
        $op = ($crop === true) ? "&amp;cropratio=".$wh[0].":".$wh[1] : "";
        return (file_exists(_FILES_.$img) ===true && is_file(_FILES_.$img)) ? '<img src="'._BASE_.'image.php?width='.$wh[0].'&amp;height='.$wh[1].$op.'&amp;image='._URL_FILES_.$img.'" '.$attr.'  />':'';

    }

    function geraCodigo()
    {
        return hash('crc32b',mt_rand());
    }

    function banner($banner = '',$wh = '',$whf = '',$flutuante = false,$href = '')
    {
        $arrb = explode('.',$banner);
        $extencao     = end($arrb);
        $extencoesImg = array('jpeg','png','jpg','gif');
        $rBanner      = _FILES_.$banner;
        //$banner       = _URL_FILES_.$banner;
        $HTML         = '';
        $IDB          = '';
        $STYLE        = '';
        $A            = '';

        if(file_exists($rBanner)===true && is_file($rBanner))
        {
            $wh    = (!empty($wh)) ? explode('x',$wh) : getimagesize($rBanner);

            $HTML  = ' <!-- BANNER --> ';

            if($flutuante===true)
            {
                $wh     = (!empty($whf)) ? explode('x',$whf) : getimagesize($rBanner);
                $STYLE  = 'style="position:absolute;width:'.$wh[0].'px; height:'.$wh[1].'px;left:50%; top:50%;margin-top:-'.($wh[1] / 2).'px; margin-left:-'.($wh[0] / 2).'px; z-index:9999; display:table;" ';
                $A =
                '
                    <a class="close-banner">Fechar</a>
                ';
            }

            if($extencao ==='swf')
            {
                $IDB   = geraCodigo();

                $HTML .=
                '
                    <script type="text/javascript" language="javascript">
                        $(function()
                        {
                           $("#'.$IDB.'").flash
                           ({
                              src:  "'.$rBanner.'",
                              width: '.$wh[0].',
                              height:'.$wh[1].',
                              wmode:"transparent"
                           },
                           {
                            expressInstall: true
                            },
                           {
                              version: 8
                           });

                        });
                    </script>

                    <div id="'.$IDB.'" '.$STYLE.' class="container-banner" >'.$A.'</div>
                ';
            }
            else
            {
                $HTML .=
                '
                    <div id="'.$IDB.'" '.$STYLE.' class="container-banner" >
                        '.$A.'
                        <a '.(!empty($href) ? 'href="'.$href.'"':'').'>
                        '.image($banner,$wh[0].'x'.$wh[1]).'
                        </a>
                    </div>
                ';
            }

            $HTML  .= ' <!-- FIM BANNER --> ';

            return $HTML;
        }
    }//by: JPGM

    function data($str = '',$lk = false)
    {
        if(!empty($str))
        {
            $array = explode(' ',$str);

            $data = $array[0];
            $hora = $array[1];

            return (preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$data,$arr) ? $arr[3].'/'.$arr[2].'/'.$arr[1].(($lk === true) ? ' '.$hora : '') :
                   (preg_match('/([0-9]{2})[\/|-]([0-9]{2})[\/|-]([0-9]{4})/',$data,$arr) ? $arr[3].'-'.$arr[2].'-'.$arr[1].' '.$hora :'DATE UNDEFINED'));
        }
        else
        {
            $verao = date('I') == 1 ? 3:4;
            $timestamp = mktime(date('H')-$verao, date('i'), date('s'), date('m'), date('d'), date('Y'));
            return gmdate('Y-m-d H:i:s', $timestamp);
        }
    }//by: JPGM


    function upload($array = array() ,$dir = _FILES_,$t = 0)
    {
        $c  = count($_FILES[$array]['name']);
        $r  = array();
        $type = array();
        $mb = 1024 * 1024 * 100; //100MB

        if(!empty($_FILES[$array]) && (!is_dir($dir) ? mkdir($dir,0777):true))
        {
            $type[0] = array('jpg','jpeg','png','gif','swf'); //IMAGENS  ACEITAS
            $type[1] = array('txt','doc','docx','pdf','xls','rar','zip'); //ARQUIVOS ACEITOS
            $type[2] = array('jpg','jpeg','png','gif','swf','txt','doc','docx','pdf','xls','rar','zip'); //TODOS ARQUIVOS ACEITOS

            for($i=0; $i < $c; $i++)
            {
                $attr = array();
                $nome = NULL;
                $exte = NULL;
                $tmp  = NULL;

                $attr = explode('.',$_FILES[$array]['name'][$i]);
                $exte = strtolower(end($attr));

                if(in_array($exte,$type[$t]) === true && $_FILES[$array]['error'][$i] === 0 && $_FILES[$array]['size'][$i] <= $mb)
                {
                    $nome = substr($_FILES[$array]['name'][$i],0,-(strlen($exte) + 1));
                    $nome = substr(urllimpa($nome),0,100);
                    $tmp  = $nome.'.'.$exte;

                    if(file_exists($dir.$tmp) && is_file($dir.$tmp))
                    {
                        $tmp = $nome.'_'.hash('crc32',mt_rand()).'.'.$exte;
                    }

                    set_time_limit(0);

                    if(move_uploaded_file($_FILES[$array]['tmp_name'][$i],$dir.$tmp) === true)
                    {
                        $r[] = $tmp;
                    }
                    else
                    {
                        $r[] = '';
                    }

                    set_time_limit(30);
                }
                else
                {
                    $r[] = '';
                }
            }
        }
        return $c > 1 ? $r : reset($r);
    }//by: JPGM

    function urllimpa($str)
    {
        $str   = strip_tags(html_entity_decode(trim($str)));
        $final = removeAcento($str);
        $final = preg_replace('/[^A-Za-z0-9]+/','-',$final);
        $final = trim($final,'-');
        return strtolower($final);
    }

    function removeAcento( $str = '' ) {

        $map = array(
            'á' => 'a', 'à' => 'a', 'ã' => 'a',
            'â' => 'a', 'é' => 'e', 'ê' => 'e',
            'í' => 'i', 'ó' => 'o', 'ô' => 'o',
            'õ' => 'o', 'ú' => 'u', 'ü' => 'u',
            'ç' => 'c', 'Á' => 'A', 'À' => 'A',
            'Ã' => 'A', 'Â' => 'A', 'É' => 'E',
            'Ê' => 'E', 'Í' => 'I', 'Ó' => 'O',
            'Ô' => 'O', 'Õ' => 'O', 'Ú' => 'U',
            'Ü' => 'U', 'Ç' => 'C'
        );

        return strtr( $str, $map );
    }

    function diffDate($d1,$d2,$type='D')
    {
        $d1 = reset(explode(' ', $d1));
        $d2 = reset(explode(' ', $d2));

        if(!preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$d1,$arr))
        {
            $d1 = data($d1);
        }

        if(!preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$d2,$arr))
        {
            $d2 = data($d2);
        }

        $d1 = explode('-',$d1);
        $d2 = explode('-',$d2);

        switch ($type)
        {
            case 'A'://Anos
                $X = (days_in_month(date('D'), date('Y')) == 29) ? 31536000 + 86400 : 31536000;// Se for bissexto adiciona + 1 dia
            break;
            case 'M'://Meses
                $X = (days_in_month(date('D'), date('Y')) == 29) ? 2592000 + 86400 : 2592000;// Se for bissexto adiciona + 1 dia
            break;
            case 'D'://Dias
                $X = 86400;
            break;
            case 'H'://Horas
                $X = 3600;
            break;
            case 'MI'://Minutos
                $X = 60;
            break;
            default://Segundos
                $X = 1;
        }

        return floor(((mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]) - mktime(0, 0, 0, $d1[1], $d1[2], $d1[0] ) )/$X));
    }

    function days_in_month($month,$year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    function printArray($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }//by: JPGM

    function strLower($str = "",$max = 0)
    {
        $str = trim(strip_tags($str));

        if(strlen($str) > $max)
        {
            $str = substr($str,0,$max);
            $str = $str.'...';
        }
        return $str;
    }//by: JPGM

    function includeNoCache($url = "")
    {
        $url = trim($url);

        if(is_file($url))
        {
            $urlArr = array();
            $urlArr = explode('.',$url);

            switch(end($urlArr) )
            {
                case 'js' :echo '<script type="text/javascript" language="javascript" src="',$url,'?',filemtime($url),'" ></script>'."\n";break;
                case 'css':echo '<link rel="stylesheet" type="text/css" href="',$url,'?',filemtime($url),'"/>'."\n";break;
                default:'undefined';
            }
            unset($url);
        }
        else
        {
            echo '<font color="#FF0000">File not found !</font> &raquo; <b>',$url,'</b><br />';
        }
    }//by: JPGM

    function location($url = '',$msg = '',$log = '')
    {
        setMensagem($msg,$log);
        exit('<meta http-equiv="refresh" content="0; url='.urldecode($url).'"/>');
    }//by: JPGM

    function setMensagem($msg = '',$log = '')
    {
        $_SESSION['msg']['txt'] = $msg;
        $_SESSION['msg']['log'] = $log;
    }

    function continueAcao($jmsg = '',$msg = '',$msgAjx = '',$log = '')
    {
        $HTML =
        "
            <script type='text/javascript'>
                $(function()
                {
                    $.alerts.okButton = 'SIM';
                    $.alerts.cancelButton = 'N&atilde;o';

                    jConfirm('$jmsg','Messagem',function(comfir)
                    {
                        if(comfir===true)
                        {
                            setMessag('$msg',$log);
                        }
                        else
                        {
                            $.ajax
                            ({
                                beforeSend:function()
                                {
                                    setMessag('Aguarde , redirecionando...',1);
                                },
                                url:'setmessag.php',
                                type:'post',
                                data:'m=$msgAjx&l=$log',
                                success:function()
                                {
                                    window.location.href='".$_SESSION['continue']."';
                                }
                            });
                        }
                    });
                });
            </script>
        ";

        echo $HTML;
    }

    function formatDate($date,$op = 0)
    {
        if(!preg_match('/([0-9]{4})[\/|-]([0-9]{2})[\/|-]([0-9]{2})/',$date,$arr))
        {
            $date = data($date);
        }

        $ux = strtotime($date);

        switch($op)
        {
            case 0:$er = '%d/%b/%Y';break; // 21/01/2012
            case 1:$er = '%d, '.mes($date,true).' - %Y';break; // 21, Jan - 2012
            case 2:$er = '%d de '.mes($date).' de %Y';break; // 21 de Janeiro de 2012
            case 3:$er = '%d '.mes($date).' %Y';break; // 21 de Janeiro de 2012
        }

        return strftime($er,$ux);
    }//by: JPGM

    function idMovieYT($url)
    {
        //$regex = "#youtu(be.com|.b)(/v/|/watch\\?v=|e/|/watch(.+)v=)(.{11})#";
        $regex = "#youtu(be.com|.b)(/embed/|/v/|/watch\\?v=|e/|/watch(.+)v=)(.{11})#";

        preg_match_all($regex,$url,$matches);

        if(!empty($matches[4]))
        {
            $codigos_unicos = array();
            $quantidade_videos = count($matches[4]);
            foreach($matches[4] as $code)
            {
                if(!in_array($code,$codigos_unicos))
                    array_push($codigos_unicos,$code);

            }

            return $codigos_unicos[0];
        }
        else
        {
            return $url;
        }
    }

    function logs($acao = 0,$tabela,$registro = NULL,$autor = NULL,$dir = './logs')
    {
        if(!empty($acao) && !empty($tabela) && !empty($registro) && !empty($autor) && !empty($dir))
        {
            $year  = $dir.'/'.date('Y');
            $file  = $year.'/'.date('M').'.xml';
            $date  = explode(' ',data());

            if((!is_dir($dir))?mkdir($dir,0777):true)
            {
                if((!is_dir($year))?mkdir($year,0777):true)
                {
                    /*switch($acao)
                    {
                        case '1':$acao = "CADASTRO"       ;break;
                        case '2':$acao = "ERRO_CADASTRO"  ;break;
                        case '3':$acao = "ALTERACAO"      ;break;
                        case '4':$acao = "ERRO_ALTERACAO" ;break;
                        case '5':$acao = "REMOCAO"        ;break;
                        case '6':$acao = "ERRO_REMOCAO"   ;break;
                        case '7':$acao = "LOGAR"          ;break;
                        case '8':$acao = "ERRO_LOGAR"     ;break;
                        case '9':$acao = "SAIR"           ;break;
                        default :$acao = "UNDEFINED";
                    }*/

                    $dom = new DOMDocument('1.0','ISO-8859-1');
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;

                    if(file_exists($file))
                    {
                        $dom->load($file);
                        $root = $dom->getElementsByTagName('logs')->item(0);
                    }
                    else
                    {
                        $root = $dom->createElement('logs');
                    }

                    $log = $dom->createElement('log');
                    $log->setAttribute('date',$date[0]);
                    $log->setAttribute('hour',$date[1]);
                    $log->setAttribute('action',$acao);
                    $log->setAttribute('table',$tabela);
                    $log->setAttribute('record',$registro);
                    $log->setAttribute('author',$autor);
                    $root->appendChild($log);
                    $dom->appendChild($root);
                    $dom->save($file);
                }
            }
        }
    }//by: JPGM