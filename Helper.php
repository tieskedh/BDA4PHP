<?php

/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 30-5-2016
 * Time: 15:08
 */
class Helper {
    public static function getDropDown(string $name, array $array, string $selected='') {
        if(!empty($array)) {
            $selectBox = '<select name="'.$name.'" id="'.$name.'"><option></option>';
            foreach ($array as $id => $value) {
                $selectBox.='<option value="'.$id.'" ';
                $selectBox.=($id == $selected)?'selected':'';
                $selectBox.='>'.$value.'</option>';
            }
            return $selectBox.='</select>';
        } else {
            return '';
        }
    }

    public static function getPagination(string $name, int $max, int $current, int $size) {
        $pagination ='<ul class="pagination">';
        $min = ceil($current-$size/2);
        if($min < 0) {
            $min = 0;
        }
        $tempMax = $min+$size;
        if( $tempMax > $max) {
            $tempMax = $max;
        }
        if($current!=0) {
            $pagination.='<li><a href="'.$name.'0"><<<</a></li>';
            $pagination.='<li><a href="'.$name.($current-1).'"><<</a></li>';
        }
        for ($index = $min; $index <$current; $index++) {
            $pagination.='<li><a href="'.$name.$index.'">'.$index.'</a></li>';
        }
        $pagination.='<li><a href="'.$name.$current.'" class="active">'.$index.'</a></li>';
        for ($index = $current+1; $index<$tempMax; $index++) {
            $pagination.='<li><a href="'.$name.$index.'">'.$index.'</a></li>';
        }
        if($current!=$max) {
            $pagination.='<li><a href="'.$name.($current+1).'">>></a></li>';
            $pagination.='<li><a href="'.$name.($max).'">>>></a></li>';
        }
        return $pagination.'</ul>';
    }

    public static function getHiddenInput(string $name, string $value) {
        return '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
    }

    public static function getCheckBox(string $name, string $checkedValue, string $uncheckedValue='') {
        return (($uncheckedValue=='')?'':'<input type="hidden" name="'.$name.'" value="'.$uncheckedValue.'" id="'.$name.'"/>').
                '<input type="checkbox" name="'.$name.'" value="'.$checkedValue.'"/>';
    }

}