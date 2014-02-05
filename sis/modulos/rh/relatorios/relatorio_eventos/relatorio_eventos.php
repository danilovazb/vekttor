<?
$caminho = $tela->caminho;

function exibe_funcionarios($evento,$empresa){
	global $vkt_id;
	if($empresa>0){
		$add_sql = " AND empresa_id='$empresa' ";
	}
	$evento=mf(mq("SELECT * FROM rh_eventos WHERE vkt_id='$vkt_id' AND id = '$evento' "));
	$cargo = $evento->cargo_id;
	$funcionario= $evento->funcionario_id;
	$emresa= $evento->empresa_id;
	
	// Todos
	if($cargo==0 && $funcionario==0 && $emresa==0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' $add_sql");
	}
	// Todos na Empresa
	if($cargo==0 && $funcionario==0 && $emresa>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND empresa_id='$empresa' $add_sql");
	}
	
	// Cargo
	if($cargo>0 && $funcionario==0 && $emresa==0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND cargo_id='$cargo'  $add_sql");
	}
	// Cargos na Empresa
	if($cargo>0 && $funcionario==0 && $emresa>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND status='admitidos' AND empresa_id='$emresa' AND  cargo_id='$cargo' $add_sql");
	}
	// Funcionario
	if($funcionario>0){
		$f = mq($a="SELECT * FROM rh_funcionario  WHERE vkt_id='$vkt_id' AND id='$funcionario'  $add_sql");
	}
	
	return array($evento,$f);
	
}


?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s1'>
  	RH
</a>
<a href="?" class='s2'>
  	Relatórios
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<style>
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
</style>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" /><input type="hidden" name="empresa1id" value="<?=$_GET['empresa1id']?>" />
   
    <input type="text" value="<?=$_GET['busca']?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info"> 
	<strong>Empresa:</strong>
   <?
   if($_POST['empresa_id']>0){
	   $empresa=mysql_result(mysql_query("
	   	SELECT 
	   		nome_fantasia
		FROM 
			cliente_fornecedor 
		WHERE 
			cliente_vekttor_id='$vkt_id'
		AND
			id='{$_POST['empresa_id']}'
	"),0);
	echo $empresa;
   }elseif($_POST['empresa_id']==0){
	   echo "Todas";
   }
   echo " | <strong>Eventos:</strong>  ";
   if(count($_POST['eventos'])>0){
	   $eventos_str=implode(',',$_POST['eventos']);
	   $eventos_q=mysql_query("SELECT nome FROM rh_eventos WHERE vkt_id='$vkt_id' AND id IN (".$eventos_str.")");
	   
	   while($evento=mysql_fetch_object($eventos_q)){
			$eventos_arr[]=$evento->nome;   
	   }
	   $eventos_str=implode(', ',$eventos_arr);
	   echo $eventos_str;
   }else{
	   echo "Nenhum";
	   
   }
   
   if($_POST['mes']!=''){
	   echo ' | <strong>Mês:</strong> '.$mes_extenso[$_POST['mes']-1];
   }
   
   if($_POST['ano']!=''){
	   echo ' | <strong>Ano:</strong> '.$_POST['ano'];
   }
   	   $eventos_str=@implode(',',$_POST['eventos']);
   
   ?>
	<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('<?=$caminho?>impressao_relatorio_eventos.php?eventos=<?=$eventos_str?>&empresa_id=<?=$_POST['empresa_id']?>&mes=<?=$_POST['mes']?>&ano=<?=$_POST['ano']?>')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  </div>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<div id="info_filtro">
 	<?=date('d/m/Y')?>

 	<div style="clear:both"></div>
    <?=date('H:i:s')?>
 </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	
    	<tr>
            <td width="250">Funcion&aacute;rio</td>
            <td>Premio</td>
            <td>Valor Reprovado</td>
            <td>Faltas</td>
            <td>Saldo M. A.</td>
            <td>Saldo a Rec.</td>
          	<td >OBS</td>
          	<td >ASS.</td>
        </tr>
    </thead>
    <TBODY>
    	
        <?
		if($_POST['mes']<10){
			$mes = "0{$_POST['mes']}";
		}else{
			$mes = $_POST['mes'];
		}
		
		$x=0;
		for($i=0;$i<count($_POST[eventos]);$i++){//for dos eventos
			
			$rf= exibe_funcionarios($_POST[eventos][$i],$_POST[empresa_id]); //Funcionarios retorno da funcao
			$evento= $rf[0];
			$f= $rf[1];
			if(mysql_num_rows($f)>0){
				?>
                <tr>
                	<td style="background-color:gray; color:white;" colspan="8"><?=$evento->nome?></td>
                </tr>
                <?
			}
        	while($funcionario= mf($f)){//funcionario
			$faltas= mysql_result(mysql_query($t="
		SELECT
			COUNT(rx.id) as faltas
		FROM
			rh_hora_extra as rx
		WHERE
			rx.vkt_id='$vkt_id'
		AND
			rx.funcionario_id='$funcionario->id'
		AND
			rx.falta_integral='1'
		AND
			MONTH(rx.data)='$mes' 
			"),0);
				$x++;
				if($x%2==0){$al='al';}else{$al='';}
				if($evento->forma_valor==0){
					$valor = $evento->valor;
				}
				if($evento->forma_valor==1){
					$valor = $evento->valor/100*$funcionario->salario;
				}
			
		?>
    	<tr class=" <?=$al?>">
            <td width="250"><?=$funcionario->nome?></td>
            <td><?=moedaUsaToBr($valor)?></td>
            <td></td>
            <td><?=$faltas?></td>
            <td></td>
            <td></td>
          	<td ></td>
          	<td ></td>
			
        </tr>
        
        <?
        }
		}
		
		?>
    </TBODY>
</table>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr <?=$sel ?>>
      		<td width="250">&nbsp;</td>
           <td>&nbsp;</td>
          	<td width="" class="wp"></td>
        </tr>
     </thead>
     
</table>
</div>
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
  <?
  echo"<script>window.open('$caminho/form.php','carregador')</script>";
?>
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
<script>
$('#sub93').show();
$('#sub418').show()
</script>