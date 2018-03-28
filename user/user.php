<?php 
require_once 'Db.php';
$db = new MysqliDatabase('localhost', 'root', 'mysql', 'php');

if (isset($_POST['username'])) {
	$user = $_POST['username'];
	$result = $db->setTable('users')->findOneBy(['username' => $user]);

	if ($result == false) {
		echo false;
	}
	else {
		echo true;
	}
}

if (isset($_POST['email'])) {
	$email = $_POST['email'];
	$result = $db->setTable('users')->findOneBy(['email' => $email]);

	if ($result == false) {
		echo false;
	}
	else {
		echo true;
	}
}

if (isset($_POST['mydata'])) {
	$jsonData = $_POST['mydata'];

	$data = json_decode($jsonData, true);

	$db->setTable('users')->insert($data);

	echo 1;
}