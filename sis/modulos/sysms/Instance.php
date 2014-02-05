<?php

function __autoload($classe)
{
	   $pastas = array('modulos/sysms/control', 'modulos/sysms/model');
	   foreach ($pastas as $pasta)
	   {
		      if (file_exists("{$pasta}/{$classe}.class.php")){
		
			         include_once "{$pasta}/{$classe}.class.php";
		      }
	   }
}

		//$grupo_social = new ControlGrupoSocial;
		$EleitoralSMS    = new EleitoralSMSController;
?>