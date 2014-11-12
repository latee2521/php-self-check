<?

exec("mode com4: BAUD=9600 PARITY=n DATA=8 STOP=1 to=off dtr=off rts=off");

//$fp =fopen("com1", "w");

$fp = fopen('/dev/tty.usbmodem1411','r+'); //use this for Linux

fwrite($fp, "string to send"); //write string to serial

fclose($fp);

?>