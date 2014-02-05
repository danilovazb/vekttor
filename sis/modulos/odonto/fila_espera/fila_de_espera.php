<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
?>
<script src="modulos/odonto/atendimento/script_dentes.js"></script>
<?
include('modulos/odonto/atendimento/scripts_exames.php');
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
	#pagina{
		border:1px solid #000;
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
		box-shadow:2px 1px 2px #333333;
		margin-top:20px;
		padding:20px;
		
	}
	.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
	
.dente{background:url(../fontes/img/odonto.dentes.png);position:absolute; cursor:pointer; z-index:5;}


.dente55{background-position:-31px -1px;margin:224px 0 0 218px; width:70px; height:120px; background-image:none; background-color:#0FF; opacity:0;}
	.dente55hover,.dente55:hover{background-position:-81px -1px; opacity:0.3;}
.dente54{background-position:-31px -1px;margin:224px 0 0 143px; width:70px; height:120px; background-image:none; background-color:#0FF; opacity:0;}
	.dente54hover,.dente54:hover{background-position:-81px -1px; opacity:0.3;}
.dente53{background-position:-31px -1px;margin:99px 0 0 140px; width:70px; height:120px; background-image:none; background-color:#0FF; opacity:0;}
	.dente53hover,.dente53:hover{background-position:-81px -1px; opacity:0.3;}
.dente52{background-position:-31px -1px;margin:99px 0 0 220px; width:70px; height:120px; background-image:none; background-color:#0FF; opacity:0;}
	.dente52hover,.dente52:hover{background-position:-81px -1px; opacity:0.3;}
.dente51{background-position:-31px -1px;margin:220px 0 0 370px; width:50px; height:140px; background-image:none; background-color:#0FF; opacity:0;}
	.dente51hover,.dente51:hover{background-position:-81px -1px; opacity:0.1;}
.dente50{background-position:-31px -1px;margin:67px 0 0 370px; width:50px; height:140px; background-image:none; background-color:#0FF; opacity:0;}
	.dente50hover,.dente50:hover{background-position:-81px -1px; opacity:0.1;}
.dente49{background-position:-31px -1px;margin:46px 0 0 20px; width:40px; height:344px; background-image:none; background-color:#0FF; opacity:0;}
	.dente49hover,.dente49:hover{background-position:-81px -1px; opacity:0.1;}
.dente48{background-position:-31px -1px;margin:227px 0 0 93px; width:40px; height:34px;}
	.dente48hover,.dente48:hover{background-position:-81px -1px}
.dente47{background-position:-31px -41px;margin:260px 0 0 95px; width:42px; height:32px;}
	.dente47hover,.dente47:hover{background-position:-81px -41px}
.dente46{background-position:-31px -80px;margin:286px 0 0 103px; width:40px; height:35px;}
	.dente46hover,.dente46:hover{background-position:-81px -80px}
.dente45{background-position:-31px -119px;margin:317px 0 0 114px; width:39px; height:27px;}
	.dente45hover,.dente45:hover{background-position:-81px -119px}
.dente44{background-position:-31px -152px;margin:337px 0 0 127px; width:37px; height:29px;}
	.dente44hover,.dente44:hover{background-position:-81px -152px}
.dente43{background-position:-31px -186px;margin:356px 0 0 144px; width:33px; height:32px;}
	.dente43hover,.dente43:hover{background-position:-81px -186px}
.dente42{background-position:-31px -224px;margin:369px 0 0 169px; width:24px; height:32px;}
	.dente42hover,.dente42:hover{background-position:-81px -224px}
.dente41{background-position:-31px -261px;margin:376px 0 0 191px; width:25px; height:33px;}
	.dente41hover,.dente41:hover{background-position:-81px -261px}
.dente38{background-position:-31px -299px;margin:225px 0 0 296px; width:40px; height:34px;}
	.dente38hover,.dente38:hover{background-position:-81px -299px}
.dente37{background-position:-31px -344px;margin:255px 0 0 291px; width:41px; height:33px;}
	.dente37hover,.dente37:hover{background-position:-81px -344px}
.dente36{background-position:-31px -388px;margin:283px 0 0 284px; width:40px; height:37px;}
	.dente36hover,.dente36:hover{background-position:-81px -388px}
.dente35{background-position:-31px -434px;margin:315px 0 0 279px; width:38px; height:30px;}
	.dente35hover,.dente35:hover{background-position:-81px -434px}
.dente34{background-position:-31px -473px;margin:336px 0 0 266px; width:36px; height:29px;}
	.dente34hover,.dente34:hover{background-position:-81px -473px}
.dente33{background-position:-32px -513px;margin:357px 0 0 253px; width:34px; height:30px;}
	.dente33hover,.dente33:hover{background-position:-82px -513px}
.dente32{background-position:-31px -552px;margin:369px 0 0 239px; width:32px; height:32px;}
	.dente32hover,.dente32:hover{background-position:-81px -552px}
.dente31{background-position:-31px -594px;margin:376px 0 0 215px; width:25px; height:33px;}
	.dente31hover,.dente31:hover{background-position:-81px -594px}
.dente28{background-position:-31px -637px;margin:177px 0 0 295px; width:40px; height:35px;}
	.dente28hover,.dente28:hover{background-position:-81px -637px}
.dente27{background-position:-31px -678px;margin:149px 0 0 290px; width:41px; height:33px;}
	.dente27hover,.dente27:hover{background-position:-81px -678px}
.dente26{background-position:-33px -717px;margin:121px 0 0 285px; width:38px; height:32px;}
	.dente26hover,.dente26:hover{background-position:-83px -717px}
.dente25{background-position:-31px -758px;margin:97px 0 0 276px; width:39px; height:27px;}
	.dente25hover,.dente25:hover{background-position:-81px -758px}
.dente24{background-position:-31px -794px;margin:75px 0 0 267px; width:37px; height:29px;}
	.dente24hover,.dente24:hover{background-position:-81px -794px}
.dente23{background-position:-31px -830px;margin:50px 0 0 258px; width:35px; height:32px;}
	.dente23hover,.dente23:hover{background-position:-81px -830px}
.dente22{background-position:-31px -868px;margin:34px 0 0 242px; width:28px; height:32px;}
	.dente22hover,.dente22:hover{background-position:-81px -868px}
.dente21{background-position:-37px -911px;margin:23px 0 0 214px; width:30px; height:31px;}
	.dente21hover,.dente21:hover{background-position:-87px -911px}
.dente18{background-position:-34px -951px;margin:179px 0 0 92px; width:40px; height:34px;}
	.dente18hover,.dente18:hover{background-position:-84px -951px}
.dente17{background-position:-35px -989px; margin:151px 0 0 95px; width:42px; height:32px;}
	.dente17hover,.dente17:hover{background-position:-85px -989px;}
.dente16{background-position:-32px -1026px; margin:122px 0 0 98px; width:42px; height:33px;}
	.dente16hover,.dente16:hover{background-position:-82px -1026px;}
.dente15{background-position:-33px -1072px; margin:97px 0 0 108px; width:39px; height:28px;}
	.dente15hover,.dente15:hover{background-position:-83px -1072px;}
.dente14{background-position:-32px -1111px; margin:74px 0 0 118px; width:37px; height:28px;}
	.dente14hover,.dente14:hover{background-position:-82px -1111px;}
.dente13{background-position:-32px -1144px; margin:50px 0 0 134px; width:35px; height:32px;}
	.dente13hover,.dente13:hover{background-position:-82px -1144px;}
.dente12{background-position:-35px -1180px; margin:33px 0 0 158px; width:28px; height:32px;}
	.dente12hover,.dente12:hover{background-position:-85px -1180px;}
.dente11{background-position:-33px -1218px; margin:23px 0 0 183px; width:31px; height:32px;}
	.dente11hover,.dente11:hover{background-position:-83px -1218px;}
	
.doenca{
	clear:both;
	margin-bottom:7px;
}
.nome_doenca{
	float:left;
	width:200px;
	
	
}
</style>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Ondontologo 
</a>
<a href="#" class="navegacao_ativo">
<span></span>  <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
<form method="get">
	<select name="agenda_id" id="agenda_id">
    	<option value=''>Agenda</option>
		<?php
			
			echo $t;
			while($agenda = mysql_fetch_object($agendas)){
				if($agenda->id==$_GET['agenda_id']){
					$selected="selected='selected'";
				}
				echo "<option value='$agenda->id' $selected>$agenda->nome</option>";
				$selected='';
			}
		?>
    </select>
   
    Data <input type="text" value="<?php if(empty($_GET['data'])){echo date("d/m/Y");}else{ echo $_GET['data'];}?>" name="data" id="data" calendario='1' size="8"/>
    <?php
		if(empty($_GET['data'])){$data=date("d/m/Y");}else{$data=$_GET['data'];}
		$espera = Quantidade($_GET['agenda_id'],$data,'Em espera',$filtro_campo);
	?>
    <input type="submit" value="Em espera" name="status" id="status"/>(<?=$espera?>)
	<?php
		
		$atendimento = Quantidade($_GET['agenda_id'],$data,'Em atendimento',$filtro_campo);
	?>
    <input type="submit" value="Em atendimento" name="status" id="status"/>(<?=$atendimento?>)
    <?php
		$cancelado = Quantidade($_GET['agenda_id'],$data,'Cancelado',$filtro_campo);
	?>
    <input type="submit" value="Cancelado" name="status" id="status"/>(<?=$cancelado?>)
    <?php
		$concluido = Quantidade($_GET['agenda_id'],$data,'Concluido',$filtro_campo);
	?>
    <input type="submit" value="Concluido" name="status" id="status"/>(<?=$concluido?>)
    <input type="submit" value="Toda a Fila" name="status" id="status"/>
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
</form>	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           	<td width="60">Numero</td>
            <td width="230">Agenda</td>   
            <td width="230">Nome</td>          	
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	$filtro = '';
	if($_GET[agenda_id]>0){
		$filtro .= "AND agenda_id='".$_GET['agenda_id']."'";
	}
	if($_GET[data]>0){
		$filtro .= "AND data_chegada='".dataBrToUsa($_GET['data'])."'";
		//echo "oi";
	}else{
		$filtro .= "AND data_chegada='".date('Y-m-d')."'";
		//echo "oi2";
	}
	if(!empty($_GET[status])&&$_GET['status']!='Toda a Fila'){
		$filtro .= "AND status='".$_GET[status]."'";
	}else if($_GET['status']=='Toda a Fila'){
		//$filtro .= "AND status='Em espera'";
	}else{
		$filtro .= "AND status='Em espera'";
	}
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		odontologo_fila_espera 
		WHERE
		vkt_id='$vkt_id'
		$busca_add $filtro"),0,0);
    
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT * FROM 
		odontologo_fila_espera 
		WHERE
		$filtro_campo AND
		vkt_id='$vkt_id'
		$busca_add $filtro ORDER BY ordem_de_atendimento ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	//echo $usuario_id;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
			$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$r->cliente_fornecedor_id."'"));
			$agenda = mysql_fetch_object(mysql_query($t="SELECT * FROM agenda WHERE id = '$r->agenda_id'"));
	
	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->id?>','carregador')">
<td width="60"><?=$r->ordem_de_atendimento?></td>
<td width="230"><?=$agenda->nome?></td>
<td width="230"><?=$cliente_fornecedor->razao_social?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           	<td width="60"></td>
            <td width="230"></td>   
            <td width="230"></td>          	
          	<td></td>
        </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
