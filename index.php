<?php require("db_conn.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if (isset($_GET["mess"]) && $_GET["mess"] == "error") { ?>
                    <input type="text" name="title" id="" placeholder="This field is required">
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php } else { ?>
                    <input type="text" name="title" id="" placeholder="What do you need to do?">
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>

        <?php
        $todos = $conn->query("SELECT * FROM todos ORDER BY id ASC");
        ?>

        <div class="show-todo-section">
            <?php if ($todos->rowCount() <= 0) { ?>
                <div class="todo-item">
                    <div class="item">
                        <img src="img/table.png" width="100%">
                        <img src="img/ellipsis.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span class="remove-to-do" id="<?= $todo["id"] ?>">x</span>

                    <?php if ($todo["checked"]) { ?>
                        <input class="check-box" type="checkbox" data-todo-id="<?= $todo["id"] ?>" checked>
                        <h2 class="checked"><?= $todo["title"] ?></h2>
                    <?php } else { ?>
                        <input class="check-box" type="checkbox" data-todo-id="<?= $todo["id"] ?>">
                        <h2><?= $todo["title"] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?= $todo["date_time"] ?></small>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="js/jquery-3.6.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".remove-to-do").click(function() {
                const id = $(this).attr("id")

                $.post("app/remove.php", {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(600)
                        }
                    },
                )
            })

            $(".check-box").click(function(e) {
                const id = $(this).attr("data-todo-id")

                $.post("app/check.php", {
                        id: id
                    },
                    (data) => {
                        if (data != "error") {
                            const h2 = $(this).next()

                            if (data === "1") {
                                h2.removeClass("checked")
                            } else {
                                h2.toggleClass("checked")
                            }
                        }
                    },
                )
            })
        })
    </script>
</body>

</html>