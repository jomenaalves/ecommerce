<?php 

    namespace Source\Utils;
    
    class Utils {


        /**
         * Role responsible for the string filter
         * @param String
         */
        public static function filterString(String $string): String
        {

            $filteredString = filter_var($string, FILTER_SANITIZE_STRING);

            return $filteredString;

        }
        

        public function startSection() {
            
            !session_start() && session_start();

        }
    }