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
		height:100px;
		background: none repeat scroll 0% 0% rgb(237, 237, 237);  
		
	}
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
	
	
		document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML
		
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
				document.getElementById('ed').contentWindow.document.execCommand('insertHTML', false, "<img src=\"http://vkt.srv.br/~nv/sis/"+img+"\" class='imagens'/>");
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
					url:'modulos/eleitoral/emailmarketing/remove_imagem.php',
					data:dados,
					success: function(data) {
						
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
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral
</a>
<a href="#" class="navegacao_ativo">
<span></span>  EmailMarketing
</a>
</div>
<div id="barra_info">
	<input type="button" value="<<" style="margin-top:3px;" onclick="location.href='?tela_id=402'" />
    <a href="modulos/eleitoral/emailmarketing/form.php" target="carregador" class="mais"></a>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="230">Nome</td>
            <td width="230">Email</td>
            <td width="130">Data</td>
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
    $id = $_GET['emailmarketing_id'];
	$registros= mysql_result(mysql_query($t="SELECT count(*) FROM eleitoral_emailmarketing_envio WHERE vkt_id = '$vkt_id' AND email_marketing_id = '$id' $busca_add $filtro"),0,0);
    //echo $t;
	$ordem="data";
	
	
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT *,date_format(data,'%d/%m/%Y as %m:%i') as dt FROM 
		eleitoral_emailmarketing_envio
		WHERE
		email_marketing_id = '$id' AND
		vkt_id = '$vkt_id'
		$busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']." DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		
		$eleitor = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='$r->eleitor_id'"));
		//$nao_recebidos = $qtd_enviados->qtd - $qtd_recebidos->qtd;
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){$status='nao';}else{$status='sim';}
	?>
<tr <?=$sel?>>
<td width="230"><?=$eleitor->nome?></td>
<td width="230"><?=$eleitor->email?></td>
<td width="130"><?=$r->dt?></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&emailmarketing_id=<?=$_GET['emailmarketing_id']?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador], array("emailmarketing_id" => $_GET['emailmarketing_id']))?>
    </div>
</div>
