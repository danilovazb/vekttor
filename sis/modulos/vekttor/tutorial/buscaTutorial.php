<?php
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	//alert(oi);
	if( strstr($_SERVER['HTTP_USER_AGENT'],'Firefox') || strstr($_SERVER['HTTP_USER_AGENT'],'MSIE') ){
		$desaparece['firefox']="style='inline-block'";
		$desaparece['outros']="style='display:none;'";
	}else{
		$desaparece['firefox']="style='display:none'";
		$desaparece['outros']='';
	}
	
	
	$videos=array('flv','mov','mp4');
	$imagens=array('jpg','jpeg','gif','png');
	$audio=array('mp3','wav','ogg');
	$extensoes=array_merge($videos,$imagens,$audio);
	
	$id = $_GET['id'];
	
	$tutorial1 = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos_tutorial WHERE id=$id"));
	
	if(!empty($tutorial1->texto)){
?>
<div id="texto">
   	<?php
		echo $tutorial1->texto; 
	?>
</div>
    <?php
		}
		if(!empty($tutorial1->extensao1)){
	?>   
<div id="arquivo1">
   	<?php
		$extensao1 = substr($tutorial1->extensao1,-3);
		//alert($extensao1);
    	if(in_array($extensao1,$imagens)){ 
	
          
           echo "<img src='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/$tutorial1->id$tutorial1->extensao1'/>";
    
        }
		if(in_array($extensao1,$videos)){ ?>
           
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
                        wmode: "transparent",flashvars: "fichier=<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao1?>"/* DPS DO 'fichier='  vai o caminho do vídeo */
                    };
                var attributes_37710 = {};
                flashObject("player_video.swf", "lecteur_37710", "720", "405", "8", false, flashvars_37710, params_37710, attributes_37710);
            </script> 
            <video width="720" height="405" controls="controls" <?=$desaparece['outros']?>>
              <source src="<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao1?>" type="video/<?=$tutorial1->extensao1?>" />
              Seu navegador não suporta HTML5.
            </video>
    <? } 
        
       if($tutorial1->extensao1=='mp3'||$tutorial1->extensao1=='wav'){ 
	?>
           
            <embed autostart="false" height="20px;" width="100px" src="<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao1?>" />
    <? 
	}} 
		if(!empty($tutorial1->extensao2)){
	?>   
<div id="arquivo1">
   	<?php
		$extensao2 = substr($tutorial1->extensao2,-3);
		//alert($extensao1);
    	if(in_array($extensao2,$imagens)){ ?>
           
           <img src="<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao2?>" />
        <?
        }
		if(in_array($extensao2,$videos)){ ?>
           
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
                        wmode: "transparent",flashvars: "fichier=<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao2?>"/* DPS DO 'fichier='  vai o caminho do vídeo */
                    };
                var attributes_37710 = {};
                flashObject("player_video.swf", "lecteur_37710", "720", "405", "8", false, flashvars_37710, params_37710, attributes_37710);
            </script> 
            <video width="720" height="405" controls="controls" <?=$desaparece['outros']?>>
              <source src="<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao2?>" type="video/<?=$tutorial1->extensao2?>" />
              Seu navegador não suporta HTML5.
            </video>
        <? } 
        
        if($tutorial1->extensao2=='mp3'||$tutorial1->extensao2=='wav'){ ?>
            
            <embed autostart="false" height="20px;" width="100px" src="<?='http://vkt.srv.br/~nv/sis/modulos/vekttor/item_menu/tutorial/'.$tutorial1->id.$tutorial1->extensao2?>" />
        <? }} ?>
	
</div>    