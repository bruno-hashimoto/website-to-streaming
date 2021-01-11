<?php
	include 'conn/session.php';
	include 'conn/autenticacao.php';
	include 'conn/config.php';
	include 'conn/class/Banco.class.php';
	
	$sql    = new Banco();
	
	$tabela         = $_GET['tabela'];
	$campo  		= $_GET['campo'];
	$csv_terminated = '\n';
	$csv_separator  = ';';
	$csv_enclosed   = '"';
	$csv_escaped    = '\\';
	$sql_query      = "select `$campo` from `$tabela` ";
		
	$result = $sql->query($sql_query);
	$fields_cnt = mysql_num_fields($result);
	$schema_insert = '';
	
	for($i = 0; $i < $fields_cnt; $i++)
	{
		$l = $csv_enclosed.str_replace($csv_enclosed,$csv_escaped.$csv_enclosed,stripslashes(mysql_field_name($result,$i))).$csv_enclosed;
				
		$schema_insert .= $l;
		$schema_insert .= $csv_separator;
	}
	
	$out = trim(substr($schema_insert, 0, -1));
	$out .= $csv_terminated;
	
	while ($row = $sql->fetch($result))
	{
		$schema_insert = '';
			
		for ($j = 0; $j < $fields_cnt; $j++)
		{
			if ($row[$j] == '0' || $row[$j] != '')
			{
				if ($csv_enclosed == '')
				{
					$schema_insert .= $row[$j];
				}
				else
				{
					$schema_insert .= $csv_enclosed .
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
				}
			}
			else
			{
				$schema_insert .= '';
			}
			
			if ($j < $fields_cnt - 1)
			{
				$schema_insert .= $csv_separator;
			}
		} // end for
		
		$out .= $schema_insert;
		$out .= $csv_terminated;
		
	} // end while
		
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D,d M YH:i:s').' GMT');
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	header ('Content-type: application/x-msexcel');
	header ('Content-Disposition: attachment; filename="{$filename}"' );
	header ('Content-Description: PHP Generated Data');
	
	exit($out);