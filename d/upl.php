<?php
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.

$uploaddir = '/opt/www/d/';
$uploadfile = $uploaddir . 'image.jpg';

echo '<pre>';
if (substr($_FILES['userfile']['name'],-3,3)=='jpg') {
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
    header("Location: show2.php");
}
 else
     header("Location: index.php");

print "</pre>";

?>