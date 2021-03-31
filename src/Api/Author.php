<?php

    namespace App\Api;

    use App\Response\Response;
    use App\Validate\AuthorValidate;

    class Author extends Api
    {
        /**
         * Get a list of authors
         *
         * @param array $params
         * @return
         */
        public function list(array $params)
        {
            $params = AuthorValidate::validatePageAndPerPage($params);

            return Response::out(200, $this->authorModel->list($params['page'], $params['perPage']));
        }

        /**
         * Create a new author
         *
         * @param array $params
         * @return
         */
        public function add(array $params)
        {
            if (AuthorValidate::validate($params)) {

                $author_id = $this->authorModel->add([
                    'first_name'  => $params['first_name'],
                    'last_name'   => $params['last_name'],
                    'middle_name' => $params['middle_name'] ?? null
                ]);

                return Response::out(201, ['author_id' => $author_id]);
            }
        }

        /**
         * Update author information
         *
         * @param array $params
         * @return
         */
        public function update(array $params)
        {
            $authorId = $params['author_id'];
            unset($params['author_id']);

            if ($this->authorModel->find($authorId)) {
                if (AuthorValidate::validate($params)) {

                    $this->authorModel->update([
                        'id'          => $authorId,
                        'first_name'  => $params['first_name'],
                        'last_name'   => $params['last_name'],
                        'middle_name' => $params['middle_name'] ?? null
                    ]);

                    Response::out(200, ['message' => 'Author updated!']);
                }
            } else {
                Response::out(400, ['message' => 'Author not found!']);
            }
        }

        /**
         * Delete author
         *
         * @param array $params
         * @return
         */
        public function delete(array $params)
        {
            if ($this->authorModel->find($params['author_id'])) {
                $this->authorModel->delete($params['author_id']);

                $result = [200, 'Author was deleted!'];
            } else {
                $result = [400, 'Author not found!'];
            }

            return Response::out($result[0], ['message' => $result[1]]);
        }

    }