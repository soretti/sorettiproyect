<?php
class Reporte5_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }


    public function _set_tem_rep($type=0)
    {       
            /*Rango de fechas si no existe  tomar el dia 15 del mes actual como fecha de corte y 15 del mes anterior como fecha de inicio*/
            if($this->input->post('fecha_ini') && $this->input->post('fecha_fin')){
                $this->session->set_userdata(array( 'fecha_reporte_ini'=>$this->input->post('fecha_ini'), 'fecha_reporte_fin'=>$this->input->post('fecha_fin') ));
            }

            if($this->session->userdata('fecha_reporte_ini') && $this->session->userdata('fecha_reporte_ini')){
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');
            }else{
                list($year,$month,$day)=explode("-",date('Y-m-d') );
                list($year_ini,$month_ini,$day_ini)=explode("-", date('Y-m-d',strtotime("-1 month")) ); 
                $fecha_inicio=$year_ini."-".$month_ini."-15";
                $fecha_fin=$year."-".$month."-15";
                $this->session->set_userdata(array( 'fecha_reporte_ini'=>$fecha_inicio, 'fecha_reporte_fin'=>$fecha_fin ));
            }

            $this->db->query("DROP TABLE IF EXISTS temp_reporte5");
            
            $this->db->query("CREATE TEMPORARY TABLE `temp_reporte5` (
                      `nombre_producto` varchar(255) NOT NULL DEFAULT '0',
                      `numero_ventas` float,
                      `precio` float,
                      `subtotal` float
             )");
            
 

            $items=$this->db->query("SELECT SUM(items.cantidad) as total_vendidos,cat_precios.costo, SUM(items.cantidad*items.precio) as total, cat_productos.titulo, items.precio FROM items
                LEFT JOIN cat_productos ON cat_productos.id=items.producto_id
                LEFT JOIN cat_precios ON cat_productos.id=cat_precios.producto_id
                LEFT JOIN orders on orders.id=items.order_id
                WHERE orders.pago_verificado = 1 AND orders.solicitud_factura=".$type." AND total <> '' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and ( DATE( pago_verificado_fecha ) between '".$fecha_inicio."' AND '".$fecha_fin."') 
                GROUP BY cat_productos.id, items.precio
            ")->result();

          
            foreach($items as $item)
            {
                    $this->db->insert('temp_reporte5',array(
                            'nombre_producto'=>$item->titulo,
                            'numero_ventas'=>$item->total_vendidos,
                            'precio'=>$item->precio,
                            'subtotal'=>$item->precio*$item->total_vendidos
                    ));
            }


            $fletes=$this->db->query("SELECT datos_pago FROM orders 
                WHERE orders.pago_verificado = 1 AND orders.solicitud_factura=".$type." AND total <> '' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and ( DATE( pago_verificado_fecha ) between '".$fecha_inicio."' AND '".$fecha_fin."') 
            ")->result();

            $total_fletes=0;
            foreach ($fletes as $flete) {
                $datos_flete=json_decode($flete->datos_pago);
                if($datos_flete->flete_gratis==0){
                    $total_fletes+=$datos_flete->flete;
                }
            }

            $this->db->insert('temp_reporte5',array(
                    'nombre_producto'=>'Flete',
                    'numero_ventas'=>0,
                    'precio'=> ($total_fletes*0.84),
                    'subtotal'=>($total_fletes*0.84)
            ));


            $this->db->insert('temp_reporte5',array(
                    'nombre_producto'=>'IVA Flete',
                    'numero_ventas'=>0,
                    'precio'=> ($total_fletes) * 0.16,
                    'subtotal'=>($total_fletes) * 0.16
            ));



            $descuentos=$this->db->query("SELECT SUM(items.precio * items.cantidad) as total_order, orders.id, cuponPorcentaje, mayoreoPorcentaje FROM orders 
                LEFT JOIN items ON items.order_id=orders.id 
                WHERE orders.pago_verificado = 1 AND orders.solicitud_factura=".$type." AND total <> '' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and ( DATE( pago_verificado_fecha ) between '".$fecha_inicio."' AND '".$fecha_fin."') 
                GROUP BY orders.id ")->result();

            $total_descuento=0;
            foreach ($descuentos as $descuento) {
                $descuento_importe=0;
                $total_order=$descuento->total_order;
                if(isset($descuento->cuponPorcentaje) & $descuento->cuponPorcentaje>0){
                        $descuento_importe=$total_order - ( ($descuento->cuponPorcentaje*$total_order)/100 );
                }
                if(isset($descuento->mayoreoPorcentaje) && $descuento->mayoreoPorcentaje>0){
                        $descuento_importe=($descuento_importe>0) ? $descuento_importe : $total_order;
                        
                        $descuento_importe=$descuento_importe - ( ($descuento->mayoreoPorcentaje*$descuento_importe)/100 );
                }
                if($descuento->cuponPorcentaje || $descuento->mayoreoPorcentaje){
                     $total_descuento+=($total_order-$descuento_importe);
                }
               
            }

            $this->db->insert('temp_reporte5',array(
                    'nombre_producto'=>'DESCUENTOS cupones/mayoreo',
                    'numero_ventas'=>0,
                    'precio'=> $total_descuento,
                    'subtotal'=>$total_descuento
            ));            


            $tbl=$this->db->get('temp_reporte5')->result();

    }
  


    public function index()
    {


        $byPage=50;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        // $pagination=$this->config->item('pagination');
        // $pagination['base_url'] = site_url("tienda/backend/reporte5/index")."?";
        // $pagination['total_rows'] = $this->db->count_all_results('temp_reporte5');
        // $pagination['per_page'] = $byPage;
        // $pagination['page_query_string'] = TRUE;
        // $pagination['query_string_segment'] = 'pagina';
        // $this->pagination->initialize($pagination);


        $this->_set_tem_rep(); 
        $reporte=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->limit($byPage,$offset)->get('temp_reporte5')->result();
        $flete=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
        $flete_iva=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
        $descuentos=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();

        $this->_set_tem_rep(1); 
        $reporte_facturado=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->limit($byPage,$offset)->get('temp_reporte5')->result();
        $flete_facturado=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
        $flete_iva_facturado=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
        $descuentos_facturado=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();





        //$totales = $this->db->select('SUM(numero_ventas) as numero_ventas,SUM(total_costo) as total_costo')->get('temp_reporte4')->row();
 

        $this->titulo = 'REPORTE VENTAS AL MOSTRADOR';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/ventas_mostrador',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$reporte,
                'flete'=>$flete,
                'flete_iva'=>$flete_iva,
                'descuentos'=>$descuentos,
                'reporte_facturado'=>$reporte_facturado,
                'flete_facturado'=>$flete_facturado,
                'flete_iva_facturado'=>$flete_iva_facturado,
                'descuentos_facturado'=>$descuentos_facturado
                // 'totales'=>$totales,
                ),true);
        $this->load->view('plantilla/backend/form');
        
    }

    public function pdf()
    {


        $byPage=50;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);

        $this->_set_tem_rep(); 
        $reporte=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->limit($byPage,$offset)->get('temp_reporte5')->result();
        $flete=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
        $flete_iva=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
        $descuentos=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();

        $this->_set_tem_rep(1); 
        $reporte_facturado=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->limit($byPage,$offset)->get('temp_reporte5')->result();
        $flete_facturado=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
        $flete_iva_facturado=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
        $descuentos_facturado=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();
 

        $this->titulo = 'REPORTE VENTAS AL MOSTRADOR';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/ventas_mostrador_pdf',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$reporte,
                'flete'=>$flete,
                'flete_iva'=>$flete_iva,
                'descuentos'=>$descuentos,
                'reporte_facturado'=>$reporte_facturado,
                'flete_facturado'=>$flete_facturado,
                'flete_iva_facturado'=>$flete_iva_facturado,
                'descuentos_facturado'=>$descuentos_facturado
                // 'totales'=>$totales,
                ),true);

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            // $pdf->setPageOrientation('L', $autopagebreak='', $bottommargin='');
     

            $pdf->SetTitle($this->titulo);
            $pdf->SetHeaderMargin(10);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(10);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);        
            $pdf->AddPage();
            // output the HTML content
            $pdf->writeHTML($this->layout_content, true, false, true, false, ''); 

            $pdf->Output('reporte_ventas.pdf', 'I');

        
    }

     public function excel(){
                $total1=0;
                $total2=0;
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('REPORTE VENTAS MOSTRADOR');
                //set cell A1 content with some text
   

                $this->_set_tem_rep();
                $reporte=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->result();
                $flete=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
                $flete_iva=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
                $descuentos=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();

                $this->_set_tem_rep(1);
                $reporte_facturado=$this->db->where('nombre_producto <>','Flete')->where('nombre_producto <>','IVA Flete')->where('nombre_producto <>','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->result();
                $flete_facturado=$this->db->where('nombre_producto','Flete')->get('temp_reporte5')->row();
                $flete_iva_facturado=$this->db->where('nombre_producto','IVA Flete')->get('temp_reporte5')->row();
                $descuentos_facturado=$this->db->where('nombre_producto','DESCUENTOS cupones/mayoreo')->get('temp_reporte5')->row();

                $fila=3;

                $this->excel->getActiveSheet()->setCellValue('A1', 'Ventas no facturadas');

                $this->excel->getActiveSheet()->setCellValue('A2', 'Producto');
                $this->excel->getActiveSheet()->setCellValue('B2', 'Cantidad');
                $this->excel->getActiveSheet()->setCellValue('C2', 'Precio mostrador');
                $this->excel->getActiveSheet()->setCellValue('D2', 'Importe');
                
                $total_ventas=0;
                $total_numero_ventas=0;
                foreach ($reporte as $item)
                {
                    $total_ventas+=$item->subtotal;
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->nombre_producto);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $item->numero_ventas);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, formato_precio($item->precio));
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($item->subtotal));
                    $fila++;
                }

                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Subtotal');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($total_ventas));
                    $fila++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Descuentos/Cupones/Mayoreo');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, '- '.formato_precio($descuentos->precio));
                    $fila++;
                                      
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Fletes');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($flete->precio));
                    $fila++;  
                                                        
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Fletes IVA');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($flete_iva->precio));
                    $fila++; 

                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Total');
                    $total1=($total_ventas+$flete->precio+$flete_iva->precio)-$descuentos->precio;
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($total1));
                    $fila++;
                    $fila++;
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, 'Ventas facturadas');

                    $fila++;



                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, 'Producto');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, 'Cantidad');
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Precio mostrador');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, 'Importe');
                    $fila++;

                    $total_ventas=0;
                    $total_numero_ventas=0;
                    foreach ($reporte_facturado as $item)
                    {
                        $total_ventas+=$item->subtotal;
                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->nombre_producto);
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, $item->numero_ventas);
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, formato_precio($item->precio));
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($item->subtotal));
                        $fila++;
                    }

                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Subtotal');
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($total_ventas));
                        $fila++;
                        
                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Descuentos/Cupones/Mayoreo');
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, '- '.formato_precio($descuentos->precio));
                        $fila++;
                                          
                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Fletes');
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($flete->precio));
                        $fila++;  
                                                            
                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Fletes IVA');
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($flete_iva->precio));
                        $fila++; 

                        $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('B'.$fila, '');
                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Total');
                        $total2=($total_ventas+$flete_facturado->precio+$flete_iva_facturado->precio)-$descuentos_facturado->precio;
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($total2));
                        $fila++;
                        $fila++;
                        $fila++;

                        $this->excel->getActiveSheet()->setCellValue('C'.$fila, 'Total de ventas: ');
                        $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($total2+$total1));

                    // $this->excel->getActiveSheet()->setCellValue('E'.$fila, formato_precio($totales->total_costo));
                    // $this->excel->getActiveSheet()->setCellValue('F'.$fila, '');

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

                $filename='ventas-mostrador.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');


     }

}