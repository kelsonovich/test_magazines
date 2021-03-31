<?php

    namespace App\Validate;

    use App\Response\Response;

    class AuthorValidate extends Validate
    {
        /**
         * Validate author data before store in DB
         *
         * @param array $author
         * @return void|bool
         */
        public static function validate(array $author)
        {
            if (!isset($author['first_name']) || strlen($author['first_name']) < 3) {

                $error = 'First name is required and must be longer than 3 characters!';

            } elseif (!isset($author['last_name'])) {

                $error = 'Last name is required and must be longer than 3 characters!';

            }

            return (!isset($error)) ? true : Response::out(400, ['message' => $error]);
        }
    }