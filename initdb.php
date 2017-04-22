<?php
/**
 * Created by PhpStorm.
 * User: Brayd
 * Date: 4/1/2017
 * Time: 4:05 PM
 */


define("BASE_SITE", "http://note-to-myself.pricechecker.pro");

$db_conn = mysqli_connect('localhost', 'notetomyself', '1234') or
die(mysqli_connect_error());

mysqli_select_db($db_conn, 'notetomyself') or
die(mysqli_error($db_conn));

mysqli_query($db_conn, "CREATE TABLE IF NOT EXISTS users (
	email VARCHAR(200) primary key not null,
	password_hash VARCHAR(45) not null,
	tmp_hash VARCHAR(45),
	notes_text TEXT,
	links_serialized TEXT,
	tbd_text TEXT,
	uploaded BOOLEAN DEFAULT FALSE NOT NULL
	
)") or	die(mysqli_error($db_conn));

mysqli_query($db_conn, "CREATE TABLE IF NOT EXISTS images (
	id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	user_email VARCHAR(200) not null,
	data TEXT,
	thumbnail TEXT,
	FOREIGN KEY (user_email) REFERENCES users(email)
	
)") or	die(mysqli_error($db_conn));


function getConn() {
    global $db_conn;
    return $db_conn;
}

function sanitizeInt($int) {
    return preg_replace("/[^0-9]/", "", $int);
}

function accountExists($user) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    return mysqli_num_rows($result) > 0;
}

function getUser($user) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    return mysqli_fetch_assoc($result);
}

function updateUserStrings($user, $data) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $vals = [];
    $types = "";
    $sql = "UPDATE users SET";
    $set = false;
    foreach($data AS $key => $val) {
        // not secure but idc at this point
        $sql .= " $key = ?, ";
        $vals[] = $val;
        $types .= "s";
        if(!empty($val)) $set = true;
    }
    if($set) $sql .= " uploaded = 1, ";

    $sql = substr($sql, 0, -2) . " WHERE email = '$user'";

    $query = $conn->prepare($sql);


    if(sizeof($vals) == 0) die('no vals to set!');
    if(sizeof($vals) == 1) $query->bind_param($types, $vals[0]);
    if(sizeof($vals) == 2) $query->bind_param($types, $vals[0], $vals[1]);
    if(sizeof($vals) == 3) $query->bind_param($types, $vals[0], $vals[1], $vals[2]);
    if(sizeof($vals) == 4) $query->bind_param($types, $vals[0], $vals[1], $vals[2], $vals[3]);
    if(sizeof($vals) == 5) $query->bind_param($types, $vals[0], $vals[1], $vals[2], $vals[3], $vals[4]);



    $query->execute();

}

function getConfirmHash($user) {
    $user = strtolower(trim($user));
    $conn = getConn();

    $result = mysqli_query($conn, "SELECT email, password_hash, tmp_hash FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    $assoc = $result->fetch_assoc();

    return @$assoc['tmp_hash'];
}

