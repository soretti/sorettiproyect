<?php
class Columna extends DataMapper
{
	public $table = "columnas";
	public $has_many = array('modulo');

	function __construct($id=0){
		return parent::__construct($id);
	}

	function sort_elements($modulo)
	{
        //$this->load->model("destinodestacado/destinodestacado");
        $this->load->model("banners/banners");

		if( $this->id ) $modulo->where('is_enable',1)->like('columnas',$this->id)->get();
        $col_modulo=array();
        
        $modulos_seleccionados=json_decode($this->modulos,true);
        
        //$destinodestacado=new Destinodestacado;
        //$destinodestacado->get();

        $banners=new banners;
        $banners->where('is_enable','1')->where('columna_id',$this->id)->get();

        $elements = array();
        $key = "";
        $indice=0;


        foreach ($modulo as $key => $m) {
            $pos='';
            if(is_array( $modulos_seleccionados)) foreach( $modulos_seleccionados as $idc=>$m_sel){
                if($m_sel['id']==$m->id && $m_sel['tipo']=='modulo') $pos=$idc+1;
            }
            $elements[$indice]['id'] = $m->id;
            $elements[$indice]['titulo'] = $m->nombre;
            $elements[$indice]['posicion'] = $pos;
            $elements[$indice]['tipo'] = "modulo";
            $indice++;
        }

        foreach ($banners as $key => $m) {
            $pos='';
               if(is_array($modulos_seleccionados)) foreach( $modulos_seleccionados as $idc=>$m_sel){  
                    if($m_sel['id']==$m->id && $m_sel['tipo']=='banner') $pos=$idc+1;
                }
            $elements[$indice]['id'] = $m->id;
            $elements[$indice]['titulo'] = $m->titulo;
            $elements[$indice]['posicion'] =  $pos;
            $elements[$indice]['tipo'] = "banner";
            $indice++;
        }

        // if($this->id==1 || $this->id==2  ){
        //     foreach ($destinodestacado as $key => $m) {
        //         $pos='';
        //            if(is_array($modulos_seleccionados)) foreach( $modulos_seleccionados as $idc=>$m_sel){  
        //                 if($m_sel['id']==$m->id && $m_sel['tipo']=='destinodestacado') $pos=$idc+1;
        //             }
        //         $elements[$indice]['id'] = $m->id;
        //         $elements[$indice]['titulo'] = $m->titulo_modulo;
        //         $elements[$indice]['posicion'] =  $pos;
        //         $elements[$indice]['tipo'] = "destinodestacado";
        //         $indice++;
        //     }
        // }

 
        $posicion = array();


        foreach ($elements as $key => $row)
        {
            $posicion[$key] = $row['posicion'];
        }

        array_multisort($posicion, SORT_ASC, $elements);

        return $elements;
	}
}