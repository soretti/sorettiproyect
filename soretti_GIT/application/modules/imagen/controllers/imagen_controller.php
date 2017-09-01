<?php

class Imagen_controller extends MX_Controller
{

	function __construct(){
		parent::__construct();
        $this->load->library('image_fit');
	}
	function prev_recortar()
	{

        $this->acceso->valida_login(1);

        $imagen=new Image_fit();
        $data['width']=$this->input->post('width');
        $data['height']=$this->input->post('height');
        $ruta_imagen=strstr($this->input->post('imagen'),"pub/uploads");
        $data['imagen']=$ruta_imagen;
        $data['imagen']=urldecode($data['imagen']);      
        $imagen->_inicializar($data);
        $imagen->upload_dir='pub/uploads/thumbs';

        //Retorna el nombre de la imagen escalada Image_fit::escalar();
        $data['imagen_escalada']=$imagen->escalar();
        if(!$data['imagen_escalada'])
        {
            $info_img=pathinfo($data['imagen']);
            $target_image=$imagen->upload_dir."/".$info_img['basename'];
            copy($data['imagen'],$target_image);
            $data['imagen_escalada']=$target_image;
        }

        //Si alto es 0 obtener el alto de la imagen
        if(!$data['height'])
        {
            $proporciones_imagen=getimagesize($data['imagen_escalada']);
            $data['height']=$proporciones_imagen[1];
        }
        if(!$data['width']){
            $proporciones_imagen=getimagesize($data['imagen_escalada']);
            $data['width']=$proporciones_imagen[0];

        }
        $data['original_height']=$this->input->post('height');

        $this->load->view("recortar",$data);
    }

    function recortar()
    {
         $this->acceso->valida_login(1);
         $crop_imagen=new Image_fit();
         $cordenadas=json_decode($this->input->post('cordenadas'));
         
         $data['imagen']=$this->input->post('imagen');
         $data['crop_x']=$cordenadas->x;
         $data['crop_y']=$cordenadas->y;
         $data['width']= $cordenadas->x2-$cordenadas->x;
         $data['height']=$cordenadas->y2-$cordenadas->y;
         $crop_imagen->_inicializar( $data );
         if($crop_imagen->cortar()==TRUE){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('response'=>'TRUE')));

        }else{

            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('response'=>'FALSE')));

        }
    }
}