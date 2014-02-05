<?php
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");


	class  FileAjax{
		
		
		public function Cadastra(){
			
			
			echo " CADASTRAR ";
			$_POST["name"];	
		}
		
		public function Delete(){
			echo "DELETAR";	
		}
		
		public function Update(){
			echo "DELETAR";	
		}
		
		
	}
	
	
	
	$ajax = new FileAjax;
	$method = $_REQUEST["method"];
	
	call_user_func_array(array($ajax,$method), array($_REQUEST));