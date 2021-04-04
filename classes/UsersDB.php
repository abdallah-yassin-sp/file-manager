<?php
// require_once('UserFolder.php');
// $file_name = 'UsersData.json';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     function get_data($user)
//     {
//         global $file_name;
//         $array_data = [];
//         if (file_exists($file_name)) {
//             $array_data = json_decode(file_get_contents($file_name), true);
//         }

//         $array_data[] = $user;
//         return $array_data;
//     }

//     function test_input($data) {
//         $data = trim($data);
//         $data = stripslashes($data);
//         $data = htmlspecialchars($data);
//         return $data;
//     }

//     if (empty($_POST["firstName"])) {
//         $firstNameErr = "First Name is required";
//         header("location: ../index.php");
//     } else {
//         $firstName = test_input($_POST["firstName"]);
//         // check if name only contains letters and whitespace
//         if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)) {
//             $firstNameErr = "Only letters and white space allowed";
//         }
//     }

//     if (empty($_POST["lastName"])) {
//         $lastNameErr = "Last Name is required";
//         header("location: ../index.php");
//     } else {
//         $lastName = test_input($_POST["lastName"]);
//         // check if name only contains letters and whitespace
//         if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)) {
//             $lastNameErr = "Only letters and white space allowed";
//         }
//     }
    
//     if (empty($_POST["email"])) {
//     $emailErr = "Email is required";
//     } else {
//         $email = test_input($_POST["email"]);
//         // check if e-mail address is well-formed
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $emailErr = "Invalid email format";
//         header("location: ../index.php");
//         }
//     }

//     if (empty($_POST["password"])) {
//         $passwordErr = "password is required";
//     } else {
//         $password = $_POST["password"];
//     }

//     $user = array(
//         'firstName' => $firstName,
//         'lastName' => $lastName,
//         'email' => $email,
//         'password' => password_hash($password, PASSWORD_DEFAULT)
//     );

//     $users = get_data($user);
//     $file_data = json_decode(file_get_contents($file_name), true);

//     foreach( $file_data as $DBuser ){
//         if( $user["email"] == $DBuser["email"] ){
//             die("user exist !");
//         }
//     }

//     if (!file_put_contents($file_name, json_encode($users))) {
//         echo 'There is some error';
//     }

//     $newFolder = new UserFolder((object)$user);
//     $newFolder->create('');

//     header('location: ../login.php');
// }
