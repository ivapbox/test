<?php
$file="abilities.json";
$f = fopen($file, "r");
$c=0;
while ($buffer = fgets($f, 4096))
    if (substr($buffer,0,10)=="    \"img\":") {
        $s = "http://cdn.dota2.com" . substr($buffer, 12, -2);
        $headers = get_headers($s);
        if (substr($headers[0], 9, 3)=='200')
        {
            if (copy($s,"media/".++$c.".png"))
                echo $c.": Загружено.\n";
        }
            //if (file_put_contents("media/".++$c.".png", file_get_contents($s)))

    }

fclose($file);
?>