<?php
require_once '../App.php';

if ($request->hasPost("submit") && $request->hasGet("id")) {
    $id = $request->get("id");
    $title = $request->sanitize('title');
    $description = $request->sanitize('description');

    //validation
    $validation->validate("title", $title, ['Str',"Required"]);
    $validation->validate("description", $description, ['Str']);
    $errors = $validation->getError();

    if (empty($errors)) {
        $stm = $conn->prepare("select * from todo where id=(:id)");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $output = $stm->execute();
    

        if ($output) {
            $updated_at = date ("Y-m-d H:i:s");
            $stm = $conn->prepare(" UPDATE `todo`   
            SET `title` = :title,
            `description` = :description,
            `updated_at` = :updated_at
            WHERE `id` = (:id)");

            $stm->bindParam(":title", $title, PDO::PARAM_STR);
            $stm->bindParam(":description", $description, PDO::PARAM_STR);
            $stm->bindParam(":updated_at", $updated_at, PDO::PARAM_STR);
            $stm->bindParam(":id", $id, PDO::PARAM_INT);
            $is_updated = $stm->execute();

            if($is_updated)
            {
                $session->set('success', ["task edited successfully"]);
                $request->redirect("../index.php");
            }
        } else {
            $session->set('errors', "error while update");
            $request->redirect("../edit.php?id=$id");
        }
    } else {
        $session->set('errors', $errors);
        $request->redirect("../edit.php?id=$id");
    }
} else {
    $session->set('errors', "page invalid");
    $request->redirect("../edit.php?id=$id");
}
