<?php
require_once '../App.php';

if ($request->hasPost('submit')) {

    //sanitize
    $title = $request->sanitize('title');
    $description = $request->sanitize('description');

    //validation

    $validation->validate("title", $title, ["required", "Str"]);
    $validation->validate("description", $description, ["Str"]);
    $errors = $validation->getError();


    if (empty($errors)) {
        if($session->hasGetSession("loggedIn"))
        {
            $user_id = $session->get("loggedIn");
        }

        $stm = $conn->prepare("insert into todo(`title`,`description`,`user_id`) values(:title,:description,:user_id)");
        $stm->bindParam(":title", $title, PDO::PARAM_STR);
        $stm->bindParam(":description", $description, PDO::PARAM_STR);
        $stm->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $output = $stm->execute();

        $session->set('success', ["task added successfully"]);
        $request->redirect('../index.php');
    } else {
        $session->set('errors', $errors);
        $request->redirect('../index.php');
    }
} else {
    $session->set('errors', "page invalid");
    $request->redirect('../index.php');
}
