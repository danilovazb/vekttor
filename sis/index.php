<?
include("_config.php");
include("_functions_base.php");
include("modulos/tour/tour_base.class.php");
validaUsuario();
$template_cabecalho_impressao="
<img  src=\"vekttor/clientes/img/$vkt_id.png\"   style=\"max-height:65px;float:left\" alt=\"\"/>
<div style=\"float:right; width:300px; text-align:left;\">
{$_SESSION[nome]}<br />
{$_SESSION[cnpj]}<br />
{$_SESSION[endereco]}, {$_SESSION[bairro]}<br />
{$_SESSION[telefone]}
</div>
<div style=\"clear:both;\"></div>
";
//print_r($_COOKIE);
if(isset($_GET['tela_id'])){
	
	$tela= mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE id='$_GET[tela_id]'"));
	mysql_query($t="UPDATE usuario SET ultima_tela_id='$tela->id' WHERE id='$usuario_id'");
}else{
	@$tela->nome="Inicial do Sistema";
}

//
//salvaUsuarioHistorico("Tela - ".$tela,"Abriu");
salvaUsuarioHistorico("Tela - ".$tela->nome,"Abriu","","");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xht5ml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <!--<?=$tela->caminho.'/'.$tela->tela ?>-->
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.png" type="image/png" />
<link rel="apple-touch-icon-precomposed" href="../favicon.png"></link>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><? if($tela->nome!="")echo $tela->nome; else echo "Sistema NV"; ?></title>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../favicon.png" type="image/png" />
<link rel="apple-touch-icon-precomposed" href="../favicon.png"></link>

<!--
<meta name="viewport" content="initial-scale=1.0; maximum-scale=0.9; user-scalable=0.5;"/>
-->
<link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" /><!-- -->
<link href="../fontes/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" /><!-- -->
<script src="../fontes/js/sis.js"></script> <!-- -->
<script src="../fontes/js/jquery.min.js"></script>
<script src="../fontes/js/jquery-ui-1.9.2.custom.min.js"></script>
<?

$teldas_nao_aparecer_tootip = array(53,80,52,101,571,53);

if(!in_array($_GET[tela_id],$teldas_nao_aparecer_tootip)){
 echo '<script src="../fontes/js/tooltip.js"></script>';
}
?>
<!--
<script src="../fontes/js/menu.js"></script>
-->
<script src="../fontes/js/notificacao.js"></script>

<script>

$(document).ready(function() {
	
	/*$('.exibe_formulario').live('mouseover',function(){
    	$(this).draggable({cursor: "crosshair"});
	});*/
	//$('.window').draggable({cursor: "move"});
	$('.exibe_formulario').draggable({cursor: "move", opacity:0.7, cancel:'.janela, form, input, textarea, select, .modal-body '});
	$('.janela,.sub-janela').live('mouseover',function(){
    	$(this).draggable({cursor: "move", cancel:'.modal-body'});
	});
	$('.window').live('mouseover',function(){ $(this).draggable({cursor: "move"});});
  $.ajaxSetup({ cache: false });
});
var pressedCtrl = false; 

$(document).keydown(function (e) {
	
	contagem = $("#logop").attr('conta')*1;
	if(contagem ==3){
		$("#logop").attr('conta',0);
		$("#carregador").toggle();
	}else{
		if(e.which == 67){
			$("#logop").attr('conta',contagem+1);
		}else{
			$("#logop").attr('conta',0);
		}
	}
});
</script>
<script>
// Chamada do Resize para a barra ficar em baixo e o tamanho da tabela ser proporcional
<?
if($_GET[tela_id]!='96'){
	?>
	window.onresize=function() {
		resize();
	}
	<?
}
?>
// Chamada do Arrastar Janela

var nn6=document.getElementById&&!document.all;
var isdrag=false;
var x,y;
var dobj;
document.onmousedown=selectmouse;

document.onmouseup=new Function("isdrag=false");

document.onkeydown=formataCampo// chama a mascara
document.onkeyup=secal//
document.onclick=formataExclui// da valor aos atributos colocados no campo

$("#some").live("hover", function(){ 
	$('#mmenu').fadeIn(100)
	$("#some").html("<img src='../fontes/img/logovekttor_r2.png' >");

});
$("#some").live("click", function(){ 
	$('#mmenu').fadeIn(100)
	$("#some").html("<img src='../fontes/img/logovekttor_r2.png' >");

});
$("#conteudo_modelo,#exibe_formulario,#mmenu").live("click",function(){
	$('#mmenu').fadeOut(200)
	$("#some").html("<img src='../fontes/img/logovekttor_r.png' >");

})
// itens do menu
$("#mmd .mp").live("mouseover",function(){
	$('#mmenu').css('width','450px');

	i=$(this).attr('i');
	$(".mp").removeClass('active');
	
	$(this).addClass('active');
	
	$(".mme").hide();
	
	$("#mme"+i).show();
	$(".mmme").hide();

})
$(".mme .abre").live("mouseover",function(){
	i=$(this).attr('i');
});
$(".mme .expande").live("mouseover",function(){

	$('#mmenu').css('width','655px');
	i=$(this).attr('i');

	$(".mmme").hide();
	
	$("#mmme"+i).show();
});
$(".mmme .mp").live("mouseover",function(){
	$(".mme .expande").removeClass('active');
	i=$(this.parentNode).attr('id').substr(4,3);
	$("[i="+i+"]").addClass('active');
});

</script>

</head>

<body>
<style>
#menu_sup{ height:23px;  background:url(../fontes/img/bgmenu.jpg); border-bottom:1px solid #999999; overflow:hidden; font-size:11px;  }
#menu_sup a{ background-repeat:no-repeat; color:#362C22;  padding:2px 5px 2px 5px; margin:2px 1px 0px 3px; display:blockf; float:left; text-decoration:none;  }
#menu_sup a:hover, #menu_sup a.menu_sup_activ{ background:url(../fontes/img/bgmenu_on.jpg) #E4E3E3; border:1px solid #B6B7B7;  border-radius:10px; margin:1px 0px 0px 2px;}
</style>
<div id='menu_sup' style="display:none;">
	<?
    $q_tela_filhos = mq("SELECT * FROM sis_modulos WHERE modulo_id='$tela->modulo_id' order by ordem_menu,nome");
	while($st = mf($q_tela_filhos)){
		if($_GET[tela_id]==$st->id){$addcls= 'class="menu_sup_activ"';}else{$addcls='';}
	if($_SESSION[acesso][$st->id]==1&&$st->acao_menu=='abre'){
	?>
  <a href="?tela_id=<?=$st->id?>" <?=$addcls?>><?=$st->nome?></a> 
<?
	}
	}
?>
</div>
<div style="background:url(../fontes/img/logovekttor_r.png)"></div>
<div style="background:url(../fontes/img/logovekttor_r2.png)"></div>
<div id='salvamenu'> 
<?	if($_GET[tela_id]<1||isset($_GET[NKJHiU])){ ?>
<div id='mmenu' style="display:none" >
<img src="../fontes/img/stb.png" width="31" height="20"  alt="" style="position:absolute; margin:-13px 0 0 5px;"/>
    	<div id='mmcc' >
        <div style="width:100%;  padding:10px 0 10px 10px"><img src="modulos/vekttor/clientes/img/<?=$vkt_id?>.png"   style="max-height:65px;" alt=""/></div>
        <div id='mmt'>
        	<div id='mmd'>
            	<?
$q = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='0' order by ordem_menu,nome ");
while($r= mysql_fetch_object($q)){
	$mmenu[$r->id] = $r->nome;
	if($_SESSION[acesso][$r->id]==1){
		if($r->acao_menu=='blank'){$href="href='$r->caminho/$r->tela' target='_blank' ";}else{$href="href='?tela_id=$r->id'";}
				?>
               <a class='mp' i='<?=$r->id?>' <?=$href?> style="background-image:url(../fontes/img/mn/<?=$r->id?>.png);"><?=$r->nome?></a> 
               <?
}} 
			   ?>
                <a class='mp' href="../?cliente_id=<?=$vkt_id?>">Sair</a> 
              <div style="clear:both;"></div>
           </div>
<?
foreach($mmenu as $menu_id => $menu_nome){
	$q=mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$menu_id' order by ordem_menu,nome ");
?>
           <div id='mme<?=$menu_id?>' class='mme'>
           <strong><?=$menu_nome?></strong>
 <?
 	while($r=mysql_fetch_object($q)){
		if($_SESSION[acesso][$r->id]==1){

		if($r->acao_menu=='expande'){$menuterceiro[$r->id]=$r->nome;}
		if($r->acao_menu=='abre'){$href="href='?tela_id=$r->id'";}else{$href='';if($r->acao_menu=='blank'){$href="href='$r->caminho/$r->tela' target='_blank' ";}else{$href='';}}
		
 ?>
		<a class='mp <?=$r->acao_menu?>' <?=$href?> i='<?=$r->id?>'><?=$r->nome?></a> 
<?
	}}
?>           </div>
<?
}
?>  
    
<?
//pr($menuterceiro);
foreach(@$menuterceiro as $menu_id => $menu_nome){
	$q=mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$menu_id' order by ordem_menu,nome ");
	if($_SESSION[acesso][$menu_id]==1){

?>
           <div id='mmme<?=$menu_id?>' class='mmme'>
           <strong><?=$menu_nome?></strong>
 <?
 	while($r=mysql_fetch_object($q)){
		$mmenu[$r->id] = $r->nome; 
		if($r->acao_menu=='abre'){$href="href='?tela_id=$r->id'";}else{$href='';if($r->acao_menu=='blank'){$href="href='$r->caminho/$r->tela' target='_blank' ";}else{$href='';}}
 ?>
		<a class='mp <?=$r->acao_menu?>'  <?=$href?> i='<?=$r->id?>'><?=$r->nome?></a> 
<?
	}
?>           </div>
<?
}}
?>       

<div style="clear:both;"></div>
</div>
        </div>
</div>
<? } ?>
</div>
<??>
<iframe src="" width="600" height="400" style="<? if(!$_GET[carregador]){?>display:none;<? } ?>;position:absolute;margin:250px 0 0 400px; background:#FFF " name="carregador" id="carregador" >
</iframe>

<?
	// Aparece trour
	$modulo_pai = TourController::retornaModuloPaiID($tela->id);
	$tourModulo = Tour::init();
?>
                  
<!-- Local de exibição de Formulários -->
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;"></div>

<!-- FIM Local do Formulário -->

<div id='menu' >
<script type="text/javascript">chamaNotificacao();</script>


<script>

<?
	if($_GET[tela_id]<1||isset($_GET[NKJHiU])){

?>
localStorage.setItem("menuteste", document.getElementById('salvamenu').innerHTML);
	<?
		if($_SESSION['usuario']->ultima_tela_id<1&&$_SESSION['usuario']->tela_inicial){
			echo '$("#mmenu").show();';
	
		}
	?>
<?
	}else{
?>
document.getElementById('salvamenu').innerHTML=localStorage.getItem('menuteste');
<?
	}
	
	function vepais($tela_id,$tela,$nivel){
		$nivel++;
		$r = mysql_fetch_object(mysql_query($t="
		SELECT * FROM sis_modulos WHERE id= '$tela_id'
		"));

		$tela = $tela." $('[i=".$r->modulo_id."]').addClass('active');
$('#mme".$r->modulo_id."').show();
$('#mmme".$r->modulo_id."').show();

		";
		if($nivel==3){
			$tela = $tela."$('#mmenu').css('width','655px');";
		}
		if($r->modulo_id!=0){
			$tela = vepais($r->modulo_id,$tela,$nivel); 
		}
		return $tela;
	}
	
	echo vepais($_GET[tela_id],'',0);

?>
$("[i=<?=$_GET[tela_id]?>]").addClass('active') ;
</script>

<a   href="../index.php?cliente_id=<?=$vkt_id?>" ><img src="../fontes/img/sd.png" width="8" height="8" style="margin:0 2px 0 -10px; visibility:hidden" /><strong>Sair <span style="font-weight:normal">(<?=$_SESSION['usuario']->login?>)</span></strong></a>
<div style="margin-top:10px; box-shadow:#999 0px 3px 3px; width:100%; height:5px ">
</div>
	
<img src="../fontes/img/assinaturavkt.png"  style=" position:bottom; display:block; margin:0px auto 0px auto;" /><div></div>

</div>
<? if($tela->menu_escondido==1){ ?>
	<style>
	#conteudo_modelo #conteudo{ margin-left:0;}
	#conteudo_modelo #rodape{margin-left:0;}
    </style>
<? } ?>
<div id="conteudo_modelo">
	<!-- Página modelo de Conteúdo -->
	<? 
	if(strlen($_GET[tela_id])>0){
		
		include($tela->caminho.'/'.$tela->tela);
	}else{
		include('resumo.php');
	}
	avaliaCarregamento($inicio_carregamento,($_GET['tela_id']>0) ? $_GET['tela_id'] : 0);
	
	$pai = $paide[$_GET[tela_id]];
	
	if($pai==5){
		echo "<script></script>";	
	}
	
	
	//echo "<script>alert('".memory_get_usage(true)."')</script>";
	
	
	?>
  <!-- Fim da Página modelo de Conteúdo -->
</div>
<div style="height:"></div>

<script>
<?
$nao_exibe_menu=array('80');
if($vkt_id==1&&!in_array($nao_exibe_menu)){
	?>
	$("#navegacao").after("<div id='menu_sup' class='sas'>"+$("#menu_sup").html()+"</div>");
//	$(".sas").animate({ height: "22px"},500 );
	<?
}
?>
$("#some").html("<img src='../fontes/img/logovekttor_r.png' >");
$("#navegacao .s1:first").html("");
$("#navegacao .s1:first").css("padding-right",10);
  
</script>
<?
//pr($_SESSION);
?>
</body>
</html>