<?php
class Reporte2_controller extends MX_Controller
{
    public $per_page = 30;
    public function __construct()
    {
        parent::__construct();
        $this->acceso->carga_permisos('tienda');
        $this->load->model('tienda/order');
    }

    function _set_tem_rep($distribuidor_id)
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

        $this->db->select( "usuarios.id, nombre,apellidoPaterno,apellidoMaterno, descuentos.titulo as descuento_titulo, cupones.id as cupon_id, porcentaje" );
        $this->db->where('descuento_id <>','')->where('usuarios.id',$distribuidor_id)->where('usuarios.is_enable',1)->from('usuarios');
        $this->db->join('descuentos', 'usuarios.descuento_id = descuentos.id');
        $this->db->join('cupones', 'usuarios.cupon_id = cupones.id' );
        $distribuidor=$this->db->get()->row();

        $this->db->query("DROP TABLE IF EXISTS temp_reporte2");
        $this->db->query("CREATE TEMPORARY TABLE `temp_reporte2` (
                  `order_id` int(11),
                  `fecha` datetime,
                  `cupon` varchar(255) NOT NULL DEFAULT '0',
                  `total_compra` float,
                  `comision` float
                )");

            
            /*USUARIOS Subordinados*/
            $this->db->select('GROUP_CONCAT(cupon_id) as cupones')->where('usuario_id',$distribuidor->id)->from('subordinados');
            $this->db->join('usuarios', 'usuarios.id = subordinados.subordinado_id');
            $subordinados=$this->db->get()->row();
            $txtsubordinados = ($subordinados->cupones) ? $subordinados->cupones : '0';
            
            /*Monto de ventas del distribuidor*/
            //$comprasSubordinados=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `cupon_id` IN (".$txtsubordinados.") AND `cupon_id`<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 )")->row();
            //$comprasDirectas=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `usuario_id` = '".$distribuidor->id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 )")->row();
            //$comprasCupon=$this->db->query("SELECT SUM(total) as total FROM (`orders`) WHERE `cupon_id` = '".$distribuidor->cupon_id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 )")->row();
           
            
            /*Calcular las comisiones de las ordenes de compra del distribuidor*/
            $orderCupon=$this->db->query("SELECT * FROM (`orders`) WHERE `cupon_id` = '".$distribuidor->cupon_id."' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."')  ")->result();

            foreach ($orderCupon as $order) {
                    $comisionCupones=0;
                    $productos=$this->db->where('order_id',$order->id)->get('items')->result();
                    foreach ($productos as $producto) {
                        $precioVenta=precioVenta($producto->precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                        $precioDistribuidor=precioDistribuidor($producto->precio,$distribuidor->porcentaje);
                        $comisionCupones+=( ($precioVenta-$precioDistribuidor) * $producto->cantidad );  
                    }
                    /*Monto total de las compras*/
                    $this->db->insert('temp_reporte2',array(
                        'order_id'=>$order->id,
                        'fecha'=>$order->fecha_creacion,
                        'cupon'=>$order->cupon,
                        'total_compra'=>$order->total,
                        'comision'=>$comisionCupones
                    ));
            }

            /*Calcular las comisiones de las ordenes de compra de subordinados*/
            $orderCupon=$this->db->query("SELECT descuentos.porcentaje as usuario_descuentoPorcentaje, orders.id,orders.cuponPorcentaje, orders.mayoreoPorcentaje, usuarios.id as usuario_id FROM (`orders`)
                LEFT JOIN usuarios ON usuarios.cupon_id=orders.cupon_id
                LEFT JOIN descuentos ON usuarios.descuento_id=descuentos.id
                WHERE orders.cupon_id IN (".$txtsubordinados.") AND orders.cupon_id<>'' AND (`estatus` = 2 OR `estatus` = 3 OR `estatus` = 4 OR `estatus` = 5 ) and (orders.fecha_creacion between '".$fecha_inicio."' AND '".$fecha_fin."')  ")->result();

            
            
            foreach ($orderCupon as $order) {
                $comisionCuponesSubordinados=0;
                    $productos=$this->db->where('order_id',$order->id)->get('items')->result();
                    foreach ($productos as $producto) {
                        $precioVenta=precioVenta($producto->precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);
                        $precioDistribuidor=precioDistribuidor($producto->precio,$order->usuario_descuentoPorcentaje);
                        $precioDistribuidorPadre=precioDistribuidor($producto->precio,$distribuidor->porcentaje);
                        $comisionCuponesSubordinados+=( ($precioDistribuidor-$precioDistribuidorPadre) * $producto->cantidad );  
                    }

                    /*Monto total de las compras*/
                    $this->db->insert('temp_reporte2',array(
                        'order_id'=>$order->id,
                        'fecha'=>$order->fecha_creacion,
                        'cupon'=>$order->cupon,
                        'total_compra'=>$order->total,
                        'comision'=>$comisionCuponesSubordinados
                    )); 
            }



    }


    public function index($distribuidor_id)
    {
        $distribuidor=$this->db->where('id',$distribuidor_id)->get('usuarios')->row();

        $this->titulo = 'REPORTE COMISIONES '.strtoupper($distribuidor->nombre." ".$distribuidor->apellidoPaterno);
        $this->acceso->valida('tienda', 'consultar', 1);
        $this->_set_tem_rep($distribuidor_id);
        
        $total_comisiones=$this->db->select('SUM(total_compra) AS total_compra, SUM(comision) as total_comision ')->get('temp_reporte2')->row();

        $this->layout_content   = $this->load->view('tienda/backend/comision/distribuidor',
            array(
                'fecha_fin'=>$this->session->userdata('fecha_reporte_fin'),
                'fecha_inicio'=>$this->session->userdata('fecha_reporte_ini'),
                'distribuidor'=>$distribuidor,
                'reporte'=>$this->db->get('temp_reporte2')->result(),
                'totales'=>$total_comisiones
                ),true);
        $this->load->view('plantilla/backend/form');
    }


 function excel($distribuidor_id){

                $distribuidor=$this->db->where('id',$distribuidor_id)->get('usuarios')->row();

                $this->_set_tem_rep($distribuidor_id);

                $fecha_inicio=$this->session->userdata('fecha_reporte_ini');
                $fecha_fin=$this->session->userdata('fecha_reporte_fin');

                $this->load->library('excel');
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Comisiones distribuidor');
                //set cell A1 content with some text

                $this->excel->getActiveSheet()->setCellValue('A1', 'N° Orden');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Fecha');
                $this->excel->getActiveSheet()->setCellValue('C1', 'Cupón');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Total');
                $this->excel->getActiveSheet()->setCellValue('E1', 'Comisión');


                $contacto=$this->db->get('temp_reporte2')->result();

                $fila=2;
                foreach ($contacto as $item)
                {
                    $this->excel->getActiveSheet()->setCellValue('A'.$fila, $item->order_id);
                    $this->excel->getActiveSheet()->setCellValue('B'.$fila, $item->fecha);
                    $this->excel->getActiveSheet()->setCellValue('C'.$fila, $item->cupon);
                    $this->excel->getActiveSheet()->setCellValue('D'.$fila, $item->total_compra);
                    $this->excel->getActiveSheet()->setCellValue('E'.$fila, $item->comision);
                    $this->excel->getActiveSheet()->getStyle('D'.$fila)->getNumberFormat()->setFormatCode('\$ #,##0.00');
                    $this->excel->getActiveSheet()->getStyle('E'.$fila)->getNumberFormat()->setFormatCode('\$ #,##0.00');

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

                $filename='Comisiones distribuidor.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');


   
 }

}