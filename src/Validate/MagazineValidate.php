<?php

    namespace App\Validate;

    use App\Response\Response;

    class MagazineValidate extends Validate
    {
        /**
         * Validate magazines data before store
         *
         * @param array $magazine
         * @return void|bool
         */
        public static function validate(array $magazine)
        {
            if (!isset($magazine['title'])) {

                $error = 'Title is required!';

            } elseif (!isset($magazine['authors']) || count($magazine['authors']) === 0) {

                $error = 'Authors is required!';

            } elseif (!isset($magazine['image'])) {

                $error = 'Image is required!';

            } elseif (isset($magazine['image'])) {

                if ($magazine['image']['size'] <= 2048) {

                    $error = 'Image size must be less 2MB!';

                } elseif (!in_array($magazine['image']['type'], ['image/jpeg', 'image/png'])) {

                    $error = 'Image must be *.jpg or *.png!';

                }

            }

            return (!isset($error)) ? true : Response::out(400, ['message' => $error]);
        }

        /**
         * Validate magazines data with out image before updating
         *
         * @param array $magazine
         * @return void|bool
         */
        public static function validateWithoutImage(array $magazine)
        {
            if (!isset($magazine['title'])) {

                $error = 'Title is required!';

            } elseif (!isset($magazine['authors']) || count($magazine['authors']) === 0) {

                $error = 'Authors is required!';

            }

            return (!isset($error)) ? true : Response::out(400, ['message' => $error]);
        }
    }