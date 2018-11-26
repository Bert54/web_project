<?php
    $elem = $_REQUEST["elem"];
    $user_recipes = json_decode($_COOKIE['user_recipes'], true);
<<<<<<< HEAD
    if (!in_array($elem, $user_recipes)) {
        array_push($user_recipes, $elem);
        setcookie('user_recipes', json_encode($user_recipes), time() + 36000);
    }
=======
    array_push($user_recipes, $elem);
    setcookie('user_recipes', json_encode($user_recipes), time()+36000);
>>>>>>> 6525fe2dc8b2cd4c379f00bf138642483fd85556
?>