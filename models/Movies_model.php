<?php
require_once('../system/database.php');

class Movies_model {

    protected $db;

    public function __construct()
    {
        $this->db = dbconnect();
    }    

    /**
     * Lists the movies
     * 
     * @param string $order [optional] Column to sort list (default title)
     * @param int $page Page 
     * @param int $limit Rows per request
     * 
     * @return array $results Array list of movies
     */

     // TODO: Implement pagination and limit
    public function list($order = 2, $offset = 1, $limit = 25) {
        $sql = "SELECT id, title, delivery_format, run_length, release_year, rating FROM bigscreen.movies";
        
        if ($order) {
            $orderBy = $order + 1;
        } else {
            $orderBy = 2;
        }
        $sql .= " ORDER BY $orderBy LIMIT :offset, :limit";

        $stmt = $this->db->prepare($sql);
        $params = array(
            ":limit" => $limit,
            ":offset" => $offset,
            //":orderBy" => $orderBy
        );

        $results = array();
        if ($stmt->execute($params) && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $results;            
    }


    /**
     * Insert moves
     * 
     * @param mixed $data Array of column values
     * 
     * @return int|false $results Returns the inserted id or false if failed
     */
    public function persist($data) {

        //TODO: if the title of the movie exists => update the record 
        $sql = "INSERT INTO bigscreen.movies (title, delivery_format, run_length, release_year, rating) 
            VALUES (:title, :delivery_format, :run_length, :release_year, :rating)";

        $stmt = $this->db->prepare($sql);

        $result = false;
        $params = array(
            ":title" => $data['title'],
            ":delivery_format" => $data['delivery_format'],
            ":run_length" => $data['run_length'],
            ":release_year" => $data['release_year'],
            ":rating" => $data['rating'],                                                
        );

        if ($stmt->execute($params) && $stmt->rowCount() > 0){
            $result = $this->db->lastInsertId();
        }
        
        return $result;

    }

    /**
     * Get movie by id
     * 
     * @param int $id The id of the movie to return
     * 
     * @return array $results Array list of movies
     */
    public function get($id) {
        $sql = "SELECT id, title, delivery_format, run_length, release_year, rating FROM bigscreen.movies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt = $this->db->prepare($sql);
        $params = array(
            ":id" => $id
        );

        $results = false;
        if ($stmt->execute($params) && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $results ? $results[0] : $results;  
    }

    /**
     * Update a movie
     * 
     * @param mixed $data Movie data being updated
     * 
     * @return bool True if successful or false if failed
     */
    public function update($data) {
        $sql = "UPDATE bigscreen.movies 
            SET 
                title = :title,
                delivery_format = :delivery_format, 
                run_length = :run_length, 
                release_year = :release_year, 
                rating = :rating
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $result = false;
        $params = array(
            ":id" => $data['id'],
            ":title" => $data['title'],
            ":delivery_format" => $data['delivery_format'],
            ":run_length" => $data['run_length'],
            ":release_year" => $data['release_year'],
            ":rating" => $data['rating'],                                                
        );

        if ($stmt->execute($params) && $stmt->rowCount() > 0){
            $result = true;
        }
        
        return $result;

    }


    /**
     * Delete a movie 
     * 
     * @param int $id The id of the record to delete
     * 
     * @return bool Returns true if deleted or false in unsuccessful
     */
    public function delete($id) {
        $sql = "DELETE FROM bigscreen.movies WHERE id = :id";

        $stmt = $this->db->prepare($sql);        
        $params = array(
            ":id" => $id
        );

        $isDeleted = false;
        if ($stmt->execute($params) && $stmt->rowCount() > 0) {
            $isDeleted = true;
        }    

        return $isDeleted;
    }

    /**
     * Search a movie by any column
     * 
     * @param string $q Search string
     * @param string $column [optional] Column to search (default "title")
     * 
     * @return array $results Array list of movies
     */
    public function search($q, $column = "title") {
        $sql = "SELECT id, title, delivery_format, run_length, release_year, rating 
                FROM bigscreen.movies 
                WHERE $column LIKE :search";

        $stmt = $this->db->prepare($sql);
        $search = '%'.$q.'%';
        $params = array(
            ":search" => $search
        );

         $results = array();
         if ($stmt->execute($params) && $stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }

        return $results;        
    }

}
