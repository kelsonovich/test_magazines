<?php

    namespace App\Route;

    class Route
    {
        /**
         * Controller name
         *
         * @var string
         */
        private string $controller;

        /**
         * Action name
         *
         * @var string
         */
        private string $action;

        /**
         * Method type
         *
         * @var string
         */
        private string $method;

        /**
         * Route constructor.
         *
         * @param string $controller
         * @param string $action
         * @param string $method
         */
        public function __construct(string $controller, string $action, string $method)
        {
            $this->controller = $controller;
            $this->action     = $action;
            $this->method     = $method;
        }

        /**
         * Get controller name
         *
         * @return string
         */
        public function getController(): string
        {
            return $this->controller;
        }

        /**
         * Get action name
         *
         * @return string
         */
        public function getAction(): string
        {
            return $this->action;
        }

        /**
         * Get method type
         *
         * @return string
         */
        public function getMethod(): string
        {
            return $this->method;
        }
    }