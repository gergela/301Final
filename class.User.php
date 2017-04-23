<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 3:48 PM
 */

class User{
    private $name;
    private $database;
    private $userID;

    public function User($userID, $database){
        $sql = file_get_contents('sql/getUser.sql');
        $params = array(
            'customerid' => $userID
        );
        $statement = $database->prepare($sql);
        $statement->execute($params);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        $user = $users[0];

        $this->userID = $userID;
        $this->name = $user['name'];
        $this->database = $database;
    }

    public function getName(){
        return $this->name;
    }
}
