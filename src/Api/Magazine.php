<?php

    namespace App\Api;

    use App\Response\Response;
    use App\Validate\MagazineValidate;
    use App\Validate\Validate;

    class Magazine extends Api
    {
        /**
         * Get a list of magazines with parameters 'page' and 'prePage'
         *
         * @param array $params
         * @return
         */
        public function list(array $params)
        {
            $params = Validate::validatePageAndPerPage($params);

            $list = $this->magazineModel->list($params['page'], $params['perPage']);
            foreach ($list as $key => $magazine) {
                $list[$key]['authors'] = [];

                $authors = explode(',', $magazine['authors']);
                foreach ($authors as $author) {
                    $list[$key]['authors'][] = $this->authorModel->find($author);
                }

                $list[$key]['image'] = 'storage/images/magazines/' . $magazine['id'] . '/' . $list[$key]['image'];
            }

            return Response::out(200, $list);
        }

        /**
         * Create a new magazine
         *
         * @param array $params
         * @return
         */
        public function add(array $params)
        {
            if (MagazineValidate::validate($params)) {

                $newImage = $this->saveImage($params);

                $magazineId = $this->magazineModel->add([
                    'title'             => $params['title'],
                    'short_description' => $params['short_description'] ?? null,
                    'image'             => $newImage,
                    'authors'           => implode(',', array_unique($params['authors'])),
                    'release_date'      => $params['release_date'] ?? null
                ]);

                $this->moveNewFile($newImage, $magazineId);

                Response::out(200, ['magazine_id' => $magazineId]);
            }
        }

        /**
         * Update magazine info
         *
         * @param array $params
         * @return
         */
        public function update(array $params)
        {
            $magazineId = $params['magazine_id'];
            unset($params['magazine_id']);

            $magazine = $this->magazineModel->find($magazineId);

            if ($magazine) {

                if (isset($params['image'])) {

                    if (MagazineValidate::validate($params)) {

                        unlink('storage/images/magazines/' . $magazineId . '/' . $magazine['image']);
                        $newImage = $this->saveImage($params);
                        $this->moveNewFile($newImage, $magazineId);

                        $this->magazineModel->update([
                            'id'                => $magazineId,
                            'title'             => $params['title'],
                            'short_description' => $params['short_description'],
                            'image'             => $newImage,
                            'authors'           => implode(',', array_unique($params['authors'])),
                            'release_date'      => $params['release_date']
                        ]);

                        Response::out(200, ['message' => 'Magazine updated!']);
                    }

                } else {

                    if (MagazineValidate::validateWithoutImage($params)) {
                        $this->magazineModel->update([
                            'id'                => $magazineId,
                            'title'             => $params['title'],
                            'short_description' => $params['short_description'],
                            'authors'           => implode(',', array_unique($params['authors'])),
                            'release_date'      => $params['release_date']
                        ]);

                        Response::out(200, ['message' => 'Magazine updated!']);
                    }
                }
            } else {
                Response::out(400, ['message' => 'Magazine not found!']);
            }
        }

        /**
         * Delete a magazine
         *
         * @param array $params
         */
        public function delete(array $params)
        {
            $magazine = $this->magazineModel->find($params['magazine_id']);
            if ($magazine) {
                $this->deleteFolder($params['magazine_id'], $magazine['image']);

                $this->magazineModel->delete($params['magazine_id']);

                $result = [200, 'Magazine was deleted!'];
            } else {
                $result = [400, 'Magazine not found!'];
            }

            return Response::out($result[0], ['message' => $result[1]]);
        }

        /**
         * Save new image and return new file name
         *
         * @param array $params
         * @return string
         */
        public function saveImage (array $params): string
        {
            $format = substr($params['image']['name'], strripos($params['image']['name'], '.'));

            $newName = md5($params['title'] . time() . rand(0, 10000000));

            move_uploaded_file($params['image']['tmp_name'], 'storage/images/magazines/' . $newName . $format);

            return $newName . $format;
        }

        /**
         * Delete folder with image on deletion magazine
         *
         * @param int $id
         * @param string $image
         */
        public function deleteFolder (int $id, string $image)
        {
            unlink('storage/images/magazines/' . $id . '/' . $image);

            rmdir('storage/images/magazines/' . $id);
        }

        /**
         * Move new image in magazine folder
         *
         * @param string $name
         * @param int $id
         */
        public function moveNewFile(string $name, int $id){
            $path = 'storage/images/magazines/' . $id;

            if (!is_dir($path)) mkdir($path);

            rename('storage/images/magazines/' . $name, $path . '/'. $name);
        }
    }