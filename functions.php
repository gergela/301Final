<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 7:57 PM
 */

function searchPortfolios($term, $database) {
    // Get list of books
    $term = '%' . $term . '%';
    $sql = file_get_contents('sql/searchAllPortfolios.sql');
    $params = array(
        'term' => $term
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $portfolios = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $portfolios;
}

function get($key) {
    if(isset($_GET[$key])) {
        return $_GET[$key];
    }

    else {
        return '';
    }
}

function searchUserPortfolios($term, $database, $userID){
    $term = '%' . $term . '%';
    $sql = file_get_contents('sql/searchUserPortfolios.sql');
    $params = array(
        'term' => $term,
        'user_id' => $userID
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $portfolios = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $portfolios;
}