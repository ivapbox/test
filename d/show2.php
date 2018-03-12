<?php
$image="image.jpg";
$sz=20;
$sizear=5;
$outF="out.html";
$outF = strval(str_replace("\0", "", $outF));
$asd = fopen($outF, "w");
$im = imagecreatefromjpeg($image);
$sizeimage = getimagesize($image);
$ci=(int)($sizeimage[1]/$sz);
$cj=(int)($sizeimage[0]/$sz);
$dest = imagecreatetruecolor($sz*$cj,$sz*$ci);

for ($i=0;$i<$ci;$i++)
{
    for ($j=0;$j<$cj;$j++)
    {
        $ar = array();
        $iar = array();
        $r=0;$g=0;$b=0;$cnt=-1;
        for ($ii = $i*$sz; $ii < ($i+1)*$sz; $ii++)
        {
            for ($jj = $j * $sz; $jj < ($j + 1) * $sz; $jj++)
            {
                $rgb = imagecolorat($im, $jj, $ii);
                $colors = imagecolorsforindex($im, $rgb);
                $r += $colors["red"];
                $g += $colors["green"];
                $b += $colors["blue"];
            }
        }
        $r/=($sz*$sz);
        $g/=($sz*$sz);
        $b/=($sz*$sz);
        $handle = fopen("data.csv","r");
        $min=999;
        $indx=0;
        while (($buffer = fgets($handle, 4096)) !== false)
        {
            $buffer1 = explode(";", $buffer);
            $c=sqrt(($r-$buffer1[1])*($r-$buffer1[1])+($g-$buffer1[2])*($g-$buffer1[2])+($b-$buffer1[3])*($b-$buffer1[3]));
            if ($c<$min)
            {
                $min=$c;
                $indx=$buffer1[0];
            }
            // поиск 5 минимумов
            if ($cnt<$sizear-1)
            {
                $cnt++;
                $ar[$cnt]=$c;
                $iar[$cnt] = $buffer1[0];
            }
            else
            {
                $max=0;
                $ind_razn=0;
                for ($loc = 0; $loc < $sizear; $loc++)
                    if ($ar[$loc] > $max)
                    {
                        $max = $ar[$loc];
                        $ind_razn = $loc;
                    }
                if ($c<$max)
                {
                    $ar[$ind_razn] = $c;
                    $iar[$ind_razn] = $buffer1[0];
                }
            }
            // поиск 5 минимумов END
        }
        fclose($handle);
        $src = imagecreatefrompng("media/".$iar[rand(0,$sizear-1)].".png");
        imagecopyresized($dest, $src, $j*$sz, $i*$sz, 0, 0, $sz, $sz, 64, 64);
        imagedestroy($src);
        unset($ar);
        unset($iar);
    }
}
fclose($asd);
imagepng($dest, 'result.png');
echo "<img src=result.png>";
echo "<br><a href=index.php>New image</a>";
imagedestroy($dest);
?>