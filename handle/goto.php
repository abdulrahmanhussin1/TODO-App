<?php
require_once '../App.php';

if ($request->hasGet("id")) {
    $id = $request->get("id");

    if($request->hasGet("name"))
    {
        $name = $request->get("name");
        $stm = $conn->prepare("select * from todo where id=(:id)");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $output = $stm->execute();
    
    
        if($output) {
            $stm = $conn->prepare("UPDATE todo SET `status`=:name WHERE `id`=(:id)");
            $stm->bindParam(":id", $id, PDO::PARAM_INT);
            $stm->bindParam(":name", $name, PDO::PARAM_STR);
            $is_doing = $stm->execute();
    
            if($is_doing) {
                $session->set('success',[ "task changed successfully"]);
                $request->redirect("../index.php");
            }
        } else {
            $session->set('errors', "error while update");
            $request->redirect("../index.php");
        }

    }

} else {
    $request->redirect("../index.php");
}
