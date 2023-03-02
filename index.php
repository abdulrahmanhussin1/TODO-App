<?php
require_once 'inc/header.php';
require_once 'inc/nav.php';
require_once 'App.php';

?>
<?php
if (!$session->get("loggedIn")) {
    $request->redirect("login.php");
} else { ?>
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

        <?php
        if ($session->hasGetSession("success")) {
            foreach ($session->get("success") as  $success) : ?>
                <div class="alert alert-success">
                    <?= "* " . $success ?>
                </div>
        <?php endforeach;
        } ?>
        <?php $session->remove("success") ?>

    </div>


    <div class="row d-flex justify-content-between">
        <?php $user_id = $session->get("loggedIn"); ?>
        <!-- todo -->
        <div class="col-md-3 ">
            <h4 class="text-white">To Do</h4>
            <?php $query = $conn->query("select * from todo where status='todo' and user_id=$user_id ORDER BY created_at DESC"); ?>
            <div class="m-2  py-3">
                <div class="show-to-do">
                    <?php if ($query->rowCount() < 1) : ?>
                        <div class="item">
                            <div class="alert-danger text-center ">
                                To do list is Empty
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php while ($todo = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                        <div class="alert alert-info p-2">
                            <h4><?= $todo['title'] ?> </h4>
                            <h6><?= $todo['description'] ?> </h6>
                            <p><?= "Created at" . $todo['created_at'] ?> </p>
                            <p><?php if ($todo['updated_at'] !== null) {
                                    echo "Updated at" . $todo['updated_at'];
                                } ?> </p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="edit.php?id=<?= $todo['id'] ?>" class="btn btn-info p-1 text-white">edit</a>
                                <a href="handle/delete.php?id=<?= $todo['id'] ?>" class="btn btn-danger p-1 text-white">delete</a>
                                <a href="handle/goto.php?name=doing&id=<?= $todo['id'] ?>" class="btn btn-success p-1 text-white">doing >></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- doing -->
        <div class="col-md-3 ">

            <h4 class="text-white">Doing</h4>
            <?php $query = $conn->query("select * from todo where status='doing' and user_id = $user_id ")   ?>

            <div class="m-2 py-3">
                <div class="show-to-do">

                    <?php if ($query->rowCount() < 1) : ?>
                        <div class="item">
                            <div class="alert-danger text-center ">
                                Doing list is Empty
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php while ($doing = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                        <div class="alert alert-success p-2">
                            <h4><?= $doing['title'] ?> </h4>
                            <h6><?= $doing['description'] ?> </h6>
                            <p><?= "Created at" . $doing['created_at'] ?> </p>
                            <p><?php if ($doing['updated_at'] !== null) {
                                    echo "Updated at" . $doing['updated_at'];
                                } ?> </p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="edit.php?id=<?= $doing['id'] ?>" class="btn btn-info p-1 text-white">edit</a>
                                <a href="handle/delete.php?id=<?= $doing['id'] ?>" class="btn btn-danger p-1 text-white">delete</a>
                                <a href="handle/goto.php?name=todo&id=<?= $doing['id'] ?>" class="btn btn-secondary p-1 text-white">
                                    << todo</a>

                                        <a href="handle/goto.php?name=done&id=<?= $doing['id'] ?>" class="btn btn-success p-1 text-white">done >></a>
                            </div>

                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

        </div>

        <!-- done -->
        <div class="col-md-3">
            <h4 class="text-white">Done</h4>
            <?php $query = $conn->query("select * from todo where status='done' and user_id=$user_id ")   ?>
            <div class="m-2 py-3">
                <div class="show-to-do">
                    <?php if ($query->rowCount() < 1) : ?>
                        <div class="item">
                            <div class="alert-danger text-center ">
                                Done list is Empty
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php while ($done = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                        <div class="alert alert-warning p-2">
                            <h4><?= $done['title'] ?> </h4>
                            <h6><?= $done['description'] ?> </h6>
                            <p><?= "Created at" . $done['created_at'] ?> </p>
                            <p><?php if ($done['updated_at'] !== null) {
                                    echo "Updated at" . $done['updated_at'];
                                } ?> </p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="handle/goto.php?name=doing&id=<?= $done['id'] ?>" class="btn btn-secondary p-1 text-white">
                                    << doing</a>
                                        <a href="handle/delete.php?id=<?= $done['id'] ?>" class="btn btn-danger p-1 text-white">delete</a>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="handle/addToDo.php" method="post">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputTitle1" aria-describedby="emailHelp" placeholder="add your title">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="add your description "></textarea>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-success">Add Task</button>
                </div>
                </form>
            </div>
        </div>
    </div>


<?php
};
require_once 'inc/footer.php';
?>