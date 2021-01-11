<?php
    include '../../conn/session.php';
    include '../../conn/autenticacao.php';
    include '../../conn/config.php';
    include '../../conn/class/Banco.class.php';
    include '../../conn/funcoes.php';
    include 'Classes/PHPExcel.php';

    $sql     = new Banco();
    $phpexel = new PHPExcel();

    $container = array(
        'clientes'=>array(
            'select'=>'SELECT t.nome,t.email,t.cpf,t.celular,t.telefone,t.facebook FROM `sh_cliente` t where t.excluido = 0 order by t.data desc',

            'header'=> array('Nome','E-mail','CPF','Celular','Telefone','Facebook')
            )
        ,
        'contato'=>array(
            'select'=>'SELECT nome,email,celular,assunto,mensagem FROM `sh_contato` where excluido = 0 order by data desc ',

            'header'=> array('Nome','E-mail','Celular','Assunto','Mensagem')
            )
        ,
        'newsletter'=>array(
            'select'=>'SELECT nome,email FROM `sh_newsletter` where excluido = 0 order by data desc',
            'header'=> array('Nome','E-mail')
            )

        );

    $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

    if(isset($_GET['export']))
    {
        $export = $_GET['export'];

        if(isset($container[$export]))
        {
            $item = $container[$export];

            $phpexel->getProperties()->setCreator('Shapeweb')
                                     ->setLastModifiedBy('Shapeweb')
                                     ->setTitle('Emails exportados');
                                    //->setSubject('Emails exportados')
                                    //->setDescription('Emails exportados')
                                    //->setKeywords("pdf php")
                                    //->setCategory("Test result file");

            $select = $sql->select($item['select'],true);

            if(!empty($select))
            {
                // $phpexel->setActiveSheetIndex(0)
                //              ->setCellValue($alphabet,$fields['nome']);


                $nFields = null;

                $c = 2;

                foreach($select as $kf => $fields)
                {
                    if(!$nFields)
                        $nFields = count($fields);

                    for($i = 0 ; $i<$nFields;$i++)
                    {
                        $phpexel->setActiveSheetIndex(0)
                             ->setCellValue($alphabet[$i].$c,utf8_encode($fields[$i]) );
                    }

                    $c++;
                }

                $nHeader = count($item['header']);
                // $styleArray = array(
                //         'font' => array(
                //             'bold' => true
                //         )
                //     );

                for ($i=0; $i < $nHeader ; $i++)
                {
                    $phpexel->setActiveSheetIndex(0)
                            ->setCellValue($alphabet[$i].'1',utf8_encode($item['header'][$i]) );
                    $phpexel->getActiveSheet()->getColumnDimension($alphabet[$i])->setWidth(40);
                    //$phpexel->getActiveSheet()->getStyle($alphabet[$i])->applyFromArray($styleArray);
                }

                $phpexel->getActiveSheet()->setTitle($export);


                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$export.'.xls"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($phpexel, 'Excel5');
                $objWriter->save('php://output');
            }
        }
        else
            echo 'Opção inválida';
    }
    else
        echo 'Parametros inválidos';