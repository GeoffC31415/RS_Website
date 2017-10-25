<?php 

echo date('Y-m-d H:i:s');

include "php/RS_db_handler.php"

$sensorcount = count($sensornames);

for($x = 0; $x < $sensorcount; $x++) {
	echo $sensornames[$x];
	echo "<br>";
}

phpinfo(); 

?>
