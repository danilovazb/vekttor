<?
    $info = uploadprogress_get_info($_GET['id_progresso']);
	$porcentagem = @($info['bytes_uploaded']/$info['bytes_total'])*100;
	echo number_format($porcentagem,2,',','.');
?>