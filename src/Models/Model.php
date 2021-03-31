<?php

    namespace App\Models;

    use App\Database\Database;

    abstract class Model
    {
        /**
         * Database connection
         *
         * @var \PDO
         */
        protected \PDO $db;

        /**
         * Model constructor.
         */
        public function __construct()
        {
            $this->db = Database::getConnection();
        }

        /**
         * Create a new author/magazine
         *
         * @param array $values
         * @return int
         */
        public function add(array $values): int
        {
            $keys   = implode(',', array_keys($values));
            $params = substr(str_repeat('?, ', count($values)), 0, -2);

            $add = $this->db->prepare('INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES (' . $params . ')');

            $add->execute(array_values($values));

            return $this->db->lastInsertId();
        }

        /**
         * Update author/magazine
         *
         * @param array $values
         * @return void
         */
        public function update(array $values): void
        {
            $id = $values['id'];
            array_shift($values);

            $keys = '';
            foreach ($values as $key => $value) {
                $keys .= $key . ' = ?, ';
            }

            $update = $this->db->prepare(
                'UPDATE ' . $this->table . ' SET ' . substr($keys, 0, -2) . ' WHERE id = ?'
            );

            $update->execute(array_merge(array_values($values), [$id]));
        }

        /**
         * Delete author/magazine
         *
         * @param int $id
         * @return void
         */
        public function delete(int $id): void
        {
            $delete = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE id = ?');

            $delete->execute([$id]);
        }

        /**
         * Get all author/magazine with 'page' and 'perPage' parameters
         *
         * @param string $page
         * @param string $perPage
         * @return array
         */
        public function list(string $page = '', string $perPage = ''): array
        {
            $list = $this->db->prepare('SELECT * FROM ' . $this->table . $perPage . $page);

            $list->execute();

            return $list->fetchAll(\PDO::FETCH_ASSOC);
        }

        /**
         * Get once record
         *
         * @param int $id
         * @return bool|array
         */
        public function find(int $id): bool|array
        {
            $find = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE id = ?');

            $find->execute([$id]);

            return ($find->rowCount() !== 0) ? $find->fetchAll(\PDO::FETCH_ASSOC)[0] : false;
        }
    }