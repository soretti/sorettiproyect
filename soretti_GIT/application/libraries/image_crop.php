<?php

class Image_crop
{
	public $upload_dir; /*ruta donde se guardara la imagen recordata*/
	public $generar_nueva_image=1;
    public $width;  
    public $height;  
    public $imagen; /* nombre de la imagen con ruta relativa  pub/uploads/prueba.jpg */
    public $crop_x; /* cordenada x para recortar imagen */
    public $crop_y; /* cordenada y para recortar imagen */
    private $CI;
    public $remplazar=0;

	function __construct(){
		$this->CI=& get_instance(); 
		$this->CI->load->library('image_lib');
	}

    function inicializar($imagen)
    {
        if(isset($imagen['width']))  $this->width=$imagen['width'];
        if(isset($imagen['height'])) $this->height=$imagen['height'];
        if(isset($imagen['imagen'])) $this->imagen=$imagen['imagen'];
        if(isset($imagen['crop_x'])) $this->crop_x=$imagen['crop_x'];
        if(isset($imagen['crop_y'])) $this->crop_y=$imagen['crop_y'];
        if(isset($imagen['upload_dir'])) $this->upload_dir=$imagen['upload_dir'];
        $part_image = pathinfo($this->imagen);  
        if(!$this->upload_dir) $this->upload_dir=$part_image['dirname'];        
    }

        /*
        @ancho1 ancho de la imagen
        @alto1 ancho de la imagen
        @ancho2 ancho requerido
        @alto2 alto requerido
        */

    function _obtenerFormato($ancho1, $alto1, $ancho2, $alto2){
            
        
        $alto_final=($ancho2 * $alto1) / $ancho1;
        
        if(!$alto2)
         return "width";
        
        if( $alto_final < $alto2 ) 
            return "width";
        else 
            return "height"; 

        
        // if($alto2){
        //     $fmt1 = $ancho1 / $alto1;
        //     $fmt2 = $ancho2 / $alto2;
        //     if($fmt1>1){
        //         if($fmt2>1){
        //             if($fmt1>$fmt2){
        //                 return "height";
        //             }else{
        //                 return "width";
        //             }
        //         }else{
        //             return "height";
        //         }
        //     }else{
        //         if($fmt2<1){
        //             if($fmt1>$fmt2){
        //                 return "height";
        //             }else{
        //                 return "width";
        //             }
        //         }else{
        //             return "width";
        //         }
        //     }
        // }else{
        //     return "width";
        // }
        
    }

	function escalar($tabla,$campo)
	{

        $part_image = pathinfo($this->imagen);

        list($o_ancho, $o_alto, $o_tipo, $o_atributos) = getimagesize($this->imagen);

        $config['master_dim'] = $this->_obtenerFormato($o_ancho,$o_alto,$this->width,$this->height);

        $config['image_library'] = 'GD2';
        $config['source_image'] = $this->imagen;
        $config['maintain_ratio'] = TRUE;

        if($this->height==0)
        	$this->height=round( ($o_alto*$this->width)/$o_ancho );

        if($this->width==0)
            $this->width=round( ($o_ancho*$this->height)/$o_alto );

               
        $key=md5($tabla.$campo.$part_image['dirname'].$this->width.$this->height);

        $nueva_imagen = $part_image['filename'].'_'.$key.'.'.$part_image['extension'];

        $config['new_image'] = $this->upload_dir."/".$nueva_imagen;

        $config['width'] = $this->width;
    
        $config['height']   = $this->height;

        $this->CI->image_lib->initialize($config);

        // if($this->width <= $o_ancho || $this->height <= $o_alto)
        if( $this->CI->image_lib->resize() )
        { 
            $this->imagen=$config['new_image'];
            return TRUE;
        }else{
            //$this->imagen=$config['new_image'];
        	return FALSE;
        }
	}

	function cortar()
	{
        
        // if(!$this->crop_x && !$this->crop_y){
        //     $info_image_resize=getimagesize($this->imagen);
        //     $this->crop_x=($info_image_resize[0]-$this->width)/2;
        //     $this->crop_y=($info_image_resize[1]-$this->height)/2;
        // }
         $info_image_resize=getimagesize($this->imagen);
         $this->crop_x='';
         $this->crop_y='';

		$config['image_library'] = 'gd2';
 		$config['source_image']	= $this->imagen;
		$config['x_axis'] = $this->crop_x;
		$config['y_axis'] = $this->crop_y;
		$config['maintain_ratio'] = FALSE;
		$config['width']  =  $this->width;
		$config['height'] =  $this->height;
		$this->CI->image_lib->initialize($config);


		if(  $this->CI->image_lib->crop() )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}
}