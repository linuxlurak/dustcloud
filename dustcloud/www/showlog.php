<?php
# Author: Dennis Giese [dustcloud@1338-1.org]
# Copyright 2017 by Dennis Giese

#This program is free software: you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation, either version 3 of the License, or
#(at your option) any later version.

#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.

$longlog = isset($_GET['longlog']) ? $_GET['longlog'] : '0';
if ($longlog == 0)
{
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 30; URL=$url1");
}

require_once 'config.php';
$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo "<a href=\"index.php\">Index</a><br>";
$res = $mysqli->query("SELECT * FROM devices WHERE did = '".$_GET["did"]."'");

$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    echo "<a href=\"./show.php?did=" . $row['did'] . "\">" . $row['name'] . "(did:" . $row['did'] . ")</a><br>Last contact: " . $row['last_contact'];
	$date1 = new DateTime("now");
	$date2 = new DateTime($row['last_contact']);
	$interval = $date1->diff($date2);
	echo " (".$interval->format('%a days %H:%I:%S ago').")";
	echo "<br>\n";
}
echo "<a href=\"".$url1."&longlog=1\">2000 messages without refresh</a><br>";
echo "<hr>";
if ($longlog == 1)
{
	$res = $mysqli->query("SELECT * FROM statuslog WHERE did = '".$_GET["did"]."' ORDER by id DESC LIMIT 2000");
}else
{
	$res = $mysqli->query("SELECT * FROM statuslog WHERE did = '".$_GET["did"]."' ORDER by id DESC LIMIT 100");
}
$res->data_seek(0);
while ($row = $res->fetch_assoc())
{
		foreach ($row as $key => $value)
	{
		echo "$key : $value ";
		echo "<br>";
	}
	echo "<hr>";
}
?>