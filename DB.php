<?php
$link = mysql_connect('ec2-54-186-2-83.us-west-2.compute.amazonaws.com', 'root', 'ninjacornz');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db('codenc');
?>