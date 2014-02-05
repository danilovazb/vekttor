<?
$caminho = $tela->caminho; 
include '_functions.php';
include '_ctrl.php';
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.ui-tooltip{ opacity:1;}
#semfundo tr td{ cursor:pointer;}
#semfundo tr:hover td{ background-image:none; color:#000000; background:#FFF }
#semfundo tr.al:hover  td{ background:#F1F5FA; }
#semfundo .al:hover td{ background:#F1F5FA; }
#semfundo .al td:hover{ background:#F0F0F0}

#table_tip tbody{ border:0;}
#table_tip tbody td{ margin:0; padding:0px;  border:0;  font-size:10px;}

.fic:hover{ color:#009}
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
	#semfundo td.cardapios{ padding-left:2px;}
</style>
<script src="<?=$caminho?>cardapio.js"></script>
<script src="modulos/cozinha/ficha_tecnica/ficha_tecnica.js"></script>
<script>
$(".cardapios .add").live('click',function(){
	opf($("#contrato_id").val(),$(this.parentNode).attr('data'),$(this.parentNode).attr('refeicao'));
	
})


$(".fic").live('click',function(){
	
	window.open('modulos/cozinha/ficha_tecnica/form.php?id='+$(this).attr('fc'),'carregador')

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
			$(this).html("<img style='float:right; margin-top:2px; margin-right:2px' src='../fontes/img/mais.png' width='14' height='14' class='add' />")
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
$('form').live('mouseover',function(){
	
			$(".ui-tooltip").remove();

	})
$('.fic').live('mouseout',function(){
	
			$(".ui-tooltip").remove();
	})
	
$(document).tooltip({
    items:'.fic',
 	track: true,
	content:function(callback) {
		$(".ui-tooltip").remove();
    $.get('<?=$caminho?>/infomacoes_ficha.php?data_click='+$(this).parent().attr('data')+'&contrato_id=<?=$contrato_id?>&id='+$(this).attr('fc')+'&qt='+$(this).attr('qt'),function(data) {			
            callback(data); //**call the callback function to return the value**
	    });
    }
});

$(".qtd_pessoas_ficha").live("keyup",function(){
	
	$(".ficha_imput").val($(this).val());
})

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
<a href="?tela_id=101&contrato_id=<?=$_GET[contrato_id]?>" class='navegacao_ativo'>
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
    <style>
	.menu_adicional{border:1px solid #CCC;  background:#FFF; position:absolute; right:27px; top:30px; box-shadow:#999 0 0 10px}
	.menu_adicional a{ display:block; padding:0px 10px 0px 10px; cursor:pointer; font-size:11px; text-decoration:none;}
	.menu_adicional a:hover{ background-color:#F2F5FA;}
</style>
<script>
$(".menu_actions").live('click',function(){
	$(".menu_adicional").toggle();
	
	})

</script>
<div class='menu_adicional' style="display:none" >
    	<a  href="modulos/cozinha/cardapio/form_import.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>" target="carregador">Importar Cardápio</a>
    	<a href="modulos/cozinha/cardapio/impressao_cardapio.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>" target="_blank">Imprimir para Cliente</a>
    	<a href="modulos/cozinha/cardapio/impressao_cardapio_producao.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>" target="_blank">Imprimir Cardápio Produção</a>
    	<a href="modulos/cozinha/cardapio/form_email.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>" target="carregador">Enviar Por E-mail</a>
    	<a href="modulos/cozinha/cardapio/form_necessidade.php?contrato_id=<?=$contrato_id?>&filtro_inicio=<?=$filtro_inicio?>&filtro_fim=<?=$filtro_fim?>" target="carregador">Gerar Necessidade para este período</a>
    	<a href="modulos/cozinha/ficha_tecnica/form.php" target="carregador"><img style="float:left; margin-top:6px; margin-right:4px" src='../fontes/img/mais.png' width='14' height='14' /> Adicionar Ficha Técnica</a>
    </div>
    <button type="button" class="menu_actions" style="float:right; padding:0px; margin:3px 2px 0 0"> <img src="../fontes/img/menu-alt.png"></button>
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
    	  <td width="75" >Refeição</td>
			<?
			 for($i=0;$i<$total_dias;$i++){
				 $dia_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%d') "),0,0);
				 $dia_numero=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%w') "),0,0);
				 $data_cardapio =mysql_result(mysql_query("SELECT DATE_ADD('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			 ?>
             
				<td width="120" ><?=$semana_abreviado[$dia_numero]?>,<?=$dia_oficial?> 
                	<img src='../fontes/img/menos.png' width='14' height='14' class='remove' data_cardapio="<?=$data_cardapio?>" style="margin-top:0px;float:right;margin-right:2px; cursor:pointer"  title="Limpar Dados Deste Dia"/>
             		   	
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
          	<td width="70">Café - <?=$contrato->cafe_dia?></td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			//$grupos_fichas_tecnicas = mysql_query(" SELECT * FROM cozinha_fichas_tecnicas");
			?>
            <td width="120" valign="top" class="cardapios" data="<?=$data_oficial?>" refeicao="cafe">
<img style="float:right; margin-top:2px; margin-right:2px" src='../fontes/img/mais.png' width='14' height='14' class="add" /><? 
				
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id,f.id as ficha_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='cafe'
				ORDER BY g.cafe_ordem, g.nome,f.nome ASC 
				");
				echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='font-weight:bold'>$ficha->grupo_cardapio</span><br>
";
						$grupo_anterior=$grupo_id;
					}
					echo "<span  class='fic' qt='$ficha->pessoas' fc='$ficha->ficha_id'>{$ficha->pessoas} {$ficha->ficha}</span><br>
";
				}
				?>            
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td >Almo&ccedil;o - <?=$contrato->almoco_dia?></td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" valign="top" class="cardapios" data="<?=$data_oficial?>" refeicao="almoco" ><img style="float:right; margin-top:2px; margin-right:2px" src='../fontes/img/mais.png' width='14' height='14' class="add" />            <? 
				$fichas_q = mysql_query($t="
				SELECT f.id as ficha_id, f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g  
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id  
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND f.exibir_cliente='1'
				AND tipo_refeicao='almoco'
				ORDER BY almoco_ordem,g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span class='fic' qt='$ficha->pessoas' fc='$ficha->ficha_id' style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
          
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td>Lanche - <?=$contrato->lanche_dia?></td>
            <?
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width="120" valign="top" class="cardapios" data="<?=$data_oficial?>" refeicao="lanche"><img style="float:right; margin-top:2px; margin-right:2px" src='../fontes/img/mais.png' width='14' height='14' class="add" />              <? 
				$fichas_q = mysql_query($t="
				SELECT f.id as ficha_id, f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g   
				WHERE 
				contrato_id='$contrato_id'
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='lanche'
				ORDER BY g.lanche_ordem,g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span class='fic' style='display:block;' qt='$ficha->pessoas' fc='$ficha->ficha_id'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
        </tr>
        <tr >
          	<td>Janta - <?=$contrato->janta_dia?></td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" valign="top" class="cardapios" data="<?=$data_oficial?>" refeicao="janta"><img style="float:right; margin-top:2px; margin-right:2px" src='../fontes/img/mais.png' width='14' height='14' class="add" />            <? 
				$fichas_q = mysql_query($t="
				SELECT f.id as ficha_id, f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id' 
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1'
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='janta'
				ORDER BY g.janta_ordem,g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span class='fic' style='display:block;' qt='$ficha->pessoas' fc='$ficha->ficha_id'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
          </td>
            <?
			 }
			?>
        </tr>
        <tr >
          <td>Ceia - <?=$contrato->seia_dia?></td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
          <td width="120" valign="top" class="cardapios" data="<?=$data_oficial?>" refeicao="seia"><img style="float:right; margin-top:2px; margin-right:2px" src='../fontes/img/mais.png' width='14' height='14' class="add" />            <? 
				$fichas_q = mysql_query($t="
				SELECT f.id as ficha_id, f.nome as ficha, c.pessoas as pessoas, g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$contrato_id' 
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1'
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='seia'
				ORDER BY g.ceia_ordem,g.nome,f.nome ASC ");
				//echo $t;
				//echo mysql_error();
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					echo "<span class='fic' qt='$ficha->pessoas' fc='$ficha->ficha_id' style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
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
</script><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
function opf(contrato_id,data,refeicao){
	
	window.open('<?=$caminho?>form.php?contrato_id='+contrato_id+'&data='+data+'&refeicao='+refeicao+'&data_inicio='+$("#filtro_inicio").val()+"&data_fim="+$("#filtro_fim").val(),'carregador')
}

</script><!-- Isso é Necessário para a criação o resize -->

<?
  }
?>
</div>
<script>resize()</script>
</div>
<div id='rodape'>
</div>


