
<div>
  <img src="<?php echo base_url("pub/theme/img/logo.jpg")?>" alt="" style="margin:0 auto;">
</div>

<div style="font-family:Arial; font-size:13px; color:#5E5E5E">
    
    <h2>Registro de Organizaciones</h2>

    <div>
      
        <h4>Solicitud de servicio</h4>

        <div>
          <strong>Tipo de servicio requerido: </strong> <?php echo $this->input->post('tipo_sevicio') ?>
        </div>      

    </div>

    <div>
        <h4>Requerimiento</h4>

        <div>
          <strong>Titulo ó nombre de laposición ó cargo requerido: </strong> <?php echo $this->input->post('titulo') ?>
        </div>     
        <div>
          <strong>Lugar de trabajo: </strong> <?php echo $this->input->post('lugar_trabajo') ?>
        </div>       
        <div>
          <strong>Propósito y objetivos de la posición ó cargo requerido: </strong> <?php echo $this->input->post('objetivos') ?>
        </div>        
        <div>
          <strong>Tareas clave a realizar por el profesional: </strong> <?php echo $this->input->post('tareas') ?>
        </div>          
        <div>
          <strong>Experiencia requerida del profesional: </strong> <?php echo $this->input->post('experiencia') ?>
        </div>          
        <div>
          <strong>Conocimientos y certifiaciones clave requeridas por el profesional: </strong> <?php echo $this->input->post('conocimientos_certificaciones') ?>
        </div>           
        <div>
          <strong>Esquema de contratación ofrecida: </strong> <?php echo $this->input->post('esquema_contratacion') ?>
        </div>      

    </div>

    <div>
        <h4>Organización</h4>

        <div>
          <strong>Nombre ó Razón social: </strong> <?php echo $this->input->post('nombre_razon_social') ?>
        </div>     
        <div>
          <strong>Giro o Sector: </strong> <?php echo $this->input->post('giro') ?>
        </div>       
        <div>
          <strong>País: </strong> <?php echo $this->input->post('pais') ?>
        </div>        
        <div>
          <strong>Estado: </strong> <?php echo $this->input->post('estado') ?>
        </div>    

    </div>

    <div>
        <h4>Contacto</h4>

        <div>
          <strong>Nombre: </strong> <?php echo $this->input->post('nombre') ?>  <?php echo $this->input->post('apellido_paterno') ?>  <?php echo $this->input->post('apellido_materno') ?>
        </div>     
        <div>
          <strong>Puesto, Posición ó Cargo: </strong> <?php echo $this->input->post('puesto') ?>
        </div>       
        <div>
          <strong>Área ó Departamento: </strong> <?php echo $this->input->post('departamento') ?>
        </div>        
        <div>
          <strong>Teléfono: </strong> <?php echo $this->input->post('telefono') ?>
        </div>    
        <div>
          <strong>Usuario Skype: </strong> <?php echo $this->input->post('skype') ?>
        </div>    
        <div>
          <strong>Correo: </strong> <?php echo $this->input->post('email') ?>
        </div>    

    </div>






</div>