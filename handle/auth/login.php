<?php
require_once '../../App.php';

if ($request->hasPost("submit")) {
    //sanitize
    $email = $request->sanitize("email");
    $password = $request->sanitize("password");
    // validation
    $validation->validate("email", $email, ["Str", "Required", "Email"]);
    $validation->validate("password", $password, ["Str", "Required", "maxLength", "minLength"]);
    $errors = $validation->getError();

    if (empty($errors)) {
        $stm = $conn->prepare("select * from users where email=:email");
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $user = $stm->fetch(PDO::FETCH_ASSOC);
            $hashPassword = $user['password'];
            $is_verified = password_verify($password, $hashPassword);
            if ($is_verified) {
                $session->set('loggedIn',$user['id']);
                $session->set('success', ["Welcome back, you logged in successfully"]);
                $request->redirect('../../index.php');
            } else {
                $session->set("email",$_POST['email']);
                $session->set('errors', ['your credentials are wrong']);
                $request->redirect('../../login.php');
            }
        } else {
            $session->set("email",$_POST['email']);
            $session->set('errors', ['this account does not exist']);
            $request->redirect('../../login.php');
        }
    } else {
        $session->set("email",$_POST['email']);
        $session->set('errors', $errors);
        $request->redirect('../../login.php');
    }
} else {
    $session->set("errors", ["page invalid"]);
    $request->redirect("../../login.php");
}
