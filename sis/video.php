<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<div style="display:inline-block;">

	<? 
	if( strstr($_SERVER['HTTP_USER_AGENT'],'Firefox') || strstr($_SERVER['HTTP_USER_AGENT'],'MSIE') ){
		$desaparece['firefox']="style='inline-block'";
		$desaparece['outros']="style='display:none;'";
	}else{
		$desaparece['firefox']="style='display:none'";
		$desaparece['outros']='';
	}
	?>

	<script type="text/javascript" src="player_video.js"></script>
    <div id="lecteur_37710" <?=$desaparece['firefox']?>>
		<a href="http://get.adobe.com/fr/flashplayer/">Você precisa instalar o plugin do flash</a>
    </div>
    <script type="text/javascript">
    //<!--
		var flashvars_37710 = {};
		var params_37710 = {
				quality: "high",
				bgcolor: "#000000",
				allowScriptAccess: "always",
				allowFullScreen: "true",
				wmode: "transparent",flashvars: "fichier=123.mp4"/* DPS DO 'fichier='  vai o caminho do vídeo */
			};
		var attributes_37710 = {};
        flashObject("player_video.swf", "lecteur_37710", "720", "405", "8", false, flashvars_37710, params_37710, attributes_37710);
    //-->
    </script>
    <video width="720" height="405" controls="controls" <?=$desaparece['outros']?>>
      <source src="123.mp4" type="video/mp4" />
      Seu navegador não suporta HTML5. Atualiza esta merda.
    </video>
    <? 
	$player=file_get_contents('http://flash.webestools.com/flv_player/v1_27.swf'); 
	//echo $player;
	fopen('player_video.swf','w');
	if(file_put_contents('player_video.swf',$player)){
		echo 'copiouo';
	}
	?>
    
</div>
</body>
</html>