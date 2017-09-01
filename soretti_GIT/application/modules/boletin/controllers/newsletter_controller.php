<?php
class Newsletter_controller extends MX_Controller
{
    protected $per_page=30;

	public function __construct()
    {
        parent::__construct();
         $this->acceso->carga_permisos('boletin');
         $this->load->model('boletin/grupos');
         $this->load->model('boletin/boletin_newsletterstatus');
    }


    public function suscribe_sendblaster()
    {
        $proyecto=$this->config->item('proyecto');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email_newslatter', 'Email', 'required|valid_email');
        $datos['enviado']='';
        $datos['error']='';

        if($this->input->post('mnewsletterf') && $this->input->post('mnewsletterf')=='TRS6745-*1') if($this->form_validation->run())
        {
            if($this->input->post('email_fieldf')!=''){
                $datos['error']='Petición invalida';
                echo json_encode($datos);
            return false;
                
            }

            $this->load->model('boletin/boletin_usuarios');

            $boletin_usuario = new boletin_usuarios;
            $boletin_usuario->get_by_email($this->input->post('email_newslatter'));
            if(!$boletin_usuario->exists()){
                $boletin_usuario->email=$this->input->post('email_newslatter');
                $boletin_usuario->skip_validation()->save();

                /*Inscribirlo a send_blaster*/
                $send_blaster=$this->config->item('send_blaster','proyecto');
                if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Subscribe','','From: '.$boletin_usuario->email);
                $datos['enviado']='Gracias por suscribirte a nuestro newsletter';
            }
            echo json_encode($datos);
            return false;
        }
        $datos['error']='Escriba un email válido';
        echo json_encode($datos);
            return false;


    }

    public function agregar(){
            $this->titulo='AGREGAR NEWSLETTER';
            $this->acceso->valida('boletin','consultar',1);

            $data['news'] = new Newsletter();
            $data['news']->fecha_envio = addfecha(date('Y-m-d H:i:s'),1);

            $grupos=new Grupos();
            $data['grupos'] = $grupos->where('is_enable',1)->order_by('nombre asc')->get();
            foreach ($data['grupos'] as $key => $value) {
                //echo $value->id."<br>";
                $temp[] = $value->id;
            }
            if(isset($temp))$data['news']->grupos=implode(",", $temp);
            //print_r(expression)

            $cuentas=new Cuentas();
            $data['cuentas'] = $cuentas->order_by('email asc')->get();

            $this->layout_content=$this->load->view('boletin/news/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }

   public function editar($id)
        {
            $this->titulo='EDITAR NEWSLETTER';
            $this->acceso->valida('boletin','consultar',1);

            $data['news']=new Newsletter($id);

            $grupos=new Grupos();
            $data['grupos'] = $grupos->where('is_enable',1)->order_by('nombre asc')->get();

            $cuentas=new Cuentas();
            $data['cuentas'] = $cuentas->order_by('email asc')->get();

            $this->layout_content=$this->load->view('boletin/news/form',$data,true);
            $this->load->view('plantilla/backend/form');
        }

        public function eliminar()
        {
            $this->acceso->valida('boletin','eliminar',1);
            $news = new Newsletter();
            $news->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
            redirect('modulo/boletin/newsletter/listar/');
        }
     public function guardar($id=0){

            $this->titulo = ($id) ? 'EDITAR NEWSLETTER':'AGREGAR NEWSLETTER';

            if(!$_POST) show_error($this->lang->line('alert_request'));

            $this->acceso->valida('boletin','editar',1);

            $news=new Newsletter($id);


            $news->from_array($_POST);

            if($news->grupos)
            $news->grupos = implode(",",$news->grupos);

            if($news->save()){
                if(!$id){
                    $news->status = 1;
                }
                if($news->status == 1){
                    $boletin_newsletterstatus = new Boletin_newsletterstatus();
                    $boletin_newsletterstatus->where("newsletter_id",$news->id)->get();
                    $boletin_newsletterstatus->delete_all();
                    $grupos = explode(',',$news->grupos);
                    // $grupos="1";
                    foreach ($grupos as $key => $value) {
                        $suscriptor = new Boletin_usuarios();
                        $suscriptor->where("FIND_IN_SET('$value',grupos) != ", false);
                        $suscriptor->where("unsuscribed",0)->get();
                       foreach ($suscriptor as $susc){
                        $arr = array('boletin_usuarios_id'=>$susc->id, 'newsletter_id'=>$news->id);
                        $this->db->insert('boletin_newsletterstatus',$arr);
                      }
                    }
                }
                $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
                redirect('modulo/boletin/newsletter/editar/'.$news->id);
            }else{
                $data['news']=$news;

                if(!$news->fecha_envio){
                   $news->fecha_envio = addfecha(date('Y-m-d H:i:s'),1);
                }

                $grupos=new Grupos();
                $data['grupos'] = $grupos->where('is_enable',1)->order_by('nombre asc')->get();

                $cuentas=new Cuentas();
                $data['cuentas'] = $cuentas->order_by('email asc')->get();

                $this->layout_content=$this->load->view('boletin/news/form',$data,true);
                $this->load->view('plantilla/backend/form');
            }
        }

     public function _busqueda($news)
    {
        $news->clear();
        $like_text=$this->session->userdata('news_buscar');
        if($like_text){
            $news->group_start()
                     ->or_like(array('id'=>$like_text,'asunto'=>$like_text))
                     ->group_end();
        }
    }

    public function _ordenar($news)
    {
        if(!$this->session->userdata('news_ordenar'))
            $this->session->set_userdata('news_ordenar',array('id','DESC'));
            $order=$this->session->userdata('news_ordenar');

        $news->order_by($order[0],$order[1]);
    }

    public function listar(){
        $this->titulo='BOLETINES';
        $this->acceso->valida('boletin','editar',1);

        //buscar
        if($this->input->post('action_buscar')){
            $this->session->set_userdata('news_buscar',$this->input->post('buscar'));
        }

        //ordenar
        if($this->input->post('ordenar')){
            $order=$this->session->userdata('news_ordenar');
            if($this->input->post('ordenar')==$order[0] && $order[1]=='ASC')
                $this->session->set_userdata('news_ordenar',array($this->input->post('ordenar'),'DESC'));
            else
                $this->session->set_userdata('news_ordenar',array($this->input->post('ordenar'),'ASC'));
        }

        //$news=new Boletin_newsletterstatus;
        $news = new Newsletter();

        $this->_busqueda($news);
        $total_rows=$news->where('is_enable',1)->count();
        $pagina=($this->uri->segment(5)) ? $this->uri->segment(5)-1 : 0;
        $limit=($pagina*$this->per_page);
        $this->_busqueda($news);
        $this->_ordenar($news);
        $news->limit($this->per_page, $limit)->where('is_enable',1)->order_by('id','asc')->get();
        /*Paginador*/
        $configuracion_paginador=$this->config->item('pagination');
        $configuracion_paginador['base_url'] = base_url('modulo/boletin/newsletter/listar');
        $configuracion_paginador['total_rows'] = $total_rows;
        $configuracion_paginador['per_page'] = $this->per_page;
        $configuracion_paginador['uri_segment'] = 5;
        $this->pagination->initialize($configuracion_paginador);

        foreach ($news     as $item) {
            $item->total = $item->boletin_newsletterstatus->count();
            $item->enviados = $item->boletin_newsletterstatus->where('enviado',1)->count();
            $item->noenviados=($item->total)-( $item->enviados);
            $item->rechazados=$item->boletin_newsletterstatus->where('rechazado',1)->count();
            $item->unsuscribed=$item->boletin_newsletterstatus->where('unsuscribed',1)->count();
            $item->vistos=$item->boletin_newsletterstatus->where('visto',1)->count();
        }
        $this->layout_content=$this->load->view('boletin/news/grid',array('news'=>$news),true);
        $this->load->view('plantilla/backend/form');
    }

    public function cambiar_estatus($estatus, $id)
    {
        if($estatus == 1 || $estatus == 2){
            $news = new Newsletter($id);
            $news->status = $estatus;
            $news->save();
        }
        redirect('modulo/boletin/newsletter/editar/'.$id); 
    }

    public function unsuscribe()
    {
        $this->load->library('encrypt'); 
        $id = $this->input->get('unsuscribe');

        if($id){ 
            $id_decode = urldecode($this->encrypt->decode($id,'byetonews'));
            $id_arr = explode(' ', $id_decode);
            $usr = new Boletin_usuarios($id_arr[1]);
            if($usr->id){
                $usr->unsuscribed = 1;
                $usr->skip_validation()->save();
                $nstatus=$this->input->get('nstatus');
                if(is_numeric($nstatus)){
                    $status = new boletin_newsletterstatus($nstatus);
                    if($status->exists()){
                        $status->unsuscribed=1;
                        $status->skip_validation()->save();
                        /*Desuscribirlo a send_blaster*/
                        $send_blaster=$this->config->item('send_blaster','proyecto');
                        if( $send_blaster['estatus']==TRUE ) mail($send_blaster['suscribe_email'],'Unsubscribe','','From: '.$usr->email); 
                    }
                }


                $meta['titulo'] = "Newsletter";
                $this->load->view('plantilla/newsletter',array('email'=>$usr->email,'meta'=>$meta));
            }
         }
    }
}
