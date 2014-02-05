<?

class OdontoTour extends Tour{
	const _ETAPAS = 6;
	const _TITULO = "Módulo Odontológico";
	public function __construct(){
		$this->etapas=self::_ETAPAS;
		$this->titulo=self::_TITULO;
	}
	public function etapa1(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM odontologo_convenio WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[0]= $this->marcarEtapa("Cadastro de Convênio",true,371);
		}else{
			$this->itens[0]= $this->marcarEtapa("Cadastro de Convênio",false,371);
		}
	}
	public function etapa2(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM usuario_tipo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[1] = ($qtd>0)?$this->marcarEtapa("Cadastro de Tipos de Usuário",true,13):$this->marcarEtapa("Cadastro de Tipos de Usuário",false,13);
	}
	public function etapa3(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM odontologo_odontologo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[2] = ($qtd>0)?$this->marcarEtapa("Cadastro de Odontologo",true,382):$this->marcarEtapa("Cadastro de Odontologo",false,382);
	}
	public function etapa4(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM servico WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[3]= $this->marcarEtapa("Cadastro de Procedimentos",true,373);
		}else{
			$this->itens[3]= $this->marcarEtapa("Cadastro de Procedimentos",false,373);
		}
	}
	public function etapa5(){
		$qtd=mysql_result(mysql_query("SELECT count(*) FROM odontologo_contrato_modelo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[4]= $this->marcarEtapa("Cadastro de Modelos de Contrato",true,374);
		}else{
			$this->itens[4]= $this->marcarEtapa("Cadastro de Modelos de Contrato",false,374);
		}
	}
	public function etapa6(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM configuracao_relacionamento WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[5]= $this->marcarEtapa("Configuração de Relacionamento",true,519);
		}else{
			$this->itens[5]= $this->marcarEtapa("Configuração de Relacionamento",false,519);
		}
	}
	
}