<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$disRV = "none";
$disC = "none";
$disV = "none";
?>
<style>

#barra_info span span { 
		padding:1px; margin-top:0px; margin-left:-10px; font-size:11px;
		position:absolute;line-height:13px; font-weight:bold; background:#EBC096; border:1px solid #999;/*text-decoration:blink;*/
		box-shadow:0 0 0 1px #FFF;-moz-shadow:0 0 0 1px #FFF;-webkit-shadow:0 0 0 1px #FFF;
		border-radius:2px;-moz-border-radius:2px;-webkit-border-radius:2px;
}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
	
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();

		$("#div"+id).show();
			
	
	})
	
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
	});
	
$("#o_que_gerou").live("change",function(e){
	//alert("oi");		
	var o_que_gerou = $(this).val();
	if(o_que_gerou>0 && o_que_gerou<=3){
		
			$("dt_proxima_interacao").val('');
			$("hr_proxima_interacao").val('');
		
		$("#prox_interacao").css("display","block");
	}else{
		$("#prox_interacao").css("display","none");
	}
});
</script>
<div id="some">«</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'> 
    Revenda Vekttor 
</a>
<a href="?tela_id=15" class="navegacao_ativo">
<span></span>    Contato 
</a>
</div>
<?php
	$sqlInteracao = mysql_query($rv=" SELECT DISTINCT r.id,rc.revenda_contato_id,r.nome_contato,r.nome_fantasia,r.email,r.tipo_cadastro,rc.vendedor_id
										FROM revenda_contato_interacao AS rc, revenda_contato AS r
										WHERE rc.cliente_vekttor_id = '$vkt_id' 
										AND (rc.tipo_interacao='1' OR rc.tipo_interacao='2' OR rc.tipo_interacao='3') 
										AND rc.o_que_gerou = '0' 
										AND rc.revenda_contato_id = r.id ");
	$ReunicaoVistia = mysql_num_rows($sqlInteracao);
		if(!empty($ReunicaoVistia)){$disRV = "inline";}
	/*-Cancelamento-*/		
	$cancelamento = mysql_query($c="SELECT * FROM revenda_contato_interacao WHERE o_que_gerou='5' AND cliente_vekttor_id ='$vkt_id' ORDER BY ID DESC");
    $cancelar =  mysql_num_rows($cancelamento);
		if(!empty($cancelar)){$disC = "inline";}
	/*-quantas vendas-*/
	$r_venda = mysql_query($vd="SELECT DISTINCT r.id,rc.revenda_contato_id,r.nome_contato,r.nome_fantasia,r.email,r.tipo_cadastro,rc.vendedor_id 
							FROM revenda_contato_interacao AS rc, revenda_contato AS r
							WHERE  rc.cliente_vekttor_id = '$vkt_id'
							AND rc.o_que_gerou='4' 
							AND rc.revenda_contato_id = r.id
							");
	$qtd_venda=	 mysql_num_rows($r_venda);
if(!empty($qtd_venda)){$disV= "inline";}
?>
<div id="barra_info">
	<form method="get" autocomplete="off">
	
    <select name="vendedor" id="vendedor">
    		<option value="">Vendedor</option>
    		<?php
            	$sqlVendedor =  mysql_query($u=" SELECT * FROM rh_funcionario WHERE vendedor = 's' AND vkt_id = '$vkt_id'");
					while($fvendedor=mysql_fetch_object($sqlVendedor)){
							if($_GET['vendedor'] == $fvendedor->id){$selb = "selected='selected'";} else{$selb ="";} 
			?>
            <option <?=$selb?> value="<?=$fvendedor->id?>"><?=$fvendedor->nome?></option>
    		<?php
					}
			?>
    </select>
     <select name="bairro" id="bairro">
    		<option value="">Bairro</option>
    		<?php
            	$sqlFilter= mysql_query($t=" SELECT DISTINCT bairro FROM revenda_contato WHERE cliente_vekttor_id = '$vkt_id' ");
					while($bairro=mysql_fetch_object($sqlFilter)){
							if($_GET['bairro'] == $bairro->bairro){$selb = "selected='selected'";} else{$selb ="";} 
			?>
            <option <?=$selb?> value="<?=$bairro->bairro?>"><?=$bairro->bairro?></option>
    		<?php
					}
			?>
    </select>

    <input type="submit" value="Filtrar" id="filtrar" />
    
      <span>
    	<button type="submit" name="status" value="rv" />Reuniao, Visita e Telefonema</button> <span style="display:<?=$disRV?>"><strong><?php if(!empty($ReunicaoVistia)){ echo ($ReunicaoVistia);}else{echo"";}?></strong></span>
		&nbsp;
        <button type="submit" name="status" value="c" />Cancelamento</button> <span style="display:<?=$disC?>"><strong><?php if(!empty($cancelar)){echo $cancelar;}?></strong></span>
        &nbsp;
        <button type="submit" name="status" value="v" />Venda</button> <span style="display:<?=$disV?>"><strong><?php if(!empty($qtd_venda)){echo $qtd_venda;}?></strong></span>     
      </span>&nbsp;
      <button onclick="loction.href='?tela_id=346'">Todos</button>
    <input type="hidden" name="tela_id" value="346" />
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
</form>	
<!-- Filter -->  

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="230">Nome</td>
          	<td width="230">Contato</td>
            <td width="175">Email</td>
            <td width="55">Tipo</td>
            <td width="98">Vendedor</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	$sql = " SELECT * FROM revenda_contato WHERE cliente_vekttor_id = '$vkt_id' $busca_add ";
	if(!empty($_GET['status'])){
			switch($_GET['status']){
				case 'rv': //reuniao visita telefonema
				$sql=$rv;
				break;
				case 'c': //cancelada
				$sql=" SELECT * FROM revenda_contato WHERE cliente_vekttor_id = '$vkt_id' AND status='3' ";
				break;
				case 'v':
				$sql=$vd;
				break;	
			}
	}
	/*--*/
	$busca_add= "";
	if(!empty($_GET['vendedor'])){
		$busca_add .= "AND vendedor_id = '{$_GET[vendedor]}'";
	}
	if(!empty($_GET['bairro'])){
		$busca_add .= " AND bairro like '%{$_GET[bairro]}%'";
	}
	
	
	
	$sqlContato = mysql_query($sql.$busca_add);
	while($contato=mysql_fetch_object($sqlContato)){
		$vendedor =  mysql_fetch_object(mysql_query($u=" SELECT * FROM rh_funcionario WHERE vendedor = 's' AND id = '$contato->vendedor_id' "));
			
			if($contato->tipo_cadastro=="Físico")
				$nome = $contato->nome_contato;	
			 else
				$nome = $contato->nome_fantasia;
	?>
			<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$contato->id?>','carregador')">
                <td width="230"><?=$nome?></td>
                <td width="230"><?=$contato->nome_contato?></td>
                <td width="175"><?=$contato->email?></td>
                <td width="55"><?=$contato->tipo_cadastro?></td>
				<td width="98"><?=$vendedor->nome?></td>
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
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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
