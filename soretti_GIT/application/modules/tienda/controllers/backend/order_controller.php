<?php
class Order_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        $this->acceso->carga_permisos('orders');
        $this->load->model('tienda/order');
    } 


    public function _busqueda($order)
    {
        $order->clear();
        $like_text = $this->session->userdata('order_buscar');
        if ($like_text) {
            $status=$this->config->item('status_tienda','proyecto');
            $like_text_status=(array_search($like_text,$status)) ? array_search($like_text,$status) : $status;
            $order->group_start()->or_like(array(
                'id' => $like_text,
                'estatus' => $like_text_status,
            ))->or_like_related_usuario('nombre', $like_text)->or_like_related_usuario('apellidoPaterno', $like_text)->or_like_related_usuario('apellidoMaterno', $like_text)->group_end();
        }
    }
    public function _ordenar($order_object)
    {
        if (!$this->session->userdata('order_ordenar'))
            $this->session->set_userdata('order_ordenar', array(
                'id',
                'DESC'
            ));
        $order = $this->session->userdata('order_ordenar');
        if ($order[0] == 'usuario')
           $order_object->order_by_related_usuario('nombre', $order[1]);
        else
            $order_object->order_by($order[0], $order[1]);
    }



    /**CRUD**/
    public function listar()
    {

        $this->titulo = 'ORDENES';
        $this->acceso->valida('orders', 'consultar', 1);
        $usuario=new usuario($this->session->userdata('logged_user'));

        if($_POST){
            if($this->input->post('activar_busqueda_fecha')) $this->session->set_userdata(array( 'busqueda_x_fecha_pago'=>$_POST['activar_busqueda_fecha'] ));
            else $this->session->set_userdata(array( 'busqueda_x_fecha_pago'=>'' ));
        }

        /*Rango de fechas si no existe  tomar el dia 15 del mes actual como fecha de corte y 15 del mes anterior como fecha de inicio*/
        if($this->input->post('fecha_ini') && $this->input->post('fecha_fin')){
            $this->session->set_userdata(array( 'fecha_reporte_ini'=>$this->input->post('fecha_ini'), 'fecha_reporte_fin'=>$this->input->post('fecha_fin') ));
        }

        if($this->session->userdata('fecha_reporte_ini') && $this->session->userdata('fecha_reporte_ini')){
            $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
            $fecha_fin=$this->session->userdata('fecha_reporte_fin');
        }else{
            list($year,$month,$day)=explode("-",date('Y-m-d') );
            //list($year_ini,$month_ini,$day_ini)=explode("-", date('Y-m-d',strtotime("-1 month")) ); 

            $total_dias=cal_days_in_month(1,$month,$year);

            $fecha_inicio=$year_ini."-".$month."-01";
            $fecha_fin=$year."-".$month."-".$total_dias;
            $this->session->set_userdata(array( 'fecha_reporte_ini'=>$fecha_inicio, 'fecha_reporte_fin'=>$fecha_fin ));
        }

        //buscar
        if ($this->input->post('action_buscar')) {
            $this->session->set_userdata('order_buscar', $this->input->post('buscar'));
        }

        //ordenar
        if ($this->input->post('ordenar')) {
            $order = $this->session->userdata('order_ordenar');
            if ($this->input->post('ordenar') == $order[0] && $order[1] == 'ASC')
                $this->session->set_userdata('order_ordenar', array(
                    $this->input->post('ordenar'),
                    'DESC'
                ));
            else
                $this->session->set_userdata('order_ordenar', array(
                    $this->input->post('ordenar'),
                    'ASC'
                ));
        }
        $order = new Order;
        $this->_busqueda($order);  
        if($usuario->rol_id==15){
            $order->group_start();
            $order->where('estatus',3);
            $order->or_where('estatus',4);
            $order->or_where('estatus',5);
            $order->group_end();
        }else{
            $order->where('estatus <>',0);
        }
        if($this->session->userdata('busqueda_x_fecha_pago')) $order->where("DATE(orders.pago_verificado) BETWEEN '{$fecha_inicio}' AND '{$fecha_fin}'");
        $total_rows = $order->count();

        $pagina     = ($this->uri->segment(6)) ? $this->uri->segment(6) - 1 : 0;
        $limit      = ($pagina * $this->per_page);
        $this->_busqueda($order);
        $this->_ordenar($order);
        $order->include_related('usuario');
        if($usuario->rol_id==15){
            $order->group_start();
            $order->where('estatus',3);
            $order->or_where('estatus',4);
            $order->or_where('estatus',5);
            $order->group_end();
        }else{
            $order->where('estatus <>',0);
        }
        if($this->session->userdata('busqueda_x_fecha_pago')) $order->where("DATE(orders.pago_verificado_fecha) BETWEEN '{$fecha_inicio}' AND '{$fecha_fin}'");
        $order->limit($this->per_page, $limit)->order_by('id', 'desc')->get();

        /*Paginador*/
        $configuracion_paginador                = $this->config->item('pagination');
        $configuracion_paginador['base_url']    = base_url('modulo/tienda/backend/order/listar');
        $configuracion_paginador['total_rows']  = $total_rows;
        $configuracion_paginador['per_page']    = $this->per_page;
        $configuracion_paginador['uri_segment'] = 6;
        $this->pagination->initialize($configuracion_paginador);
        $this->layout_content = $this->load->view('tienda/backend/order/listar',array('orders'=>$order,'fecha_inicio'=> $fecha_inicio,'fecha_fin'=>$fecha_fin,'status_tienda'=>$this->config->item('status_tienda','proyecto')), true);
        $this->load->view('plantilla/backend/form');
    }

     public function excel(){
            $this->acceso->valida('orders', 'consultar', 1);
            $usuario=new usuario($this->session->userdata('logged_user'));
        
            if($this->session->userdata('fecha_reporte_ini') && $this->session->userdata('fecha_reporte_ini')){
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');
            }else{
                list($year,$month,$day)=explode("-",date('Y-m-d') );
                //list($year_ini,$month_ini,$day_ini)=explode("-", date('Y-m-d',strtotime("-1 month")) ); 

                $total_dias=cal_days_in_month(1,$month,$year);

                $fecha_inicio=$year_ini."-".$month."-01";
                $fecha_fin=$year."-".$month."-".$total_dias;
                $this->session->set_userdata(array( 'fecha_reporte_ini'=>$fecha_inicio, 'fecha_reporte_fin'=>$fecha_fin ));
            }

            $order = new Order;
            $this->_busqueda($order);
            $this->_ordenar($order);
            $order->include_related('usuario');
            if($usuario->rol_id==15){
                $order->group_start();
                $order->where('estatus',3);
                $order->or_where('estatus',4);
                $order->or_where('estatus',5);
                $order->group_end();
            }else{
                $order->where('estatus <>',0);
            }
            if($this->session->userdata('busqueda_x_fecha_pago')) $order->where("DATE(orders.pago_verificado_fecha) BETWEEN '{$fecha_inicio}' AND '{$fecha_fin}'");
            $order->order_by('id', 'desc')->get();

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('REPORTE PEDIDOS');
                //set cell A1 content with some text

                                            
                $this->excel->getActiveSheet()->setCellValue('A1', 'ID');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Usuario');
                $this->excel->getActiveSheet()->setCellValue('C1', 'Fecha creacion');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Fecha pago');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Guia');
                $this->excel->getActiveSheet()->setCellValue('F1', 'Pago verificado');
                $this->excel->getActiveSheet()->setCellValue('G1', 'Pago verificado estatus');
                $this->excel->getActiveSheet()->setCellValue('H1', 'Estatus del pedido');
                $this->excel->getActiveSheet()->setCellValue('I1', 'Importe');

                $fila=2;
                $status_tienda=$this->config->item('status_tienda','proyecto');             
                foreach ($order as $item)
                {
                    $datos_pago=json_decode($item->datos_pago);
                    $datos_envio=json_decode($item->datos_envio);

                    $txt_usuario='';
                    $txt_fecha1='';
                    $txt_fecha2='';
                    $txt_usuario.=$item->usuario_nombre." ".$item->usuario_apellidoPaterno." ".$item->usuario_apellidoMaterno;
                    
                    if($item->numero_compra){
                      $txt_usuario.="{$datos_envio->nombre} {$datos_envio->apellidoPaterno} {$datos_envio->apellidoMaterno}";
                      $txt_usuario.="#{$item->numero_compra}";
                    }
                    if($item->pago_fecha!='0000-00-00 00:00:00') $txt_fecha1=$this->dateutils->datees(strtotime($item->pago_fecha),'C','c','m');
                    if($item->pago_verificado_fecha!='0000-00-00 00:00:00') $txt_fecha2=$this->dateutils->datees(strtotime($item->pago_verificado_fecha),'C','c','m');

                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->id);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $txt_usuario);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, $this->dateutils->datees(strtotime($item->fecha_creacion),'C','c','m'));
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, $txt_fecha1);
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, $item->numero_guia);
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, $txt_fecha2);
                    $this->excel->getActiveSheet()->setCellValue('G'.$fila, ($item->pago_verificado==1) ? "Si" : "No" );
                    $this->excel->getActiveSheet()->setCellValue('H'.$fila, $status_tienda[$item->estatus]);
                    $this->excel->getActiveSheet()->setCellValue('I'.$fila, formato_precio($datos_pago->total));
                    $fila++;
                }

                  

                //change the font size
                //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
                //make the font become bold
                //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
                //$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

                //merge cell A1 until D1
                //$this->excel->getActiveSheet()->mergeCells('A1:D1');
                //set aligment to center for that merged cell (A1 to D1)
                //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $filename='pedidos.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');


     }

    public function guardar($id = 0)
    {
        $usuario=new usuario($this->session->userdata('logged_user'));   
        $this->titulo = ($id) ? 'EDITAR ORDEN' : 'AGREGAR PRODUCTO';
        if (!$_POST)show_error($this->lang->line('alert_request'));
        $this->acceso->valida('orders', 'editar', 1);
        $order    = new Order($id);
 
        //if($_POST['pago_referencia']==0 || !$_POST['pago_referencia']) $_POST['pago_referencia']='';
        //if($_POST['costo_flete']==0 || !$_POST['costo_flete']) $_POST['costo_flete']='';
      
    
        $order->validation['estatus']=array('rules' => array('required'));
        $order->validation['pago_fecha']=array('rules' => array('date'));
        $order->validation['pago_verificado_fecha']=array('rules' => array('date'));
        $order->validation['fecha_creacion']=array('rules' => array('date'));
        


        $campos = array(
            'estatus',
            'flete_id',
            'numero_guia',
            'costo_flete',
            'pago_fecha',
            'fecha_creacion',
            'pago_referencia',
            'pago_verificado',
            'pago_verificado_fecha',
            'numero_compra'
            
        );
        if($usuario->rol_id==15 && ($order->estatus==4 OR $order->estatus==3 OR $order->estatus==5)){
            $campos = array(
                'estatus',
                'flete_id',
                'numero_guia',
                'costo_flete'
            );
        }
        $order->from_array($_POST, $campos);

        if($order->estatus==4 || $order->estatus==5){
            $order->validation['numero_guia']=array('rules' => array('required'));
             // $order->validation['costo_flete']=array('rules' => array('required'));           
             $order->validation['flete_id']=array('rules' => array('required'));           
        }

         if($order->estatus==2 || $order->estatus==3 || $order->estatus==4 || $order->estatus==5){
            $order->validation['pago_fecha']=array('rules' => array('required','date'));
            $order->validation['pago_referencia']=array('rules' => array('required'));                
         }


        $order->force_validation()->validate();

        if ($order->valid) {
            if($order->estatus==5 && $order->entrega_fecha!='0000-00-00 00:00:00') $order->entrega_fecha=date('Y-m-d H:i:s');
            if($this->input->post('precioFlete'))
            {
                 if(is_numeric($this->input->post('precioFlete')))
                 {
                     $order_pago=json_decode($order->datos_pago,true);
                     $order->total=$order->total-$order_pago['flete'];
                     $order->total=  $order->total + $this->input->post('precioFlete');
                     $order_pago['flete']=$this->input->post('precioFlete');
                     $order_pago['total']=$order->total;
                     $order->datos_pago=json_encode($order_pago);
                 }   
            }

            $order->save();


            if($this->input->post('enviarEmail')){
                modules::run('tienda/checkout/_enviar_mail',$order->id);
            }
            
            $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
            redirect('tienda/backend/order/editar/' . $order->id);
        } else {
            $data['order'] = $order;
            $data_mail=$this->config->item('send_mail_tienda','proyecto');
            $data['email'] = $data_mail['smtp_user'];
            $data['order'] = $order;
            $data['usuario'] = $usuario;
            $data['status_tienda'] = $this->config->item('status_tienda','proyecto');
            if($usuario->rol_id==15){
                unset($data['status_tienda'][1]);
                unset($data['status_tienda'][2]);
                // unset($data['status_tienda'][3]);
                unset($data['status_tienda'][6]);
             }

            $data['metodos_de_pago'] =  $this->config->item('metodos_pago','proyecto');
            $data['banco']    = json_decode($order->datos_banco);
            $data['pago']    =json_decode($order->datos_pago);
            $fletes= new Flete();
            $data['fletes']=$fletes->order_by('titulo ASC')->get();
            $this->layout_content = $this->load->view('tienda/backend/order/form', $data, true);
            $this->load->view('plantilla/backend/form');
        }
    }
    
    public function editar($id)
    {
        $usuario=new usuario($this->session->userdata('logged_user'));

        $this->titulo = 'EDITAR Orden';
        $this->acceso->valida('orders', 'consultar', 1);
        $order= new Order();
        $order->include_related('usuario');
        $order->where('id',$id)->get();
        if(!$order->pago_fecha || $order->pago_fecha=='0000-00-00 00:00:00') $order->pago_fecha=date('Y-m-d H:i:s');
        if($usuario->rol_id==15 && ($order->estatus!=4 && $order->estatus!=3 && $order->estatus!=5)){
            show_error('Permisos insuficientes');
        }

        $fletes= new Flete();
        $data['fletes']=$fletes->order_by('titulo ASC')->get();

        $data_mail=$this->config->item('send_mail_tienda','proyecto');
        $data['email'] = $data_mail['smtp_user'];
        $data['order'] = $order;
        $data['status_tienda'] = $this->config->item('status_tienda','proyecto');
         if($usuario->rol_id==15){
            unset($data['status_tienda'][1]);
            unset($data['status_tienda'][2]);
            // unset($data['status_tienda'][3]);
            unset($data['status_tienda'][6]);
         }
        $data['metodos_de_pago'] =  $this->config->item('metodos_pago','proyecto');
        $data['envio'] =  $order->datos_envio;
        $data['banco']    = json_decode($order->datos_banco);
        $data['pago']    =json_decode($order->datos_pago);
        $data['usuario']    =$usuario;
        $this->layout_content   = $this->load->view('tienda/backend/order/form', $data, true);
        $this->layout_assets=array();
        $this->load->view('plantilla/backend/form');
    }
 
    public function eliminar()
    {
        $this->acceso->valida('orders', 'eliminar', 1);
        $order = new Order();
        $order->where_in('id', $this->input->post('post_ids'))->get()->delete_all();
        $this->session->set_flashdata('mensaje', $this->lang->line('alert_save'));
        redirect('tienda/backend/order/listar');
    }
 
}
