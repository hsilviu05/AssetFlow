<?php
    class InvalidCredentialsException extends Exception 
    {
        public function __construct($message = "Invalid credentials provided.", $code = 0, Exception $previous = null) 
        {
            parent::__construct($message, $code, $previous);
        }
    }
?>