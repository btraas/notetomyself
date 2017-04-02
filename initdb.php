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
	password_hash VARCHAR(45) not null
)") or	die(mysqli_error($db_conn));

function getConn() {
    global $db_conn;
    return $db_conn;
}
