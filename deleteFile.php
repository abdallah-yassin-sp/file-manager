<?php
require('header.php');
require('classes/UserFolder.php');
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileName = $_POST['fileName'];
    $path = trim($_POST['path'], "/");
    $full_path = "{$path}/{$fileName}";

    $newFolder = new UserFolder($user);
    $newFolder->delete($full_path);
    header("location: dashboard.php?path={$path}");
}
