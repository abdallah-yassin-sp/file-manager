<?php
class UserFolder
{
  private $user;

  public function __construct($user)
  {
    $this->user = $user;
  }

  public function create($folderName)
  {
    $dir = $this->getPath($folderName);

    if (file_exists($dir)) {
      die("Folder exist, please choose different folder name");
    } else if (!mkdir($dir, 0777, true)) {
      echo "There is some error";
    }
  }

  public function delete($folderName)
  {
    $dir = $this->getPath($folderName);
    if (is_dir($dir)) {
      $this->rrmdir($dir);
    } else {
      unlink($dir);
    }
  }

  private function getPath($folderName)
  {
    $userEmail = $this->user->email;
    $directory = explode('/', __DIR__);
    array_pop($directory);
    $directory = implode('/', $directory);
    return $directory . "/directories/" . $userEmail . "/" . $folderName;
  }

  private function rrmdir($dir)
  {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object)) {
          $this->rrmdir($dir . DIRECTORY_SEPARATOR . $object);
        } else {
          unlink($dir . DIRECTORY_SEPARATOR . $object);
        }
      }
    }
    rmdir($dir);
  }
}
