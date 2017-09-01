<?php

class Rol_controller extends  MX_Controller
{
    protected $per_page = 40;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario/permiso');
        $this->load->model('usuario/usuario');
        $this->acceso->carga_permisos('usuario');
    }
    
    public function agregar()
    {
        $this->titulo='AGREGAR PERFIL';
        $this->acceso->valida('usuario', 'consultar', 1);
        $permisos = new Permiso();
        $permisos->order_by('permiso', 'asc')->get();
        $rol=new Rol();

        $this->layout_content=$this->load->view('rol/form',array('rol'=>$rol,'permisos'=>$permisos,'acl'=>array()),true);
        $this->load->view('plantilla/backend/form');

    }
    
    public function editar($id)
    {
        $this->titulo='EDITAR PERFIL';
        $this->acceso->valida('usuario', 'consultar', 1);
        $permisos = new Permiso();
        $permisos->order_by('permiso', 'asc')->get();
        $configuracion = array();
        $query         = $this->db->from('acl')->where('roles_id', $id)->get();
        $acl           = $query->result();
        foreach ($acl as $item) {
            $configuracion[$item->permisos_id] = json_decode($item->acl, true);
        }
        $rol     = new Rol($id);

        $this->layout_content=$this->load->view('rol/form',array('rol'=>$rol,'permisos'=>$permisos,'acl'=>$configuracion),true);
        $this->load->view('plantilla/backend/form');
    }
    
    public function eliminar()
    {
        $this->acceso->valida('usuario', 'eliminar', 1);
        $rol = new Rol();
        $rol->where_in('id', $this->input->post('post_ids'))->update('is_enable', 0);
        $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
        redirect('modulo/rol/lista/');
    }
    
    public function guardar($id = 0)
    {
        $this->titulo = ($id) ? 'EDITAR PERFIL' : 'AGREGAR PERFIL';
        $configuracion=array();
        $this->acceso->valida('usuario', 'editar', 1);
        $rol = new Rol($id);
        $rel = $rol->from_array($_POST, array('nombre','descripcion' ));
        
        if ($rol->save($rel)) {
            $this->db->delete('acl', array('roles_id' => $id));
            
            if (is_array($this->input->post('permiso_id')))
                foreach ($this->input->post('permiso_id') as $indice => $acl) {
                    $this->db->insert('acl', array('roles_id' => $rol->id,'permisos_id' => $indice,'acl' => json_encode($acl) ));
                }
            
            $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
            redirect('modulo/rol/editar/' . $rol->id);
        } else {
            
            $permisos = new Permiso();
            $permisos->order_by('permiso', 'asc')->get();
        
            foreach ($permisos as $permiso) {
                if (isset($_POST['permiso_id'][$permiso->id]))
                    $configuracion[$permiso->id] = $_POST['permiso_id'][$permiso->id];
            }
            
            $this->layout_content=$this->load->view('rol/form',array('rol'=>$rol,'permisos'=>$permisos,'acl'=>$configuracion),true);
            $this->load->view('plantilla/backend/form');
        }
    }
    
    
    public function _busqueda($rol)
    {
        $rol->clear();
        $like_text = $this->session->userdata('rol_buscar');
        
        if ($like_text) {
            $rol->group_start()->or_like(array('id' => $like_text,'nombre' => $like_text,'descripcoin' => $like_text))->group_end();
        }
    }
    
    public function _ordenar($rol)
    {
        if (!$this->session->userdata('rol_ordenar'))
            $this->session->set_userdata('rol_ordenar', array('id','DESC'));
        $order = $this->session->userdata('rol_ordenar');
        $rol->order_by($order[0], $order[1]);
    }
    
    
    public function lista()
    {
        $this->titulo='PERFILES DE USUARIO';
        $this->acceso->valida('usuario', 'consultar', 1);
        
        //buscar
        if ($this->input->post('action_buscar')) {
            $this->session->set_userdata('rol_buscar', $this->input->post('buscar'));
        }
        
        //ordenar
        if ($this->input->post('ordenar')) {
            $order = $this->session->userdata('rol_ordenar');
            if ($this->input->post('ordenar') == $order[0] && $order[1] == 'ASC')
                $this->session->set_userdata('rol_ordenar', array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('rol_ordenar', array($this->input->post('ordenar'),'ASC'));
        }
        
        $rol = new Rol;
        $this->_busqueda($rol);
        $total_rows = $rol->where('is_enable', 1)->count();
        $pagina     = ($this->uri->segment(4)) ? $this->uri->segment(4) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $this->_busqueda($rol);
        $this->_ordenar($rol);
        $rol->limit($this->per_page, $limit)->where('is_enable', 1)->get();
        
        /*Paginador*/
        $configuracion_paginador                = $this->config->item('pagination');
        $configuracion_paginador['base_url']    = base_url('modulo/usuario/lista');
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);
        
        $this->layout_content=$this->load->view('grid', $data = array('roles' => $rol),true);
        $this->load->view('plantilla/backend/form');
    }
    
}