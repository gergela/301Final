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
            $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
            $customer = $customers[0];

            $this->name = $customer['name'];
            $this->title = $customer['title'];
        }
    }

    public function addSection($title,$featuredImage,$text,$image){
        $this->sections[count($this->sections)]["sectionTitle"] = $title;
        $this->sections[count($this->sections)]["featuredImage"] = $featuredImage;
        $this->sections[count($this->sections)]["text"] = $text;
        $this->sections[count($this->sections)]["image"] = $image;

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