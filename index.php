<?php
require 'conn.php';

//insert data
if (isset($_POST['add'])) {

    $q_insert = "insert into task(label, status) value ('" . $_POST['task-name'] . "','open')";

    $run_q_insert = mysqli_query($connect, $q_insert);

    if ($run_q_insert) {
        header('Refresh:0; url=index.php');
    }
}

//show data
$q_show = "select * from task order by id desc";
$run_q_show = mysqli_query($connect, $q_show);

//delete
if (isset($_GET['delete'])) {
    $q_delete = "delete from task where id= '" . $_GET['delete'] . "'";
    $run_q_delete = mysqli_query($connect, $q_delete);

    header('Refresh:0, url=index.php');
}

//update
if (isset($_GET['done'])) {
    $status = 'close';
    if ($_GET['status'] == 'open') {
        $status = 'close';
    } else {
        $status = 'open';
    }
    $q_update = "update task set status ='" . $status . "' where id = '" . $_GET['done'] . "'";
    $run_q_update = mysqli_query($connect, $q_update);
    header('Refresh:0, url=index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APP_To-Do-List</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #6441A5;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #2a0845, #6441A5);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #2a0845, #6441A5);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .container {
            width: 590px;
            height: 100vh;
            margin: 0 auto;
        }

        .header {
            padding: 15px;
            color: #fff;
        }

        .header .title {
            display: flex;
            align-items: center;
        }

        .header .title i {
            font-size: 24px;
            margin-right: 10px;
        }

        .header .title span {
            font-size: 18px;
            font-weight: bold;
        }

        .header .time {
            margin-top: 5px;
            font-size: 12px;
        }

        .content {
            padding: 15px;
        }

        .content .card {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }

        .content .card form {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .content .card .input-task {
            padding: 5px;
            border: 1px solid;
            border-radius: 5px;
            font-size: 18px;
            width: 100%;

        }

        .content .card .submmit-task {
            font-size: 14px;
            margin-left: 5px;
            padding: 9px;
            color: #fff;
            border: 1px;
            border-radius: 3px;
            cursor: pointer;
            background: #6441A5;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #2a0845, #6441A5);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #2a0845, #6441A5);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .card .task-items {
            font-size: 16px;
        }

        .card .task-items.done {
            color: #ccc;
            text-decoration: line-through;
        }

        .card .action .bx-edit {
            color: orange;
        }

        .card .action .bx-trash {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">
                <i class='bx bx-sun'></i>
                <span>To Do List</span>
            </div>
            <div class="time">
                <?= date("l, d M Y") ?>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <form action="" method="POST">
                    <input type="text" name="task-name" class="input-task" placeholder="Add Task">
                    <div>
                        <button type="submit" class="submmit-task" name="add">Add</button>
                    </div>
                </form>
            </div>

            <?php
            if (mysqli_num_rows($run_q_show) > 0) {
                while ($q = mysqli_fetch_array($run_q_show)) {
            ?>
                    <div class="card">
                        <div class="task-items <?= $q['status'] == 'close' ? 'done' : '' ?>">
                            <input type="checkbox" onclick="window.location.href = '?done=<?= $q['id'] ?>&status=<?= $q['status'] ?>'" <?= $q['status'] == 'close' ? 'checked' : '' ?>>
                            <span><?= $q['label'] ?></span>
                        </div>
                        <div class="action">
                            <a href="#"><i class='bx bx-edit' title="Edit"></i></a>
                            <a href="?delete=<?= $q['id'] ?>"><i class='bx bx-trash' title="Hapus" onclick="return confirm('Apakah anda Yakin ingin menghapus ini?')"></i></a>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="card">
                    <div class="task-items">
                        <span>Belum Ada Kegiatan Hari ini</span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>