<?
if($_GET['unidade_id_origem']>0){$unidade_id_origem=$_GET['unidade_id_origem'];}
if($_GET['unidade_id_destino']>0){$unidade_id_destino=$_GET['unidade_id_destino'];}




if(count($_POST['produto_id'])>0){
	criarTransferencia($_POST);
}
