<?
$caminho = $tela->caminho; 
include '_functions.php';
include '_ctrl.php';
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#semfundo tr td{ cursor:pointer; }
#semfundo tr:hover td{ background-image:none; color:#000000 }
#semfundo .al:hover td{ background:#F1F5FA; }
#semfundo .al td:hover{ background:#F0F0F0}

#semfundo td:hover{ background:#E0E0E0;}
</style>
<script src="<?=$caminho?>cardapio.js"></script>
<script>
$(".cardapios").live('click',function(){
	opf($("#contrato_id").val(),$(this).attr('data'),$(this).attr('refeicao'));
})


$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

$("#desperdicio").live('blur',function(){
			var qtd_desperdicio = $(this).val();
			var ficha_id = $(this).parent().parent().find("#ficha_id").val();
				var dados = 'ficha_id='+ficha_id+'&desperdicio='+qtd_desperdicio;
				//alert(dados);
				$.ajax({
						url: 'modulos/cozinha/quebra/desperdicio.php?acao=desperdicio', 
						dataType: 'html',
						type: 'POST',
						data: dados,
						success: function(data, textStatus) {
							$("#result_teste").html(data);
						},	
				})/* Fim Ajax */
})
</script>
<div id='conteudo'>
<div id='navegacao'>
<? 
if($contrato_id){$nivel_antes='s1';$class='s2';}else{$nivel_antes='s2'; $class='navegacao_ativo';}
?>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s2'>
    Cozinha 
</a> 
<a href="?tela_id=101" class='<?=$class?>'>
  	<span></span>Cardápio
</a>

<? if($contrato_id>0){?>
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>    Contrato No. <?=$_POST[contrato_id]?> - <?=$cliente->razao_social?>
</a>
<? } ?>

</div>
<div id="barra_info">
<?
    if(($_GET['desperdicio'])){
		$desperdicio = $_GET['desperdicio'];
		  				if($desperdicio == '2')
						  	$and = "AND c.desperdicio <> 0";
						else if($desperdicio == '1')
							$and = "AND c.desperdicio = 0";	
						else
							$and = "";
		}
	
	
	if(empty($_POST[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
		++$total_dias;
	?>
  <form style="margin:0; padding:0" method="GET"> 
    
 <!--<input type="button" value="Imprimir" 
 onclick="window.open('modulos/cozinha/cardapio/impressao_cardapio.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?$filtro_inicio?>&filtro_fim=<?$filtro_fim?>')" 
 style="float:right; margin:3px 3px 0 0;" />
 <!--<input type="submit" value="Importar" name="action" style="float:right; margin:3px 3px 0 0;" />-->
<!-- <select name="outro_contrato_id" style="float:right; margin:3px 3px 0 0;">
<? 
/*$contratos_q=mysql_query($x="SELECT c.id as id, cf.razao_social as cliente FROM cozinha_contratos as c, cliente_fornecedor as cf WHERE c.vkt_id='$vkt_id' AND c.cliente_id=cf.id AND c.id!='$contrato_id' " );
while($contrato=mysql_fetch_object($contratos_q)){*/
 ?>
          <option value="<?$contrato->id?>" ><?$contrato->id?> - <?$contrato->cliente?></option>
    <? //} ?>
    </select>-->
    <input type="hidden" id="contrato_id" name="contrato_id" value="<?=$contrato_id?>" />
    <input type="hidden" name="tela_id" value="112" />
    Inicio
    
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
   
    </label>
    
<label><select name="desperdicio" id="desperdicio">
		
	<option <? if($_GET['desperdicio'] == 'todos'){ echo 'selected="selected"';}?> value="todos">Todos</option>
	<option <? if($_GET['desperdicio'] == '2'){ echo 'selected="selected"';}?> value="2">Verificados</option>
    <option <? if($_GET['desperdicio'] == '1'){ echo 'selected="selected"';}?>value="1">N&atilde;o Verificados</option>
</select></label>

<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>
<div id="dados">
<?
  if(!$contrato_id){

?>
  <table cellpadding="0" cellspacing="0"  width="100%" style="width:100%;">
    <thead>
      <tr>
        <td width="150" >CONTRATO</td>
        <td width="140" >Ultima Data Planejada</td>
        <td ></td>
      </tr>
    </thead>
  </table>
  <table cellpadding="0" cellspacing="0"  width="100%" style="width:100%;">
    <tbody>
    <?
    
	$contratos_q = mysql_query("SELECT 
		*,ct.id as contrato_id
	FROM 
		cozinha_contratos as ct ,
		cliente_fornecedor as c
	WHERE 
		ct.cliente_id = c.id
	AND
		ct.vkt_id ='$vkt_id' 
	AND 
		ct.status ='1' ");
	
	while($contrato= mysql_fetch_object($contratos_q)){
	$ultima_data = @mysql_result(mysql_query("SELECT DATE_FORMAT(data,'%d/%m/%Y') as data FROM cozinha_cardapio_dia_refeicao WHERE contrato_id='$contrato->contrato_id' AND vkt_id='$vkt_id' ORDER BY data DESC"),0,0);
	?>
      <tr>
        <td width="150" onclick="location='?tela_id=112&contrato_id=<?=$contrato->contrato_id?>'" >000<?=$contrato->contrato_id?> - <?=$contrato->nome_fantasia ?></td>
        <td width="140" align="center" ><?=$ultima_data?></td>
        <td ></td>
      </tr>
      <?
	}
	  ?>
    </tbody>
  </table>
  <table cellpadding="0" cellspacing="0"  width="100%" style="width:100%;">
    <thead>
      <tr>
        <td width="150" >-</td>
        <td width="140" >-</td>
        <td ></td>
    </thead>
  </table>
  <?
  }
  	
  if($contrato_id>0){
	  

?>

<table cellpadding="0" cellspacing="0"  width="<?=300+(($total_dias+1)*170)?>">
    <thead>
    	<tr>
    	  <td width="80" >Descricao</td>
			<?
			 for($i=0;$i<$total_dias;$i++){
				 $dia_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%d') "),0,0);
				 $dia_numero=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%w') "),0,0);
			 ?>
             
				<td width="120" ><?=$semana_abreviado[$dia_numero]?>,<?=$dia_oficial?></td>
            <?
			 }
			?>
    	</tr>
    </thead>
</table>


<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*170)?>" >
<tbody id='semfundo'><!--<img src='../fontes/img/_error.png' align="absbottom">-->
	<tr >
          	<td width="80">Café</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="cafe" >
            	<? 
				
				$fichas_q = mysql_query($t="
				SELECT *,f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='cafe' 
				$and
				");
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}";
					if($ficha->desperdicio == 0){
						echo "<span> <strong style='color:#D20000'>X</strong></span>";
					} else if($ficha->desperdicio > 0){
						echo "<span> <strong style='color:#D20000'>OK</strong> </span></span>";
					}
				}
				?>            
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="80">Almo&ccedil;o</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td data="<?=$data_oficial?>" width="120" class="cardapios" refeicao="almoco" >
          <? 
		  		
				$fichas_q = mysql_query($t="
				SELECT *,f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='almoco' 
				$and
				");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
						
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}";
					if($ficha->desperdicio == 0){
						echo "<span> <strong style='color:#D20000'>X</strong></span>";
					} else if($ficha->desperdicio > 0){
						echo "<span> <strong style='color:#009933'>OK</strong> </span></span>";
					}
				}
				
				?>
          <!--<img src='../fontes/img/accept.png'>-->
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="80">Lanche</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="lanche">
            <? 
				$fichas_q = mysql_query($t="
				SELECT *,f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='lanche' 
				$and
				");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}";
					if($ficha->desperdicio == 0){
						echo "<span> <strong style='color:#D20000'>X</strong></span>";
					} else if($ficha->desperdicio > 0){
						echo "<span> <strong style='color:#009933'>OK</strong> </span></span>";
					}
				}
				?>
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="80">Janta</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="janta">
          <? 
				$fichas_q = mysql_query($t="
				SELECT *,f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='janta' 
				$and
				");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}";
					if($ficha->desperdicio == 0){
						echo "<span> <strong style='color:#D20000'>X</strong></span>";
					} else if($ficha->desperdicio > 0){
						echo "<span> <strong style='color:#009933'>OK</strong> </span></span>";
					}
				}
				?>
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          <td>Seia</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="seia">
          <? 
				$fichas_q = mysql_query($t="
				SELECT *,f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='seia' 
				$and
				");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}";
					if($ficha->desperdicio == 0){
						echo "<span> <strong style='color:#D20000'>X</strong></span>";
					} else if($ficha->desperdicio > 0){
						echo "<span> <strong style='color:#009933'>OK</strong> </span></span>";
					}
				}
				?>
          </td>
            <?
			 }
			?>
        </tr>
</tbody>
</table>
<script>

	$("#dados tr:nth-child(2n+1)").addClass('al');
</script><table cellpadding="0" cellspacing="0" width="<?=(300+($total_dias+1)*170)?>">
  <thead>
    	<tr>
       	  <td width="80">Total</td>
            <?
            ?>
      </tr>
    </thead>
</table>
<script>
function opf(contrato_id,data,refeicao){
	window.open('modulos/cozinha/quebra/form.php?contrato_id='+contrato_id+'&data='+data+'&refeicao='+refeicao,'carregador')
}

</script><!-- Isso é Necessário para a criação o resize -->

<?
  }
?>
</div>
<script>resize()</script>
</div>
<div id='rodape'>
<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();
	})
		
		
</script>
</div>

<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>

