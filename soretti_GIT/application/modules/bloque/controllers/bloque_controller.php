<?php
class Bloque_controller extends MX_Controller
{
  protected $per_page=40;

  public function __construct()
    {
        parent::__construct();
        $this->load->model('bloque/bloque');
        $this->load->model('bloque/bloquecontenidos');
        $this->acceso->carga_permisos('pagina');
    }

    public function _data($id){
        $bloque=new Bloque($id);
        return $bloque;
    }

    // public function _busqueda($bloque)
    // {
    //     $bloque->clear();

    //     $like_text=$this->session->userdata('bloque_buscar');

    //     if($like_text){
    //         $bloque->group_start()
    //                  ->or_like(array( 'titulo' => $like_text, 'subtitulo' => $like_text))
    //                  ->group_end();
    //     }
    // }

    // public function _ordenar($bloque)
    // {
    //     if(!$this->session->userdata('bloque_ordenar'))
    //         $this->session->set_userdata('bloque_ordenar',array('id','DESC'));
    //     $order=$this->session->userdata('bloque_ordenar');

    //     $bloque->order_by($order[0],$order[1]);
    // }


    // public function listar(){

    //     $this->titulo='BLOQUES';

    //     $this->acceso->valida('pagina','consultar',1);
    //     //buscar
    //     if($this->input->post('action_buscar')){
    //         $this->session->set_userdata('bloque_buscar',$this->input->post('buscar'));
    //     }

    //     //ordenar
    //     if($this->input->post('ordenar')){
    //         $order=$this->session->userdata('bloque_ordenar');
    //         if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
    //             $this->session->set_userdata('bloque_ordenar',array($this->input->post('ordenar'),'DESC'));
    //         else
    //             $this->session->set_userdata('bloque_ordenar',array($this->input->post('ordenar'),'ASC'));
    //     }

    //     $bloque=new Bloque;
    //     $this->_busqueda($bloque);
    //     $total_rows=$bloque->where('is_enable',1)->count();
    //     $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
    //     $limit=($pagina*$this->per_page);
    //     $this->_busqueda($bloque);
    //     $this->_ordenar($bloque);
    //     $bloque->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','desc')->get();
    //     /*Paginador*/
    //     $configuracion_paginador=$this->config->item('pagination');
    //     $configuracion_paginador['base_url'] = base_url('modulo/bloque/lista');
    //     $configuracion_paginador['total_rows'] = $total_rows;
    //     $configuracion_paginador['per_page'] = $this->per_page;
    //     $configuracion_paginador['uri_segment'] = 4;
    //     $this->pagination->initialize($configuracion_paginador);
    //     $this->layout_content=$this->load->view('bloque/grid',$data=array('bloque'=>$bloque),true);
    //     $this->load->view('plantilla/backend/form');
    // }

    // public function agregar(){
    //     $this->acceso->valida('pagina','consultar',1);
    //     $data['bloque'] = new Bloque();
    //     $this->acceso->valida('pagina','editar',1);
    //     $this->load->view('bloque/form',$data);
    // }

    // public function eliminar()
    // {
    //     $this->acceso->valida('pagina','eliminar',1);
    //     $bloque = new Bloque();
    //     $bloque->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
    //     $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
    //     redirect('modulo/bloque/listar/');
    // }

    public function editar($id=0)
    {

            $this->acceso->valida('pagina','consultar',1);
            $data['bloque']=new Bloque($id);

            if(!$data['bloque']->id) show_error('El registro solicitado no existe!');

                $data['bloques']=$data['bloque']->bloquecontenidos->where('is_enable',1)->order_by('sort','asc')->get();
                // $data['tipoBloque']=$this->ContenidoBloque;
                $data['tipoBloque']=$this->ContenidoBloque;

                $this->titulo = 'EDITAR '.$data['bloque']->titulo;
                $this->layout_content =  $this->load->view('bloque/form',$data,true);
                $this->layout_assets=array(
                    'js'=>array(base_url('pub/libraries/trahctools/js/bloque_editar.js'))
                 );
                $this->load->view('plantilla/backend/form');


    }

    


    public function guardar($id=0)
    {
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('pagina','editar',1);

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
            redirect('modulo/'.$this->uri->segment(2).'/editar/'.$bloque->id);
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




    public function eliminar_bloque()
    {

        $this->acceso->valida('pagina','eliminar',1);
        $bloque = new Bloquecontenidos();

        //if(!$bloque->id) show_error('El registro solicitado no existe!');

        $bloque->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
    }

    public function guardar_bloque($id_bloque,$id=0)
    {
        $this->titulo= ($id) ? "EDITAR" : 'AGREGAR';
        $this->acceso->valida('pagina','editar',1);

        $bloque=$this->ContenidoBloque;
        $bloque->get_by_id($id);

        $rel = $bloque->from_array($_POST, array('titulo','visible','subtitulo','texto','titulo_imagen','imagen','imagen2','liga','target','bloque_id','fecha_creacion','fecha_activacion','fecha_desactivacion','titulo_en','texto_en'));
        if(!$id) $bloque->sort='0';

        if($bloque->save($rel)){
            if(!$id){
                $reordenar_bloques=$this->ContenidoBloque;
                $reordenar_bloques->where(array('bloque_id'=>$id_bloque,'is_enable'=>'1'))->update(array('sort'=>'sort + 1'),false);
            }

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/'.$this->uri->segment(2).'/editar_bloque/'.$id_bloque.'/'.$bloque->id);
        }else{
            $data['bloques']=$bloque;
            $data['bloque'] = new Bloque($id_bloque);
            $this->layout_content = $this->load->view('form', $data,true);
            $this->load->view('plantilla/backend/form');
        }
    }

    public function editar_bloque($id_bloque,$id=0){
 
        $this->acceso->valida('pagina','consultar',1);

        $bloque=$this->ContenidoBloque;
        $bloque->get_by_id($id);

        $data['bloques'] = $bloque;
        $data['bloque'] = new Bloque($id_bloque);
        if(!$data['bloque']->id) show_error('El registro solicitado no existe!');

        $this->titulo="EDITAR";

        $this->layout_content = $this->load->view('form', $data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar_bloque($id_bloque){
        $this->acceso->valida('pagina','consultar',1);
        $data['bloques'] = $this->ContenidoBloque;
        $data['bloques']->fecha_creacion=date('Y-m-d H:i:s');
        $data['bloque'] = new Bloque($id_bloque);
         if(!$data['bloque']->id) show_error('El registro solicitado no existe!');
        $this->titulo="AGREGAR";
        $this->layout_content = $this->load->view('form', $data,true);
        $this->load->view('plantilla/backend/form');
    }

}
