<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Slider_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();

        $this->load->model('bloque/bloque');
        
        $this->load->model('pagina/pagina');
        //$this->acceso->carga_permisos('bloque');
		$this->load->model('bloque/bloquecontenidos');
        $this->load->model('slider','ContenidoBloque');
        //$this->acceso->carga_permisos('slider');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{

                           $nompage=$this->uri->segment(2);
                           $paginas=new Pagina;

                           //echo $nompage; die();

                           if (!empty($nompage)){
                                    $paginas->where('uri', $nompage)->get();
                                    $pagina_id=$paginas->id;
                           }else{
                                   $pagina_id=79;
                           }

                          $bloque = $this->_data(1);
		$sliders = $bloque->bloquecontenidos->is_active()->where("pagina_id",$pagina_id)->order_by('sort','ASC')->get();
		$this->load->view('slider',array('sliders'=>$sliders , 'bloques'=> $bloque, 'pagina_id'=>$pagina_id ));
	}

     public function editar_bloque($id_bloque,$id=0){

        $id_page=$this->uri->segment(5);
        //echo $id_page; die();
        //$this->acceso->valida('bloque','consultar',1);

        $bloque=$this->ContenidoBloque;
        $bloque->get_by_id($id);

        $data['id_page'] = $id_page;
        $data['bloques'] = $bloque;
        $data['bloque'] = new Bloque($id_bloque);
        if(!$data['bloque']->id) show_error('El registro solicitado no existe!');

        $this->titulo="EDITAR";

        $this->layout_content = $this->load->view('form', $data,true);
        $this->load->view('plantilla/backend/form');
    }

     public function agregar_bloque($id_bloque){

        //$this->acceso->valida('bloque','consultar',1);

        $nompage=$this->uri->segment(5);

         $data['id_page']=$nompage;

        $data['bloques'] = $this->ContenidoBloque;
        $data['bloques']->fecha_creacion=date('Y-m-d H:i:s');
        $data['bloque'] = new Bloque($id_bloque);
         if(!$data['bloque']->id) show_error('El registro solicitado no existe!');
        $this->titulo="AGREGAR";
        $this->layout_content = $this->load->view('form', $data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function editar($id=0)
    {
              $nompage=$this->uri->segment(5);

              $paginas=new Pagina;

               if ($nompage!='index'){
                    $paginas->where('uri', $nompage)->get();

                    if($paginas->id){
                        $id_page=$paginas->id;
                    }else{
                         $id_page=$nompage;
                    }
               }else{
                    $id_page=24;
               }

            $data['id_page']=$id_page;

            //$this->acceso->valida('bloque','consultar',1);
            $data['bloque']=new Bloque($id);

            if(!$data['bloque']->id) show_error('El registro solicitado no existe!');

                $data['bloques']=$data['bloque']->bloquecontenidos->where(array('is_enable'=>1,'pagina_id'=>$id_page))->order_by('sort','asc')->get();
               //$data['bloque']->check_last_query();
                $data['tipoBloque']=$this->ContenidoBloque;

                $this->titulo = 'EDITAR '.$data['bloque']->titulo;
                $this->layout_content =  $this->load->view('editarform',$data,true);
                $this->layout_assets=array(
                    'js'=>array(base_url('pub/libraries/trahctools/js/bloque_editar.js'))
                 );
                $this->load->view('plantilla/backend/form');
    }

     public function guardar($id=0)
    {
         $id_page=$this->uri->segment(5);

        if(!$_POST) show_error($this->lang->line('alert_request'));
        //$this->acceso->valida('bloque','editar',1);

        $bloque=new Bloque($id);

         if(!$bloque->id) show_error('El registro solicitado no existe!');

        $rel = $bloque->from_array($_POST,array( 'titulo','titulo_en'));
        if(!$id) $bloque->sort='0';

        if($bloque->save($rel)){
             if( $this->input->post('slide') ) foreach ($this->input->post('slide') as $key => $slide) {
                $bloques = new Bloquecontenidos($slide);
                $bloques->sort=$key;
                $bloques->save();
            }
            if(!$id){
                $gal=new Bloquecontenidos();
                $gal->where(array('is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));

            redirect('modulo/'.$this->uri->segment(2).'/editar/'.$bloque->id.'/'.$id_page);
        }else{
            $data['bloque']=$bloque;
            $data['bloques']=$data['bloque']->bloquecontenidos->where('is_enable',1)->order_by('sort','asc')->get();
            $data['tipoBloque']=$this->ContenidoBloque;
            $this->layout_assets=array(
                'js'=>array(base_url('pub/libraries/trahctools/js/bloque_editar.js'))
            );

            $this->layout_content =  $this->load->view('bloque/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }
    }


     public function guardar_bloque($id_bloque)
    {

        $id_page=$this->uri->segment(5);
        $id=$this->uri->segment(6);

        if(!$id)$id=0;
        $this->titulo= ($id) ? "EDITAR" : 'AGREGAR';
        //$this->acceso->valida('bloque','editar',1);

        $bloque=$this->ContenidoBloque;
        $bloque->get_by_id($id);

        $_POST['pagina_id']=$id_page;

        $data['id_page']=$id_page;

        $rel = $bloque->from_array($_POST, array('titulo','visible','subtitulo','texto','imagen','imagen2','liga','target','bloque_id','fecha_creacion','fecha_activacion','fecha_desactivacion','titulo_en','texto_en','pagina_id'));
        if(!$id) $bloque->sort='0';

        if($bloque->save($rel)){
            if(!$id){
                $reordenar_bloques=$this->ContenidoBloque;
                $reordenar_bloques->where(array('bloque_id'=>$id_bloque,'is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/'.$this->uri->segment(2).'/editar_bloque/'.$id_bloque.'/'.$bloque->id.'/'.$id_page);
        }else{
            $data['bloques']=$bloque;
            $data['bloque'] = new Bloque($id_bloque);
            $this->layout_content = $this->load->view('form', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }

}


