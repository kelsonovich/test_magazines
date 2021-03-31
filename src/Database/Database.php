<?php

    namespace App\Database;

    class Database
    {
        /**
         * @var \PDO
         */
        private static $connetction;

        /**
         * @var string
         */
        private static $DB_HOST = '127.0.0.1';
        /**
         * @var string
         */
        private static $DB_NAME = 'magazines';
        /**
         * @var string
         */
        private static $DB_USER = 'root';
        /**
         * @var string
         */
        private static $DB_PASS = '';

        /**
         * @return \PDO
         */
        public static function getConnection(): \PDO
        {
            if (!self::$connetction) {
                self::$connetction = new \PDO('mysql:host=' . self::$DB_HOST . ';dbname=' . self::$DB_NAME, self::$DB_USER, self::$DB_PASS);
            }

            return self::$connetction;
        }

    }