CREATE OR REPLACE FUNCTION ssom.ft_proceso_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_proceso_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tproceso'
   AUTOR: 		 (max.camacho)
   FECHA:	        15-07-2019 20:16:48
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				15-07-2019 20:16:48								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tproceso'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_proceso_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_PCS_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		15-07-2019 20:16:48
	***********************************/

	if(p_transaccion='SSOM_PCS_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						pcs.id_proceso,
						pcs.proceso,
						pcs.descrip_proceso,
						pcs.acronimo,
						pcs.estado_reg,
						pcs.id_responsable,
						pcs.codigo_proceso,
						pcs.vigencia,
						pcs.id_usuario_ai,
						pcs.usuario_ai,
						pcs.fecha_reg,
						pcs.id_usuario_reg,
						pcs.id_usuario_mod,
						pcs.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        vf.desc_funcionario1
                        --vig.vigencia
						from ssom.tproceso pcs
						inner join segu.tusuario usu1 on usu1.id_usuario = pcs.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pcs.id_usuario_mod
                        join orga.vfuncionario as vf on pcs.id_responsable=vf.id_funcionario
                        --join ssom.tvigencia as vig on pcs.id_vigencia=vig.id_vigencia
				        where  ';
			--uo.nombre_unidad
			--join orga.tuo as uo on pcs.id_responsable=uo.id_uo
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_PCS_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		15-07-2019 20:16:48
    ***********************************/

	elsif(p_transaccion='SSOM_PCS_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_proceso)
					    from ssom.tproceso pcs
					    inner join segu.tusuario usu1 on usu1.id_usuario = pcs.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pcs.id_usuario_mod
                        join orga.vfuncionario as vf on pcs.id_responsable=vf.id_funcionario
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*++++++++++  Inicio adicion de funciones  ++++++++++++*/
		/**********************************
        #TRANSACCION:  'SSOM_PCSE1_SEL'
        #DESCRIPCION:	Consulta de datos de UO
        #AUTOR:		max.camacho
        #FECHA:		15-07-2019 20:16:48
        ***********************************/

	elsif(p_transaccion='SSOM_PCSE1_SEL')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
                  id_uo,
                  nombre_unidad
                  from orga.tuo
                  where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;
		/**********************************
    #TRANSACCION:  'SSOM_PCSE1_CONT'
    #DESCRIPCION:	Conteo de registros de UO
    #AUTOR:		max.camacho
    #FECHA:		15-07-2019 20:16:48
    ***********************************/
	elsif(p_transaccion='SSOM_PCSE1_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_uo)
                      from orga.tuo
                      where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
		/*++++++++++++ Fin adicion de funciones  +++++++++++++*/

	else

		raise exception 'Transaccion inexistente';

	end if;

	EXCEPTION

	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
END;
$body$
	LANGUAGE 'plpgsql'
	VOLATILE
	CALLED ON NULL INPUT
	SECURITY INVOKER
	COST 100;