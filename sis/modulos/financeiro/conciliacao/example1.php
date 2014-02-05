<?php
	include('OFXParser.php');
	$ofx= new OFXParser();
	$ofx->loadFromFile('extrato.ofx');
	
	echo '<pre>';
	//print_r($ofx->getCredits());
	print_r($ofx->getDebits());
	print_r($ofx->getByDate(07, 08, 2013));
//	print_r($ofx->getMoviment(0)); // the second moviment
	//print_r($ofx->filter('MEMO', 'DOC', true, true)); // all moviments that have DOC in its description, NOT case sensitive
	echo '</pre>';
?>