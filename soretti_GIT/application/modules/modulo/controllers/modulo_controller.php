<?php

class Modulo_controller extends MX_Controller
{
        protected $per_page=40;

        public function __construct()
        {

            parent::__construct();
            $this->load->model('modulo');
            $this->load->model('columna/columna');
            $this->load->helper('text');
            $this->acceso->carga_permisos('pagina');

        }

        public function _busqueda($modulo)
        {
            $modulo->clear();
            $like_text=$this->session->userdata('modulo_buscar');

            if($like_text){
                $modulo->group_start()
                         ->or_like(array('id'=>$like_text,'nombre'=>$like_text))
                         ->group_end();
            }
        }

        public function _ordenar($modulo)
        {
            if(!$this->session->userdata('modulo_ordenar'))
                $this->session->set_userdata('modulo_ordenar',array('id','DESC'));
                $order=$this->session->userdata('modulo_ordenar');

                $modulo->order_by($order[0],$order[1]);
        }



         public function agregar(){
            $this->titulo='AGREGAR MÓDULO';
            $this->acceso->valida('pagina','editar',1);
            $data['modulo']=new Modulo();
            $columnas=new Columna();
            $data['columna']=$columnas->where('is_enable',1)->get();

            $this->layout_content=$this->load->view('modulo/form',$data,true);
            $this->load->view('plantilla/backend/form');
         }


        public function guardar($id=0)
        {
            $this->titulo=($id) ? 'EDITAR MÓDULO' : 'AGREGAR MÓDULO';
            $this->acceso->valida('pagina','editar',1);

            $modulo=new Modulo($id);
            if(isset($_POST['columnas'])) $_POST['columnas'] = implode(",",$_POST['columnas']);
            else $_POST['columnas']='';
            $rel = $modulo->from_array($_POST, array('nombre','columnas'));

            if($modulo->save($rel))
            {
                $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
                redirect('modulo/modulo/editar/'.$modulo->id);
            }else{
                $data['modulo']=$modulo;
                $columnas=new Columna();
                $data['columna']=$columnas->where('is_enable',1)->get();                
                $this->layout_content=$this->load->view('modulo/form',$data,true);
                $this->load->view('plantilla/backend/form');
            }

        }

         public function editar($id)
        {
            $this->titulo='EDITAR MÓDULO';
            $this->acceso->valida('pagina','editar',1);

            $data['modulo']=new Modulo($id);

            $columnas=new Columna();
            $data['columna']=$columnas->where('is_enable',1)->get();

            $this->layout_content=$this->load->view('modulo/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }

        public function eliminar()
        {
            $this->acceso->valida('pagina','eliminar',1);  

            $modulo = new Modulo();
            $modulo->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);

            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/modulo/listar/');
        }


         public function listar()
        {
            $this->titulo='LISTA DE MÓDULOS';

            $this->acceso->valida('pagina','consultar',1);

            //buscar
            if($this->input->post('action_buscar')){
                $this->session->set_userdata('modulo_buscar',$this->input->post('buscar'));
            }

            //ordenar
            if($this->input->post('ordenar')){
                $order=$this->session->userdata('modulo_ordenar');
                if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                    $this->session->set_userdata('modulo_ordenar',array($this->input->post('ordenar'),'DESC'));
                else
                    $this->session->set_userdata('modulo_ordenar',array($this->input->post('ordenar'),'ASC'));
            }

            $columnas=new Columna;
            $columnas->where('is_enable',1)->get();

            foreach ($columnas as $key => $value) {
                    $nombres[$key]=($value->id);
            }

            $modulo=new Modulo;
            $this->_busqueda($modulo);
            $total_rows=$modulo->where('is_enable',1)->count();
            $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
            $limit=($pagina*$this->per_page);
            $this->_busqueda($modulo);
            $this->_ordenar($modulo);
            $modulo->limit($this->per_page, $limit)->where('is_enable',1)->get();


            /*Paginador*/
            $configuracion_paginador=$this->config->item('pagination');
            $configuracion_paginador['base_url'] = base_url('modulo/modulo/listar');
            $configuracion_paginador['total_rows'] = $total_rows;
            $configuracion_paginador['per_page'] = $this->per_page;
            $configuracion_paginador['uri_segment'] = 4;
            $this->pagination->initialize($configuracion_paginador);

            $this->layout_content=$this->load->view('modulo/grid',$data=array('modulos'=>$modulo),true);
            $this->load->view('plantilla/backend/form');
        }

}
