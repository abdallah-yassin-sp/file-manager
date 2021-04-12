<?php
class File
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function upload($file, $current_path, $file_name)
    {
        $path_parts = pathinfo($file_name);

        $file_extention = $path_parts['extension'];

        $allowed_extentions = ['txt', 'png', 'jpg', 'jpeg', 'webp', 'pdf', 'mp3', 'mp4'];

        if ($pos = strrpos($file_name, '.')) {
            $name = $path_parts['filename'];
            $ext = substr($file_name, $pos);
        } else {
            $name = $file_name;
        }

        $newpath = $current_path . '/' . $file_name;
        $newname = $file_name;
        $counter = 1;
        while (file_exists($newpath)) {
            $newname = $name . '_' . $counter . $ext;
            $newpath = $current_path . '/' . $newname;
            $counter++;
        }

        if (in_array($file_extention, $allowed_extentions)) {
            if ($file['error'] === 0) {
                if ($file['size'] <= 2000000) {
                    $file_path = $newpath;
                    if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                        echo 'upload error!';
                    }
                } else {
                    echo "File size is more than 2 MB";
                }
            }
        } else {
            echo "file extetion is not allowed";
        }

        header('../dashboard.php');
    }
}
