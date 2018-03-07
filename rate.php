<?php

class Rate{
    private $count_values;
    private $delay;
    public $values = array(); // rate values
    public $values1 = array(); // first dy/dx
    public $values2 = array(); // second dy/dx
    public $id_change_sign;
    public $sign;

    function __construct($size, $delay, $v){
        $this->count_values = $size;
        $this->delay = $delay;
        for ($i=0;$i<$this->count_values;$i++) {
            $this->values[$i] = $v;
            $this->values1[$i] = 0;
            $this->values2[$i] = 0;
        }
        $this->id_change_sign = 1;
        if ($this->values[0]>=0)
            $this->sign = 1;
        else
            $this->sign = -1;
        return;
    }


    public function summ($choose, $start, $finish){
        $s = 0;
        for ($i=$start;$i<=$finish;$i++)
            switch($choose) {
                case 0:
                    $s+=$this->values[$i];
                    break;
                case 1:
                    $s+=$this->values1[$i];
                    break;
                case 2:
                    $s+=$this->values2[$i];
                    break;
            }
        return $s;
    }


    public function refresh($value){
        for ($i=$this->count_values-1;$i>0;$i--) {
            $this->values[$i] = $this->values[$i - 1];
            $this->values1[$i]=$this->values1[$i-1];
            $this->values2[$i]=$this->values2[$i-1];
        }
        $this->values[0]=$value;
        $this->values1[0]=($this->values[0]-$this->values[1])/$this->delay;
        $this->values2[0]=($this->values1[0]-$this->values1[1])/$this->delay;
        if ($this->id_change_sign<$this->count_values-1)
            $this->id_change_sign++;
        if ($this->values[0]>$this->values[1])
            $this->sign = 1;
        if ($this->values[0]<$this->values[1])
            $this->sign = -1;
        return;
    }


    public function check(){
        if ((($this->sign == -1 ) && ($this->values[0]<$this->values[1])) || (($this->sign == 1) && ($this->values[0]>$this->values[1])))
            return true;
        return false;
    }



}

?>