<?php

    namespace App\Api;

    use App\Models\AuthorModel;
    use App\Models\MagazineModel;

    abstract class Api
    {
        /**
         * @var AuthorModel
         */
        protected AuthorModel $authorModel;
        /**
         * @var MagazineModel
         */
        protected MagazineModel $magazineModel;

        /**
         * Api constructor.
         */
        public function __construct()
        {
            $this->authorModel   = new AuthorModel();
            $this->magazineModel = new MagazineModel();
        }

        /**
         * Abstract action to get a list of author/magazine
         *
         * @param array $params
         * @return mixed
         */
        abstract public function list(array $params);

        /**
         * Abstract action to create a new author/magazine
         *
         * @param array $params
         * @return mixed
         */
        abstract public function add(array $params);

        /**
         * Abstract action to update author/magazine
         *
         * @param array $params
         * @return mixed
         */
        abstract public function update(array $params);

        /**
         * Abstract action to delete author/magazine
         *
         * @param array $params
         * @return mixed
         */
        abstract public function delete(array $params);
    }