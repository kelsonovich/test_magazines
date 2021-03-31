<?php

    namespace App\Validate;

    abstract class Validate
    {
        /**
         * Validate optional parameters 'page' and 'perPage'
         *
         * @param array $params
         * @return array
         */
        public static function validatePageAndPerPage(array $params): array
        {
            $empty = ['page' => '', 'perPage' => ''];

           if (isset($params['page']) && isset($params['perPage'])) {

                $params['page']    = Validate::checkNegativeOrZero($params['page']);
                $params['perPage'] = Validate::checkNegativeOrZero($params['perPage']);

                if ($params['page'] !== '' && $params['perPage'] !== '') {

                    $params['page']    = ' OFFSET ' . $params['perPage'] * ($params['page'] - 1) ;
                    $params['perPage'] = ' LIMIT ' . $params['perPage'];

                } else {
                    $params = $empty;
                }

            } else {
                $params = $empty;
            }

            return $params;
        }

        /**
         * Check value if int or other
         *
         * @param mixed $value
         * @return int|string
         */
        public static function checkNegativeOrZero(mixed $value): int|string
        {
            return ((int) $value >= 1) ? $value : '';
        }
    }