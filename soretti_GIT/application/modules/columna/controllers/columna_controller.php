<?php  
class Columna_controller extends MX_Controller
{
    protected $per_page=40;

	public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('pagina'); 
        $this->load->model("columna");
        $this->load->model("modulo/modulo");
        
    }

    public function index($vista,$id)
    {
        $this->load->library('mobiledetect/Mobile_Detect');
        $detect = new Mobile_Detect();
        $is_mobile = false;
        
        if( $detect->isMobile() || $detect->isTablet() ){
            $is_mobile = true;
        }

        $columna = new Columna($id);
        $elements = $columna->sort_elements(new Modulo());
        foreach ($elements as $key => $element) {
            if($element["posicion"] == 0){
                unset($elements[$key]);
            }
        }
        $this->load->view($vista,array('columna'=>$columna,'elements'=>$elements,'is_mobile'=>$is_mobile));
    }

    public function editar($columna_id)
    {
        $this->titulo='EDITAR COLUMNA';
        $this->acceso->valida('pagina','consultar',1);

        $columna = new Columna($columna_id); 
    
        $elements = $columna->sort_elements(new Modulo()); 
        $modulos_activos = array();
        $modulos_inactivos = array();

        foreach ($elements as $key => $element) {
            if($element['posicion']){
                $modulos_activos[] = $element;
            }else{
                $modulos_inactivos[] = $element;
            }
        }
        $data['modulos_inactivos'] = $modulos_inactivos;
        $data['columna'] = $columna;
        $data['modulos_activos'] = $modulos_activos;
        $this->layout_assets=array(
            'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
            'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/columna_editar.js'))
        );


        $this->layout_content = $this->load->view('form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    public function agregar($columna_id=0)
    {  
        $this->titulo='AGREGAR COLUMNA';
        $this->acceso->valida('pagina','consultar',1);

        $columna = new Columna($columna_id);  
    
        $elements = $columna->sort_elements(new Modulo());
        $modulos_activos = array();
        $modulos_inactivos = array();

        foreach ($elements as $key => $element) {
            if($element['posicion']){
                $modulos_activos[] = $element;
            }else{
                $modulos_inactivos[] = $element;
            }
        }
        $data['modulos_inactivos'] = $modulos_inactivos;
        $data['columna'] = $columna;
        $data['modulos_activos'] = $modulos_activos;

        $this->layout_assets=array(
            'css'=>array(base_url('pub/libraries/nestable-master/nestable.css')),
            'js'=>array(base_url('pub/libraries/nestable-master/jquery.nestable.js'), base_url('pub/libraries/trahctools/js/columna_editar.js'))
        );


        $this->layout_content = $this->load->view('form',$data,true);
        $this->load->view('plantilla/backend/form');
    }

    function guardar($id)
    {
        $this->acceso->valida('pagina','editar',1);
        $this->load->helper('file');
        $this->load->helper('url');

        $columna = new Columna($id);

        $columna->modulos=$this->input->post("lista_json_modulos");
        $columna->nombre=$this->input->post("nombre");
        $columna->save();

        $arr_lista = json_decode($this->input->post("lista_json_modulos"),true);

        $columna_file=$this->load->view('columna',array('columna'=>$columna,'elements'=>$arr_lista),true);
        $columna_file=str_replace("{{", "<?php ", $columna_file);
        $columna_file=str_replace("}}", "?> ", $columna_file);
        write_file(APPPATH.'modules/plantilla/views/'.strtolower(url_title($columna->nombre)).'.php',$columna_file, 'w+');

        redirect('modulo/columna/editar/'.$columna->id);
    }

    public function _busqueda($columna)
    {
        $columna->clear();

        $like_text=$this->session->userdata('columna_buscar');

        if($like_text){
            $columna->group_start()
                     ->or_like(array('id'=>$like_text,'titulo'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($columna)
    {
        if(!$this->session->userdata('columna_ordenar'))
            $this->session->set_userdata('columna_ordenar',array('id','DESC'));
        $order=$this->session->userdata('columna_ordenar');
        $columna->order_by($order[0],$order[1]);
    }


    public function listar(){
        $this->titulo='COLUMNAS';
        $this->acceso->valida('pagina','consultar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('columna_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('columna_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('columna_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('columna_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        $columna=new Columna;
        $this->_busqueda($columna);
        $total_rows=$columna->where('is_enable',1)->count();
        $pagina=($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($columna);
        $this->_ordenar($columna);
        $columna->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/columna/lista');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 4;
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content=$this->load->view('grid',$data=array('columnas'=>$columna),true);
        $this->load->view('plantilla/backend/form');
    }


    public function eliminar()
    {
        $this->acceso->valida('pagina','eliminar',1);
        $columna = new Columna();
        $columna->where_in('id', $this->input->post('post_ids'))->update('is_enable',0);
        $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
        redirect('modulo/columna/listar/');
    }

}