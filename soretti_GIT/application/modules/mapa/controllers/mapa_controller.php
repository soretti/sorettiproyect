<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Mapa_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('direccion','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
        $this->load->model('direccion','ContenidoBloqueMapa');
		$bloque = $this->_data(4);
		$direcciones = $this->ContenidoBloqueMapa->where('bloque_id',$bloque->id)->is_active()->order_by('sort','ASC')->get();
		$this->load->view('mapa',array('direcciones_mapa'=>$direcciones , 'bloque'=> $bloque ));
	}

	public function guardar_bloque($id_bloque,$id=0)
    {
        $this->titulo= ($id) ? "EDITAR" : 'AGREGAR';
        $this->acceso->valida('pagina','editar',1);
        $this->load->model('direccion','ContenidoBloqueMapa');
        $bloque=$this->ContenidoBloqueMapa;
        $bloque->get_by_id($id);

        $rel = $bloque->from_array($_POST, array( 'titulo','visible','subtitulo','texto','imagen','liga','target','bloque_id','fecha_creacion','fecha_activacion','fecha_desactivacion','titulo_en','texto_en'));
        if(!$id) $bloque->sort='0';

        if($bloque->save($rel)){
            if(!$id){
                $reordenar_bloques=$this->ContenidoBloqueMapa;
                $reordenar_bloques->where(array('bloque_id'=>$id_bloque,'is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }
	        $mapa=new Mapa();
	    	$mapa->where('bloquecontenido_id',$id)->get();
	    	$mapa->coordenadas=$this->input->post('coordenadas');
                            $mapa->texto=$this->input->post('texto_mapa');
	    	$mapa->texto_en=$this->input->post('textomapa_en');
	    	$mapa->save($bloque);

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/'.$this->uri->segment(2).'/editar_bloque/'.$id_bloque.'/'.$bloque->id);
        }else{
            $data['bloques']=$bloque;
            $data['bloque'] = new Bloque($id_bloque);
            $this->layout_content = $this->load->view('form', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function mostrar_mapa(){
        $this->load->model('direccion','ContenidoBloqueMapa');
        $bloque = $this->_data(4);
        $direcciones = $this->ContenidoBloqueMapa->where('bloque_id',$bloque->id)->is_active()->order_by('sort','ASC')->get();
        $this->load->view('plantilla/bigmapa',array('direcciones_mapa'=>$direcciones,'bloque'=> $bloque));
    }


}
