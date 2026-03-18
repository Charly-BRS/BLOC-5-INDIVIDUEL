<?php

namespace App;

class Config
{
    const SHOW_ERRORS = true;

    public static function dbHost()
    {
        return getenv('DB_HOST') ?: 'db-dev';
    }

    public static function dbName()
    {
        return getenv('DB_NAME') ?: 'videgrenierenligne';
    }

    public static function dbUser()
    {
        return getenv('DB_USER') ?: 'webapplication';
    }

    public static function dbPassword()
    {
        return getenv('DB_PASSWORD') ?: '653rag9T';
    }
}