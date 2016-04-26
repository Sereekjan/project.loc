<?php
include_once './core/Controller.php';
include_once './core/Tasks.php';
$content[] = "<h1 class='page-header'>Add Task</h1>";
$title = 'Add Task';
if (isset($_POST["submit"])) {
    $task = new Tasks();
    $task->add($_POST['title'], $_POST['description'], $_POST['date_start'], $_POST['date_end'], $_POST['status_priority_id']);
}
$content[] = "<form method='post'>
        <div class='form-group'>
            <label>Title</label>
            <input type='text' class='form-control' name='title'>
        </div>
        <div class='form-group'>
            <label>Description</label>
            <textarea class='form-control' name='description'></textarea>
        </div>
        <div class='form-group'>
            <label>Date start</label>
            <input type='date' class='form-control' name='date_start'>
        </div>
        <div class='form-group'>
            <label>Date end</label>
            <input type='date' class='form-control' name='date_end'>
        </div>
        <div class='form-group'>
            <label>Priority</label>
            <select name='status_priority_id'>
                <option value='1'>Важное</option>
                <option value='2'>Нормальное</option>
                <option value='2'>На днях сделаю</option>
            </select>
        </div>
        <div class='form-group'>
            <button class='btn btn-success' name='submit'>Add</button>
        </div>
    </form>";

$user = new Controller($content, $title);