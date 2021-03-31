<?php

    namespace App\Response;

    class Response
    {
        /**
         * Display data in JSON
         *
         * @param int $code
         * @param array $data
         */
        public static function out (int $code, array $data = []): void
        {
            header('Content-type: application/json');
            http_response_code($code);
            echo json_encode($data);
        }
    }