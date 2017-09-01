<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sepomex_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('estado');
		$this->load->model('ciudad');
		$this->load->model('municipio');
		$this->load->model('colonia');
	}

	public function  importar(){

		$this->load->library('dom_parser');

        		$this->load->library('csvreader');
        		$this->csvreader->separator="|";
        		$data=$this->csvreader->parse_file('pub/uploads/estados/CPdescarga05.txt');

	       $by_page=200;
	        $total_resultados=count($data);
	        $total_paginas=ceil($total_resultados/$by_page);
	        $pagina_actual=($this->uri->segment(4)) ? $this->uri->segment(4) : '0' ;
	        $limit_ini=$by_page*$pagina_actual;
	        $limit_fin=$by_page*($pagina_actual+1);
	        if($pagina_actual>$total_paginas) die('El catalogo se importo correctamente');


 		$catatalogo_array=array_slice($data, $limit_ini,$by_page,true);

	        	foreach ($catatalogo_array as $key=>$row) { //die();

			$estado=new estado;
			$ciudad=new ciudad;
			$municipio=new  municipio;
			$colonia=new colonia;

			//$estado->where(array('titulo'=>$row['d_estado']))->get();
			$estado->get_by_titulo($row['d_estado']);
			$estado->titulo=$row['d_estado'];
			$estado->save();
			$nomestado=$estado->titulo;

			$ciudad->where(array('titulo'=>$row['d_ciudad'],'estado_id'=>$estado->id))->get();
			$ciudad->titulo=$row['d_ciudad'];
			$ciudad->estado_id=$estado->id;
			if($ciudad->titulo)  $ciudad->save();

			$municipio->where(array('titulo'=>$row['D_mnpio'],'estado_id'=>$estado->id))->get();
			$municipio->titulo=$row['D_mnpio'];
			$municipio->estado_id=$estado->id;
			if($municipio->titulo)  $municipio->save();

			$colonia->where(array('titulo'=>($row['d_asenta']),'municipio_id'=>$municipio->id,'cp'=>$row['d_codigo']))->where_related('municipio/estado','id',$estado->id)->get();

			// if( $colonia->exists() ){
			// 	write_file('pub/result.txt', 'fila:'.$key.' colonia:'.$$row['d_asenta'], 'a+');
			// }

			$colonia->titulo=($row['d_asenta']);
			$colonia->municipio_id=$municipio->id;
			$colonia->ciudad_id=$ciudad->id;
			$colonia->cp=$row['d_codigo'];
			if($colonia->titulo)  $colonia->save();

		}

		    redirect('modulo/sepomex/importar/'.($this->uri->segment(4)+1), 'refresh');
   		 die();
		echo 'Termino proceso -> '.$nomestado.'<br>';

	}


	public function  repetidos(){

		$this->load->library('dom_parser');

        		$this->load->library('csvreader');
        		$this->csvreader->separator="|";
        		$data=$this->csvreader->parse_file('pub/uploads/estados/CPdescarga.txt');

	       $by_page=1000;
	        $total_resultados=count($data);
	        $total_paginas=ceil($total_resultados/$by_page);
	        $pagina_actual=($this->uri->segment(4)) ? $this->uri->segment(4) : '0' ;
	        $limit_ini=$by_page*$pagina_actual;
	        $limit_fin=$by_page*($pagina_actual+1);
	        if($pagina_actual>$total_paginas) die('El catalogo se importo correctamente');


 		$catatalogo_array=array_slice($data, $limit_ini,$by_page,true);

	        	foreach ($catatalogo_array as $key=>$row) { //die();

			$estado=new estado;
			$ciudad=new ciudad;
			$municipio=new  municipio;
			$colonia=new colonia;

			//$estado->where(array('titulo'=>$row['d_estado']))->get();
			$estado->get_by_titulo($row['d_estado']);
			$estado->titulo=$row['d_estado'];
			$estado->save();
			$nomestado=$estado->titulo;

			$ciudad->where(array('titulo'=>$row['d_ciudad'],'estado_id'=>$estado->id))->get();
			$ciudad->titulo=$row['d_ciudad'];
			$ciudad->estado_id=$estado->id;
			if($ciudad->titulo)  $ciudad->save();

			$municipio->where(array('titulo'=>$row['D_mnpio'],'estado_id'=>$estado->id))->get();
			$municipio->titulo=$row['D_mnpio'];
			$municipio->estado_id=$estado->id;
			if($municipio->titulo)  $municipio->save();

			$colonia->where(array('titulo'=>($row['d_asenta']),'municipio_id'=>$municipio->id,'cp'=>$row['d_codigo']))->where_related('municipio/estado','id',$estado->id)->get();
			if( $colonia->exists() ){
				write_file('result.txt', 'fila:'.$key.' colonia:'.$$row['d_asenta'], 'a+');
			}
			$colonia->titulo=($row['d_asenta']);
			$colonia->municipio_id=$municipio->id;
			$colonia->ciudad_id=$ciudad->id;
			$colonia->cp=$row['d_codigo'];
			if($colonia->titulo)  $colonia->save();

		}

		    redirect('modulo/sepomex/importar/'.($this->uri->segment(4)+1), 'refresh');
   		 die();
		echo 'Termino proceso -> '.$nomestado.'<br>';

	}




}
