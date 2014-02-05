<?
$qualtelata ="modulos/administrativo/reservas/"; 
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="" class='s1'>
  	Sistema NV
</a>
<a href="" class='s2'>
  	Administrativo
</a>
<a href="" class="navegacao_ativo">
<span></span>Reservas
</a>
</div>
<div id="barra_info">
    <a href="<?=$qualtelata?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="250"><a href="#" class='tda'>Identificação <span class="sdown"></span></a></td>
          	<td width="100"><a href="#" class='tda'>Vendido <span class="sup"></span></a></td>
			<td width="100"><a href="#" class='tda'>Reservado <span class="sup"></span></a></td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
		<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="250">1036 B</td>
          	<td width="100">Sim</td>
			<td width="100">1</td>
           	<td width=""></td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="250"><a>Total</a></td>
            <td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	356 Registros <select name="select" id="select" style="margin-left:10px">
    <option>15</option>
    <option>30</option>
    <option>50</option>
    <option>100</option>
  </select>
  Por P&aacute;gina 
<div style="float:right; margin:0px 20px 0 0">
	<a href=" " class='bt_left'></a>
	<input name="textfield" class="nPaginacao" type="text" id="textfield" size="2" value="1" />
	<a href=" " class='bt_rigth'></a>
</div>
</div>
