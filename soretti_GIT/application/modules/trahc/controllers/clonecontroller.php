<?php
class {{nombre_controller}}_controller extends CI_Controller
{
  protected $per_page=40;

  public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('{{permiso_controller}}');
    }
    
    public function _busqueda(${{object_modelo}})
    {
        ${{object_modelo}}->clear();

        $like_text=$this->session->userdata('{{permiso_controller}}_buscar');

        if($like_text){
            ${{object_modelo}}->group_start()
                     ->or_like(array({{like_fields}}))
                     ->group_end();
        }
    }

    public function _ordenar(${{object_modelo}})
    {
        if(!$this->session->userdata('{{permiso_controller}}_ordenar'))
            $this->session->set_userdata('{{permiso_controller}}_ordenar',array('id','DESC'));
        $order=$this->session->userdata('{{permiso_controller}}_ordenar');

        ${{object_modelo}}->order_by($order[0],$order[1]);
    }


    public function listar(){
        $this->acceso->valida('{{permiso_controller}}','consultar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('{{permiso_controller}}_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('{{permiso_controller}}_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('{{permiso_controller}}_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('{{permiso_controller}}_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        ${{object_modelo}}=new {{nombre_modelo}};
        $this->_busqueda(${{object_modelo}});
        $total_rows=${{object_modelo}}->where('is_enable',1)->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda(${{object_modelo}});
        $this->_ordenar(${{object_modelo}});
        ${{object_modelo}}->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','desc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/{{object_modelo}}/lista');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);
        $this->load->view('{{object_modelo}}/grid',$data=array('{{object_modelo}}'=>${{object_modelo}}));
    }

    public function agregar(){
        $this->acceso->valida('{{permiso_controller}}','consultar',1);
        $data['{{object_modelo}}'] = new {{nombre_modelo}}();
        $data['{{object_modelo}}']->is_enable=1;
        $this->acceso->valida('{{permiso_controller}}','editar',1);
        $this->load->view('{{object_modelo}}/form',$data);
    }

    public function editar($id)
    {
        $this->acceso->valida('{{permiso_controller}}','consultar',1);
        $data['{{object_modelo}}']=new {{nombre_modelo}}($id);
        $this->load->view('{{object_modelo}}/form',$data);
    }


    public function guardar($id=0)
    {
        if(!$_POST) show_error($this->lang->line('alert_request'));
        $this->acceso->valida('{{permiso_controller}}','editar',1);

        ${{object_modelo}}=new {{nombre_modelo}}($id);
        $campos=array({{list_fields}});

        $rel = ${{object_modelo}}->from_array($_POST, $campos);

        if(${{object_modelo}}->save($rel)){
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/{{object_modelo}}/editar/'.${{object_modelo}}->id);
        }else{
            $data['{{object_modelo}}']=${{object_modelo}};
            $this->load->view('{{object_modelo}}/form',$data);
        }
    }

    public function eliminar()
    {
        $this->acceso->valida('{{permiso_controller}}','eliminar',1);
        ${{object_modelo}} = new {{nombre_modelo}}();
        ${{object_modelo}}->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/{{object_modelo}}/listar/');
    }

}
