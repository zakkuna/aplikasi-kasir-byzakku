<?php
require 'function.php';


if (isset($_SESSION['login'])) {
    //yaudah berhasil
} else {
    header("location:login.php");
}
