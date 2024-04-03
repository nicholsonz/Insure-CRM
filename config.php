<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "clients";
$password   = "clients!@#456";
$dbname     = "clients";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

function mysql_entities_fix_string($string)
  {
  return htmlentities(mysql_fix_string($string));
  }
function mysql_fix_string($string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return mysql_real_escape_string($string);
  }

?>
