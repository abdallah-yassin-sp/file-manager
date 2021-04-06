<?php
require('header.php');
?>

<?php
if (!isset($_SESSION['user'])) {
?>
    <div class="container error-message">
        <h1>You are not allow to access this page, Please login to access your account.</h1>
        <a href="login.php">Login</a>
    </div>
<?php
} else {
    $user = $_SESSION['user'];
    $_SESSION['folder_path'] = "directories/{$user->email}";
    $new_path = $_GET['path'] ?? "";
    $directory = "directories/{$user->email}/{$new_path}";
    $real_directory = realpath($directory);
    $real_directory = explode('/', $real_directory);
    $lastPart = array_pop($real_directory);
    if($lastPart == "directories"){
        die("<span class=\"error\">Access denied</span>");
    }
    $_SESSION['directory'] = $directory;
?>

    <div class="dashboard-header1">
        <div class="container">
            <div class="row m-auto">
                <h1 class="col-lg-6 col-sm-12">File Management System</h1>
                <div class="logout-and-admin d-flex col-lg-6 col-sm-12">
                    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    <a href="#" class="admin"><i class="fas fa-user"></i>Admin</a>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-header2">
        <div class="container">
            <div class="row m-auto">
                <h2 class="col-lg-6 col-sm-12">File Manager</h2>
                <div class="files-creation d-flex col-lg-6 col-sm-12">
                    <button type="button" data-toggle="modal" data-target="#createFolderModal">Create Folder</button>
                    <button type="button" data-toggle="modal" data-target="#uploadFileModal">Upload File</button>
                    <div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="modal-title-and-close">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Folder</h5>
                                        <span type="button" data-dismiss="modal">&#10005;</span>
                                    </div>
                                    <form action="createFolder.php" method="POST" class="create-folder-form">
                                        <input type="hidden" name="path" value="<?= $new_path ?>">
                                        <input type="text" name="folderName" id="folderName">
                                        <div class="create-folder-form-buttons">
                                            <button type="button" data-dismiss="modal">Cancel</button>
                                            <input type="submit" name="crete-folder-submit" value="Create"></input>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="modal-title-and-close">
                                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                                    <span type="button" data-dismiss="modal">&#10005;</span>
                                </div>
                                <form action="uploadFile.php?path=<?php echo $new_path ?>" method="POST" enctype="multipart/form-data" class="upload-file-form">
                                    <input type="file" name="file" id="file">
                                    <div class="upload-file-form-buttons">
                                        <button type="button" data-dismiss="modal">Cancel</button>
                                        <input type="submit" name="crete-folder-submit" value="Upload"></input>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="files-container">
        <div class="container table-responsive-lg files-body">
            <table class="table">
                <tr class="contents-header">
                    <td><a href="javascript:void(0)">Title/Name</a></td>
                    <td><a href="javascript:void(0)">File Type</a></td>
                    <td><a href="javascript:void(0)">Date Added</a></td>
                    <td><a href="javascript:void(0)">Manage</a></td>
                </tr>
                <?php

                chdir($directory);
                $dh = opendir('.');
                while ($file = readdir($dh)) {
                    
                    if ($file != "." && $file != "..") {
                ?>
                        <tr>
                            <td class="file-name">
                                <?php
                                if (filetype($file) === 'dir') { ?>
                                    <a href="<?= "?path={$new_path}/{$file}" ?>"><i class="far fa-folder"></i><?php echo $file ?></a>
                                <?php
                                } else {
                                ?>
                                    <a href="<?= "{$directory}/{$file}" ?>" target="_blank"><?php echo $file ?></a>
                                    <p><?php echo $file ?></p>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $path = pathinfo($file);
                                if (filetype($file) === 'dir') {
                                    echo 'folder';
                                } else {
                                    echo $path['extension'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo date("F d Y H:i:s.", filectime($file)) ?>
                            </td>
                            <td class="manage">
                                <?php
                                if (is_dir($file)) { ?>
                                    <form action="deleteFile.php" method="POST">
                                        <input type="hidden" name="path" value="<?= $new_path ?>">
                                        <input type="hidden" name="fileName" value="<?php echo $file ?>">
                                        <button type="submit" name="deleteFile" class="delete"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                <?php
                                } else { ?>
                                    <button class="view" data-toggle="modal" data-target="#view-file-modal" data-file="<?php echo $file ?>"><i class="fas fa-eye"></i></button>
                                    <form action="deleteFile.php" method="POST">
                                        <input type="hidden" name="path" value="<?= $new_path ?>">
                                        <input type="hidden" name="fileName" value="<?php echo $file ?>">
                                        <button type="submit" name="deleteFile" class="delete"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                closedir($dh);
                ?>
            </table>
            <!-- View File Modal -->
            <div class="modal fade" id="view-file-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <iframe id="view-Item-modal-iframe" src="" alt="image"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<script>
    jQuery('document').ready(function() {
        jQuery(".view").click(function() {
            var fileName = jQuery(this).attr("data-file");
            var dir = "<?php echo $directory ?>";
            jQuery("#view-Item-modal-iframe").attr("src", dir + "/" + fileName);
        });

        jQuery("#view-Item-modal-iframe").on('load', function() {
            jQuery("#view-Item-modal-iframe").contents().find("body").css("display", "flex");
            jQuery("#view-Item-modal-iframe").contents().find("body").css("align-items", "center");
            jQuery("#view-Item-modal-iframe").contents().find("img").css("width", "100%");
            jQuery("#view-Item-modal-iframe").contents().find("img").css("height", "90%");
        });
    });
</script>

<?php


?>

<?php require('footer.php'); ?>