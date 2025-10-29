<?php

    class StockZeroException extends Exception 
    {
        public function __construct($message = "Stock level is zero.", $code = 0, ?Exception $previous = null) 
        {
            parent::__construct($message, $code, $previous);
        }
    }

?>