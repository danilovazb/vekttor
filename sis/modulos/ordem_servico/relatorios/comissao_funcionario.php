<?
session_start();

//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=281" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	OS
</a>
<a href="?tela_id=302" class='navegacao_ativo'>
<span></span>    Comissao Funcionários
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
  <span style="float:right">
  Período: 
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo $_GET['de']." a ".$_GET['ate'];
		}?>
  </span>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</form>
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Nome</td>
          <td width="70">Comissao</td>
          
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php
		$mes_atual = date("m"); 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro = " AND os.data_aprovacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$filtro = " AND MONTH(os.data_aprovacao) = '$mes_atual'";
		}
		if(!empty($_GET['busca'])){
			$busca = "AND f.nome LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT COUNT(DISTINCT(funcionario_id)) 
							   FROM 
								os_item i,
								os os,
								rh_funcionario as f
							   WHERE 
							   i.os_id=os.id AND
							   i.funcionario_id=f.id AND							   
							   os.situacao = '2' AND
							   i.vkt_id='$vkt_id' $filtro $busca"),0,0);
		
		$sql = mysql_query($t="SELECT 
								DISTINCT(funcionario_id) 
							   FROM 
								os_item i,
								os os,
								rh_funcionario as f
							   WHERE 
							   i.os_id=os.id AND
							   i.funcionario_id=f.id AND							   
							   os.situacao = '2' AND
							   i.vkt_id='$vkt_id' $filtro $busca
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));;		
						
		//echo $t;
		//echo mysql_error();	
		$cont=0;
		
		while($r=mysql_fetch_object($sql)){
			
			if($r->funcionario_id>0){
			$qtd=mysql_fetch_object(mysql_query($t="SELECT SUM(valor_funcionario) as valor FROM os_item WHERE funcionario_id=$r->funcionario_id AND vkt_id='$vkt_id'"));
			$p=mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario	WHERE id=$r->funcionario_id AND vkt_id='$vkt_id'"));
			//echo $t."<br>";
			$funcionario[$cont]['valor']=$qtd->valor;
			$funcionario[$cont]['funcionario_id']=$r->funcionario_id;			
			$funcionario[$cont]['nome']=$p->nome;
			//echo $produto[$cont]['produto_id']."<br>";
			$cont++;			
			}
		}
		//print_r($funcionario);
		if(sizeof($funcionario)>0){
		
			sort($funcionario);
			//print_r($produto);
			for($i=sizeof($funcionario)-1;$i>=0;$i--){
	?>      
    	<tr <?=$sel?>>
          <td width="60"><?=$funcionario[$i]['funcionario_id']?></td>
          <td width="200"><?=substr($funcionario[$i]['nome'],0,100);?></td>
          <td width="70"><?=number_format($funcionario[$i]['valor'],2,',','.')?></td>
          <td></td>
        </tr>
<?php
			}
		}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
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
