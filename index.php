<?php
require 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List WAH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Comfortaa&family=Dancing+Script&family=Poiret+One&family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <div id="root">
        <br><br><br><br>
        <div class="ttt"> <i> Good Morning. Afternoon. Evening.<br>Here are your Todos.</i> </div>
        <div class="main-section">
            <div class="add-section">
                <form action="app/add.php" method="POST" autocomplete="off">
                    <?php if (isset($_GET['mess']) && $_GET['mess'] === 'error') { ?>
                        <input type="text" name="title" class="holder-place" placeholder="It is as empty as the void." />
                        <button type="submit"> Ao-chan Inscription </button>

                    <?php } else { ?>
                        <input class="input-box" type="text" name="title" class="holder-placez" style='text-align: center;   font-family: "Comfortaa", cursive;' placeholder="Have something to do? zzz" />
                        <button type="submit"> Inscribe to Ao-chan </button>
                    <?php } ?>
                </form>
            </div>
            <?php
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
            ?>
            <div class="show-todo-section">
                <?php if ($todos->rowCount() <= 0) { ?>
                    <div class="todo-item all-done">
                        <img src="img/dualogue box.gif" alt="" class="dia" />
                        <img src="img/ina.gif" alt="" class="ina" />
                        <hr class="hr1" />
                        <hr class="hr2" />
                        <h2 class="wah">The Priestess is bored.<br>Do somethink.</h2>

                    </div>
                <?php } ?>
                <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>
                        <?php if ($todo['checked']) { ?>
                            <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="check-box" checked />
                            <h4 class='checked'> <?php echo $todo['title'] ?> </h4>
                        <?php } else { ?>
                            <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="check-box" />
                            <h4> <?php echo $todo['title'] ?> </h4>
                        <?php } ?>
                        <small> created: <?php echo $todo['date_time'] ?> </small>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.remove-to-do').click(function() {
                const id = $(this).attr('id');
                $.post("app/remove.php", {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(200);
                        }
                    });
            });
            $(".check-box").click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post('app/check.php', {
                        id: id
                    },
                    (data) => {
                        if (data != 'error') {
                            const h4 = $(this).next();
                            if (data === '1') {
                                h4.removeClass('checked');
                            } else {
                                h4.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>
</body>

</html>