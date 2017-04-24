<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:13 AM
 */

class Portfolio{
    private $portfolioName;
    private $name;
    private $title;
    private $sections;

    public function updateUserInfo($database){
        if (isset($_SESSION['userID'])){
            $sql = file_get_contents('sql/getUser.sql');
            $params = array(
                'userid' => $_SESSION['userID']
            );
            $statement = $database->prepare($sql);
            $statement->execute($params);
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            $user = $users[0];

            $this->name = $user['name'];
            $this->title = $user['job_title'];
        }
    }

    public function addSection($title,$featuredImage,$text,$image,$id, $isActive){
        $this->sections[$id]["sectionTitle"] = $title;
        $this->sections[$id]["featuredImage"] = $featuredImage;
        $this->sections[$id]["text"] = $text;
        $this->sections[$id]["image"] = $image;
        $this->sections[$id]["id"] = $id;
        $this->sections[$id]["isActive"] = $isActive;

    }

    public function setPortfolioName($name){
        $this->portfolioName = $name;
    }

    public function getPortfolioName(){
        return $this->portfolioName;
    }

    public function getName(){
        return $this->name;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getSections(){
        return $this->sections;
    }
}