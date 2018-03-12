<?php
$image="image.png";

$r=0;$g=0;$b=0;
$im = imagecreatefrompng($image);
$sizeimage = getimagesize($image);
for ($i = 0; $i < $sizeimage[0]; $i++)
    for ($j = 0; $j < $sizeimage[1]; $j++)
    {
        $rgb = imagecolorat($im, $i, $j);
        $colors = imagecolorsforindex($im, $rgb);
        $r += $colors["red"];
        $g += $colors["green"];
        $b += $colors["blue"];
    }
$r/=($sizeimage[0]*$sizeimage[1]);
$g/=($sizeimage[0]*$sizeimage[1]);
$b/=($sizeimage[0]*$sizeimage[1]);
//echo "r: ".$r."<br>g: ".$g."<br>b: ".$b;
$handle = fopen("data.csv","r");
$min=9999;
$i=0;
while (($buffer = fgets($handle, 4096)) !== false)
{
    $buffer1 = explode(";", $buffer);
    $c=sqrt(($r-$buffer1[1])*($r-$buffer1[1])+($g-$buffer1[2])*($g-$buffer1[2])+($b-$buffer1[3])*($b-$buffer1[3]));
    if ($c<$min)
    {
        $min=$c;
        $i=$buffer1[0];
    }
}
echo " <img src = media/".$i.".png> ";
echo "<br><a href=index.php>New image</a>";
//fclose($handle);
?>