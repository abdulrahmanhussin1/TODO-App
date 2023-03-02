<?php
require_once 'inc/header.php';
require_once 'inc/nav.php';
require_once 'App.php';
?>

<?php

if ($request->hasGet('id')) {
    $id = $request->get('id');

    $stm = $conn->prepare("select * from todo where id = (:id)");
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();

    $todo = $stm->fetch(PDO::FETCH_ASSOC);
} else {
    $request->redirect("index.php");
}
?>
<div class="container w-25 my-1">
    <?php
    if ($session->hasGetSession("errors")) {
        foreach ($session->get("errors") as  $error) : ?>
            <div class="alert alert-danger">
                <?= "* " . $error ?>
            </div>
    <?php endforeach;
    } ?>
    <?php $session->remove("errors") ?>

</div>
<div class="row d-flex justify-content-between">
    <div class="container mb-5 d-flex justify-content-center">

        <div class="col-md-4">
            <br>
            <form action="handle/edit.php?id=<?= $id ?>" method="post">
                <div class="mb-3">
                    <input type="text" name="title" class="form-control" id="exampleInputTitle1" aria-describedby="emailHelp" placeholder="add your title" value="<?php echo $todo['title'] ?>">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="add your description"><?php echo $todo['description'] ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" name="submit" class="form-control text-white bg-info mt-3 ">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>

</html>

<?php
require_once 'inc/footer.php';
?>