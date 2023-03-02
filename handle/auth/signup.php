<?php
require_once '../../App.php';

if ($request->hasPost("submit")) {
    //sanitize
    $name = $request->sanitize("name");
    $email = $request->sanitize("email");
    $password = $request->sanitize("password");
    $confirmPassword = $request->sanitize("confirmPassword");

    // validation
    $validation->validate("name", $name, ["Str", "Required", "maxLength", "minLength"]);
    $validation->validate("email", $email, ["Str", "Required", "Email"]);
    $validation->validate("password", $password, ["Str", "Required", "maxLength", "minLength"]);
    $validation->validate("confirmPassword", $confirmPassword, ["Str", "Required", "maxLength", "minLength"]);
    $errors = $validation->getError();
    if ($confirmPassword !== $password) {
        $errors[] = "Password did not match";
    }
    
    //Unique email validation
    $stm = $conn->prepare("select * from users where email=:email");
    $stm->bindParam(':email', $email, PDO::PARAM_STR);
    $stm->execute();

    if ($stm->rowCount() > 0) {
        $errors[] = "Sorry... email already taken";
    }

    //Signing Up
    if (empty($errors)) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stm = $conn->prepare("insert into users(`name`,`email`,`password`) values(:name,:email,:hashPassword)");
        $stm->bindParam(":name", $name, PDO::PARAM_STR);
        $stm->bindParam(":email", $email, PDO::PARAM_STR);
        $stm->bindParam(":hashPassword", $hashPassword, PDO::PARAM_STR);
        $output = $stm->execute();
        if ($output) {
            $session->set('regEmail',$email);
            $session->set('success', ["user added successfully"]);
            $request->redirect('../../login.php');
        }
    } else {
        $session->set('name', $_POST['name']);
        $session->set('email', $_POST['email']);
        $session->set('password', $_POST['password']);
        $session->set('confirmPassword', $_POST['confirmPassword']);
        $session->set('errors', $errors);
        $request->redirect('../../signup.php');
    }
} else {
    $session->set("errors", ["page invalid"]);
    $request->redirect("../../signup.php");
}
