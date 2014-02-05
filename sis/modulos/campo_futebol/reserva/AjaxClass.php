<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

define("VKT_ID", $vkt_id);

	class AjaxClass{
		
		protected static $_table_cliente = "cliente_fornecedor";
		protected static $_table_campo = "campo_futebol";
		protected static $_table_reserva = "campo_futebol_reserva";
		protected static $_table_reserva_horarios = "campo_futebol_reserva_horarios";
		protected static $vkt_id = "";
		protected $json = array();
		
		public function __construct(){
			self::$vkt_id = VKT_ID;
		}
		
		public function CadastraReserva(){
			$sql = " INSERT INTO ".self::$_table_reserva." SET 
			vkt_id                = '".self::$vkt_id."',
			cliente_fornecedor_id = '".$_POST["cliente_id"]."', 
			cliente_vekttor_id    = '".self::$vkt_id."', 
			data_cadastro_reserva = '".$_POST["data_reserva"]."', 
			valor                 = '".$_POST["valor"]."', 
			status                = 'reserva', 
			local_pagamento       = 'campo' ";
			
			echo $sql;
		}
		
		public function CadastraCliente(){
			$sql = " INSERT INTO ".self::$_table_cliente." SET 
			cliente_vekttor_id = '".self::$vkt_id."',
			razao_social  = '".$_POST["nome"]."', 
			nome_fantasia = '".$_POST["nome"]."', 
			cnpj_cpf      = '".$_POST["cnpjCpf"]."',
			tipo          = '".$_POST["tipo"]."',
			tipo_cadastro = ".$_POST["tipo_cadastro"];
			mysql_query($sql);
			$lastID = mysql_insert_id();
			echo $lastID;
			
		}
		
		public function ConsultaValor(){
			$qtdHorarios = count($_POST["horario"]);
			$qtdCampos = count($_POST["campo_id"]);
			$campos_id = implode(",",$_POST["campo_id"]);
			$tipo_campo = $_POST['tipo_campo'];
			
			$dia_semana  = mysql_result(mysql_query($t="SELECT DAYOFWEEK('".DataBrToUsa($_POST['data_reserva'])."')"),0,0);
			 
			if($tipo_campo=="society"){
				$valor_reserva=50;
				$valor_hora = array("1"=>"110",
								"2"=>"90",
									"3"=>"75",
									"4"=>"110",
									"5"=>"110",
									"6"=>"110");
			}else{
				$valor_hora = array("1"=>"300",
								"2"=>"270",
								"3"=>"225",
								"4"=>"300",
								"5"=>"300",
								"6"=>"300");
				$valor_reserva=150;
			}
			
			$json["valor_total"] = $valor_hora[$dia_semana-1] * $qtdHorarios;
			$soma = $json["valor_total"];
			if($soma==0){
				$json["valor_reserva"] = 0;
				$json["saldo_devedor"] = 0;
			}else{
				$json["valor_reserva"] = $valor_reserva;
				$json["saldo_devedor"] = $soma-$valor_reserva;
			}
			/*$sqlCampo = mysql_query(" SELECT * FROM ".self::$_table_campo." AS campo WHERE campo.vkt_id = '".self::$vkt_id."' AND campo.id IN(".$campos_id.") " );
			
			while($info_campo = mysql_fetch_array($sqlCampo)){
				$json["valor_total"][] = $info_campo[valor.$qtdCampos] * $qtdHorarios ;
			}*/
			
			$json["soma"] = $soma;
			$json["saldo_devedor"] = $soma-$json["valor_reserva"];
			echo json_encode($json);
			
		}
		
		public function ConsultaDisponibilidade(){
			
			$qtdHorarios = count($_POST["horario"]);
			$qtdCampos = count($_POST["campo_id"]);
			$campos_id = implode(",",$_POST["campo_id"]);
			$ocupados = array();
			
			$sqlDisponibilidade = mysql_query($t=" SELECT *, DATE_FORMAT(horarios.data_hora, '%H:%i') AS hora FROM ".self::$_table_reserva_horarios." AS horarios 
			JOIN ".self::$_table_reserva." AS reserva ON reserva.id = horarios.reserva_id
			WHERE horarios.campo_id IN(".$campos_id.") 
			AND DATE_FORMAT(horarios.data_hora, '%d/%m/%Y' ) = '".$_POST['data_reserva']."' " );
			$json["sql"] = $t;
			
			while($info_disponibilidade = mysql_fetch_array($sqlDisponibilidade)){
				
				//Horarios
				$json["horarios_ocupados"][] = $info_disponibilidade["hora"];	
						
				//Campos
				$campo = mysql_fetch_array( mysql_query(" SELECT * FROM ".self::$_table_campo." WHERE id = ".$info_disponibilidade["campo_id"]."  "));
				
				//Clientes
				$cliente = mysql_fetch_array(mysql_query( " SELECT * FROM ".self::$_table_cliente." WHERE id = ".$info_disponibilidade["cliente_fornecedor_id"]." " ));

				$json[$info_disponibilidade["hora"]]['nome_campo'][]= $campo["nome"];
				$json[$info_disponibilidade["hora"]]['cliente'][]= $cliente["razao_social"];
				
			}
			
			/*if(count($json["horarios_ocupados"])<1){
				$json["horarios_ocupados"] = 0;	
			}*/
				
				for($i = 0; $i < 24; $i++){
					$j = $i;
					$j = $j <= 9 ? "0".$j : $j;
					$horas = $j.":00";
					$td .=  '<tr '.$s.' style="background:#FFF;"> ';
					
					if( count($json["horarios_ocupados"]) > 0 ){
					
					  if( in_array($horas,$json["horarios_ocupados"])){
						  
						   $campos_nome = implode("<br />",$json[$horas]['nome_campo']);
						   $cliente = implode("<br />",$json[$horas]['cliente']);
							  
						   $td .= '<td style="color:#CCC;"><input type="checkbox" disabled id="horario_reserva" name="horario_reserva[]" value="'.$horas.'"></td>';
						   $td .= '<td style="color:#CCC;">'.$horas.'</td>';
						   $td .= '<td style="color:#CCC;">'.$campos_nome.'</td>';
						   $td .= '<td style="color:#CCC;">'.$cliente.'</td>';
								  
					  } else {
						  $td .= '<td><input type="checkbox" id="horario_reserva" name="horario_reserva[]" value="'.$horas.'"></td>';
						  $td .= '<td>'.$horas.'</td>';
						  $td .= '<td></td>';
						  $td .= '<td></td>';
					  }
					
					} else {
						
						$td .= '<td><input type="checkbox" id="horario_reserva" name="horario_reserva[]" value="'.$horas.'"></td>';
						$td .= '<td>'.$horas.'</td>';
						$td .= '<td></td>';
						$td .= '<td></td>';
						
					}
					
					$td .= '</tr>';
				
				}//fim de for
				
				
			echo $td;
			//print_r($json);
		}
		
		
		public function ConsultaCampoHorario(){
			
			$sql= mysql_query(" SELECT * FROM  ".self::$_table_reserva_horarios." AS horarios 
			JOIN ".self::$_table_campo." AS campo ON campo.id = horarios.campo_id
			WHERE DATE_FORMAT(horarios.data_hora, '%H:%i') = '".$_POST["hora"]."' 
			AND DATE_FORMAT(horarios.data_hora, '%d/%m/%Y' ) = '".$_POST['data_reserva']."' ");
			
			while($campos=mysql_fetch_array($sql)){
				$temp = $campos["nome"];
				$json["nome"][] = $temp;	
			}
			echo json_encode($json);
		}
		
	}/*Fim da classe*/
	
	$ajax= new AjaxClass;
	$method = $_REQUEST["method"];
	
	call_user_func_array(array($ajax,$method),array($_REQUEST));