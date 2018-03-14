<?php

function upd_current($pdo, $buffer1, $id)
{
    $name = addslashes($buffer1[0]);
    $articul = $buffer1[3];
    $isbn = $buffer1[2];
    $qty=$buffer1[10];
    $retail = $buffer1[11];
    $location = $buffer1[13];
    $loc1 = $buffer1[9];
    $buffer2 = explode(". ", $loc1); // разбиваем строчку на ячейки
    $buffer2[0] = str_replace('.', '', $buffer2[0]);
    $loc = (int)$buffer2[0];
    if (($qty != '') || ($retail != ''))
    {
        if (($qty != '') && ($retail == '') && ctype_digit($qty)) // цена пустая, количество меняем
        {
            $stmt = $pdo->query('UPDATE a_departaments SET DepQty = ' . $qty . ' WHERE Key_G=' . $id);
            $stmt = $pdo->query('UPDATE a_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Key_Sip='.$loc.', Qty = ' . $qty . ', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
            //echo "departaments+elements: Обновлен файл " . $id . ". Количество: " . $qty . ".\n";
        }
        if (($qty == '') && ($retail != '')) // количество пустое, цену меняем
        {
            $stmt = $pdo->query('SELECT * FROM a_departaments WHERE Key_G=' . $id);
            if ($row1 = $stmt->fetch()) {
                $stmt = $pdo->query('UPDATE a_departaments SET DepRetail = \'' . $retail . '\' WHERE Key_G=' . $id);
                $stmt = $pdo->query('UPDATE a_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Key_Sip='.$loc.', Retail = \'' . $retail . '\', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
                //echo "departaments+elements: Обновлен файл " . $id . ". Цена: " . $retail . "\n";
            } else {
                $stmt = $pdo->query('INSERT INTO a_departaments (Key_G, KeyDep, DepRetail, DepQty) VALUES ( ' . $id . ', 158, ' . $retail . ', 0);');
                //echo "departaments: Добавлен файл " . $id . ". Цена: " . $retail . ". Количество: 0.\n";
            }
        }
        if (($qty != '') && ($retail != '') && ctype_digit($qty)) // все непустое, все меняем
        {
            $stmt = $pdo->query('SELECT * FROM a_departaments WHERE Key_G=' . $id);
            if ($row1 = $stmt->fetch()) {
                $stmt = $pdo->query('UPDATE a_departaments SET DepRetail = ' . $retail . ', DepQty = ' . $qty . ' WHERE Key_G=' . $id);
                $stmt = $pdo->query('UPDATE a_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Key_Sip='.$loc.', Retail = ' . $retail . ', Qty = ' . $qty . ', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
                //echo "departaments+elements: Обновлен файл " . $id . ". Цена: " . $retail . ". Количество: " . $qty . ".\n";
            } else {
                $stmt = $pdo->query('INSERT INTO a_departaments (Key_G, KeyDep, DepRetail, DepQty) VALUES ( ' . $id . ', 158, ' . $retail . ', ' . $qty . ');');
                //echo "departaments: Добавлен файл " . $id . ". Цена: " . $retail . ". Количество: ". $qty .".\n";
            }
        }
    }
    return;
}

function upd_current_new($pdo, $buffer1, $id)
{
    $name = addslashes($buffer1[0]);
    $isbn = $buffer1[2];
    $qty=$buffer1[10];
    $retail = $buffer1[11];
    $location = $buffer1[13];
    $articul = $buffer1[3];
    if (($qty != '') || ($retail != ''))
    {
        if (($qty != '') && ($retail == '') && ctype_digit($qty)) // цена пустая, количество меняем
        {
            $stmt = $pdo->query('UPDATE a_new_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Qty = ' . $qty . ', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
            //echo "departaments+elements: Обновлен файл " . $id . ". Количество: " . $qty . ".\n";
        }
        if (($qty == '') && ($retail != '')) // количество пустое, цену меняем
        {
            $stmt = $pdo->query('UPDATE a_new_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Retail = ' . $retail . ', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
            //echo "departaments+elements: Обновлен файл " . $id . ". Цена: " . $retail . ".\n";
        }
        if (($qty != '') && ($retail != '') && ctype_digit($qty)) // все непустое, все меняем
        {
            $stmt = $pdo->query('UPDATE a_new_elements SET articul=\''.$articul.'\', valISBN=\''.$isbn.'\', Name=\''.$name.'\', Retail = ' . $retail . ', Qty = ' . $qty . ', LocCode=\''.$location.'\', LocName=\''.repars($location).'\' WHERE Key_G=' . $id);
            //echo "departaments+elements: Обновлен файл " . $id . ". Цена: " . $retail . ". Количество: " . $qty . ".\n";
        }
    }
    return;
}

function insert_into_main($pdo, $temp12)
{
    $stmt = $pdo->query('SELECT * FROM a_new_elements WHERE isHandled=1');
    while ($row=$stmt->fetch())
    {
        //$query='SELECT COUNT(*) as cnt FROM a_elements WHERE Key_G='.$row['Key_G'];
        //$stmt1 = $pdo->query($query);
        //$row1 = $stmt1->fetch();
        //if (($row1['cnt']) != 0)
        {
            //echo "Найден в main'e файл с ключом ".$row['Key_G'].", переименован с тройкой в конце.\n";
            //$pdo->query('UPDATE a_elements SET Key_G=Key_G*10+3 WHERE Key_G=' . $row['Key_G']);
        }
        $query='INSERT INTO a_elements (articul, Key_G, Name, Retail, AnnotFile, ImageFile, IncomeDate, isNew, isLeader, Qty, isActive, valAuthor, valPublishing, valSerial, valYear, valISBN, valTranslate, valPainter, valEdition, valWeight, valRating, isHandled, checkString, Key_Sip, last_change, valPages, valBinding, valTirazh, valPereizd, valIllustr, valCreator, valSerialN, LocCode, LocName) 
                VALUES (\''.addslashes($row['articul']).'\', '.$row['Key_G'].', \''.addslashes($row['Name']).'\', \''.$row['Retail'].'\', \''.$row['AnnotFile'].'\', \''.$row['ImageFile'].'\', CURRENT_TIMESTAMP, \'yes\', \'no\',\''.$row['Qty'].'\', \'yes\', \''.addslashes($row['valAuthor']).'\',\''.addslashes($row['valPublishing']).'\', \''.addslashes($row['valSerial']).'\', \''.$row['valYear'].'\',\''.addslashes($row['valISBN']).'\', \''.addslashes($row['valTranslate']).'\', \''.addslashes($row['valPainter']).'\', \''.addslashes($row['valEdition']).'\', \''.$row['valWeight'].'\', 50, 1, CURRENT_TIMESTAMP, \''.$row['Location'].'\', CURRENT_TIMESTAMP, \''.$row['valPages'].'\', \''.addslashes($row['valBinding']).'\', \''.$row['valTirazh'].'\', \''.addslashes($row['valPereizd']).'\', \''.addslashes($row['valIllustr']).'\', \''.addslashes($row['valCreator']).'\', \''.addslashes($row['valSerialN']).'\', \''.$row['LocCode'].'\', \''.addslashes($row['LocName']).'\')';
        if ($pdo->query($query))
        {
            //echo "Добавлен в main файл ".$row['Key_G'].".\n";
            $query = 'INSERT IGNORE INTO a_departaments (Key_G, KeyDep, DepRetail, DepQty) VALUES (' . $row['Key_G'] . ', ' . $temp12 . ', ' . $row['Retail'] . ', ' . $row['Qty'] . ')';
            $pdo->query($query);
            $query = 'DELETE FROM a_new_elements WHERE Key_G=' . $row['Key_G'];
            $pdo->query($query);
        }
    }
}

function insert_into_new($pdo, $buffer1)
{
    $buffer1[0] = addslashes($buffer1[0]);
    $buffer1[3] = addslashes($buffer1[3]);
    $buffer1[4] = addslashes($buffer1[4]);
    $buffer1[5] = addslashes($buffer1[5]);
    $buffer1[7] = addslashes($buffer1[7]);
    $buffer1[13] = addslashes($buffer1[13]);
    $buffer2 = explode(". ", $buffer1[9]); // разбиваем строчку на ячейки
    $buffer2[0] = str_replace('.', '', $buffer2[0]);
    $loc = (int)$buffer2[0];
    if (substr($buffer1[1],0,2)=='00')
        $new_key=(int)substr($buffer1[1],3,8)*10+1;
    else
        $new_key=(int)substr($buffer1[1],5,8)*10+2;
    $query='INSERT INTO a_new_elements(articul, Key_G, Name, Retail, Qty, IncomeDate, isLeader, isHandled, valAuthor, valPublishing, valSerial, valYear, valISBN, valTranslate, valPainter, valEdition, valWeight, valRating, checkString, last_change, Location,  AnnotFile, ImageFile, LocCode, LocName) 
      VALUES (\''.$buffer1[3].'\', '.$new_key.', \''.$buffer1[0].'\', \''.$buffer1[11].'\', \''.$buffer1[10].'\', CURRENT_TIMESTAMP, \'no\',0,\''.$buffer1[4].'\',\''.$buffer1[5].'\', \'\',\''.$buffer1[6].'\',\''.$buffer1[2].'\', \'\', \'\',\''.$buffer1[7].'\', \'\', 50, \'\', CURRENT_TIMESTAMP,\''.$loc.'\',\''.$new_key.'.txt\',\''.$new_key.'.jpg\', \''.$buffer1[13].'\', \''.repars($buffer1[13]).'\')';
    //echo "Новый файл новинок: ".$new_key.".\n";
    //echo $query."\n";
    $pdo->query($query);
    return;
}

function fix_price($pdo, $key, $new_key)
{
    if (($key==0) && ($new_key!=545232))
    {
        $stmt = $pdo->query('SELECT * FROM a_promo WHERE key_g='.$new_key);
        if ($row=$stmt->fetch())
        {
            if ($pdo->query('DELETE FROM a_promo WHERE key_g=' . $new_key)) {
                //echo "Товар ".$new_key." больше не с фиксированной ценой.\n";
            }
        }
    }
    else
    {
        $stmt = $pdo->query('SELECT * FROM a_promo WHERE key_g='.$new_key);
        if (!$row=$stmt->fetch())
        {
            if ($pdo->query('INSERT INTO a_promo (key_g, departament_key, discount, key_promo_disc, internet_only) VALUES ('.$new_key.', 23769, 0, 1164502, 0)')) {
                //echo "Товар ".$new_key." теперь с фиксированной ценой.\n";
            }
        }
    }

}

function repars($instring)
{
    $result='';
    $sstring = explode(",",$instring);
    foreach ($sstring as $string)
    {
        if ($result!='')
            $result.="<br />";
        $sstr = $string;
        if (substr($sstr, 0, 1) == 'A' || (substr($sstr, 0, 1)) == 'B' || (substr($sstr, 0, 1)) == 'C') {
            switch (substr($sstr, 0, 1)) {
                case 'A': {
                    $result .= 'Этаж 0, ';
                    $sstr = substr($string, 2);
                    break;
                }
                case 'B': {
                    $result .= 'Этаж 1, ';
                    $sstr = substr($string, 2);
                    break;
                }
                case 'C': {
                    $result .= 'Этаж 2, ';
                    $sstr = substr($string, 2);
                    break;
                }
            }
            $result .= 'раздел ';

            if (!ctype_digit(substr($sstr, 0, 1))) {
                while (!(ctype_digit(substr($sstr, 0, 1))) && (substr($sstr, 0, 1) != '/')) {
                    $result .= substr($sstr, 0, 1);
                    $sstr = substr($sstr, 1);
                }
                if (substr($sstr, 0, 1) != '/')
                    $result .= ' ';
            }

            $result .= substr($sstr, 0, strpos($sstr, '/'));
            $sstr = substr($sstr, strpos($sstr, '/') + 1);


            $result .= ', стеллаж ' . substr($sstr, 0, strpos($sstr, '-'));
            $sstr = substr($sstr, strpos($sstr, '-') + 1);
            $result .= ', полка ' . substr($sstr, 0);
        } elseif (substr($sstr, 0, 1) == 'H') {
            $sstr = substr($string, 1);
            switch (substr($sstr, 0, strpos($sstr, '.'))) {
                case 'Basket': {
                    $result .= 'Корзина ';
                    break;
                }
                case 'Cube': {
                    $result .= 'Кубик ';
                    break;
                }
                case 'Table': {
                    $result .= 'Стол ';
                    break;
                }
                case 'Wall': {
                    $result .= 'Торец ';
                    break;
                }
                case 'Virt': {
                    $result .= 'Круглый стол ';
                    break;
                }
                default:
                    $result = $string;
            }
            $sstr = substr($string, strpos($sstr, '/') + 2);
            while (substr($sstr, 0, 1) == '0')
                $sstr = substr($sstr, 1);
            $result .= $sstr;
        } //else
            //$result = $string;
    }
    return $result;
}

$host = '127.0.0.1';
$db   = 'spbdk2';
$user = 'root';
$pass = 'bitrix2015petr2015';
$charset = 'utf8';
$temp12 = '158';
$symb = ' ';
$dir    = '/exchange/in/goods/';
$dir_upload = "/exchange/in/goods_uploaded/";
//mkdir($dir_upload, 0777);
$files1 = scandir($dir);
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$new_key=0;
$handle3 = @fopen("/home/apostol/others_mainbase.txt", "w");
$pdo = new PDO($dsn, $user, $pass, $opt);
for ($i=2;$i<count($files1);$i++)
{
    if ($handle = @fopen($dir . $files1[$i], "r"))  //если файл существует
    {
        while (($buffer = fgets($handle, 4096)) !== false)  // пока строчка не закончена //1
        {
            $buffer1 = explode(";", $buffer); // разбиваем строчку на ячейки
            if (stripos($buffer1[11], $symb) == true)
                $buffer1[11] = str_replace($symb, '', $buffer1[11]);
            if (stripos($buffer1[10], $symb) == true)
                $buffer1[10] = str_replace($symb, '', $buffer1[10]);
            if (stripos($buffer1[11], ',') == true)
                $buffer1[11] = str_replace(',', '.', $buffer1[11]);

            if (($buffer1[1]!='Код1С') /*&& (sizeof($buffer1) == 15)*/ && ($buffer1[1] != '')) // если блок Key_G не пустой и строка не битая
            {
                if (substr($buffer1[1],0,2)=='00')
                    $new_key=(int)substr($buffer1[1],3,8)*10+1;
                else
                    $new_key=(int)substr($buffer1[1],5,8)*10+2;

                fix_price($pdo, $buffer1[12], $new_key);

                if ($buffer1[11]=='' || empty($buffer1[11]) || is_null($buffer1[11]))
                    $buffer1[10] = '0';

                $stmt = $pdo->query('SELECT * FROM a_elements WHERE Key_G=' . $new_key);
                if ($row = $stmt->fetch())
                    upd_current($pdo, $buffer1, $new_key);
                else
                {
                    $stmt = $pdo->query('SELECT * FROM a_new_elements WHERE Key_G=' . $new_key);
                    if ($row = $stmt->fetch())
                        upd_current_new($pdo, $buffer1, $new_key);
                    else
                        insert_into_new($pdo, $buffer1);
                }
            }
        }
        fclose($handle);
    }
    rename($dir.$files1[$i], $dir_upload.$files1[$i]);
}
fclose($handle3);
//if (file_get_contents("/home/apostol/others_mainbase.txt"))
//{
//    $newfilenews="/exchange/in/news_uploaded/upl-news-".date("Y-m-d_H-i-s").".txt";
//    copy("others_mainbase.txt", $newfilenews);
//}

insert_into_main($pdo, $temp12);

$stmt = null;
$pdo = null;

?>