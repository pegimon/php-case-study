<?php
$config = parse_ini_file('config.ini');
$db_host = 'localhost';

$conn = new mysqli($config['host'], $config['user'], $config['password'], $config['name']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
