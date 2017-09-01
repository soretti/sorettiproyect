<?php

class Image_fit
{
	public $upload_dir; /*ruta donde se guardara la imagen recordata*/
	public $generar_nueva_image=1;
    public $width;  
    public $height;  
    public $imagen; /* nombre de la imagen con ruta relativa  pub/uploads/prueba.jpf */
    public $crop_x; /* cordenada x para recortar imagen */
    public $crop_y; /* cordenada y para recortar imagen */
    private $CI;
    public $remplazar=0;

	function __construct(){
		$this->CI=& get_instance(); 
		$this->CI->load->library('image_lib');
	}

    function _inicializar($imagen)
    {
        if(isset($imagen['width']))  $this->width=$imagen['width'];
        if(isset($imagen['height'])) $this->height=$imagen['height'];
        if(isset($imagen['imagen'])) $this->imagen=$imagen['imagen'];
        if(isset($imagen['crop_x'])) $this->crop_x=$imagen['crop_x'];
        if(isset($imagen['crop_y'])) $this->crop_y=$imagen['crop_y'];
        $part_image = pathinfo($this->imagen);  
        $this->upload_dir=$part_image['dirname'];        
    }

    function _obtenerFormato($ancho1, $alto1, $ancho2, $alto2){
        if($alto2){
            $fmt1 = $ancho1 / $alto1;
            $fmt2 = $ancho2 / $alto2;
            if($fmt1>1){
                if($fmt2>1){
                    if($fmt1>$fmt2){
                        return "height";
                    }else{
                        return "width";
                    }
                }else{
                    return "height";
                }
            }else{
                if($fmt2<1){
                    if($fmt1>$fmt2){
                        return "height";
                    }else{
                        return "width";
                    }
                }else{
                    return "width";
                }
            }
        }else{
            return "width";
        }
    }

	function escalar()
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

        $nueva_imagen = $part_image['filename'].'_'.$this->width.'x'.$this->height.'.'.$part_image['extension'];

               
         $key=md5($this->CI->input->post('modulo').$this->CI->input->post('campo').$part_image['dirname'].$this->width.$this->height);

        $nueva_imagen = $part_image['filename'].'_'.$key.'.'.$part_image['extension'];

        // $n=1; while (file_exists($this->upload_dir."/".$nueva_imagen)) {
        //     $nueva_imagen = $rename."_".$part_image['filename'].'_'.$this->width.'x'.$this->height.'-'.$n.'.'.$part_image['extension'];
        //     $n++;
        // }

        // if($this->generar_nueva_image) $config['new_image'] = $this->upload_dir."/".$nueva_imagen;
        $config['new_image'] = $this->upload_dir."/".$nueva_imagen;

        $config['width'] = $this->width;
    
        $config['height']   = $this->height;

        $this->CI->image_lib->initialize($config);

        if($this->width <= $o_ancho || $this->height <= $o_alto)
        if( $this->CI->image_lib->resize())
        {
        	return $config['new_image'];
        }else{
        	return FALSE;
        }
	}

	function cortar()
	{
 
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