<?php
    function inputEmpty($name, $email, $username, $pwd, $pwdRepeat)
    {
        $result;
        if(empty($name) || empty($email)  || empty($username)  || empty($pwd) ||  empty($pwdRepeat))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function usernameInvalid($username)
    {
        $result;
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function emailInvalid($email)
    {
        $result;
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function passMatch($pwd, $pwdRepeat)
    {
        $result;
        if($pwd !== $pwdRepeat)
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function userExists($conn, $username, $email)
    {
        $sql = "SELECT * FROM users WHERE = usersUid = ? OR usersEmail = ?;";
        $state = mysqli_stmt_init($conn);

        if(!mySqli_stmt_prepare($state, $sql))
        {
            header("location: ../signup.php?error=statefailed");
            exit();
        }
        
        mysqli_stmt_bind_param($state, "ss", $username, $email);
        mysqli_stmt_execute($state);

        $resultsData = mysqli_stmt_get_results($state);

        if($r = mysqli_fetch_assoc($resultsData))
        {
            return $r;
        }
        else
        {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($state);
    }

    function makeUser($conn, $name, $email, $username, $pwd)
    {
        $sql = "INSERT INTO users (usersName, usersEmail, userUid, usersPwd) VALUES (?, ?, ?, ?);";
        $state = mysqli_stmt_init($conn);

        if(!mySqli_stmt_prepare($state, $sql))
        {
            header("location: ../signup.php?error=statefailed");
            exit();
        }
        
        $hashPass = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($state, "ssss", $name, $email, $username, $hashPass);
        mysqli_stmt_execute($state);
        mysqli_stmt_close($state);
        heaader("location: ../signup.php?error=none");
        exit();
    }





