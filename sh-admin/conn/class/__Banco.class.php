<?php
    class Banco
    {
        const HOST  = HOST;
        const LOGIN = LOGIN;
        const SENHA = SENHA;
        const DATAB = DATAB;
        private static $conn;
        private static $dBug;

        public function __construct($dBug = false)
        {
            try
            {
                self::$dBug = $dBug;
                $this->conn();
                $this->setChar('utf8');
                //$this->setTimeZone();
                register_shutdown_function("mysql_close",self::$conn);
            }
            catch(Exception $e)
            {
                echo self::error($e->getMessage());
            }
        }

        final private function conn()
        {
            self::$conn = @mysql_connect(self::HOST,self::LOGIN,self::SENHA);

            if(!self::$conn)
            {
                throw new Exception("Erro , ao tentar conectar-se com o banco de dados &#187;  <b>".self::HOST."</b> - ".mysql_error());
            }
            else if(!mysql_select_db(self::DATAB,self::$conn))
            {
                throw new Exception("Erro , ao tentar conectar-se com a base de dados &#187;  <b>".self::DATAB."</b> - ".mysql_error());
            }
        }

        final public function select($sql = NULL, $n = false)
        {
            try
            {
                if($query = $this->query($sql))
                {
                    if($this->rows($query) > 0)
                    {
                        $DATA = array();
                        $i    = 0;

                        while($rows = $this->fetch($query,$n))
                        {
                            foreach($rows as $key => $field)
                            {
                                $DATA[$i][$key] = $this->removeEscapeString($field);
                                unset($field,$key);
                            }
                            $i++;
                        }

                        mysql_free_result($query);
                        unset($rows);
                        return $DATA;
                    }
                }
                else
                {
                    throw new Exception("Query inválida &#187; <b>".$sql."</b> - ".mysql_error());
                }
            }
            catch(Exception $e)
            {
                echo self::error($e->getMessage());
            }
        }

        final public function insert($table = NULL,$array = "input")
        {
            try
            {
                if(!empty($table))
                {
                    if(!empty($array))
                    {
                        $fields = "";$values = "";$i_insert = 0;$arr = NULL;

                        $arr = (is_array($array) ===true) ? $array: $_POST[$array];

                        foreach($arr as $field => $value)
                        {
                            if(!empty($value ) )
                            {
                                $fields .= ($i_insert==0) ? "`".$field."`" : ","."`".$field."`";
                                $values .= ($i_insert==0) ? "'".$this->escapeString($value)."'" : ","."'".$this->escapeString($value)."'";

                                $i_insert++;
                            }


                        }

                        $insert = "INSERT INTO `$table` ($fields) VALUES($values)";

                        if(!$this->query($insert))
                        {
                            throw new Exception("Erro , ao tentar inserir &#187; <b>".$insert."</b> - ".mysql_error());
                        }
                        else
                        {
                            return true;
                        }
                    }
                }
                else
                {
                    throw new Exception("Informe uma tabela para inserir !");
                }
            }
            catch(Exception $e)
            {
                echo self::error($e->getMessage());
            }
        }

        final public function update($table = NULL,$where = NULL,$array = "input")
        {
            try
            {
                if(!empty($table))
                {
                    if(!empty($array))
                    {
                        $fields = "";$values = "";$i_update = 0;$arr = NULL;

                        $arr = (is_array($array) ===true) ? $array: $_POST[$array];

                        foreach($arr as $field => $value)
                        {
                            $values .= ($i_update==0) ? "`".$field."` = "."'".$this->escapeString($value)."'" : ",`".$field."` = "."'".$this->escapeString($value)."'";

                            $i_update++;
                        }

                        $where  = !empty($where) ?' WHERE '.$where:'';
                        $update = "UPDATE `$table` SET $values $where";

                        if(!$this->query($update))
                        {
                            throw new Exception("Erro , ao tentar atualizar &#187; <b>".$update."</b> - ".mysql_error());
                        }
                        else
                        {
                            return true;
                        }
                    }
                }
                else
                {
                    throw new Exception("Informe uma tabela para atualizar !");
                }
            }
            catch(Exception $e)
            {
                echo self::error($e->getMessage());
            }
        }

        final public function query($sql)
        {
            try
            {
                $query = mysql_query($sql,self::$conn);

                if($query===false)
                {
                    throw new Exception("Query inválida &#187; <b>".$sql."</b> - ".mysql_error());
                }
                else
                {
                    return $query;
                }
            }
            catch(Exception $e)
            {
                echo self::error($e->getMessage());
            }
        }

        final public function fetch($query,$n = false)
        {
            return  $n ? mysql_fetch_row($query):mysql_fetch_assoc($query);
        }

        final public function rows($query)
        {
            return mysql_num_rows($query);
        }

        public static function error($msg = "")
        {
            $msg = (self::$dBug===true) ? $msg : "";

            return
            '
                <div style="width:960px; display:table; margin:auto;border:solid 1px red; height:auto; background:#ffffff; border: solid 1px #999; margin-bottom:10px; position:absolute;top:10px; left:10px;">
                    <h3 style="display:block;font-weight:bold; color:#000; font-size:11pt; font-family:Arial, Helvetica, sans-serif; padding:5px; background:#ebebeb; border-left:solid 1px #fff;border-top:solid 1px #fff; border-bottom:dashed 1px #999;">Exceptions</h3>
                    <b style="color:#F00; display:block;text-transform:uppercase;">Erro , Banco de Dados</b>
                    <p style="display:block;">'.$msg.'</p>
                </div>
            ';
        }

        final public function escapeString($value)
        {
            return addslashes($value);
        }

        final public function removeEscapeString($value)
        {
            return stripslashes($value);
        }

        final public function clearString($field)
        {
            return $this->removeEscapeString(strip_tags($field));
        }

        final public function convertQ($field)
        {
            return htmlentities($field,ENT_QUOTES,'ISO-8859-1');
        }

        final public function removeQ($field)
        {
            return html_entity_decode($field,ENT_QUOTES);
        }

        final public function setChar($char = "latin1")
        {
            $this->query("SET NAMES '$char'");
            $this->query("SET character_set_connection='$char'");
            $this->query("SET character_set_client='$char'");
            $this->query("SET character_set_results='$char'");
        }

        final public function setTimeZone($time = "-04:00")
        {
            $this->query("SET time_zone ='$time'");
        }
    }
?>