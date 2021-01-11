<?php
    require 'Gump.class.php';

    class Validate extends GUMP {

        public function validate_csrf($field, $input, $param = NULL)
        {
            if ( !empty( $input[$field] ) && $input[$field] === $_SESSION['_token'] ) {
                return;
            }

            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule'  => __FUNCTION__,
                'param' => $param
            );
        }

        public function validate_equals($field, $input, $param = NULL)
        {
            if ( $input[$param] === $input[$field] ) {
                return;
            }

            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule'  => __FUNCTION__,
                'param' => $param
            );
        }

        public function validate_cpf($field, $input, $param = NULL)
        {
            if ( !empty( $input[$field] ) && isCpf( $input[$field] ) ) {
                return;
            }

            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule'  => __FUNCTION__,
                'param' => $param
            );
        }

        public function validate_cnpj($field, $input, $param = NULL)
        {
            if ( !empty( $input[$field] ) && isCnpj( $input[$field] ) ) {
                return;
            }

            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule'  => __FUNCTION__,
                'param' => $param
            );
        }

        public function get_error($field = '',$element = 'span', $class = 'help-block') {

            $errors = $this->get_errors_array();

            if ( !empty( $errors) && isset( $errors[$field])  ) {
                return '<'.$element.' class="'.$class.'">'.$errors[$field].'</'.$element.'>';
            }

            return '';
        }

        public function has_error($field = '') {

            $errors = $this->get_errors_array();

            return !empty( $errors) && isset( $errors[$field] );
        }
    }