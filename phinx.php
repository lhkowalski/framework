<?php

// change this, if you changes the core directory
require './core/config.php';

// load settings
Config::load();

return [
    "paths" => [
        "migrations" => "application/migrations"
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "default",
        "default" => [
            "adapter" => Config::get('DB_DRIVER'),
            "host" => Config::get('DB_HOST'),
            "name" => Config::get('DB_NAME'),
            "user" => Config::get('DB_USER'), 
            "pass" => Config::get('DB_PASS'), 
            "port" => Config::get('DB_PORT'), 
        ]
    ]
];