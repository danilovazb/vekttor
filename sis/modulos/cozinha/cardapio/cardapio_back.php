<?
$caminho = $tela->caminho; 
include '_functions.php';
include '_ctrl.php';
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#semfundo tr td{ cursor:pointer;}
#semfundo tr:hover td{ background-image:none; color:#000000 }
#semfundo .al:hover td{ background:#F1F5FA; }
#semfundo .al td:hover{ background:#F0F0F0}

#semfundo td:hover{ background:#E0E0E0}
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
<script src="<?=$caminho?>cardapio.js"></script>
<script>
$(".cardapios").live('click',function(){
	opf($("#contrato_id").val(),$(this).attr('data'),$(this).attr('refeicao'));
})


$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

$(".remove").live('click',function(){
	data = $(this).attr('data_cardapio');
	data2 = data.split("-");
	data2 = data2[2]+"/"+data2[1]+"/"+data2[0];
	contrato_id = $("#contrato_id").val();
	var c=0;
	if(confirm("Deseja Deletar o Cardápio do dia "+data2+"?")){
		$("#semfundo tr td").each(function() {
        if($(this).attr('data')==data){
			if(c==0){
				window.open('modulos/cozinha/cardapio/acao.php?action=limpardia&contrato_id='+contrato_id+'&data='+data,'carregador');	
				c++;
			}
			$(this).html('')
		}
    });
	}
	/**/
});
//-----script para email----------------------------------------------
function rteInsertHTML(html) {
	 rteName = 'ed';
	if (document.all) {
		document.getElementById(rteName).contentWindow.document.body.focus();
		var oRng = document.getElementById(rteName).contentWindow.document.selection.createRange();
		oRng.pasteHTML(html);
		oRng.collapse(false);
		oRng.select();
	} else {
		document.getElementById(rteName).contentWindow.document.execCommand('insertHTML', false, html);
	}
}
function ti(m,v){
    w= document.getElementById('ed').contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v);
	}else{
		
	if(m == "backcolor"){
		if(navigator.appName =='Netscape'){
			w.execCommand('hilitecolor',false,v);
		}else{
			w.execCommand('backcolor',false,v);
		}
	}else{
		
		w.execCommand(m, false, v);
	}
	}
}

function html_to_form(){
		
		document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML;
		
		document.getElementById("ed").contentWindow.document.body.innerHTML.replace("\n","");
}

function form_to_html(){
	
	
		document.getElementById("ed").contentWindow.document.body.innerHTML = document.getElementById("tx_html").value;
		
		document.getElementById("ed").contentWindow.document.body.innerHTML.replace("\n","");
}

function insere_txt(txt) {
    var myQuery = document.getElementById("ed").contentWindow.document.body;
    var chaineAj = txt;
	//IE support
	if (document.selection) {
		myQuery.focus();
		sel = document.selection.createRange();
		sel.innerHTML = chaineAj;
	}
	//MOZILLA/NETSCAPE support
	else if (document.getElementById("ed").selectionStart || document.getElementById("ed").selectionStart == "0") {
		var startPos = document.getElementById("ed").selectionStart;
		var endPos = document.getElementById("ed").selectionEnd;
		var chaineSql = document.getElementById("ed").innerHTML;

		myQuery.innerHTML = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
	} else {
		myQuery.innerHTML += chaineAj+'++aaa++';
	}
}




function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}
</script>
<div id='conteudo'>

<div id='navegacao'>
<? 
if($contrato_id){$nivel_antes='s1';$class='s2';}else{$nivel_antes='s2'; $class='navegacao_ativo';}
?>
<div id="some">>></div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="?" class='<?=$nivel_antes?>'>
  	Cozinha
</a>

<a href="?tela_id=101" class='<?=$class?>'>
  	<span></span>Cardápio
</a>

<? if($contrato_id>0){ ?>
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>    Contrato No. <?=$contrato->id?> - <?=$cliente->razao_social?>
</a>
<? } ?>

</div>
<div id="barra_info">
<?
    if(empty($_POST[filtro_inicio])&&empty($_GET[filtro_fim])){
		$dt = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_cardapio_data WHERE vkt_id='$vkt_id' ORDER BY id DESC"));
		
		if($dt->id>0){	
			$filtro_inicio 	= $dt->data_inicio;
			$filtro_fim		= $dt->data_fim;
		}else{
			$filtro_inicio 	= date("Y-m-").'01';
			$filtro_fim		= date("Y-m-t");
		}
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
		mysql_query("INSERT INTO cozinha_cardapio_data SET vkt_id='$vkt_id',data_inicio='$filtro_inicio',data_fim='$filtro_fim', contrato_id='".$_GET[contrato_id]."'");
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
		++$total_dias;
	?>
  <form style="margin:0; padding:0" method="GET"> 
    <? if($contrato_id>0){ ?>
    <button type="button" style="float:right; padding:0px; margin:3px 2px 0 0"> <img src="../fontes/img/menu-alt.png"></button>
 <input type="button" value="Enviar Email" 
 onclick="window.open('modulos/cozinha/cardapio/form_email.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>','carregador')" 
 style="float:right; margin:3px 3px 0 0;" />
 <input type="button" value="Produção" 
 onclick="window.open('modulos/cozinha/cardapio/impressao_cardapio_producao.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>')" 
 style="float:right; margin:3px 3px 0 0;" />
 <input type="button" value="Imprimir" 
 onclick="window.open('modulos/cozinha/cardapio/impressao_cardapio.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>')" 
 style="float:right; margin:3px 3px 0 0;" />
 <input type="submit" value="Importar" name="action" style="float:right; margin:3px 3px 0 0;" />
<select name="outro_contrato_id" style="float:right; margin:3px 3px 0 0;">
<? 
$contratos_q=mysql_query($x="SELECT c.id as id, cf.razao_social as cliente, c.* FROM cozinha_contratos as c, cliente_fornecedor as cf WHERE c.vkt_id='$vkt_id' AND c.cliente_id=cf.id AND c.id!='$contrato_id' " );
while($contrato=mysql_fetch_object($contratos_q)){
 ?>
          <option value="<?=$contrato->id?>" ><?=$contrato->id?> - <?=$contrato->cliente?></option>
    <? } ?>
    </select>
    <input type="hidden" id="contrato_id" name="contrato_id" value="<?=$contrato_id?>" />
    <input type="hidden" name="tela_id" value="101" />
    Inicio
    
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
   
    </label>
    
<input type="submit" name="button" id="button" value="Ir" />
<? } ?>
</form>
</div>
<div id="dados">
<?
  if(!$contrato_id){

?>
  <table cellpadding="0" cellspacing="0"  width="100%" style="width:100%;">
    <thead>
      <tr>
        <td width="250" >CONTRATO</td>
        <td width="150" >Unidade</td>
        <td width="140" >Ultima Data Planejada</td>
        <td ></td>
      </tr>
    </thead>
  </table>
  <table cellpadding="0" cellspacing="0"  width="100%" style="width:100%;">
    <tbody>
    <?
    
	$contratos_q = mysql_query("SELECT 
		*,ct.id as contrato_id, cu.nome as unidade
	FROM 
		cozinha_contratos as ct ,
		cliente_fornecedor as c,
		cozinha_unidades as cu
	WHERE 
		ct.cliente_id = c.id
	AND
		ct.vkt_id ='$vkt_id'
	AND
		ct.unidade_id=cu.id
	AND 
		ct.status ='1' ");
	
	while($contrato= mysql_fetch_object($contratos_q)){
	$ultima_data = @mysql_result(mysql_query("SELECT DATE_FORMAT(data,'%d/%m/%Y') as data FROM cozinha_cardapio_dia_refeicao WHERE contrato_id='$contrato->contrato_id' AND vkt_id='$vkt_id' ORDER BY data DESC"),0,0);
	?>
      <tr onclick="location='?tela_id=101&contrato_id=<?=$contrato->contrato_id?>'">
        <td width="250"  ><?=$contrato->nome_fantasia ?></td>
        <td width="150" ><?=$contrato->unidade?></td>
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
        <td width="250" >-</td>
        <td width="150" >-</td>
        <td width="140" >-</td>
        <td ></td>
    </thead>
  </table>
  <?
  }
  if($contrato_id>0){
	  $contrato=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_contratos WHERE id='$contrato_id'"));

?>

<table cellpadding="0" cellspacing="0"  width="<?=300+(($total_dias+1)*170)?>">
    <thead>
    	<tr>
    	  <td width="140" >Refeição</td>
			<?
			 for($i=0;$i<$total_dias;$i++){
				 $dia_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%d') "),0,0);
				 $dia_numero=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%w') "),0,0);
				 $data_cardapio =mysql_result(mysql_query("SELECT DATE_ADD('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			 ?>
             
				<td width="120" ><?=$semana_abreviado[$dia_numero]?>,<?=$dia_oficial?> 
                	<img src='../fontes/img/menos.png' width='18' height='18' class='remove' data_cardapio="<?=$data_cardapio?>" style="margin-top:2px;float:right;margin-right:5px;"  title="Limpar Dados Deste Dia"/>
             		   	
                </td>
            <?
			 }
			?>
    	</tr>
    </thead>
</table>


<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*170)?>" >
<tbody id='semfundo'>
	<tr >
          	<td width="140">Café - <?=$contrato->cafe_dia?> pessoas</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			//$grupos_fichas_tecnicas = mysql_query(" SELECT * FROM cozinha_fichas_tecnicas");
			?>
            <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="cafe">
            	<? 
				
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='cafe'
				ORDER BY g.nome,f.nome ASC 
				");
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>            
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="140">Almo&ccedil;o - <?=$contrato->almoco_dia?> pessoas</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td data="<?=$data_oficial?>" width="120" class="cardapios" refeicao="almoco" >
          <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g  
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id  
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND f.exibir_cliente='1'
				AND tipo_refeicao='almoco'
				ORDER BY g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
          
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="140">Lanche - <?=$contrato->lanche_dia?> pessoas</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="lanche">
            <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g   
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='lanche'
				ORDER BY g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td width="140">Janta - <?=$contrato->janta_dia?> pessoas</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="janta">
          <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id' 
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1'
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='janta'
				ORDER BY g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          <td width="140">Ceia - <?=$contrato->seia_dia?></td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" data="<?=$data_oficial?>" class="cardapios" refeicao="seia">
          <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id' 
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1'
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='seia'
				ORDER BY g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
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
	window.open('<?=$caminho?>form.php?contrato_id='+contrato_id+'&data='+data+'&refeicao='+refeicao,'carregador')
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

