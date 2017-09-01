<?php

class Banners_controller extends MX_Controller
{
        protected $per_page=5;

        public function __construct()
        {
            parent::__construct();
            $this->load->model('banners/banners');
            $this->load->helper('text');
            $this->acceso->carga_permisos('pagina');

        }

        public function _busqueda($banner)
        {
            $banner->clear();
            $like_text=$this->session->userdata('banner_buscar');

            if($like_text){
                $banner->group_start()
                         ->or_like(array('id'=>$like_text,'titulo'=>$like_text))
                         ->group_end();
            }
        }

        public function _ordenar($banner)
        {
            if(!$this->session->userdata('banner_ordenar'))
                $this->session->set_userdata('banner_ordenar',array('id','DESC'));
            $order=$this->session->userdata('banner_ordenar');

            $banner->order_by($order[0],$order[1]);
        }

    public function agregar($columna_id)
    {
        $this->load->model('columna/columna');
        $columna=new Columna($columna_id);        
        $this->titulo='AGREGAR BANNER';
        $this->acceso->valida('pagina','editar',1);
        $data['banner']=new Banners();
        $data['columna']=$columna;

        $this->layout_content=$this->load->view('banners/form',$data,true);
        $this->load->view('plantilla/backend/form'); 
    }


    public function guardar($id=0,$columna_id)
    {
        $this->load->model('columna/columna');
        $columna=new Columna($columna_id); 

        $this->titulo = ($id) ? 'EDITAR BANNER' : $this->titulo='AGREGAR BANNER';


         $this->acceso->valida('pagina','editar',1);
        $banner=new Banners($id);

        $rel = $banner->from_array($_POST, array('titulo','imagen','liga','target','titulo_imagen'));
        $banner->columna_id=$columna_id;
        if($banner->save($rel))
        {
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            $id_banner = ($banner->id) ? $banner->id : "0";
            redirect('modulo/banners/editar/'.$id_banner.'/'.$columna_id);
        }else{
            $data['banner']=$banner;
            $data['columna']=$columna;

            $this->layout_content=$this->load->view('banners/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }

    }

        public function editar($id,$columna_id)
        {
        	$this->load->model('columna/columna');
        	$columna=new Columna($columna_id);
            $this->titulo='EDITAR BANNER';
            $this->acceso->valida('pagina','consultar',1);
            $data['banner']=new Banners($id);
            $data['columna']=$columna;

            $this->layout_content=$this->load->view('banners/form',$data,true);
            $this->load->view('plantilla/backend/form'); 
        }

        public function eliminar()
        {
            $this->acceso->valida('pagina','eliminar',1);
            $banner = new Banners();
            $banner->where_in('id', $this->input->post('post_ids'))->get();
            foreach ($banner as $value) {
                $value->is_enable=0;
                $value->save();
            }
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/banners/listar/');
        }

        public function habilitar()
        {
            $this->acceso->valida('pagina','eliminar',1);
            $banner = new Banners();
            $banner->where_in('id', $this->input->post('post_ids'))->get();
            foreach ($banner as $value) {
                $value->is_enable=1;
                $value->save();
            }
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/banners/listar/');
        }


         public function listar($columna_id)
         {

            $this->titulo='LISTA DE BANNERS';

            $this->acceso->valida('pagina','consultar',1);

            //buscar
            if($this->input->post('action_buscar')){
                $this->session->set_userdata('banner_buscar',$this->input->post('buscar'));
            }

            //ordenar
            if($this->input->post('ordenar')){
                $order=$this->session->userdata('banner_ordenar');
                if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                    $this->session->set_userdata('banner_ordenar',array($this->input->post('ordenar'),'DESC'));
                else
                    $this->session->set_userdata('banner_ordenar',array($this->input->post('ordenar'),'ASC'));
            }

            $banner = new Banners();
            $this->_busqueda($banner);
            $total_rows=$banner->where('is_enable',1)->where('columna_id',$columna_id)->count();
            $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
            $limit=($pagina*$this->per_page);
            $this->_busqueda($banner);
            $this->_ordenar($banner);
            $banners=$banner->limit($this->per_page, $limit)->where('is_enable',1)->where('columna_id',$columna_id)->get();

            /*Paginador*/
            $configuracion_paginador=$this->config->item('pagination');
            $configuracion_paginador['base_url'] = base_url('modulo/banners/listar');
            $configuracion_paginador['total_rows'] = $total_rows;
            $configuracion_paginador['per_page'] = $this->per_page;
            $configuracion_paginador['uri_segment'] = 5;
            $this->pagination->initialize($configuracion_paginador);

            $this->layout_content=$this->load->view('banners/grid',array('banner'=>$banners,'columna_id'=>$columna_id),true);
            $this->load->view('plantilla/backend/form');


        }

        public function mostrar($id,$columna_id)
        {
                $banner = new Banners();
                $banner->where('is_enable',1);
                $banner->where('id',$id)->get();
                $this->load->view('banner',array('banner'=>$banner,'columna_id'=>$columna_id));
        }

        public function read($id)
        {
            $banner = new Banners($id);

            echo "<a href='".$banner->liga."' target='".$banner->target."'><image src='".$banner->imagen."' width='270' border='0'></a>";
            echo "<p>is_enable ".$banner->is_enable."</p>";

        }

        public function show($banner)
        {
                foreach ($banner as $value) {
                    echo "<p>imagen: ".$value->imagen."</p>";
                    echo "<p>liga: ".$value->liga."</p>";
                    echo "<p>id: ".$value->id."</p>";
                    echo "<p>is_enable: ".$value->is_enable."</p>";
                }
        }

}
