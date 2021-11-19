<?php

if(isset($_POST["submit"]))
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(inputEmpty($name, $email, $username, $pwd, $pwdRepeat) == true)
    {
        header("location: ../signup.php?error=inputEmpty");
        exit();
    }

    if(emailInvalid($email) !== false)
    {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    if(usernameInvalid($username) !== false)
    {
        header("location: ../signup.php?error=invalidusername");
        exit();
    }

    if(passMatch($pwdRepeat, $pwd) !== false)
    {
        header("location: ../signup.php?error=passwordontmatch");
        exit();
    }

    if(userExists($conn, $username, $email) !== false)
    {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    makeUser($conn, $name, $email, $username, $pwd);

}
else
{
    header("location: ../signup.php");
    exit();
}