<?php 
/* pull the new version */
$git = `git pull`;
/* log it */
$file = "_update_logs.txt";
$current = file_get_contents($file);
// Append a new person to the file
$current .= "$git\n";
// Write the contents back to the file
file_put_contents($file, $current);
