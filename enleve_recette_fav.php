<?php
    $elem = $_REQUEST["elem"];
    $user_recipes = json_decode($_COOKIE['user_recipes'], true);
    $key = array_search($elem, $user_recipes);
    unset($user_recipes[$key]);
    setcookie('user_recipes', json_encode($user_recipes), time() + 36000);
?>