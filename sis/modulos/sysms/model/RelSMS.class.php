<?php


	class RelSMS{
		
		protected $table = 'rel_sms';
		
			protected $id;
			protected $vkt_id;
			protected $numeroDestino;
			protected $dataEnvio;
			protected $msg;
			protected $status;
		
		
			public function setId($id){
				$this->id = $id; 
			}
			
			public function getId(){ 
				return $this->id; 
			}
			
			public function setVktId($vkt_id){ 
				$this->vkt_id = $vkt_id; 
			}
		
			public function getVktId(){ 
				return $this->vkt_id;
			}
			
			public function setNumeroDestino($numeroDestino){ 
				$this->numeroDestino = $numeroDestino;
			}
		
			public function getNumeroDestino(){ 
				return $this->numeroDestino; 
			}
			
			public function setMsg($msg){ 
				$this->msg = $msg;
			}
			
			public function getMsg(){ 
				return $this->msg;
			}
			
			public function setDataEnvio($dataEnvio){ 
				$this->dataEnvio = $dataEnvio;
			}
			
			public function getDataEnvio(){ 
				return $this->dataEnvio;
			}
			
			public function setStatus($status){ 
				$this->status = $status; 
			}
			
			public function getStatus(){ 
				return $this->status;
			} 
		
			public function listar($id = NULL){
			
				if(!empty($id)){
					
							$where = " WHERE id = ".$id;
							$sql = " SELECT * FROM ".$this->table."".$where;
							$dados = $this->Query($sql);
							
				} else{
					$sql = "SELECT * FROM ".$this->table;
					$dados = $this->Query($sql);
					
				}
				
				return $dados;
			
			}	
		
		
	}



?>