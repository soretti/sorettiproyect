<?php
class Reporte4_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }


    public function _set_tem_rep()
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

            $this->db->query("DROP TABLE IF EXISTS temp_reporte4");
            $this->db->query("CREATE TEMPORARY TABLE `temp_reporte4` (
                      `nombre_producto` varchar(255) NOT NULL DEFAULT '0',
                      `numero_ventas` float,
                      `costo` float,
                      `total_costo` float
             )");
            
 

            $items=$this->db->query("SELECT SUM(items.cantidad) as total_vendidos,cat_precios.costo, SUM(items.cantidad*cat_precios.costo) as total, cat_productos.titulo FROM items
                LEFT JOIN cat_productos ON cat_productos.id=items.producto_id
                LEFT JOIN cat_precios ON cat_productos.id=cat_precios.producto_id
                LEFT JOIN orders on orders.id=items.order_id
                WHERE orders.pago_verificado = 1 AND total <> '' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and ( DATE( pago_verificado_fecha ) between '".$fecha_inicio."' AND '".$fecha_fin."') GROUP BY cat_productos.id 
            ")->result();

            
            foreach($items as $item)
            {
                        $this->db->insert('temp_reporte4',array(
                                'nombre_producto'=>$item->titulo,
                                'numero_ventas'=>$item->total_vendidos,
                                'costo'=>$item->costo,
                                'total_costo'=>$item->total
                        ));
            }
            //$tbl=$this->db->get('temp_reporte4')->result();
            //print_pre($tbl);
    }
  


    public function index()
    {   
        $this->_set_tem_rep(); 

        $byPage=20;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte4/index")."?";
        $pagination['total_rows'] = $this->db->count_all_results('temp_reporte4');
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

        $totales = $this->db->select('SUM(numero_ventas) as numero_ventas,SUM(total_costo) as total_costo')->get('temp_reporte4')->row();
 

        $this->titulo = 'REPORTE COSTO PRODUCTOS';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/costos',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$this->db->limit($byPage,$offset)->get('temp_reporte4')->result(),
                'totales'=>$totales,
                ),true);
        $this->load->view('plantilla/backend/form');
        
    }
    public function pdf()
    {   
        $this->_set_tem_rep(); 

        $byPage=20;
        $pagina=($this->input->get('pagina') && is_numeric($this->input->get('pagina')) && $this->input->get('pagina')>0) ? $this->input->get('pagina')-1 : 0;
        $offset=($pagina*$byPage);
        $pagination=$this->config->item('pagination');
        $pagination['base_url'] = site_url("tienda/backend/reporte4/index")."?";
        $pagination['total_rows'] = $this->db->count_all_results('temp_reporte4');
        $pagination['per_page'] = $byPage;
        $pagination['page_query_string'] = TRUE;
        $pagination['query_string_segment'] = 'pagina';
        $this->pagination->initialize($pagination);

        $totales = $this->db->select('SUM(numero_ventas) as numero_ventas,SUM(total_costo) as total_costo')->get('temp_reporte4')->row();
 

        $this->titulo = 'REPORTE COSTO PRODUCTOS';
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->layout_content   = $this->load->view('tienda/backend/comision/costos_pdf',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'reporte'=>$this->db->limit($byPage,$offset)->get('temp_reporte4')->result(),
                'totales'=>$totales,
                ),TRUE);

        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPageOrientation('L', $autopagebreak='', $bottommargin='');
 

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

        $pdf->Output('reporte_costo_productos.pdf', 'I');



    }


     public function excel(){
                $this->_set_tem_rep();
                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('REPORTE COSTO PRODUCTOS');
                //set cell A1 content with some text

                                            
                $this->excel->getActiveSheet()->setCellValue('A1', 'Nombre del producto');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Número de ventas');
                $this->excel->getActiveSheet()->setCellValue('C1', '%');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Costo unitario');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Total');
                $this->excel->getActiveSheet()->setCellValue('F1', '%');

                $reporte=$this->db->get('temp_reporte4')->result();
                $totales = $this->db->select('SUM(numero_ventas) as numero_ventas,SUM(total_costo) as total_costo')->get('temp_reporte4')->row();
                

                $fila=2;
                foreach ($reporte as $item)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->nombre_producto);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $item->numero_ventas);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, number_format(($item->numero_ventas*100)/$totales->numero_ventas,1)."%");
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, formato_precio($item->costo));
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, formato_precio($item->total_costo));
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, number_format(($item->total_costo*100)/$totales->total_costo,1)."%");
                    $fila++;
                }

                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $totales->numero_ventas);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, '');
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, formato_precio($totales->total_costo));
                    $this->excel->getActiveSheet()->setCellValue('F'.$fila, '');

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

                $filename='costo-productos.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');


     }

}