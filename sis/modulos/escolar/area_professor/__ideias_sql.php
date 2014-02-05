<?

While
1 - SELECT distinct(h.periodo_id), p.nome FROM escolar_sala_materia_professor as smp, escola_sala as s, escola_horario as h, escolar_periodo WHERE smp.sal_id=s.id AND s.horario_id=h.id AND h.periodo_id=p.id
	// curso
	while
	2 - SELECT distinct(s.curso_id), c.nome FROM escolar_sala_materia_professor as smp, escola_sala as s, escola_horario as h,  escolar_cursos as c WHERE smp.sal_id=s.id AND s.curso_id=c.id  AND h.periodo_id='$perido->periodo_id'  	// Modulo
		while
		3 - SELECT distinct(s.modulo_id), m.nome FROM escolar_sala_materia_professor as smp, escola_sala as s, escola_horario as h,  escolar_modulos as m WHERE smp.sal_id=s.id AND s.modulo_id=m.id AND h.periodo_id='$perido->id'  AND h.curso_id='$curso->curso_id'
			// Horario
			4 - SELECT distinct(s.horario_id), h.nome FROM escolar_sala_materia_professor as smp, escola_sala as s, escola_horario as h WHERE smp.sal_id=s.id AND s.horario_id=h.id
				// Sala 
				5 - SELECT s.nome FROM  escolar_sala_materia_professor as smp, escola_sala as s WHERE smp.sal_id=s.id AND s.horario_id='$horario->id'
					// Materuas
						6 - SELECT m.nome,m.id FROM  escolar_sala_materia_professor as smp, escolar_materias as m WHERE smp.materia_id=m.id AND smp.sala_id='$sala->id'


?>