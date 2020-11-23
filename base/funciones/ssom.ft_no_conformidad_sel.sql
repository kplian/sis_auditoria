CREATE OR REPLACE FUNCTION ssom.ft_no_conformidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_no_conformidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tno_conformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        04-07-2019 19:53:16
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				04-07-2019 19:53:16								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tno_conformidad'
 #3				04-08-2020 19:53:16								Refactorización No Conformidad
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_id_parametro 		integer;
    v_filtro			varchar;
    v_id_uo				integer;
    v_id_aom			integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_no_conformidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_NOCONF_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	if(p_transaccion='SSOM_NOCONF_SEL')then

    	begin



    		--Sentencia de la consulta


			v_consulta:='select   noconf.id_nc,
                                  noconf.obs_consultor,
                                  noconf.estado_reg,
                                  noconf.evidencia,
                                  noconf.id_funcionario,
                                  noconf.id_uo,
                                  noconf.descrip_nc,
                                  noconf.id_parametro,
                                  noconf.obs_resp_area,
                                  noconf.id_aom,
                                  noconf.fecha_reg,
                                  noconf.usuario_ai,
                                  noconf.id_usuario_reg,
                                  noconf.id_usuario_ai,
                                  noconf.id_usuario_mod,
                                  noconf.fecha_mod,
                                  noconf.id_uo_adicional,
                                  noconf.id_proceso_wf,	--integrar con wf new
                                  noconf.id_estado_wf, 	--integrar con wf new
                                  noconf.nro_tramite,
                                  noconf.estado_wf,
                                  noconf.codigo_nc,
                                  noconf.id_funcionario_nc,
                                  usu1.cuenta as usr_reg,
                                  usu2.cuenta as usr_mod,
                                  param.valor_parametro,
                                  initcap(unorg1.nombre_unidad)::varchar as gerencia_uo1,
                                  initcap(ofunc.desc_funcionario1) as funcionario_uo,
                                  noconf.calidad,
                                  noconf.medio_ambiente,
                                  noconf.seguridad,
                                  noconf.responsabilidad_social,
                                  noconf.sistemas_integrados,
                                  noconf.revisar,
                                  noconf.rechazar,
                                  aom.nro_tramite_wf ||'' - '' || aom.nombre_aom1 as auditoria,
                                  aomuo.nombre_unidad as uo_aom,
                                  mafun.desc_funcionario1 as aom_funcionario_resp,
                                  rfun.desc_funcionario1 as funcionario_resp_nc,
                                  ts.etapa  as nombre_estado
                                  from ssom.tno_conformidad noconf
                                  inner join segu.tusuario usu1 on usu1.id_usuario = noconf.id_usuario_reg
                                  inner join ssom.tparametro param on param.id_parametro = noconf.id_parametro
                                  inner join orga.tuo unorg1 on unorg1.id_uo = noconf.id_uo
                                  inner join ssom.tauditoria_oportunidad_mejora aom on aom.id_aom  = noconf.id_aom
                                  inner join orga.vfuncionario mafun on mafun.id_funcionario = aom.id_funcionario
                                  inner join orga.tuo aomuo on aomuo.id_uo = aom.id_uo
                                  inner join wf.testado_wf es on es.id_estado_wf = noconf.id_estado_wf
        						  inner join wf.ttipo_estado ts on ts.id_tipo_estado = es.id_tipo_estado
                                  left join segu.tusuario usu2 on usu2.id_usuario = noconf.id_usuario_mod
                                  left join orga.vfuncionario ofunc on ofunc.id_funcionario = noconf.id_funcionario
                                  left join orga.vfuncionario rfun on rfun.id_funcionario = noconf.id_funcionario_nc
				       			  where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'SSOM_NOCONF_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/

	elsif(p_transaccion='SSOM_NOCONF_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros

			v_consulta:='select count(id_nc)
                        from ssom.tno_conformidad noconf
                        inner join segu.tusuario usu1 on usu1.id_usuario = noconf.id_usuario_reg
                        inner join ssom.tparametro param on param.id_parametro = noconf.id_parametro
                        inner join orga.tuo unorg1 on unorg1.id_uo = noconf.id_uo
                        inner join ssom.tauditoria_oportunidad_mejora aom on aom.id_aom  = noconf.id_aom
                        inner join orga.vfuncionario mafun on mafun.id_funcionario = aom.id_funcionario
                        inner join orga.tuo aomuo on aomuo.id_uo = aom.id_uo
                        inner join wf.testado_wf es on es.id_estado_wf = noconf.id_estado_wf
        				inner join wf.ttipo_estado ts on ts.id_tipo_estado = es.id_tipo_estado
                        left join segu.tusuario usu2 on usu2.id_usuario = noconf.id_usuario_mod
                        left join orga.vfuncionario ofunc on ofunc.id_funcionario = noconf.id_funcionario
                        left join orga.vfuncionario rfun on rfun.id_funcionario = noconf.id_funcionario_nc
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;



    /*********************************
 	#TRANSACCION:  'SSOM_USU_SEL'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_USU_SEL')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT
                          ofunc.id_uo_funcionario,
                          ofunc.id_funcionario,
                          ofunc.desc_funcionario1,
                          ofunc.desc_funcionario2,
                          ofunc.id_uo,
                          ofunc.nombre_cargo,
                          ofunc.fecha_asignacion,
                          ofunc.fecha_finalizacion,
                          ofunc.num_doc,
                          ofunc.ci,
                          ofunc.codigo,
                          ofunc.email_empresa,
                          ofunc.estado_reg_fun,
                          ofunc.estado_reg_asi,
                          ofunc.id_cargo,
                          ofunc.descripcion_cargo,
                          ofunc.cargo_codigo,
                          ofunc.nombre_unidad
                          FROM orga.vfuncionario_cargo ofunc
					      WHERE ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;
	/*********************************
 	#TRANSACCION:  'SSOM_USU_CONT'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-07-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_USU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT
            				count(ofunc.id_funcionario)
                         FROM orga.vfuncionario_cargo ofunc
					      where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;


	/*********************************
 	#TRANSACCION:  'SSOM_RPT_NOCONF'
 	#DESCRIPCION:	reporte de registros
 	#AUTOR:		szambrana
 	#FECHA:		27-09-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_RPT_NOCONF')then

		begin
          -- raise exception '%',v_parametros.id_proceso_wf;


          select aom.id_aom into v_id_aom
          from ssom.tauditoria_oportunidad_mejora aom
          where aom.id_proceso_wf = v_parametros.id_proceso_wf;

            v_consulta:= 'select   au.id_aom,
                                   au.id_proceso_wf,
                                   au.nro_tramite_wf,
                                    au.nombre_aom1,
                                   initcap(fu.desc_funcionario1)::varchar as Responsable,
                                   initcap(pn.valor_parametro)::varchar as tipo_norma,
                                   initcap(po.valor_parametro)::varchar as tipo_objeto,
                                   pa.valor_parametro,
                                   nc.descrip_nc,
                                   nc.evidencia
                            from ssom.tauditoria_oportunidad_mejora au
                            inner join orga.vfuncionario fu on fu.id_funcionario = au.id_funcionario
                            inner join ssom.tparametro pn on pn.id_parametro = au.id_tnorma
                            inner join ssom.tparametro po on po.id_parametro = au.id_tobjeto
                            inner join ssom.tno_conformidad nc on nc.id_aom = au.id_aom
                            inner join ssom.tparametro  pa on pa.id_parametro = nc.id_parametro
                            where nc.id_aom ='||v_id_aom;

			--Devuelve la respuesta
			return v_consulta;

		end;


    /*********************************
 	#TRANSACCION:  'SSOM_FUO_SEL'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		szambrana
 	#FECHA:		04-12-2019 19:53:16
	***********************************/
    elsif(p_transaccion='SSOM_FUO_SEL')then

		begin

        	--listado de funcionarios de una UO
			v_consulta:=' SELECT  vfc.id_funcionario,
                                  vfc.desc_funcionario1 as desc_funcionario
                          FROM orga.vfuncionario_cargo vfc
                          WHERE( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date)
                              and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
			return v_consulta;

		end;
        /*********************************
        #TRANSACCION:  'SSOM_FUO_CONT'
        #DESCRIPCION:	sel de registros
        #AUTOR:		szambrana
        #FECHA:		04-07-2019 19:53:16
        ***********************************/

    elsif(p_transaccion='SSOM_FUO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='SELECT  count(vfc.id_funcionario)
                        FROM orga.vfuncionario_cargo vfc
                        WHERE( vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date)
                        and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			--Devuelve la respuesta
			return v_consulta;

		end;


    /*********************************
 	#TRANSACCION:  'SSOM_NOCF_SEL'
 	#DESCRIPCION:	sel de registros
 	#AUTOR:		MMV
 	#FECHA:		2-10-2020
	***********************************/
    elsif(p_transaccion='SSOM_NOCF_SEL')then

		begin

        	--listado de funcionarios de una UO
			v_consulta:='select	nof.id_nc,
                                nof.obs_consultor,
                                nof.estado_reg,
                                nof.evidencia,
                                nof.id_funcionario,
                                nof.id_uo,
                                nof.descrip_nc,
                                nof.id_parametro,
                                nof.obs_resp_area,
                                nof.id_aom,
                                nof.fecha_reg,
                                nof.usuario_ai,
                                nof.id_usuario_reg,
                                nof.id_usuario_ai,
                                nof.id_usuario_mod,
                                nof.fecha_mod,
                                nof.id_uo_adicional,
                                nof.id_proceso_wf,
                                nof.id_estado_wf,
                                nof.nro_tramite,
                                nof.estado_wf,
                                nof.codigo_nc,
                                nof.id_funcionario_nc,
                                usu1.cuenta as usr_reg,
                                usu2.cuenta as usr_mod,
                                aom.nro_tramite_wf,
                                aom.nombre_aom1,
                                pam.valor_parametro,
                                fun.desc_funcionario1 as responsable_auditoria,
                                uo.nombre_unidad as uo_auditoria,
                                uono.nombre_unidad as nof_auditoria,
                                aom.nro_tramite_wf ||'' - '' || aom.nombre_aom1 as auditoria,
                                funo.desc_funcionario1 as funcionario_resp_nof,
                                nof.calidad,
                                nof.medio_ambiente,
                                nof.seguridad,
                                nof.responsabilidad_social,
                                nof.sistemas_integrados
                                from ssom.tno_conformidad nof
                                inner join segu.tusuario usu1 on usu1.id_usuario = nof.id_usuario_reg
                                inner join ssom.tauditoria_oportunidad_mejora aom on aom.id_aom = nof.id_aom
                                inner join ssom.tparametro pam on pam.id_parametro = nof.id_parametro
                                inner join orga.vfuncionario fun on fun.id_funcionario = aom.id_funcionario
                                inner join orga.tuo uo on uo.id_uo = aom.id_uo
                                inner join orga.tuo uono on uono.id_uo = nof.id_uo
                                left join segu.tusuario usu2 on usu2.id_usuario = nof.id_usuario_mod
                                left join orga.vfuncionario funo on funo.id_funcionario = nof.id_funcionario_nc
                                where';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
            raise notice '%',v_consulta;
			return v_consulta;

		end;
        /*********************************
        #TRANSACCION:  'SSOM_NOCF_CONT'
        #DESCRIPCION:	sel de registros
        #AUTOR:		MMV
        #FECHA:		2-10-2020
        ***********************************/

    elsif(p_transaccion='SSOM_NOCF_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count (nof.id_nc)
                          from ssom.tno_conformidad nof
                          inner join segu.tusuario usu1 on usu1.id_usuario = nof.id_usuario_reg
                          inner join ssom.tauditoria_oportunidad_mejora aom on aom.id_aom = nof.id_aom
                          inner join ssom.tparametro pam on pam.id_parametro = nof.id_parametro
                          inner join orga.vfuncionario fun on fun.id_funcionario = aom.id_funcionario
                          inner join orga.tuo uo on uo.id_uo = aom.id_uo
                          inner join orga.tuo uono on uono.id_uo = nof.id_uo
                          left join segu.tusuario usu2 on usu2.id_usuario = nof.id_usuario_mod
                          left join orga.vfuncionario funo on funo.id_funcionario = nof.id_funcionario_nc
                          where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			--Devuelve la respuesta
			return v_consulta;

		end;
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
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.ft_no_conformidad_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;