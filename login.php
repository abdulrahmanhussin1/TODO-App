<?php
require_once 'inc/header.php';
require_once 'inc/nav.php';
require_once 'App.php';
?>

<section class="vh-100">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="container w-50 ">
                            <?php
                            if ($session->hasGetSession("errors")) {
                                $errors = $session->get("errors");
                                foreach ($errors as  $error) : ?>
                                    <div class="alert alert-danger">
                                        <?= "* " . $error ?>
                                    </div>
                            <?php endforeach;
                            } ?>
                            <?php $session->remove("errors") ?>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>
                                <form class="mx-1 mx-md-4" action="handle/auth/login.php" method="post">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="form3Example3c">Email</label>
                                            <input type="email" name="email" id="form3Example3c" class="form-control" 
                                            value = "<?php 
                                            if($session->hasGetSession("regEmail")){
                                                echo $session->get('regEmail');
                                                $session->remove('regEmail');
                                                }elseif($session->hasGetSession("email")){
                                                    echo $session->get('email');
                                                    $session->remove('email');
                                                    };
                                                ?>"/>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label"   for="form3Example4c">Password</label>
                                            <input type="password" name="password" id="form3Example4c" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Login</button>
                                    </div>
                                </form>
                                <p>Do not have an account? <a href="signup.php">Sing up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once 'inc/footer.php';
?>