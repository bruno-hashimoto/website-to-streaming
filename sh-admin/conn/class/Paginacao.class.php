<?php
    /**
    *Autor: João Paulo Guedes Miranda
    *Versão: 3.4
    *Ultima Alteração: 09/08/2012

        @ CSS
            div ul li a
            div ul li span

            *{ margin:0px; padding:0px;}
            div.paginacao{ background:#C90;display:table; width:100%; text-align:center; height:auto;}
            div.paginacao ul{padding:0px; margin:0; list-style:none; display:inline-block;}
            div.paginacao ul li{margin:0px; padding:0px;margin-right:5px; display:inline;}
            div.paginacao ul li a , div.paginacao ul li span{padding:5px;background:#009; display:inline-block; color:#FFF; margin:0;}
            div.paginacao ul li span{background:#0C9;}
            div.paginacao ul li a:hover,div.paginacao ul li a.marcar{ background:#999;}
            div.paginacao ul li a.proximo,div.paginacao ul li a.anterior{ background:#F00;}
    */
    class Paginacao extends Banco
    {
        private $comandoSql;
        private $pagina;
        private $tipoPaginacao;
        private $nRegistrosListados;
        private $variaveis;
        private $marcador;
        private $nPaginas;
        private $nRegistros;
        private $paginaAtual;
        private $url;
        private $urlFirst;
        private $navegacaoClassPrincipal;
        private $navegacaoClassMarcar;
        private $navegacaoClassPrev;
        private $navegacaoClassNext;
        private $navegacaoTextPrev;
        private $navegacaoTextNext;


        public function __construct()
        {
            $this->navegacaoClassPrincipal = 'paginacao';
            $this->navegacaoClassMarcar    = 'marcar';
            $this->navegacaoClassPrev      = 'anterior';
            $this->navegacaoTextPrev       = '&laquo;';
            $this->navegacaoClassNext      = 'proximo';
            $this->navegacaoTextNext       = '&laquo;';
            $this->marcador = 'page';
        }

        public function paginacao($comandoSql = '',$pagina = 'index',$tipoPaginacao = 1,$nRegistrosListados = 12,$variaveis = '',$marcador = 'page')
        {
            $this->comandoSql = $comandoSql;
            $this->pagina = trim($pagina);
            $this->tipoPaginacao = $tipoPaginacao;
            $this->nRegistrosListados = $nRegistrosListados;
            $this->variaveis = trim($variaveis);
            $this->marcador = trim($marcador);

            $sql = $this->processaPaginacao();
            return $this->query($sql);
        }

        public function paginacaoArr($comandoSql = '',$pagina = 'index',$tipoPaginacao = 1,$nRegistrosListados = 12,$variaveis = '',$marcador = 'page')
        {
            $this->comandoSql = $comandoSql;
            $this->pagina = trim($pagina);
            $this->tipoPaginacao = $tipoPaginacao;
            $this->nRegistrosListados = $nRegistrosListados;
            $this->variaveis = trim($variaveis);
            $this->marcador = trim($marcador);

            $sql = $this->processaPaginacao();
            return $this->select($sql);
        }

        private function processaPaginacao()
        {
            if(!empty($this->comandoSql) && !empty($this->pagina) && ($this->tipoPaginacao == 0 | $this->tipoPaginacao == 1) && is_numeric($this->nRegistrosListados) && $this->nRegistrosListados > 0)
            {
                if($this->tipoPaginacao==0)
                {
                    $this->variaveis = str_replace('?','',$this->variaveis);
                    $this->pagina    = strpos($this -> pagina,'.php') ? $this -> pagina:$this -> pagina.'.php';
                    $this->url       = $this->pagina.'?'.(!empty($this->variaveis) ? $this->variaveis.'&p=':'p=');
                    $this->url       = str_replace('&&','&',$this -> url);
                    $this->url       = str_replace('?&','?',$this -> url);

                    $this->urlFirst  = $this->pagina.(!empty($this->variaveis) ? '?'.$this->variaveis:'');
                    $this->urlFirst  = str_replace('&&','&',$this -> urlFirst);
                    $this->urlFirst  = str_replace('?&','?',$this -> urlFirst);

                    $this->paginaAtual = (isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0) ? $_GET['p']:1;
                }
                else
                {
                    $this->pagina = str_replace('.php','',$this->pagina);
                    $this->url    = $this->pagina.'/'.(!empty($this->variaveis) ? $this->variaveis.'/':'');
                    $this->url    = str_replace('//','/',$this->url);

                    $this->urlFirst = $this->url;

                    $URI = explode('/',$_SERVER['REQUEST_URI']);
                    $keyMarcador = array_search($this->marcador,$URI);
                    $tmpPaginaAtual = $URI[$keyMarcador + 1];
                    $this->paginaAtual = is_numeric($tmpPaginaAtual) && $tmpPaginaAtual > 0 && $URI[$keyMarcador]===$this->marcador ? $tmpPaginaAtual :1;
                    $this->url .= $this->marcador.'/';
                }

                $this->nRegistros = $this->rows($this->query($this->comandoSql));
                $this->nPaginas   = ceil($this->nRegistros / $this->nRegistrosListados);

                $limit = ($this->paginaAtual - 1) * $this->nRegistrosListados;

                return $this->comandoSql.' LIMIT '.$limit.' , '.$this->nRegistrosListados;
            }
        }

        public function navegacao($mostrarControles = false,$mostrarLis = true,$nPaginas = 5)
        {
            if($this->nPaginas > 1)
            {
                $HTML = '';
                $LIS  = '';
                $rel  = '';

                $addPaginas = $this->paginaAtual + $nPaginas;
                $i = $this->paginaAtual > $nPaginas ? $this->paginaAtual - $nPaginas : 1;
                $addPaginas = (($this->nPaginas - $this->paginaAtual)  < $nPaginas) ?  $this->nPaginas : $addPaginas;

                if($mostrarControles !== false)
                {
                    $LIS =
                    '
                        <li>
                            <a '.($this->paginaAtual > 1 ? ' href="'.($this->paginaAtual==2 ? $this->urlFirst:$this->url.($this->paginaAtual-1)).'" ' :'').' class="'.$this->navegacaoClassPrev.'" >'.$this->navegacaoTextPrev.'</a>
                        </li>
                    ';
                }

                if($mostrarLis !== false)
                {
                    if($this->paginaAtual >= $nPaginas + 2)
                    {
                        $LIS .=
                        '
                            <li>
                                <a href="'.$this->urlFirst.'">
                                    1
                                </a>
                            </li>
                            <li>
                                <span>
                                    ...
                                </span>
                            </li>
                        ';
                    }

                    for($i; $i <= $addPaginas; $i++)
                    {
                        if($i != $this->paginaAtual)
                        {
                            $rel = $this->paginaAtual < $i ? 'next':'prev';
                        }
                        else
                        {
                            $rel  = '';
                        }

                        $LIS .=
                        '
                            <li '.($i==$this->paginaAtual ? 'class="active" ':'').' >
                                <a '.($this->paginaAtual != $i ? ($i==1 ? 'href="'.$this->urlFirst.'"':'href="'.$this->url.$i.'"') :'').' rel="'.$rel.'" '.($i==$this->paginaAtual ? 'class="'.$this->navegacaoClassMarcar.'" ':'').' >
                                    '.$i.'
                                </a>
                            </li>
                        ';
                    }

                    if($this->paginaAtual < ($this->nPaginas - $nPaginas) )
                    {
                        $LIS .=
                        '
                            <li>
                                <span>
                                    ...
                                </span>
                            </li>
                            <li>
                                <a href="'.$this->url.$this->nPaginas.'">
                                    '.$this->nPaginas.'
                                </a>
                            </li>
                        ';
                    }
                }

                if($mostrarControles!==false)
                {
                    $LIS .=
                    '
                        <li>
                            <a '.($this->paginaAtual < $this->nPaginas ? 'href="'.$this->url.($this->paginaAtual+1).'" ' :'').' class="'.$this->navegacaoClassNext.'" >'.$this->navegacaoTextNext.'</a>
                        </li>
                    ';
                }

                $HTML =
                '
                    <div class="'.$this->navegacaoClassPrincipal.'">
                        <ul class="pagination">
                            '.$LIS.'
                        </ul>
                    </div>
                ';

                return preg_replace('/[\n\r\t]/','',$HTML);
            }
        }

        public function total()
        {
            return $this->nRegistros;
        }

        public function setNavegacaoClassPrincipal($cl)
        {
            $this->navegacaoClassPrincipal = $cl;
        }

        public function setNavegacaoClassMarcar($cl)
        {
            $this->navegacaoClassMarcar = $cl;
        }

        public function setNavegacaoClassPrev($cl)
        {
            $this->navegacaoClassPrev = $cl;
        }

        public function setNavegacaoTextPrev($txt)
        {
            $this->navegacaoTextPrev = $txt;
        }

        public function setNavegacaoClassNext($cl)
        {
            $this->navegacaoClassNext = $cl;
        }

        public function setNavegacaoTextNext($txt)
        {
            $this->navegacaoTextNext = $txt;
        }

        public function getMarcador()
        {
            return $this->marcador;
        }
    }