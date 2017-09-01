<?php
function name_image($ruta_imgen,$modulo,$campo,$w,$h)
{
	if(!$ruta_imgen) return '';
	$ruta_imgen=str_replace(base_url(),"", $ruta_imgen);
    $part_image = pathinfo($ruta_imgen);
    $dir_name=strstr($part_image['dirname'],'pub/');

    $key=md5($modulo.$campo.$dir_name.$w.$h);
    $part_image['extension']=(isset($part_image['extension'])) ? $part_image['extension'] : '';
    $imagen = $part_image['filename'].'_'.$key.'.'.$part_image['extension'];

    if( !file_exists('pub/uploads/thumbs/'.$imagen) ) return '';
    return $imagen;
}

function icon_order($order,$field)
{
	$ico_order=($order[1]=='ASC') ? 'up' : 'down' ;
	if($order[0]==$field) echo "<span class='glyphicon glyphicon-chevron-".$ico_order." icon-white'></span>";
}
function url_idioma($link)
{
	if(IDIOMA && strstr($link, site_url())  )  $link=str_replace(site_url(), site_url().substr(IDIOMA,1)."/",$link);
	return $link;
}

function fecha($datetime){
	list($fecha, $hora)=explode(" ", $datetime);
	list($year,$month,$day)=explode("-",$fecha);
	return $day."/".$month."/".$year;
}

function print_pre($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

function addfecha($fecha1,$dias){

   $timestamp=strtotime($fecha1);

   $timestamp+=$dias*24*60*60;

   //$fecha2=gmdate("Y-m-d H:i:s",$timestamp+difhoramx());

   $fecha2=date("Y-m-d H:i:s",$timestamp);

   return $fecha2;

}

function extract_emails($string){
	preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $string, $found_mails);
	return $found_mails;
}

function arrayColumn(array $array, $column_key, $index_key=null){
        if(function_exists('array_column ')){
            return array_column($array, $column_key, $index_key);
        }
        $result = array();
        foreach($array as $arr){
            if(!is_array($arr)) continue;

            if(is_null($column_key)){
                $value = $arr;
            }else{
                $value = $arr[$column_key];
            }

            if(!is_null($index_key)){
                $key = $arr[$index_key];
                $result[$key] = $value;
            }else{
                $result[] = $value;
            }

        }

        return $result;
}

function formato_precio($valor)
{
    if(!is_numeric($valor)) return "";  
    return  "$".number_format($valor,2,".",",");  
}

function formato_precio_banamex($valor)
{
    if(!is_numeric($valor)) return "";
    return  number_format($valor,2,"",""); 
}