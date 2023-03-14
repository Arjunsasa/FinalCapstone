<?php

function jsRedirect($url)
{
    echo "<script>window.location.href = '" . $url . "';</script>";
}

function jsAlert($text)
{
    echo "<script>alert('" . $text . "');</script>";
}

function isBlankField($data)
{
    if (trim($data) == "") {
        return true;
    } else {
        return false;
    }
}

function isValidName($name)
{
    if (preg_match("/^[a-zA-z_ ]*$/", $name)) {
        return true;
    } else {
        return false;
    }
}

function isValidTitle($title)
{
    if (preg_match("/^[a-zA-z0-9_ ]*$/", $title)) {
        return true;
    } else {
        return false;
    }
}

function isValidPhone($phone)
{
    if (preg_match('/^[0-9]{8}+$/', $phone)) { //check if 8 numbers in phone numbers from 0-9
        return true;
    } else {
        return false;
    }
}

function filterInput($input)
{
    $input = trim($input); // remove unnecessary spaces, tabs, or new line
    $input = stripslashes($input); // remove backslashes "\"
    $input = htmlspecialchars($input); // remove any special html characters that might harm your code
    return $input; // final filtered input
}

function isValidEmail($email)
{
    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // Check if email format is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function isLoggedIn()
{
    if (isset($_SESSION["userName"]) && isset($_SESSION["userEmail"]) && isset($_SESSION["userPermission"])) { //email & name session exists
        return true;
    } else {
        return false;
    }
}


function loginSession($name, $email, $perm, $ID)
{
    $_SESSION["userName"] = $name;
    $_SESSION["userEmail"] = $email;
    $_SESSION["userPermission"] = $perm;
    $_SESSION["userID"] = $ID;
}

function function_alert($msg)
{
    echo "<script>Swal.fire('$msg')</script>";
}

function isValidPrice($price)
{
    if ($price < 1000) {
        return true;
    } else {
        return false;
    }
}

function function_redirect($link)
{
    echo "<script>";
    echo "Swal.fire({";
    echo 'icon: "success",';
    echo 'title: "Success",';
    echo 'text: "You have been Registered!",';
    echo 'footer: "<a href=' . $link . '>Go to login page?</a>"';
    echo "})";
    echo "</script>";
}

function isValidStatus($status)
{
    if ($status == 0 || $status == 1) {
        return true;
    } else {
        return false;
    }
}

function isInstructor()
{
    if ($_SESSION["userPermission"] == 2) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if ($_SESSION["userPermission"] == 3) {
        return true;
    } else {
        return false;
    }
}

function isValidPermission($permission)
{
    if ($permission == 1 || $permission == 2 || $permission == 3) {
        return true;
    } else {
        return false;
    }
}


function getCurrentHour()
{
    $today = date("d-M-Y h:i:s A"); //get today's date
    $currentHour = date("H", strtotime($today)); // get the current hour from today's date

    if ($currentHour < 12) { // before 12pm
        $day = "Morning";
    } elseif ($currentHour >= 12 && $currentHour <= 17) { // from 12pm to 5pm
        $day = "Afternoon";
    } elseif ($currentHour > 17) { // after 5pm
        $day = "Evening";
    }

    return $day;
}
