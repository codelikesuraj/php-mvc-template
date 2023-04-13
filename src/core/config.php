<?php

/* 
 * configs with similar name should be
 * distinguished using '_' character
 * e.g
 * return [
 *  'app_name' => 'name',
 *  'app_environmet => 'local',
 *  'app_api_key_secret => 'secret_key',
 *  'app_api_key_public => 'public key',
 *   ... and so on
 * ];
 */


return [
    'app_name' => env('APP_NAME'),
    'app_env' => env('APP_ENV'),
    'db_database' => env('DB_DATABASE', 'php_mvc_template'),
    'db_port' => env('DB_PORT', 3306),
    'db_host' => env('DB_HOST', 'localhost'),
    'db_username' => env('DB_USERNAME', 'root'),
    'db_password' => env('DB_PASSWORD', '')
];