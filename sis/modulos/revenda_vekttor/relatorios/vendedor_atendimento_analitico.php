<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		//var id = $(this).attr('id');
		
		//location.href='?tela_id=319';
		//window.open("modulos/vekttor/relatorios/form_venda_pacotes.php","carregador");
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  	Vektor
</a>
<a href="#" class='s2'>
  	Relatórios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Venda de Pacotes
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
   
  	<?php 
		if(!empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "Período:".$_GET['de']." a ".$_GET['ate'];
		}else{			
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}?>
  </span>
     
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="200">Nome do Contato</td>
          <td width="100">N&ordm; Telefonemas</td>
          <td width="100">N&ordm; Reunioes</td>
          <td width="100">Visitas</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro = " AND data_negociacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_ini = $_GET['de'];$data_fim = $_GET['ate'];
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_negociacao) = '$mes_atual'";
			$data_ini = date("Y-m")."-01";$data_fim = date("Y-m-t");
		}
		if(!empty($_GET['busca'])){
			$busca = "AND (r.id='".$_GET['busca']."' OR r.nome LIKE '%".$_GET['busca']."%')";
		}
		
		/*$registros= @mysql_result(mysql_query($t="SELECT DISTINCT(vendedor_id) FROM 
							revenda_contato_interacao
							$filtro
							$busca"),0,0);
							//echo $t;
		$sql = @mysql_query($t="SELECT DISTINCT(v.vendedor_id) FROM 
							revenda_contato_interacao v,
							rh_funcionario rh
							WHERE
							rh.id=v.vendedor_id
							AND rh.cliente_vekttor_id='$vkt_id'
							$filtro
							$busca
							ORDER BY (SELECT COUNT(vendedor_id) FROM vekttor_venda) DESC
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		*/
		
		$registros= @mysql_result(mysql_query($t="SELECT COUNT(*) FROM 
							revenda_contato
							WHERE vendedor_id='".$_GET['vendedor_id']."'
							"),0,0);
							//echo $t;
		$sql = @mysql_query($t="SELECT * FROM 
							revenda_contato
							WHERE vendedor_id='".$_GET['vendedor_id']."'
							");
		
		$c=0;
		$soma_num_contatos = 0;
		$soma_num_telefonemas = 0;
		$soma_num_reunioes = 0;
		$soma_num_visitas = 0;
		$resultado_vendedor = array();
		while($r=@mysql_fetch_object($sql)){
				
			$qtd_telefonemas = mysql_query($t="SELECT * FROM revenda_contato_interacao WHERE vendedor_id=$r->vendedor_id AND revenda_contato_id='$r->id' AND o_que_gerou='1' $filtro $busca");
			//echo $t;
			$soma_num_telefonemas+=@mysql_num_rows($qtd_telefonemas);
			
			$qtd_reunioes = mysql_query("SELECT * FROM revenda_contato_interacao WHERE vendedor_id=$r->vendedor_id AND revenda_contato_id='$r->id' AND o_que_gerou='3' $filtro $busca");
			$soma_num_reunioes+=@mysql_num_rows($qtd_reunioes);
			
			$qtd_visitas = mysql_query("SELECT * FROM revenda_contato_interacao WHERE vendedor_id=$r->vendedor_id AND o_que_gerou='2' AND revenda_contato_id='$r->id' $filtro $busca");
			$soma_num_visitas+=@mysql_num_rows($qtd_visitas);
									
			
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="200"><?=$r->razao_social?></td>
         <td width="100"><? if(!@mysql_num_rows($qtd_telefonemas)>0){ echo "0";}else{ echo @mysql_num_rows($qtd_telefonemas);}?></td>
          <td width="100"><? if(!@mysql_num_rows($qtd_reunioes)>0){ echo "0";}else{ echo @mysql_num_rows($qtd_reunioes);}?></td>
           <td width="100"><? if(!@mysql_num_rows($qtd_visitas)>0){ echo "0";}else{ echo @mysql_num_rows($qtd_visitas);}?></td>          
          <td></td>
        </tr>
      
<?php
		}
?>

    </tbody>
</table>
<script>


</script>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
      	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="50"></td>
          <td width="200"></td>
          <td width="100"><?php echo $soma_num_contatos?></td>
          <td width="100"><?php echo $soma_num_telefonemas?></td>
          <td width="100"><?php echo $soma_num_reunioes?></td>          
                 
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
