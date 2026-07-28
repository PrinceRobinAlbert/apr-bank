<?php
$error = [];


if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit'])) {

    $account_id = $_POST['accountid'];
    $sql_query = "SELECT account_id FROM bankaccount where account_id='$account_id'";
    $db_connect = mysqli_connect('localhost', 'root', '', 'bank');
    $row_query = mysqli_query($db_connect, $sql_query);
    $row = $row_query->fetch_assoc();
    if (empty($_POST["accountid"])) {
        $error['accountidErr'] = "Account Id is required";
    }

    if (empty($_POST["selectid"])) {
        $error["selectidErr"] = "Account type is required";
    }

    if (empty($_POST["fname"])) {
        $error["FirstnameErr"] = "First Name is required";
    }

    if (empty($_POST["mobileno"])) {
        $error["mobilenumberErr"] = "Mobile Number is required";
    }

    if (empty($_POST["aadharno"])) {
        $error["aadharnumberErr"] = "Aadhar Number is required";
    }

    if (empty($_POST["username"])) {
        $error["usernameErr"] = "Username is required";
    }
    if (empty($_POST["birthday"])) {
        $error["birthdateErr"] = "Birthdate is required";
    }

    if (empty($_POST["pwd"])) {
        $error["pwdErr"] = "Password is required";
    }
    if (($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit'])) {
        if (!preg_match("/^[a-zA-z]*$/", $_POST['fname'])) {
            echo "invalid Type first name" . "<br>";
        }
        if (!preg_match("/^[a-zA-z]*$/", $_POST['lname'])) {
            echo "invalid Type first name" . "<br>";
        }
        if (!preg_match("/^[0-9]*$/", $_POST['mobileno'])) {
            echo "invalid Mobile Number Type" . "<br>";
        }
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        if (!preg_match($pattern, $_POST['email_addr']) && !empty($_POST['email_addr'])) {
            echo "email is not valid" . "<br>";
        }
        if (!preg_match("/^[0-9]*$/", $_POST['aadharno'])) {
            echo "invalid Aadhar Number Type" . "<br>";
        }
        if (!preg_match("/^[0-9]*$/", $_POST['accountid'])) {
            echo "invalid Account ID Type";
        }

        if (isset ($row['account_id']) && $row['account_id'] == $account_id) {
            echo "Account ID already exists ";
        } else {
            if (empty($error)) {
                $hash = password_hash($_POST['pwd'], PASSWORD_BCRYPT);

                $db_connect = mysqli_connect('localhost', 'root', '', 'bank');
                $sql = " INSERT INTO `bankaccount`(`account_id`, `account_type`, `first_name`, `last_name`, `mobile_no`, `email`, `aadhar_number`, `date_of_birth`, `username`, `password`) VALUES ('" . $_POST['accountid'] . "','" . $_POST['selectid'] . "','" . $_POST['fname'] . "','" . $_POST['lname'] . "','" . $_POST['mobileno'] . "','" . $_POST['email_addr'] . "','" . $_POST['aadharno'] . "','" . $_POST['birthday'] . "','" . $_POST['username'] . "','" . $hash . "')";
                $query = mysqli_query($db_connect, $sql);
                echo "Account Created Successfully";


            }
        }
    } else {
        echo "Invalid Form  Details";
    }


}
?>

<!DOCTYPE html>
<html>
<head><title>Database</title></head>
<style>
    #background {
        background-color: aquamarine;
        justify-content: center;
    }

    #field {
        color: black;
    }

    #accountid {
        border-radius: 5px;
    }

    #selectid {
        border-radius: 5px;
    }

    #fname {
        border-radius: 5px;
    }

    #lname {
        border-radius: 5px;
    }

    #mobileno {
        border-radius: 5px;
    }

    #aadharno {
        border-radius: 5px;
    }

    #birthday {
        border-radius: 5px;
    }

    #email_addr {
        border-radius: 5px;
    }

    #username {
        border-radius: 5px;
    }

    #pwd {
        border-radius: 5px;
    }

    #required {
        color: red;
    }

    label {
        color: maroon;
    }
</style>
<body id="background">

<fieldset id="field">
    <legend>New Account Details</legend>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <label for="accountid">Account ID:</label><br>
        <input type="text" id="accountid" name="accountid"><span
                id="required"><?php if (isset($error["accountidErr"])) {
                echo $error["accountidErr"];
            } ?></span><br><br>
        <label for="accounttype">Account Type:</label><br>
        <select id="selectid" name="selectid">
            <option value="savings_account">Savings Account</option>
            <option value="current_account">Current Account</option>
            <option value="credit_account">Credit Account</option>
        </select><br><br>
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname"><br><span id="required"><?php if (isset($error["FirstnameErr"])) {
                echo $error["FirstnameErr"];
            } ?></span><br><br>
        <label for="lname">Last name:(optional)</label><br>
        <input type="text" id="lname" name="lname"><br><br>
        <label for="mobileno">Mobile No:</label><br>
        <input type="text" id="mobileno" name="mobileno"><span
                id="required"><?php if (isset($error["mobilenumberErr"])) {
                echo $error["mobilenumberErr"];
            } ?></span><br><br>
        <label for="email">Email:(optional)</label><br>
        <input type="text" id="email_addr" name="email_addr"><br><br>
        <label for="aadharno">Aadhar No:</label><br>
        <input type="text" id="aadharno" name="aadharno"><span
                id="required"><?php if (isset($error["aadharnumberErr"])) {
                echo $error["aadharnumberErr"];
            } ?></span><br><br>
        <label for="username">Username :</label><br>
        <input type="text" id="username" name="username"><span id="required"><?php if (isset($error["usernameErr"])) {
                echo $error["usernameErr"];
            } ?></span><br><br>
        <label for="birthday">DOB:</label><br>
        <input type="date" id="birthday" name="birthday"><span id="required"><?php if (isset($error["birthdateErr"])) {
                echo $error["birthdateErr"];
            } ?></span><br><br>
        <label for="password">Password :</label><br>
        <input type="password" id="pwd" name="pwd"><span id="required"><?php if (isset($error["pwdErr"])) {
                echo $error["pwdErr"];
            } ?></span><br><br>
        <input type="submit" value="Submit" name="submit">
        <input type="button" value="Reset" name="reset" onclick="self.location.replace(location['href'])"/>
    </form>

</fieldset>
</body>
</html>
