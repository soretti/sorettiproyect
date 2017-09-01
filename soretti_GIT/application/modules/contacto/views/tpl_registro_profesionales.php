
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Soretti | Registro de Profesionales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="font-family:Arial;">

<div style="font-size:16px; color:#5E5E5E">

    <table style="background-color: #fff">
      <tbody>
        <tr>
          <td width="10%"></td>
          <td></td>
          <td width="10%"></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <table border="0" cellpadding="0" cellspacing="0">
              <caption style="padding: 15px 0px; color: #000040">Hola <span style="font-weight: 700; font-style: italic;">Antonio,</span> se ha registrado un nuevo especialista:</caption>
              <thead>
                <tr style="background-color: #000040; text-align: left;">
                  <th colspan="2" style="padding: 6px 0px 6px 15px; color:white; font-size: 20px">
                    <img src="http://www.soretti.com.mx/pub/theme/img/logo2.png" alt="" style="margin:0 auto;width: 80px; ">&nbsp;|&nbsp;&nbsp;Registro de Prospecto</th>
                </tr>
              </thead>
              <tbody>
                <tr style="background-color:#fff">
                  <td style="padding: 4px 12px; border-top:1px solid #ddd;"><strong>Nombre:</strong></td>
                  <td style="padding: 0px 12px; border-top:1px solid #ddd"><?php echo $this->input->post('nombre').' '.$this->input->post('apellido_paterno').' '.$this->input->post('apellido_materno'); ?></td>
                </tr>
                <tr style="background-color:#f4f4f4">
                  <td style="padding: 4px 12px; border-top:1px solid #ddd;">
                    <strong>Área de desarrollo profesional:</strong>
                  </td>
                  <td style="padding: 0px 12px; border-top:1px solid #ddd">
                    <?php echo $this->input->post('desarrollo_profesional'); ?>
                  </td>
                </tr>
                 <tr style="background-color:#fff">
                  <td style="padding: 4px 12px; border-top:1px solid #ddd;"><strong>Especialidad:</strong></td>
                  <td style="padding: 0px 12px; border-top:1px solid #ddd">
                    <?php echo $this->input->post('especialidad'); ?>
                  </td>
                </tr>
                 <tr style="background-color:#f4f4f4">
                  <td style="padding: 4px 12px; border-top:1px solid #ddd;"><strong>Estado:</strong></td>
                  <td style="padding: 0px 12px; border-top:1px solid #ddd"><?php echo $this->input->post('estado'); ?></td>
                </tr>
              </tbody>
            </table>

          </td>
          <td></td>
        </tr>
        <tr>
          <td style="height: 25px"></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

</div>
</body>
</html>