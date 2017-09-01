<style>
.porcentaje{
<?php if($cupon->descuento>9) {?>
        font-size:60px; line-height: 60px; 
<?php } else {?>
    font-size:75px; line-height: 60px; 
<?php } ?>
text-align:center; color:#faa524; font-weight:bold;
}
.descuento{
color:#575757; text-align:center; font-weight:lighter; font-size:10px;  line-height: 13px;
}
.compras{
color:#575757; font-size:12px;  text-align:right;  line-height: 12px; text-decoration: underline;
}
.codigo{
text-align:center; color:#90B74D; text-align:center; font-size:8px; margin:0px; line-height: 14px;
}
.cupon{
    text-align:center; color:#C50707; text-align:center; font-size:10px; line-height: 15px; border:1px dashed #C50707;
}
.link{
font-size:8px; text-align:center; color:#faa524;  line-height: 5px
}
.borde{
    background-color: #EEEEEE;
}
.encabezado{
    color: #FFFFFF;
    background-color: #80B521;
    font-weight: bold;
    line-height: 20px;
    font-size: 11px;
}
.productos{
    font-size: 8px;
    font-weight: normal;line-height: 10px;
}
.pagina{
 font-weight: bold; 
}
table{
    margin:0; padding: 0;
} 
</style>
<table cellpadding="0" cellspacing="8"  border="0">
    <?php for ($i=0; $i <5 ; $i++) {?>
    <tr>
        <td class="borde"><div class="encabezado">&nbsp; &nbsp;CUPÓN DE DESCUENTO ELECTRÓNICO &nbsp;&nbsp;</div>
            <table cellpadding="2" cellspacing="0"  border="0">
                <tr>
                    <td width="40%">
                        <div class="porcentaje"><?php echo $cupon->descuento ?><span style="<?php echo($cupon->descuento>9) ? "font-size:35px;" : "font-size:50px;";  ?>">%</span></div>
                    </td>
                    <td width="60%"> <div class="descuento">Solo ingresa a nuestra tienda virtual <span class="pagina">www.algaespirulina.mx</span> y compra con el código: <br><div class="cupon"><?php echo $cupon->cupon ?></div></div></td>
                </tr>
            </table><img src="<?php echo base_url('pub/theme/img/cesped.png'); ?>" alt=""></td>
        <td class="borde"><div class="encabezado">&nbsp; &nbsp;CUPÓN DE DESCUENTO ELECTRÓNICO &nbsp;&nbsp;</div>
            <table cellpadding="2" cellspacing="0"  border="0">
                <tr>
                    <td width="40%">
                        <div class="porcentaje"><?php echo $cupon->descuento ?><span style="<?php echo($cupon->descuento>9) ? "font-size:35px;" : "font-size:50px;";  ?>">%</span></div>
                    </td>
                    <td width="60%"> <div class="descuento">Solo ingresa a nuestra tienda virtual <span class="pagina">www.algaespirulina.mx</span> y compra con el código: <br><div class="cupon"><?php echo $cupon->cupon ?></div></div></td>
                </tr>
            </table><img src="<?php echo base_url('pub/theme/img/cesped.png'); ?>" alt=""></td>
    </tr>
    <?php } ?>
</table>