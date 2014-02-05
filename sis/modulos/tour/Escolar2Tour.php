<?

class Escolar2Tour extends Tour{
	
	const _ETAPAS = 14;
	const _TITULO = "Módulo Escolar";
	
	public function __construct(){
		$this->etapas=self::_ETAPAS;
		$this->titulo=self::_TITULO;
	}
	
	public function etapa1(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM escolar2_ensino WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[0]= $this->marcarEtapa("Cadastro de Estrutura Curricular",true,456);
		}else{
			$this->itens[0]= $this->marcarEtapa("Cadastro de Estrutura Curricular",false,456);
		}
	}
	public function etapa2(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM escolar2_series WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[1]= $this->marcarEtapa("Cadastro de Séries",true,456);
		}else{
			$this->itens[1]= $this->marcarEtapa("Cadastro de Séries",false,456);
		}
	}
	public function etapa3(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM escolar2_materias WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[2]= $this->marcarEtapa("Cadastro de Matérias",true,456);
		}else{
			$this->itens[2]= $this->marcarEtapa("Cadastro de Matérias",false,456);
		}
	}		
	public function etapa4(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_unidades WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[3] = ($qtd>0)?$this->marcarEtapa("Cadastro de Escolas",true,458):$this->marcarEtapa("Cadastro de Escolas",false,458);
	}
	public function etapa5(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_periodos_avaliacao WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[4] = ($qtd>0)?$this->marcarEtapa("Cadastro de Períodos de Avaliação",true,484):$this->marcarEtapa("Cadastro de Períodos de Avaliação",false,484);
	}
	public function etapa6(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM cargo_salario WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[5]= $this->marcarEtapa("Cadastro de Cargos",true,467);
		}else{
			$this->itens[5]= $this->marcarEtapa("Cadastro de Cargos",false,467);
		}
	}
	public function etapa7(){
		$qtd=mysql_result(mysql_query("SELECT count(*) FROM rh_funcionario WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[6]= $this->marcarEtapa("Cadastro de Funcionários",true,469);
		}else{
			$this->itens[6]= $this->marcarEtapa("Cadastro de Funcionários",false,469);
		}
	}
	public function etapa8(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_horarios WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[7]= $this->marcarEtapa("Cadastro de Horários",true,460);
		}else{
			$this->itens[7]= $this->marcarEtapa("Cadastro de Horários",false,460);
		}
	}
	
	public function etapa9(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_periodo_letivo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[8]= $this->marcarEtapa("Cadastro de Período Letivo",true,460);
		}else{
			$this->itens[8]= $this->marcarEtapa("Cadastro de Período Letivo",false,460);
		}
	}
	
	public function etapa10(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_turmas WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[9]= $this->marcarEtapa("Cadastro de Turmas",true,460);
		}else{
			$this->itens[9]= $this->marcarEtapa("Cadastro de Turmas",false,460);
		}
	}
	
		
	public function etapa11(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_periodos_avaliacao WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[10]= $this->marcarEtapa("Cadastro de Período de Avaliacao",true,484);
		}else{
			$this->itens[10]= $this->marcarEtapa("Cadastro de Período de Avaliacao",false,484);
		}
	}
	
	public function etapa12(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM odontologo_contrato_modelo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[11]= $this->marcarEtapa("Cadastro de Modelo de Contrato",true,477);
		}else{
			$this->itens[11]= $this->marcarEtapa("Cadastro de Modelo de Contrato",false,477);
		}
	}
	
	/* Matricular Aluno */
	public function etapa13(){
		$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(*) AS qtd FROM escolar2_matriculas WHERE vkt_id = '".$_SESSION['usuario']->cliente_vekttor_id."' "));
		
		if ($sql->qtd > 0)
			$this->itens[12]= $this->marcarEtapa("Cadastro de Matrículas ",true,462);
		else
			$this->itens[12]= $this->marcarEtapa("Cadastro de Matrículas ",false,462);
		
	}
	
	/* Horários do professor */
	public function etapa14(){
		$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(*) AS qtd FROM escolar2_professor_has_horario_dia WHERE vkt_id = '".$_SESSION['usuario']->cliente_vekttor_id."' "));
		
		if ($sql->qtd > 0)
			$this->itens[13]= $this->marcarEtapa("Cadastro de Horários do Professor",true,460);
		else
			$this->itens[13]= $this->marcarEtapa("Cadastro de Horários do Professor",false,460);
		
	}
	
}