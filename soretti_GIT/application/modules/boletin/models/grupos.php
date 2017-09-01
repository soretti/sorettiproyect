<?php

class Grupos extends DataMapper
{
    public $table='grupos';
    public $prefix = "boletin_";

    public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';


    function __construct($id=0)
    {
        parent::__construct($id);
    }

    public $validation = array(
        'nombre' => array('rules' => array('required')),
    );


}
