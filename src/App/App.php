<?php

    namespace App\App;

    use App\Request\Request;
    use App\Response\Response;

    class App
    {
        /**
         * Request data
         *
         * @var Request
         */
        private Request $request;

        /**
         * List of routes
         *
         * @var array
         */
        private static array $routeList = [];

        /**
         * App constructor.
         */
        public function __construct()
        {
            $this->request = new Request();
        }

        /**
         *  Find route and execute it
         */
        public function run()
        {
            $routes = explode('/', $this->request->getPath());

            if (isset($routes[0]) && isset($routes[1])) {

                if ($this->checkRoute($routes, $this->request->getMethod())) {

                    $controllerName = 'App\Api\\' . ucfirst($routes[0]);
                    $controller     = new $controllerName();
                    $action         = $routes[1];

                    if (method_exists($controller, $action)) {

                        if ($this->request->getMethod() === 'GET') {

                            $controller->$action($this->request->getGetParams());

                        } elseif ($this->request->getMethod() === 'POST') {

                            $controller->$action(array_merge($this->request->getPostParams(), $this->request->getFiles()));

                        }

                    }

                } else {
                    Response::out(404, ['message' => 'Unknown route!']);
                }

            } else {
                Response::out(404, ['message' => 'Wrong url!']);
            }
        }

        /**
         * Check route exists
         *
         * @param array $route
         * @param string $method
         * @return mixed|void
         */
        public function checkRoute (array $route, string $method)
        {
            $result = false;
            foreach (self::$routeList as $each) {
                if ($each->getController() === $route[0] &&
                    $each->getAction() === $route[1] &&
                    $each->getMethod() === $method
                ) {
                    $result = $each;
                }
            }

            return $result ?? false;
        }

        /**
         * Add all routes in array
         *
         * @param $route
         */
        public static function addRoute($route)
        {
            array_push(self::$routeList, $route);
        }
    }