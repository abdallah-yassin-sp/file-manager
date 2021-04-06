<?php
require('header.php');
// require_once('classes/UsersDB.php');
?>
<?php
require_once('classes/UserFolder.php');
$file_name = 'classes/UsersData.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = test_input($_POST["firstName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }
        else{
            $firstNameErr = "";
        }
    }

    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
    } else {
        $lastName = test_input($_POST["lastName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }
        else{
            $lastNameErr = "";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        else{
            $emailErr = "";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "password is required";
    } else {
        $password = $_POST["password"];
        $passwordErr = "";
    }
}

?>

<div class="container pt-5 pb-5">
    <div class="signup-container row">
        <div class="left-column col-lg-4 col-md-12">
            <div>
                <h1 class="mb-4">Sign Up</h1>
                <p>Sign Up with your simple details, it will be cross checked by the adminstrator.</p>
            </div>
            <div>
                <h1 class="mb-4">Sign In</h1>
                <p>Sign In with your username and password.</p>
            </div>
        </div>
        <div class="right-column col-lg-8 col-md-12">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off">
                <div class="form-field">
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" placeholder="John" required>
                    <span class="error"><?php echo $firstNameErr; ?></span>
                </div>
                <div class="form-field">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName" placeholder="Doe" required>
                    <span class="error"><?php echo $lastNameErr; ?></span>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@example.com" required>
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="**********" required>
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>
                <div class="terms-and-conditions row">
                    <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions">
                    <p>I agree with the terms and conditions</p>
                </div>
                <input type="submit" name="submit" value="Submit">
                <span>or</span>
                <a href="login.php" class="login-link">Login</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>

<?php
function get_data($user)
{
    global $file_name;
    $array_data = [];
    if (file_exists($file_name)) {
        $array_data = json_decode(file_get_contents($file_name), true);
    }

    $array_data[] = $user;
    return $array_data;
}

if(isset($_POST['submit']))
{
    if($firstNameErr == "" && $lastNameErr == "" && $emailErr == "" && $passwordErr =="")
    {
        $user = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );
        
        $users = get_data($user);
        $file_data = json_decode(file_get_contents($file_name), true);
        
        foreach ($file_data as $DBuser) {
            if ($user["email"] == $DBuser["email"]) {
                die("user exist !");
            }
        }
        
        if (!file_put_contents($file_name, json_encode($users))) {
            echo 'There is some error';
        }
        
        $newFolder = new UserFolder((object)$user);
        $newFolder->create('');
        
        header('location: login.php');
    }
}
?>