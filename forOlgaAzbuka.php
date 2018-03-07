<?php
$host = '127.0.0.1';
$db   = 'spbdk2';
$user = 'root';
$pass = 'bitrix2015petr2015';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$dir = "/home/apostol/attachments/";
$anndir = $dir."annots/";
$anndir1 = scandir($anndir);
$imgdir= $dir."images/";
$imgdir1 = scandir($imgdir);
//var_dump($anndir1);
$tmpfile = '/home/apostol/forOlgaAzbuka.txt';
$handle = fopen($dir."news2017.csv", "r");
$buffer = fgets($handle, 65536);
while (($buffer = fgets($handle, 65536)) !== false)
{
    $buffer1 = explode("|", $buffer);
    $query='SELECT * FROM a_elements WHERE valISBN LIKE \''.addslashes($buffer1[5]).'\'';
    $stmt = $pdo->query($query);
    $row = $stmt->fetch();
    if (empty($row['Key_G']))
    {
        $query='SELECT * FROM a_new_elements WHERE valISBN LIKE \''.addslashes($buffer1[5]).'\'';
        $stmt = $pdo->query($query);
        $row = $stmt->fetch();
        if (!empty($row['Key_G']))
        {
            if (empty($row['valAuthor']))
                $pdo->query('UPDATE a_new_elements SET valAuthor=\''.$buffer1[2].'\' WHERE Key_G='.$row['Key_G']);
            if (empty($row['valPublishing']))
                $pdo->query('UPDATE a_new_elements SET valPublishing=\''.$buffer1[3].'\' WHERE Key_G='.$row['Key_G']);
            if (empty($row['valSerialN']))
                $pdo->query('UPDATE a_new_elements SET valSerialN=\''.$buffer1[4].'\' WHERE Key_G='.$row['Key_G']);
            if (empty($row['valBinding']))
                $pdo->query('UPDATE a_new_elements SET valBinding=\''.$buffer1[9].'\' WHERE Key_G='.$row['Key_G']);
            if (empty($row['valYear']))
                $pdo->query('UPDATE a_new_elements SET valYear=\''.(int)str_replace(' ','', $buffer1[10]).'\' WHERE Key_G='.$row['Key_G']);
            if ($row['valPages']==0)
                $pdo->query('UPDATE a_new_elements SET valPages=\''.$buffer1[11].'\' WHERE Key_G='.$row['Key_G']);
            if ($row['valTirazh']==0)
                $pdo->query('UPDATE a_new_elements SET valTirazh=\''.(int)str_replace(' ','', $buffer1[12]).'\' WHERE Key_G='.$row['Key_G']);
            if (empty($row['valWeight']))
                $pdo->query('UPDATE a_new_elements SET valWeight=\''.((float)(str_replace(',','.', $buffer1[13]))*1000).'\' WHERE Key_G='.$row['Key_G']);
        }
    }
    else
    {
        if (empty($row['valAuthor']))
            $pdo->query('UPDATE a_elements SET valAuthor=\''.$buffer1[2].'\' WHERE Key_G='.$row['Key_G']);
        if (empty($row['valPublishing']))
            $pdo->query('UPDATE a_elements SET valPublishing=\''.$buffer1[3].'\' WHERE Key_G='.$row['Key_G']);
        if (empty($row['valSerialN']))
            $pdo->query('UPDATE a_elements SET valSerialN=\''.$buffer1[4].'\' WHERE Key_G='.$row['Key_G']);
        if (empty($row['valBinding']))
            $pdo->query('UPDATE a_elements SET valBinding=\''.$buffer1[9].'\' WHERE Key_G='.$row['Key_G']);
        if (empty($row['valYear']))
            $pdo->query('UPDATE a_elements SET valYear=\''.(int)str_replace(' ','', $buffer1[10]).'\' WHERE Key_G='.$row['Key_G']);
        if ($row['valPages']==0)
            $pdo->query('UPDATE a_elements SET valPages=\''.$buffer1[11].'\' WHERE Key_G='.$row['Key_G']);
        if ($row['valTirazh']==0)
            $pdo->query('UPDATE a_elements SET valTirazh=\''.(int)str_replace(' ','', $buffer1[12]).'\' WHERE Key_G='.$row['Key_G']);
        if (empty($row['valWeight']))
            $pdo->query('UPDATE a_elements SET valWeight=\''.((float)(str_replace(',','.', $buffer1[13]))*1000).'\' WHERE Key_G='.$row['Key_G']);
    }



    if (!empty($row['Key_G'])){
        $newanname = $row['Key_G'].'.txt';
        $newimname = $row['Key_G'].'.jpg';
        echo $row['Key_G']."\n";
        for ($i=2;$i<count($anndir1);$i++){
            if (stristr($anndir1[$i], $buffer1[5])){
                $t = mb_convert_encoding(file_get_contents($anndir.$anndir1[$i]), 'windows-1251');
                if ($t[0]=='?')
                    $t = substr($t,1);
                $tfile = fopen($tmpfile, "w");
                file_put_contents($tmpfile, substr($t,0));
                fclose($tfile);
                if (!file_exists("/opt/www/upload/txt/".substr($row['Key_G'],-4,3)."/".$newanname)){
                    copy($tmpfile,"/opt/www/upload/txt/".substr($row['Key_G'],-4,3)."/".$newanname);
                    chown("/opt/www/upload/txt/".substr($row['Key_G'],-4,3)."/".$newanname, "www-data");
                    chgrp("/opt/www/upload/txt/".substr($row['Key_G'],-4,3)."/".$newanname, "apostol");
                    //unlink("/opt/www/upload/txt/".substr($row['Key_G'],-4,3)."/".$newanname);
                    echo "Аннотация перемещена.\n";
                }
            }
        }
        for ($i=2;$i<count($imgdir1);$i++){
            if (stristr($imgdir1[$i], $buffer1[5])){
                echo $imgdir1[$i];     // $anndir1[$i] - файл аннотации
                if (!file_exists("/opt/www/upload/img/".substr($row['Key_G'],-4,3)."/".$newimname)) {
                    copy($imgdir . $imgdir1[$i], "/opt/www/upload/img/" . substr($row['Key_G'], -4, 3) . "/" . $newimname);
                    chown("/opt/www/upload/img/".substr($row['Key_G'],-4,3)."/".$newimname, "www-data");
                    chgrp("/opt/www/upload/img/".substr($row['Key_G'],-4,3)."/".$newimname, "apostol");
                    echo "Изображение перемещено.\n";
                }
            }
        }
        echo "\n";
    }
}
?>