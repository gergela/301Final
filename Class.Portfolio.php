<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:13 AM
 */

class Portfolio{
    private $name;
    private $title;
    private $section;

    public function updateUserInfo($database){
        if (isset($_SESSION['userID'])){
            $sql = file_get_contents('sql/getUser.sql');
            $params = array(
                'userid' => $_SESSION['userID']
            );
            $statement = $database->prepare($sql);
            $statement->execute($params);
            $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
            $customer = $customers[0];

            $this->name = $customer['name'];
            $this->title = $customer['title'];
        }
    }

    public function addSection($title,$featuredImage,$text,$image){
        $this->section[count($this->section)]["sectionTitle"] = $title;
        $this->section[count($this->section)]["featuredImage"] = $featuredImage;
        $this->section[count($this->section)]["text"] = $text;
        $this->section[count($this->section)]["image"] = $image;

    }

    public function getName(){
        return $this->name;
    }
}