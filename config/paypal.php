<?php
return array(
    /**
     * set your paypal credential
     * 'client_id' =>"AVSbZbw7g-cdc_q-RzY63n4nLIQQJ1MsU8UHrDU3bbBUWItz7hAbt1jBHxlh3UD2VZHB56TCUvbjPxCL",
     * 'secret' => "EC-rB97O5g2SHkOY-YpECsRUXXHHm9jIrj3XB9TivA5X-fL2HrHtQT1oKyEwI6P1iRyqIBE69v0Z4t-m",
     * *
     */
    
    // Sam Credentials
    'client_id' => "AdgGdCQGGiMNRf7mZxGt1JLssYDAdLaQrT4ez767xjmbm2qZzY75eRyKqAVRBtkpFod0CY7wfyzapfHr",
    'secret' => "EPLy7BzBCVz4OJ0Mbir426URWEhN_WkAFxDidWNxHw7GQGhI5waunjzXFn0_wIrvPX-gya6KWDlrENM-",
    
    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 1000,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    )
);
