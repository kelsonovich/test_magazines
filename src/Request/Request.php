<?php

    namespace App\Request;

    use App\Response\Response;

    class Request
    {
        /**
         * HTTP method
         *
         * @var string
         */
        private string $method;

        /**
         * $_GET parameters
         *
         * @var array
         */
        private array $getParams;

        /**
         * $_POST parameters
         *
         * @var array
         */
        private array $postParams;

        /**
         * $_FILES parameters if exists
         *
         * @var array
         */
        private array $files = [];

        /**
         * Path
         *
         * @var string
         */
        private string $path = '';

        /**
         * Request constructor.
         */
        public function __construct ()
        {
            if (isset($_GET['path']) && $_GET['path'] !== '') {

                $this->path = $_GET['path'];
                unset($_GET['path']);

                $this->method     = $_SERVER['REQUEST_METHOD'];
                $this->getParams  = $_GET;
                $this->postParams = $_POST;

                if (isset($_FILES)) $this->files = $_FILES;

            }
        }

        /**
         * Get type of HTTP method
         *
         * @return string
         */
        public function getMethod(): mixed
        {
            return $this->method;
        }

        /**
         * Get $_GET parameters
         *
         * @return array
         */
        public function getGetParams(): array
        {
            return $this->getParams;
        }

        /**
         * Get $_POST parameters
         *
         * @return array
         */
        public function getPostParams(): array
        {
            return $this->postParams;
        }

        /**
         * Get $_FILES parameters
         *
         * @return array
         */
        public function getFiles(): array
        {
            return $this->files;
        }

        /**
         * Get path
         *
         * @return string
         */
        public function getPath(): mixed
        {
            return $this->path;
        }
    }