<?php
include("_functions.php");
include("_ctrl.php");
$aula= mysql_fetch_object(mysql_query("SELECT * FROM escolar_aula WHERE vkt_id='$vkt_id' AND id='".$_GET[aula_id]."'"));
/* pegar dados da proxima aula */
$aula_anterior= mysql_fetch_object(mysql_query("
SELECT MAX(id) as id,descricao FROM escolar_aula WHERE vkt_id='$vkt_id' AND sala_materia_professor_id='".$aula->sala_materia_professor_id."' AND id<'".$aula->id."'"));
$proxima_aula= mysql_fetch_object(mysql_query("
SELECT MIN(id) as id,descricao FROM escolar_aula WHERE vkt_id='$vkt_id' AND sala_materia_professor_id='".$aula->sala_materia_professor_id."' AND id>'".$aula->id."'"));

$salamateria = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor WHERE vkt_id='$vkt_id' AND id='".$aula->sala_materia_professor_id."'"));

$materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_materias WHERE id='{$salamateria->materia_id}' "));

$professor = mysql_fetch_object(mysql_query("SELECT p.* FROM escolar_professor as ep,cliente_fornecedor as p WHERE ep.cliente_fornecedor_id = p.id AND  ep.id='{$salamateria->professor_id}' "));
if( strstr($_SERVER['HTTP_USER_AGENT'],'Firefox') || strstr($_SERVER['HTTP_USER_AGENT'],'MSIE') ){
	$desaparece['firefox']="style='inline-block'";
	$desaparece['outros']="style='display:none;'";
}else{
	$desaparece['firefox']="style='display:none'";
	$desaparece['outros']='';
}
?>
<script>
$('.ops').live('click',function(){
	aula_id=$(this).attr('id');
	location = '?tela_id=288&aula_id='+aula_id;
});
</script>
<style>
#dados td{ color:black;}
#dados td:hover{ color:black; background:none; cursor:auto;}
.midia
.titulo_midia{ margin-bottom:5px; display:block; font-size:14px;} 
</style>
<script type="text/javascript" src="player_video.js"></script>
<link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolar</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Aula
</a>
</div>
<div id="barra_info">

<!--<button type="button" style="float:right" onclick="location.href='?tela_id=282&materia_id=<?$materia->id?>&professor_id=<?$professor->id?>&aula_id=<?$aula->id?>'"   />
<img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"> Forum </button>-->
<button type="button" style="float:right" onclick="location.href='?tela_id=300&aula_id=<?=$aula->id?>'"   />
<img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"> Forum </button>
<input type="button" style="float:right" value="Mensagem Professor" onclick="window.open('<?=$tela->caminho?>/mensagem_para_professor.php?materia_id=<?=$materia->id?>&professor_id=<?=$professor->id?>&aula_id=<?=$aula->id?>','carregador')" />
<strong>Mat&eacute;ria: 
</strong>
<?
echo "$materia->nome";

?>

<strong>Aula :</strong>
<?=$aula->descricao?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td>Aula</td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<tr>
           <td>
           <div style="margin-left:20px; width:800px;">
           <h3><?=nl2br($aula->texto_aula)?></h3>
           
           <?
		   $videos=array('flv','mov','mp4');
		   $imagens=array('jpg','jpeg','gif','png');
		   $audio=array('mp3','wav','ogg');
		   $extensoes=array_merge($videos,$imagens,$audio);
		   
		   $midia_q=mysql_query($trace="SELECT * FROM escolar_upload WHERE aula_id='{$_GET[aula_id]}' ORDER BY id DESC");
		   //echo $trace;
		   while($midia=mysql_fetch_object($midia_q)){
			   //echo 'modulos/'.$midia->localizacao.$midia->arquivo.'<br>';
		   ?>
           <div class="midia" style="display:block; clear:both; margin-bottom:50px; padding:10px; border-radius:10px;">
           <? if(in_array($midia->extensao,$videos)){ ?>
           <span style="display:block;" class="titulo_midia"><?=$midia->observacao?></span>
           <div id="lecteur_37710" <?=$desaparece['firefox']?>>
                <a href="http://get.adobe.com/fr/flashplayer/">Você precisa instalar o plugin do flash</a>
           </div>
           <script type="text/javascript">
		   		var flashvars_37710 = {};
                var params_37710 = {
                        quality: "high",
                        bgcolor: "#000000",
                        allowScriptAccess: "always",
                        allowFullScreen: "true",
                        wmode: "transparent",flashvars: "fichier=<?='modulos/'.$midia->localizacao.$midia->arquivo?>"/* DPS DO 'fichier='  vai o caminho do vídeo */
                    };
                var attributes_37710 = {};
                flashObject("player_video.swf", "lecteur_37710", "720", "405", "8", false, flashvars_37710, params_37710, attributes_37710);
            </script> 
            <video width="720" height="405" controls="controls" <?=$desaparece['outros']?>>
              <source src="<?='modulos/'.$midia->localizacao.$midia->arquivo?>" type="video/<?=$midia->extensao?>" />
              Seu navegador não suporta HTML5.
            </video>
            <? } ?>
            
            
            <? if($midia->extensao=='mp3'||$midia->extensao=='wav'){ ?>
            <span style="display:block;" class="titulo_midia"><?=$midia->observacao?></span>
            <embed autostart="false" height="20px;" width="100px" src="<?='modulos/'.$midia->localizacao.$midia->arquivo?>" />
            <? } ?>
            
            <?
			if(in_array($midia->extensao,$imagens)){ ?>
           <span style="display:block;" class="titulo_midia"><?=$midia->observacao;?></span>
           <img src="<?='modulos/'.$midia->localizacao.$midia->arquivo?>" />
            <?
            }
			?>
            
            
            <?
			if(!in_array($midia->extensao,$extensoes)){
            ?>
            <span style="display:block;" class="titulo_midia"><?=$midia->observacao?></span>
            <a class="titulo_midia" href="<?='modulos/'.$midia->localizacao.$midia->arquivo?>">Baixar arquivo</a>
            
            <? }?>
            
            </div>
            <? 
			} 
			?>
            
           </div>
           </td>
      </tr>
    </tbody>
</table>

</div>
</div>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0">
  <form id="navegacao_aulas" method="get" action=""> 
	  <? if($aula_anterior->id>0){ ?><input style="margin-top:3px;" onclick="location.href='?tela_id=<?=$tela->id?>&aula_id=<?=$aula_anterior->id?>'" value="Aula Anterior: <?=$aula_anterior->descricao?>" type="button" />
      <input type="hidden" name="aula_id" id="anterior_id"  value="<?=$aula_anterior->id?>" /><? }?>
      
      <? if($proxima_aula->id>0){ ?><input style="margin-top:3px;" onclick="location.href='?tela_id=<?=$tela->id?>&aula_id=<?=$proxima_aula->id?>'" value="Próxima Aula: <?=$proxima_aula->descricao?>" type="button" />
	  <input type="hidden" name="aula_id" id="proximo_id" value="<?=$proxima_aula->id?>" /><? } ?>
      
      
      <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
  </form>
  </div>
</div>
