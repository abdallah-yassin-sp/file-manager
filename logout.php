<?php
require('header.php');
unset($_SESSION['user']);
header('location: login.php');
