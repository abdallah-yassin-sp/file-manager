<?php
require('header.php');
require('classes/UserFolder.php');
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $folder_name = $_POST['folderName'];
    $path = $_POST['path'];
    $full_path = "{$path}/{$folder_name}";

    $newFolder = new UserFolder($user);
    $newFolder->create($full_path);

    header("location: dashboard.php?path={$path}");
}
