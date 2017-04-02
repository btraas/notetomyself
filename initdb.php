<?php
/**
 * Created by PhpStorm.
 * User: Brayd
 * Date: 4/1/2017
 * Time: 4:05 PM
 */

$db_conn = mysqli_connect('localhost', 'notetomyself', '1234') or
die(mysqli_connect_error());

mysqli_select_db($db_conn, 'notetomyself') or
die(mysqli_error($db_conn));

mysqli_query($db_conn, "CREATE TABLE IF NOT EXISTS users (
	email VARCHAR(200) primary key not null,
	password_hash VARCHAR(45) not null,
	tmp_hash VARCHAR(45)
)") or	die(mysqli_error($db_conn));

function getConn() {
    global $db_conn;
    return $db_conn;
}

function accountExists($user) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    return mysqli_num_rows($result) > 0;
}


function getConfirmHash($user) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $result = mysqli_query($conn, "SELECT email, password_hash, tmp_hash FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    $assoc = $result->fetch_assoc();

    return @$assoc['tmp_hash'];
}

