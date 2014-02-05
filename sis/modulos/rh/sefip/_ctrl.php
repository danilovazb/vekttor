<?php

if($_POST["action"] == "Gerar"){
	$campos = $_POST;
	consulta_por_competencia($campos);
}