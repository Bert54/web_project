<?php
    $elem = $_REQUEST["elem"];
    $user_recipes = json_decode($_COOKIE['user_recipes'], true);
    array_push($user_recipes, $elem);
    setcookie('user_recipes', json_encode($user_recipes), time()+36000);
?>