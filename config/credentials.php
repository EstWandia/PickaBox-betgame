<?php
define('MAIN_HOST', 'localhost');
define('DB_SHARED', 'comp21');
define('MONEY_HOST', 'localhost');
define('SMS_HOST', 'localhost');
define('ANALYTICS_HOST', 'localhost');

define('MAX_AMOUNT', 1000000);

define('MAIN_DB', 'ussd');
define('SMS_DB','comp21_sms');
define('MONEY_DB','comp21_mpesa');
define('ANALYTICS_DB','comp21_analytics');

define('MAIN_DB_PASSWORD','P@ssW0rd');
define('MONEY_DB_PASSWORD','P@ssW0rd');
define('DB_PASSWORD','P@ssW0rd');
define('SMS_DB_PASSWORD','P@ssW0rd');
define('ANALYTICS_DB_PASSWORD','P@ssW0rd');

define('MONEY_USERNAME','root');
define('MAIN_USERNAME','root');
define('ANALYTICS_USERNAME','root');
define('SMS_USERNAME','root');
define('DB_USERNAME','root');

define('USSD_CODE', '**384*95334#');
define('PICKABOX', ['1*1*1', '1*1*2', '1*1*3', '1*1*4', '1*1*5', '1*1*6']);
define('USSD_MONEY', ['1*1*1*1', '1*1*2*1', '1*1*3*1', '1*1*4*1', '1*1*5*1', '1*1*6*1',
'1*1*1*2', '1*1*2*2', '1*1*3*2', '1*1*4*2', '1*1*5*2', '1*1*6*2',
'1*1*1*3', '1*1*2*3', '1*1*3*3', '1*1*4*3', '1*1*5*3', '1*1*6*3',
'1*1*1*4', '1*1*2*4', '1*1*3*4', '1*1*4*4', '1*1*5*4', '1*1*6*4',
'1*1*1*5', '1*1*2*5', '1*1*3*5', '1*1*4*5', '1*1*5*5', '1*1*6*5',
'1*1*1*6', '1*1*2*6', '1*1*3*6', '1*1*4*6', '1*1*5*6', '1*1*6*6',
'1*1*1*1', '1*1*2*1', '1*1*3*1', '1*1*4*1', '1*1*5*1', '1*1*6*1',
'1*2*1', '1*2*2', '1*2*3', '1*2*4', '1*2*5', '1*2*6',
]);
define('RASHARASHA',['2*1', '2*2', '2*3', '2*4', '2*5', '2*6']);
define('LAST_LEVEL_MESSAGE', ' END Enter pin when prompted');
define('INVALID_REQUEST','END Invalid Entry');
define('REQUEST_TO_PAY','http://localhost:8000/mpesa/savempesa');
define('SAVE_WINNER','http://localhost:8000/winners/savewinners');