<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filemanager_controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
     
    public function index()
    {
        $this->acceso->valida_login(1);
 
        $this->load->view('filemanager/elfinder');
    }
     
    public function load_elfinder()
    {
        $this->acceso->valida_login(1);
        $this->load->helper('path');


        $opts = array(
        'roots' => array(
          array(
            'driver' => 'LocalFileSystem',
            'path'   => set_realpath('pub/uploads/'),
            'startPath'  => set_realpath('pub/uploads/imagenes/'),
            'uploadAllow'  => array(
                'image/jpeg',
                'image/gif',
                'image/png',
                'text',
                'application/pdf',
                'application/vnd.ms-word',
                'application/vnd.ms-excel',
                'application/vnd.ms-powerpoint',
                'application/x-shockwave-flash',
                'audio/mpeg',
                'audio/x-ms-wma',
                'video/mp4',
                'video/mpeg',
                'video/x-flv',
                'video/ogg',
                'video/x-msvideo'
                ),
            'uploadDeny'   => array('all'),
            'uploadOrder'  => 'deny,allow',
            'attributes' => array(
                    array(
                        'pattern' => '/.tmb/',
                        'read'    => true,
                        'write'   => true,
                        'locked'  => false,
                        'hidden'  => true,
                    ),
                     array(
                        'pattern' => '/cache/',
                        'read'    => false,
                        'write'   => true,
                        'locked'  => false,
                        'hidden'  => true,
                    ),
                     array(
                        'pattern' => '/thumbs/',
                        'read'    => false,
                        'write'   => true,
                        'locked'  => false,
                        'hidden'  => true,
                    )
                ),
            'URL'    => base_url('pub/uploads/')
          )
        )
        );


        $this->load->library('elfinder_lib', $opts);
    }
}