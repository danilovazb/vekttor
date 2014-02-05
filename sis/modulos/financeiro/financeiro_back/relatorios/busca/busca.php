<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");

/********************* Manipulação dos filtros ************************************/
if($_GET[conta]!=0){$filtro_conta=" AND m.conta_id='{$_GET[conta]}'";}	
if($_GET[tipo]=='centro'){$filtro_pai = $_GET[centro];$filtro_tabela='centro';$oposto='plano';}
if($_GET[tipo]=='plano'){$filtro_pai = $_GET[plano];$filtro_tabela='plano';$oposto='centro';}		
if(!isset($_GET[tipo])||$_GET[tipo]=='nulo'){$filtro_pai=0;$filtro_tabela='centro'; $oposto='plano';}else{$filtro_tabela_ex=" AND plano_ou_centro='{$filtro_tabela}' ";}
if(isset($_GET[efetivado]) && $_GET[efetivado]<2){$filtro_efetivado=" AND m.status='{$_GET[efetivado]}' ";}else{$filtro_efetivado=" AND m.status<'2' ";}
if($_GET[efetivado]=='1'){$campo_data="data_info_movimento";}
if($_GET[efetivado]=='0'){$campo_data="data_vencimento";}
if($_GET[efetivado]=='2'){$campo_data="data_vencimento";}
if(!isset($_GET[extorno])){$filtro_extorno=" AND m.extorno=0";}elseif($_GET[extorno]=='1'){ $filtro_extorno='';}
if(!isset($_GET[efetivado])){$campo_data="data_vencimento";}
/****************************************************************/
			
/**************função para fazer a soma incluindo as subcategorias***********/
function retornaFilhos($id,$tipo){
	global $vkt_id;
	$filho[]=$id;
	$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE plano_ou_centro='$tipo' AND centro_custo_id='$id' AND cliente_id='$vkt_id' ") or die(mysql_error());	
	//echo $tt;
	while($f=mysql_fetch_object($q)){
		$filho[]=$f->id;
		$filhos=mysql_query($a="SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id' ");
		//echo $a;
		if(mysql_num_rows($filhos)>0){
			$filho=array_merge($filho,retornaFilhos($f->id,$tipo));
			}	
		}
	return array_unique($filho);
}
/***************************************************************************/

?>
<script src="modulos/financeiro/financeiro.js"></script>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="../demonstrativo_periodo/?" class='s1'>
  	Sistema
</a>
<a href="../" class='s1'>
  	Financeiro
</a>
<a href="../" class='s2'>
  	Relat&oacute;rios
</a>
<a href="../?tela_id=81" class='navegacao_ativo'>
<span></span>    Busca Por Per&iacute;odo
</a>
</div>
<div id="barra_info">
<form style=" margin:0; padding:0; " method="get"> 
      <select name="tipo" id="tipo">
      	<option value="nulo">Filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro')echo 'selected="selected"'; ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano')echo 'selected="selected"'; ?> >Plano de Contas</option>
        <option value="cliente" id="cliente_escolha" title="Cliente/Fornecedor" <? if($_GET[tipo]=='cliente')echo 'selected="selected"'; ?> >Cliente/Fornecedor</option>
        <option value="ordem" id="ordem" <? if($_GET[tipo]=='ordem')echo 'selected="selected"'; ?>>Ordem de Compra</option>
        <option value="nota" id="nota" <? if($_GET[tipo]=='nota')echo 'selected="selected"'; ?>>Nota Fiscal</option>
      </select>
      <span id="labels">
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >
      <select name="centro">
      <option value="0">- Centro de Custo -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro='centro' AND cliente_id='$vkt_id' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id)echo "selected"; ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >
      <select name="plano">
      <option value="0">- Plano de Conta -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' AND cliente_id='$vkt_id' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id)echo "selected"; ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="cliente" <? if($_GET[tipo]!='cliente'){ ?> style="display:none;" <? } ?> >Cliente:
      <input name="cliente" type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$_GET[cliente]?>" />
			  <input name="cliente_nome" id="cliente_nome" value="<?=$_GET[cliente_nome]?>" busca='modulos/financeiro/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id,0' valida_minlength='5'retorno='focus|Busque o nome do Cliente' autocomplete='off'>
  </label>
  
  
  <label id="ordem" <? if($_GET[tipo]!='ordem'){ ?> style="display:none;" <? } ?> >Ordem de Compra:
      <input name="ordem" type="text" value="<?=$_GET[ordem]?>" />
  </label>
  
  <label id="nota" <? if($_GET[tipo]!='nota'){ ?> style="display:none;" <? } ?> >Nota Fiscal:
      <input name="nota" type="text" value="<?=$_GET[nota]?>" />
  </label>
  
  </span>
  
  	<select name="conta">
    <option value="0">Contas</option>
    <? $contas_q=mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id ='$vkt_id' ORDER BY nome ASC"); while($contas=mysql_fetch_object($contas_q)){ ?>
    <option <? if($_GET[conta]==$contas->id)echo "selected"; ?> value="<?=$contas->id?>"><?=$contas->nome?></option>
    <? } ?>
    </select>
    <label>
    	<select name="efetivado">
    	<option value="2" <? if(empty($_GET[efetivado]))echo "selected"; ?>>Efetivados</option>
        <option value="1" <? if($_GET[efetivado]=='1')echo "selected"; ?>>Sim</option>
        <option value="0" <? if($_GET[efetivado]=='0')echo "selected"; ?>>Não</option>
    </select>
    </label>
     <label>Mostrar extornos
    	<input style="margin-left:-2px;" type="checkbox" <? if($_GET['extorno']==1)echo "checked='checked'"; ?> name="extorno" value="1" />
    </label>
  </label>
    De
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
	$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	$filhos=retornaFilhos($filtro_pai,$filtro_tabela);

	$filhos_s="";
	
	if($_GET[filtro]=='historico'){
				$sql_data_inicio=mysql_query($opa="
				SELECT
					m.data_info_movimento as data_inicio
				FROM 
					financeiro_movimento as m, financeiro_{$_GET[tipo]}_has_movimento as fhm
				WHERE
					m.cliente_id='$vkt_id'
				AND
					m.extorno=0
				AND
					m.id=fhm.movimento_id
				AND fhm.plano_id in (".implode(',',retornaFilhos($_GET[$_GET[tipo]],$_GET[tipo])).")
				$filtro_efetivado
				ORDER BY
					m.data_info_movimento
				ASC
				LIMIT 1
				") or die(mysql_error());
				//echo $opa;
				$data=mysql_fetch_object($sql_data_inicio);
				$filtro_inicio = $data->data_inicio;
			}
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    At&eacute;
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <input type="hidden" name="tela_id" value="85" />
<input type="submit" name="button" id="button" value="Filtrar" />
<? $url= str_replace('&','|',$_SERVER['REQUEST_URI']); ?>
<!--<input  value="Imprimir"  />-->
<button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
</button>
</form>

</div>
<div id='dados'>
<div id="info_filtro">
Busca de movimentações financeiras por período.<br />
<?
if($_GET[conta]>0){$conta=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas WHERE id='$_GET[conta]'"));echo "<b>Conta:</b> ".$conta->nome."<br/>";}
if($_GET[tipo]=='plano'){$plano=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$filtro_pai'"));echo "<b>Plano de Conta:</b> ".$plano->nome."<br/>";}
if($_GET[tipo]=='centro'){$centro=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$filtro_pai'"));echo "<b>Centro de Custo</b> ".$centro->nome."<br/>";}
if($_GET[efetivado]=='1'){echo "<b>Somente efetivados</b><br/>";}
if($_GET[efetivado]=='0'){echo "<b>Somente não efetivados</b><br/>";}
echo "<b>Dias:</b> ".dataUsaToBr($filtro_inicio)." ao dia ".dataUsaToBr($filtro_fim).'<br/>';
?>
</div>
<table cellpadding="0" cellspacing="0"  width="100%">
    <thead>
   
    	<tr>
    	  <td width="70">Data Vcto.</td>
          <td width="70">Data pago.</td>

          	<td width="100"> Centro de Custo</td>
            
            <td width="100" align="left">Plano de Conta</td>
            <td width="100" align="left">Cliente</td>
            <td width="150" align="left">Descri&ccedil;&atilde;o</td>
            <td width="60" align="right">Entrada</td>
            <td width="60" align="right">Sa&iacute;da</td>
            <td width=""></td>
			
        </tr>
        
         
      
    </thead>
</table>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
	<tbody>
    
    <?		
			
			if(!isset($_GET[tipo]) || $_GET[tipo]!='cliente' || $_GET[tipo]=='nulo'){
			$pais_e_filhos=implode(',',retornaFilhos($filtro_pai,$filtro_tabela));
			$q = mysql_query($x="
				SELECT
					cc.nome as nome,
					c.valor as valor, 
					m.tipo as tipo, 
					m.data_info_movimento as data_mov,
					m.data_vencimento as data_venc,
					m.descricao as descr,
					m.id as id,
					m.status as status
				FROM
					financeiro_centro_custo as cc,
					financeiro_{$filtro_tabela}_has_movimento as c,
					financeiro_movimento as m
				WHERE 
					c.plano_id in ($pais_e_filhos)
				AND 
					c.plano_id = cc.id
				AND
					c.movimento_id = m.id 
				$filtro_efetivado
				$filtro_extorno
				AND 
					m.$campo_data>='$filtro_inicio' 
				AND 
					m.$campo_data<='$filtro_fim'
				$filtro_conta
				ORDER BY m.data_vencimento ASC ") or die(mysql_error());
			}
			if($_GET[tipo]=='cliente'||$_GET[tipo]=='nota'||$_GET[tipo]=='ordem' ){
				switch($_GET[tipo]){
					case 'cliente':
					$filtro=" m.internauta_id='{$_GET[cliente]}' ";
					break;
					case 'nota';
					$filtro=" m.doc LIKE '%{$_GET[nota]}%' ";
					break;
					case 'ordem':
					$filtro=" m.origem_id LIKE '%{$_GET[ordem]}%' ";
					break;
				}
				
				
				$q = mysql_query($tracecliente="
					SELECT 
						m.id as id,
						m.tipo as tipo,
						m.data_movimento as data_mov,
						m.data_vencimento as data_venc,
						m.entrada as entrada,
						m.saida as saida,
						m.saldo as saldo,
						m.status as status,
						tabela_plano.nome as plano_nome,
						tabela_centro.nome as centro_nome
					FROM
						 financeiro_movimento as m,
						 (SELECT * FROM financeiro_centro_custo WHERE plano_ou_centro='plano') as tabela_plano,
						 (SELECT * FROM financeiro_centro_custo WHERE plano_ou_centro='centro') as tabela_centro,
						 financeiro_centro_has_movimento as fcm,
						 financeiro_plano_has_movimento as fpm
					WHERE
					$filtro
					AND
						m.id = fcm.movimento_id
					AND
						fcm.plano_id = tabela_centro.id
					AND
						m.id=fpm.movimento_id
					AND
						fpm.plano_id= tabela_plano.id
						$filtro_extorno
					AND
						m.$campo_data>='$filtro_inicio'
					AND 
						m.$campo_data<='$filtro_fim'
					$filtro_efetivado
					$filtro_conta
					ORDER BY m.data_vencimento DESC ") or die(mysql_error());
					$oposto='centro';
			} 
			$linha_contagem=0;
			$total_entrada=0;
			$total_saida=0;
			$total_saldo=0;
			$total_pago_entrada=0;
			$total_pago_saida=0;
			$total_pago_saldo=0;
			$total_pendente_entrada=0;
			$total_pendente_saida=0;
			$total_pendente_saldo=0;
            while($r=mysql_fetch_object($q)){
				
				$clientes=mysql_query("
				SELECT c.razao_social as nome FROM cliente_fornecedor as c, financeiro_movimento as m WHERE m.id='{$r->id}' AND c.id = m.internauta_id  ");
				
				$cliente=mysql_fetch_object($clientes);
				
				if( $_GET[tipo] != 'cliente' ){
					$oposto_query=mysql_query($op="SELECT nome FROM financeiro_{$oposto}_has_movimento as h, financeiro_movimento as m, financeiro_centro_custo as c 
						WHERE m.id='{$r->id}' 
						AND h.movimento_id = m.id 
						AND h.plano_id = c.id ");
						switch($oposto){
							case'centro':
							$centro=mysql_fetch_object($oposto_query) or die(mysql_error());
							break;
							case'plano':
							$plano=mysql_fetch_object($oposto_query) or die(mysql_error());
							break;
						}
				}
				if($linha_contagem%2==0){$cl="";}else{$cl="class='al'";}
				if($r->status=='1')$v=' style="color:green;" ';
				if($r->status=='0')$v=' style="color:red;" ';
			?>
    	<tr <?=$cl?> <?=$v?> onClick="opf(<?=$r->id?>)" >
        	<td width="70"><?=dataUsaToBr($r->data_venc)?></td>
            <td width="70"><? if($r->data_mov=="0000-00-00"){echo "Pendente";}else{echo dataUsaToBr($r->data_mov); }?></td>
          	<td width="100"><? if($oposto=='plano'){echo $r->nome; }else{ echo $centro->nome;}?> <? if($_GET[tipo]=='cliente')echo $r->centro_nome; ?></td>
            
            <td width="100"><? if($oposto=='centro'){echo $r->nome; }else{ echo $plano->nome; }?> <? if($_GET[tipo]=='cliente')echo $r->plano_nome; ?></td>
            
            <td width="100" align="left"><?=$cliente->nome?></td>
            <td width="150" align="left"><?=$r->descr?></td>
            <td width="60"  align="right" ><?
			
				if($r->tipo=='receber'&&$_GET[tipo]!='cliente'){
					$valor_receber=$r->valor;	
				}elseif($_GET[tipo]=='cliente'){
					$valor_receber=$r->entrada;
				}else{$valor_receber=0;}echo number_format($valor_receber,2,',','.');
				$total_entrada+=$valor_receber;
				if($r->status=='0'){$total_pendente_entrada+=$valor_receber;}
				if($r->status=='1'){$total_pago_entrada+=$valor_receber;}
				?></td>
                
                
                
				<td width="60"  align="right" ><?
				if($r->tipo=='pagar'&&$_GET[tipo]!='cliente'){
					$valor_pagar=$r->valor;
				}elseif($_GET[tipo]=='cliente'){
					$valor_pagar=$r->saida;
				}else{$valor_pagar=0;}echo number_format($valor_pagar,2,',','.');
				$total_saida+=$valor_pagar;
				if($r->status=='0'){$total_pendente_saida+=$valor_pagar;}
				if($r->status=='1'){$total_pago_saida+=$valor_pagar;}
			?></td>
            <td width=""></td>
        </tr>
          <? $linha_contagem++;
			}
			?>
    </tbody>
</table>


<table cellpadding="0" cellspacing="0" width="100%">
  <thead>
    	<tr>
       	  <td width="645">Total</td>
          
          	<td width="70" style="margin:0; padding:0; text-align:right"><?=number_format($total_entrada,2,',','.')?></td>
          	<td width="60"><?=number_format($total_saida,2,',','.')?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0"width="100%" >
  <thead>
    <tr>
      <td width="645">Pago</td>
          
          <td width="70" style="margin:0; padding:0; text-align:right"><?=number_format($total_pago_entrada,2,',','.')?></td>
          	<td width="60"><?=number_format($total_pago_saida,2,',','.')?></td>
          	<td width=""></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
  <thead>
    <tr>
      <td width="645">Pendente</td>
       
          	<td width="70" style="margin:0; padding:0; text-align:right"><?=number_format($total_pendente_entrada,2,',','.')?></td>
          	<td width="60"><?=number_format($total_pendente_saida,2,',','.')?></td>
          	<td width=""></td>
    </tr>
  </thead>
</table>
</div>

</div>
<div id='rodape'>
	<script>
	$("#tipo").change(function(){
		var labels = $("#labels label");
		for(var i=0;i<labels.length;i++){
			if(labels[i].getAttribute('id')==this.value){labels[i].style.display='';}else{labels[i].style.display='none';}
		}
	})
	function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
</div>
