<?php
class Link_controller extends MX_Controller
{

	public function __construct()
    {
        parent::__construct();
    }
    public function agregar()
    {
        $this->titulo='LINK';

        $this->config->load('proyecto');
        
        $proyecto=$this->config->item('proyecto');

        $this->acceso->valida_login(1);

        $this->layout_assets=array(
            'js'=>array(base_url('pub/libraries/trahctools/js/link_editar.js'))
        );
        $this->layout_content=$this->load->view('link/form', array('config_proyecto'=> $proyecto),true );
        $this->load->view('plantilla/backend/form');

    } 
}
