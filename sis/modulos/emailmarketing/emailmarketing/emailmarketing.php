<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

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
	#divimagem{
		display:none;
		position:absolute;
		margin-left:100px;
		margin-top:-450px;
		width:350px;
		height:250px;
		background: none repeat scroll 0% 0% rgb(237, 237, 237);  
		
	}
	#d_imagens{
		width:80%;
		margin-left:auto;
		margin-right:auto;
		margin-top:2%;
		height:200px;
		overflow:auto;
	}
	.imagens{
		border:solid #000 1px;
	}
</style>
<script type="text/javascript">
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

$("#status").live("change",function(){
	
	$('#data_envio').text('');
	
	if($(this).val()==1){
		$("#data_envio").append("&nbsp;&nbsp;De: <input type='text' name='de' id='de' calendario='1' size=7> Até: <input type='text' name='ate' id='ate' calendario='1' size=7>");
	}
});

/*---------------------------------*/

  $('#form_arquivo').live('submit',function(){
                checaprogresso();
            });
            
            function checaprogresso(){
                id_chave=$("#id_chave").val();
                
                d = new Date();
                s = d.getTime();
                url = '<?=$tela->caminho?>/informacao_do_progresso.php?id_progresso='+id_chave+'&'+s;	
                carregabarra(url);
            }
            
            
            function carregabarra(url){
                console.log(url);
                if($("#vkt_barra").css('display')=='none'){
                    $("#vkt_barra").slideDown();
                }
                $("#progresso").load(url, function() {
                    porcentagem = $("#progresso").html();
                    $("#vkt_barra_progresso").css("width",porcentagem.replace(',','.')+'%');
                
                    if($("#vkt_barra_progresso").css("width")!=100){
                        carregabarra(url);
                    }
            
                });
            }
                
            
            function chegouao100porcento(){
                $('#vkt_barra_progresso').css('width','100%');
            }

			$(".imagens").live('click',function(){
				var img = $(this).attr('src');
				//alert(img);
				document.getElementById('ed').contentWindow.document.execCommand('insertHTML', false, "<img src='"+img+"' width='50' height='50' class='imagens'/>");
			});
			
			$("#inserir_imagem").live('click',function(){
				
				var email_id = $("#id").val();
				
				$("#form_email").attr("target","carregador");
				
					
			});
			
			$("#remover_imagem").live('click',function(){
				var  id_imagem = $(this).parent().attr('id');
				var dados = "id="+id_imagem;
				$.ajax({
					type:'POST',
					url:'modulos/emailmarketing/emailmarketing/remove_imagem.php',
					data:dados,
					success: function(data) {
							alert(data);
					},			
				})
				$("#"+id_imagem).remove();
			});
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s2'>
  	Sistema
</a>
<a href="#" class="navegacao_ativo">
<span></span>  EmailMarketing
</a>
</div>
<div id="barra_info">
<form method="get" autocomplete="off">
    <select name="status" id="status">
    	<option value="">Status</option>
    	<option value="1" <?php if($_GET['status']==0){echo "selected=selected";}?>>Não Enviado</option>
        <option value="2" <?php if($_GET['status']==1){echo "selected=selected";}?>>Enviado</option>
      
    </select>
    
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
     <a href="modulos/emailmarketing/emailmarketing/form.php" target="carregador" class="mais"></a>
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
             <td width="230">Nome</td>
          <td width="70">Enviado</td>
            <td width="85">Qtd Enviados</td>
            <td width="85">Recebidos</td>
            <td width="85">Nao Enviados</td>
            <td width="80">Data Envio</td>
            <td width="80">Hora Envio</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome_envio like '%{$_GET[busca]}%'";
	}
	
	if($_GET['status']>=1){
		if($_GET['status']==1){$status=0;}else{$status=1;}
		$filtro = "AND status='$status'";
	}
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM emailmarketing WHERE vkt_id = '$vkt_id' $busca_add $filtro"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['data_hora_envio'];
	}else{
		$ordem="data_hora_envio";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT * FROM 
		emailmarketing
		WHERE
		vkt_id = '$vkt_id'
		$busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']." DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$qtd_enviados = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM emailmarketing_envio WHERE emailmarketing_id='$r->id' AND vkt_id='$vkt_id'"));
		//echo $t."<br>";
		echo mysql_error();
		$qtd_recebidos = mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM emailmarketing_retorno WHERE emailmarketing_id='$r->id' AND vkt_id='$vkt_id'"));
		$qtd_nao_enviados = mysql_fetch_object(mysql_query("SELECT COUNT(*) as qtd FROM emailmarketing_envio WHERE emailmarketing_id='$r->id' AND vkt_id='$vkt_id' AND sucesso='0'"));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){$status='nao';}else{$status='sim';}
	?>
<tr <?=$sel?>>
<td width="230" onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->id?>','carregador')"><?=$r->nome_envio?></td>
<td width="70"><?=$status?></td>
<td width="85" onclick="location.href='?tela_id=414&emailmarketing_id=<?=$r->id?>'"><?=$qtd_enviados->qtd?></td>
<td width="85" onclick="location.href='?tela_id=415&emailmarketing_id=<?=$r->id?>'"><?=$qtd_recebidos->qtd?></td>
<td width="85" onclick="location.href='?tela_id=416&emailmarketing_id=<?=$r->id?>'"><?=$qtd_nao_enviados->qtd?></td>
<td width="80"><?php if($status=='sim'){ echo DataUsaToBr(substr($r->data_hora_envio,0,10));}else{ echo "-";}?></td>
<td width="80"><?php if($status=='sim'){ echo substr($r->data_hora_envio,11,5);}else{ echo "-";}?></td>
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
