CREATE OR REPLACE FUNCTION ssom.ft_equipo_responsable_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_equipo_responsable_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tequipo_responsable'
   AUTOR: 		 (max.camacho)
   FECHA:	        02-08-2019 14:03:25
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				02-08-2019 14:03:25								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tequipo_responsable'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'ssom.ft_equipo_responsable_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_EQRE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		02-08-2019 14:03:25
	***********************************/

	if(p_transaccion='SSOM_EQRE_SEL')then

		begin
			--Sentencia de la consulta
			--raise exception  '%',v_parametros.cantidad;

			v_consulta:='select
						eqre.id_equipo_responsable,
						eqre.id_funcionario,
						eqre.exp_tec_externo,
                        eqre.id_parametro,
                        eqre.obs_participante,
						eqre.estado_reg,
						eqre.id_aom,
						eqre.id_usuario_ai,
						eqre.id_usuario_reg,
						eqre.usuario_ai,
						eqre.fecha_reg,
						eqre.id_usuario_mod,
						eqre.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        aom.nombre_aom1,
                        vfc.desc_funcionario1,
                        par.valor_parametro,
                        par.codigo_parametro
						from ssom.tequipo_responsable eqre
						inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod

                        join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                        join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
            			inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
				        where /*vfc.fecha_finalizacion is null and*/ ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro; --=addFiltro
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_EQRE_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		02-08-2019 14:03:25
    ***********************************/

	elsif(p_transaccion='SSOM_EQRE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_equipo_responsable)
					    from ssom.tequipo_responsable eqre
						inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                        join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
            			inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
					    where vfc.fecha_finalizacion is null and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
   #TRANSACCION:  'SSOM_ECRA_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		max.camacho
   #FECHA:		02-08-2019 14:03:25
  ***********************************/

		/*elsif(p_transaccion='SSOM_ECRA_SEL')then

        begin
          --Sentencia de la consulta
              --raise exception  '%',v_parametros.cantidad;

        v_consulta:='select
              eqre.id_equipo_responsable,
              eqre.id_funcionario,
              eqre.exp_tec_externo,
                          eqre.id_parametro,
                          eqre.obs_participante,
              eqre.estado_reg,
              eqre.id_aom,
              eqre.id_usuario_ai,
              eqre.id_usuario_reg,
              eqre.usuario_ai,
              eqre.fecha_reg,
              eqre.id_usuario_mod,
              eqre.fecha_mod,
              usu1.cuenta as usr_reg,
              usu2.cuenta as usr_mod,
                          aom.nombre_aom1,
                          vfc.desc_funcionario1,
                          par.valor_parametro,
                          par.codigo_parametro
              from ssom.tequipo_responsable eqre
              inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
              left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod
                          join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                          join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
                    inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                  where vfc.fecha_finalizacion is null and  ';

        --Definicion de la respuesta
              --raise exception 'hola filtro %',v_parametros.filtro;
        v_consulta:=v_consulta||v_parametros.filtro; --=addFiltro
        v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
        --raise notice '%',v_consulta;
        --Devuelve la respuesta
        return v_consulta;

      end;*/

		/*********************************
     #TRANSACCION:  'SSOM_ECRA_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		02-08-2019 14:03:25
    ***********************************/

		/*elsif(p_transaccion='SSOM_ECRA_CONT')then

      begin
        --Sentencia de la consulta de conteo de registros
        v_consulta:='select count(id_equipo_responsable)
                from ssom.tequipo_responsable eqre
              inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
              left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod
                          join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                          join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
                    inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                where vfc.fecha_finalizacion is null and ';

        --Definicion de la respuesta
        v_consulta:=v_consulta||v_parametros.filtro;

        --Devuelve la respuesta
        return v_consulta;

      end; */

		/*========================================*/
		/*********************************
    #TRANSACCION:  'SSOM_MEQRE_SEL'
    #DESCRIPCION:	Consulta de datos
    #AUTOR:		max.camacho
    #FECHA:		02-08-2019 14:03:25
    ***********************************/

	elsif(p_transaccion='SSOM_MEQRE_SEL')then

		begin
			--Sentencia de la consulta
			--raise exception  '%',v_parametros.cantidad;
			v_consulta:='select
                        eqre.id_equipo_responsable,
                        eqre.id_funcionario,
                        eqre.exp_tec_externo,
                        eqre.id_parametro,
                        eqre.obs_participante,
                        eqre.estado_reg,
                        eqre.id_aom,
                        eqre.id_usuario_ai,
                        eqre.id_usuario_reg,
                        eqre.usuario_ai,
                        eqre.fecha_reg,
                        eqre.id_usuario_mod,
                        eqre.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        aom.nombre_aom1,
                        vfc.desc_funcionario1,
                        par.valor_parametro,
                        par.codigo_parametro
                        from ssom.tequipo_responsable eqre
                        inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                        join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
                        inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                        where vfc.fecha_finalizacion is null and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro; --=addFiltro
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_MEQRE_CONT'
    #DESCRIPCION:	Conteo de registros
    #AUTOR:		max.camacho
    #FECHA:		02-08-2019 14:03:25
    ***********************************/

	elsif(p_transaccion='SSOM_MEQRE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_equipo_responsable)
                        from ssom.tequipo_responsable eqre
                        inner join segu.tusuario usu1 on usu1.id_usuario = eqre.id_usuario_reg
                        left join segu.tusuario usu2 on usu2.id_usuario = eqre.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on eqre.id_aom = aom.id_aom
                        join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
                        inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                        where vfc.fecha_finalizacion is null and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*========================================*/

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