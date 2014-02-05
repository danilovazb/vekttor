<?php

if($_POST['action']=='Zerar Estoque'){
	
	verifica_saldos($_POST['unidade_id'],$_POST['modo']);
	
}
?>