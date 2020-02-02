 <?php
// $dbc = mysqli_connect('localhost', 'root', '') or die('Ошибка подключения к MySQL серверу.');
// $zp = "CREATE DATABASE IF NOT EXISTS test;";
// $result = mysqli_query($dbc,$zp);
// $zp = "USE test;";
// $result = mysqli_query($dbc,$zp);

// $zp = "CREATE TABLE IF NOT EXISTS `msg` (
//   `id_msg` int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   `msg` text NOT NULL,
//   `id` int(50) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// $result = mysqli_query($dbc,$zp);
// /*$zp = "CREATE TABLE IF NOT EXISTS `code` (
//   `id_code` int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   `code` int(50) NOT NULL,
//   `id` int(50) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// $result = mysqli_query($dbc,$zp);*/
// $zp = "CREATE TABLE IF NOT EXISTS `tags` (
//   `id_tag` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   `tag` varchar(15) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// $result = mysqli_query($dbc,$zp);
// $zp = "CREATE TABLE IF NOT EXISTS `msg_tags` (
//   `id_msg_tags` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   `id_msg` int(11) NOT NULL,
//   `id_tag` int(11) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// $result = mysqli_query($dbc,$zp);
// $zp = "CREATE TABLE IF NOT EXISTS `test` (
//   `id` int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   `fio` varchar(50) NOT NULL,
//   `date` date NOT NULL,
//   `text` text NOT NULL,
//   `adres` varchar(50) NOT NULL,
//   `img` varchar(50) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// $result = mysqli_query($dbc,$zp);
// //print_r($result);
$dbc = mysqli_connect('localhost', 'root', '', 'test') or die('Ошибка подключения к MySQL серверу.');
$zp = "select `id_tag` from `tags` where `tag` = 'fff'";
$result=mysqli_query($dbc,$zp);
$res = mysqli_fetch_all($result, MYSQLI_ASSOC);
print_r($res);

