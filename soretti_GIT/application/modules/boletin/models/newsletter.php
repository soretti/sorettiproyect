<?php

class Newsletter extends DataMapper
{
    public $table='newsletter';
    public $prefix = "boletin_";

    public $has_many=array('boletin_newsletterstatus'=>array('class'=>'boletin_newsletterstatus'));

    public $has_one=array('cuentas');


    public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';


    function __construct($id=0)
    {
        parent::__construct($id);
    }

    public $validation = array(
        'asunto' => array('rules' => array('required')),
        'grupos' => array('rules' => array('required')),
        'fecha_envio' => array('rules' => array('date','required'))
    );

    function _date($field)
    {
        $fecha=explode(" ",$this->{$field});
        if(count($fecha)<2)
        {
            return FALSE;
        }
        if( strstr($fecha[0], '/') )
        {
            list($day,$month,$year)=explode("/",$fecha[0]);
            $this->{$field}= $year."-".$month."-".$day." ".$fecha[1].":00";
        }
        return TRUE;
    }

    function is_active()
    {
        $this->where("fecha_envio <= '".date('Y-m-d H:i:s')."'",null);
                //$this->where("if(fecha_desactivacion='0000-00-00 00:00:00',1,  if(fecha_desactivacion >= '".date('Y-m-d H:i:s')."',1,0) )",null);
                $this->where('is_enable',1);
                return $this;
    }


}
