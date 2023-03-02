<?php
require_once '../App.php';

if ($request->hasGet("id")) {
    $id = $request->get("id");
    $stm = $conn->prepare("select * from todo where id=(:id)");
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $output = $stm->execute();


    if($output) {
        $stm = $conn->prepare("DELETE FROM todo WHERE `id`=(:id)");
        $stm->bindParam(":id", $id, PDO::PARAM_INT);
        $is_deleted = $stm->execute();

        if($is_deleted) {
            $session->set('success', ["task deleted successfully"]);
            $request->redirect("../index.php");
        }
    } else {
        $session->set('errors', "error while update");
        $request->redirect("../index.php");
    }
} else {
    $request->redirect("../index.php");
}
