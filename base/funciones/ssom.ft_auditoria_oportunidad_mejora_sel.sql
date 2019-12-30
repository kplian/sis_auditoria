CREATE OR REPLACE FUNCTION ssom.ft_auditoria_oportunidad_mejora_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_oportunidad_mejora_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_oportunidad_mejora'
   AUTOR: 		 (max.camacho)
   FECHA:	        17-07-2019 17:41:55
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				17-07-2019 17:41:55								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_oportunidad_mejora'
   #
   ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

	v_bandera 			varchar;
	v_p                 varchar;
	v_param_estado		varchar;

	v_filtro_unidad     varchar;
	v_estado            varchar;

	--variables para consult SSOM_AUDSTATUS_SEL
	v_id_proceso_macro 	integer;
	v_codigo_pm 		varchar;
	v_nombre_pm 		varchar;
	v_id_tipo_proceso 	integer;
	v_codigo_tp 		varchar;
	v_nombre_tp 		varchar;

	v_codigo_tipo_aom	varchar;
	v_codigo_dpto		varchar;
	v_id_depto          integer;

	v_codigo_parametro  varchar;
	v_id_uo_i			integer;

BEGIN

	v_nombre_funcion = 'ssom.ft_auditoria_oportunidad_mejora_sel';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_AOM_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		17-07-2019 17:41:55
	***********************************/

	if(p_transaccion='SSOM_AOM_SEL')then

		begin

			--Sentencia de la consulta
			v_consulta:='select
						aom.id_aom,
						aom.id_proceso_wf,
						aom.nro_tramite_wf,
						aom.resumen,
						aom.id_funcionario,
						aom.fecha_prog_inicio,
						aom.recomendacion,
						aom.id_uo,
						aom.id_gconsultivo,
						aom.fecha_prev_inicio,
						aom.fecha_prev_fin,
						aom.fecha_prog_fin,
						aom.descrip_aom2,
						aom.nombre_aom1,
						aom.documento,
						aom.estado_reg,
						aom.estado_wf,
                        aom.id_tobjeto,
                        --vpto.valor_parametro_to as objeto_auditoria,
						--(CASE WHEN aom.id_tobjeto is null THEN null ELSE (select valor_parametro from ssom.tparametro where id_parametro=aom.id_tobjeto::integer) END) id_tobjeto,
						aom.id_estado_wf,
						--(CASE WHEN aom.id_tnorma is null THEN null ELSE (select valor_parametro from ssom.tparametro where id_parametro=aom.id_tnorma::integer) END) id_tnorma,
                        --vptn.valor_parametro_tn as ctrl_norma_auditoria,
                        aom.id_tnorma,
						aom.fecha_eje_inicio,
						aom.codigo_aom,
						aom.id_tipo_auditoria,
						aom.descrip_aom1,
						aom.lugar,
						aom.id_tipo_om,
                        aom.formulario_ingreso,
                        aom.estado_form_ingreso,
						aom.fecha_eje_fin,
						aom.nombre_aom2,
						aom.id_usuario_ai,
						aom.fecha_reg,
						aom.usuario_ai,
						aom.id_usuario_reg,
						aom.id_usuario_mod,
						aom.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        tau.tipo_auditoria,
                        uo.nombre_unidad,
                        gct.nombre_gconsultivo,
                        vfc.desc_funcionario1,
                        vfc.desc_funcionario2,
                        vpto.valor_parametro_to as desc_tipo_objeto,--objeto_auditoria,
                        vptn.valor_parametro_tn as desc_tipo_norma,--tipo_ctrl_auditoria,
                        vptn.codigo_parametro,
                        vptom.valor_parametro_tom as desc_tipo_om,
                        tew.nombre_estado,
                        tau.codigo_tpo_aom,
                        gct.requiere_programacion,
                        gct.requiere_formulario,
                        (select count(*) from unnest(pw.id_tipo_estado_wfs) elemento where elemento = ew.id_tipo_estado)::integer as contador_estados
						from ssom.tauditoria_oportunidad_mejora aom
						inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                        left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                        left join orga.tuo as uo on aom.id_uo=uo.id_uo
                        left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                        left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                        left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                        left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                        left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                        --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                        --left join ssom.vestado_wf_aom ewfa on aom.id_aom = ewfa.id_aom
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = aom.id_proceso_wf
                        left join wf.testado_wf ew on ew.id_estado_wf = aom.id_estado_wf
                        left join wf.ttipo_estado tew on tew.id_tipo_estado = ew.id_tipo_estado
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'group by aom.id_aom,usu1.cuenta,usu2.cuenta,tau.tipo_auditoria
            						,uo.nombre_unidad,gct.nombre_gconsultivo,vfc.desc_funcionario1,vfc.desc_funcionario2
                                    ,vpto.valor_parametro_to,vptn.valor_parametro_tn,vptn.codigo_parametro,vptom.valor_parametro_tom
                                    ,tew.nombre_estado,tau.codigo_tpo_aom,gct.requiere_programacion
                                    ,gct.requiere_formulario,aom.id_proceso_wf, ew.id_tipo_estado
                                    , pw.id_tipo_estado_wfs order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			RAISE NOTICE 'v_consulta %',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_AOM_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOM_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(aom.id_aom)
					    from ssom.tauditoria_oportunidad_mejora aom
					    inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                        left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                        left join orga.tuo as uo on aom.id_uo=uo.id_uo
                        left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                        left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                        left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                        left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                        left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                        --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                        --left join ssom.vestado_wf_aom ewfa on aom.id_aom = ewfa.id_aom
                        left join wf.tproceso_wf pw on pw.id_proceso_wf = aom.id_proceso_wf
                        left join wf.testado_wf ew on ew.id_estado_wf = aom.id_estado_wf
                        left join wf.ttipo_estado tew on tew.id_tipo_estado = ew.id_tipo_estado
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'group by aom.id_aom,usu1.cuenta,usu2.cuenta,tau.tipo_auditoria
            						,uo.nombre_unidad,gct.nombre_gconsultivo,vfc.desc_funcionario1,vfc.desc_funcionario2
                                    ,vpto.valor_parametro_to,vptn.valor_parametro_tn,vptn.codigo_parametro,vptom.valor_parametro_tom
                                    ,tew.nombre_estado,tau.codigo_tpo_aom,gct.requiere_programacion
                                    ,gct.requiere_formulario,aom.id_proceso_wf, ew.id_tipo_estado
                                    , pw.id_tipo_estado_wfs order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*+++++++++++++  Inicio  +++++++++++++++*/
		/*********************************
    #TRANSACCION:  'SSOM_AOMX1_SEL'
    #DESCRIPCION:	Consult area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOMX1_SEL')then
		v_bandera = pxp.f_get_variable_global('ssom_exc_nivel_organizacional');
		begin
			--Sentencia de la consulta
			v_consulta:='select
                            id_uo,
                            nombre_unidad,
                            codigo,
                            id_nivel_organizacional as nivel_organizacional
                            from orga.tuo
                            where estado_reg = ''activo'' and id_nivel_organizacional not in ('||v_bandera||') and';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			RAISE NOTICE 'v_consulta %',v_consulta ;
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_AOMX1_CONT'
    #DESCRIPCION:	Count area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOMX1_CONT')then
		v_bandera = pxp.f_get_variable_global('ssom_exc_nivel_organizacional');
		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(uo.id_uo)
                            from orga.tuo as uo
                            where estado_reg = ''activo'' and id_nivel_organizacional not in ('||v_bandera||') and';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_AOMX2_SEL'
    #DESCRIPCION:	Consult lista funcionario activos
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOMX2_SEL')then
		--v_bandera = pxp.f_get_variable_global('ssom_exc_nivel_organizacional');
		begin
			--Sentencia de la consulta
			v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');

			select
				id_depto
				into
					v_id_depto
			from param.tdepto
			where codigo = ''||v_codigo_dpto||'' and estado_reg = 'activo';

			--raise exception 'deptoooooooooo %', v_id_depto;
			v_consulta:='select
                                vfcx.id_persona,
                                vfcx.id_funcionario,
                                vfcx.desc_funcionario1||'' ''||''(''||(case when (depusu.cargo=''administrador'') then ''Responsable'' when (depusu.cargo=''responsable'') then ''Interno'' else ''En entrenamiento'' end)||'')'' desc_funcionario1,
                                vfcx.desc_funcionario2||'' ''||''(''||(case when (depusu.cargo=''administrador'') then ''Responsable'' when (depusu.cargo=''responsable'') then ''Interno'' else ''En entrenamiento'' end)||'')'' desc_funcionario2,
                                vfcx.nombre_cargo,
                                vfcx.descripcion_cargo,
                                vfcx.cargo_codigo,
                                vfcx.id_uo,
                                vfcx.nombre_unidad
                                from param.tdepto_usuario depusu
                                inner join segu.tusuario usu1 on usu1.id_usuario = depusu.id_usuario_reg
                                left join segu.tusuario usu2 on usu2.id_usuario = depusu.id_usuario_mod
                                inner join segu.tusuario usudep on usudep.id_usuario=depusu.id_usuario
                                inner join segu.vpersona person on person.id_persona=usudep.id_persona
                                inner join orga.vfuncionario_cargo_xtra vfcx on vfcx.id_persona = person.id_persona
                                --where depusu.id_depto = 56 and vfcx.fecha_finalizacion is null
                                where depusu.id_depto = '||v_id_depto||' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and depusu.cargo in (''administrador'',''responsable'') and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			RAISE NOTICE 'v_consulta %',v_consulta ;
			return v_consulta;

		end;
		/*********************************
    #TRANSACCION:  'SSOM_AOMX2_CONT'
    #DESCRIPCION:	Count funcionarios
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOMX2_CONT')then
		--v_bandera = pxp.f_get_variable_global('ssom_exc_nivel_organizacional');
		begin
			--Sentencia de la consulta de conteo de registros
			v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');

			select
				id_depto
				into
					v_id_depto
			from param.tdepto
			where codigo = ''||v_codigo_dpto||'' and estado_reg = 'activo';

			--raise exception 'deptoooooooooo %', v_id_depto;
			v_consulta:='select count(vfcx.id_funcionario)
                            from param.tdepto_usuario depusu
                            inner join segu.tusuario usu1 on usu1.id_usuario = depusu.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = depusu.id_usuario_mod
                            inner join segu.tusuario usudep on usudep.id_usuario=depusu.id_usuario
                            inner join segu.vpersona person on person.id_persona=usudep.id_persona
                            inner join orga.vfuncionario_cargo_xtra vfcx on vfcx.id_persona = person.id_persona
                            --where depusu.id_depto = 56 and vfcx.fecha_finalizacion is null
                            where depusu.id_depto = '||v_id_depto||' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and depusu.cargo in (''administrador'',''responsable'') and ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_ADPTO_SEL'
    #DESCRIPCION:	Consult lista funcionario activos
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_ADPTO_SEL')then

		begin
			--Sentencia de la consulta
			--raise EXCEPTION '-----> %',v_parametros.p_codigo_parametro;
			v_codigo_parametro = v_parametros.p_codigo_parametro;
			v_id_uo_i = v_parametros.p_id_uo_i;
			--raise exception 'hola id_uo_i %',v_id_uo_i;
			if ( v_codigo_parametro = 'MEQ' ) then

				v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');

				select
					id_depto
					into
						v_id_depto
				from param.tdepto
				where codigo = ''||v_codigo_dpto||'' and estado_reg = 'activo';

				--raise exception 'deptoooooooooo %', v_id_depto;
				v_consulta:='select
                                vfcx.id_persona,
                                vfcx.id_funcionario,
                                vfcx.desc_funcionario1||'' ''||''(''||(case when (depusu.cargo=''administrador'') then ''Responsable'' when (depusu.cargo=''responsable'') then ''Interno'' else ''En entrenamiento'' end)||'')'' desc_funcionario1,
                                vfcx.desc_funcionario2||'' ''||''(''||(case when (depusu.cargo=''administrador'') then ''Responsable'' when (depusu.cargo=''responsable'') then ''Interno'' else ''En entrenamiento'' end)||'')'' desc_funcionario2,
                                vfcx.nombre_cargo,
                                vfcx.descripcion_cargo,
                                vfcx.cargo_codigo,
                                vfcx.id_uo,
                                vfcx.nombre_unidad
                                from param.tdepto_usuario depusu
                                inner join segu.tusuario usu1 on usu1.id_usuario = depusu.id_usuario_reg
                                left join segu.tusuario usu2 on usu2.id_usuario = depusu.id_usuario_mod
                                inner join segu.tusuario usudep on usudep.id_usuario=depusu.id_usuario
                                inner join segu.vpersona person on person.id_persona=usudep.id_persona
                                inner join orga.vfuncionario_cargo_xtra vfcx on vfcx.id_persona = person.id_persona
                                where depusu.id_depto = '||v_id_depto||' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and';

			end if;
			if (v_codigo_parametro = 'ETI' or v_codigo_parametro = 'RESP' ) then

				--v_codigo_dpto = v_parametros.p_id_uo_i;

				v_consulta:= 'SELECT
                                      vfcx.id_persona
                                      ,vfcx.id_funcionario
                                      ,vfcx.desc_funcionario1
                                      ,vfcx.desc_funcionario2
                                      ,vfcx.nombre_cargo
                                      ,vfcx.descripcion_cargo
                                      ,vfcx.cargo_codigo
                                      ,vfcx.id_uo
                                      ,vfcx.nombre_unidad
                                  from orga.vfuncionario_cargo_xtra vfcx
                                  where vfcx.id_funcionario not in (

                                  select
                                      --ss.id_persona
                                      ss.id_funcionario
                                      /*,ss.desc_funcionario1
                                      ,ss.desc_funcionario2
                                      ,ss.nombre_cargo
                                      ,ss.descripcion_cargo
                                      ,ss.cargo_codigo
                                      ,ss.id_uo
                                      ,ss.nombre_unidad*/
                                  from (WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                                                     SELECT
                                                        euo.id_uo_hijo,--id
                                                        id_uo_padre---padre
                                                     FROM orga.testructura_uo euo
                                                     WHERE euo.id_uo_hijo = '||v_id_uo_i||' and euo.estado_reg = ''activo''
                                                     UNION
                                                        SELECT
                                                           e.id_uo_hijo,
                                                           e.id_uo_padre
                                                        FROM
                                                           orga.testructura_uo e
                                                        INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''activo''
                                                  )
                                                  SELECT
                                                    suo.id_uo_hijo
                                                    ,suo.id_uo_padre
                                                    ,vfc.id_persona
                                                    ,vfc.id_funcionario
                                                    ,vfc.desc_funcionario1
                                                    ,vfc.desc_funcionario2
                                                    ,vfc.nombre_cargo
                                                    ,vfc.descripcion_cargo
                                                    ,vfc.cargo_codigo
                                                    ,vfc.id_uo
                                                    ,vfc.nombre_unidad
                                                  FROM uo_mas_subordinados suo
                                                  inner join orga.vfuncionario_cargo_xtra vfc on suo.id_uo_hijo = vfc.id_uo
                                                  where (vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date)) ss) and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()::date) and ';

			end if;

			--v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');


			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--raise exception 'deptoooooooooo %', v_consulta;
			--Devuelve la respuesta
			RAISE NOTICE 'v_consulta %',v_consulta ;
			return v_consulta;

		end;
		/*********************************
    #TRANSACCION:  'SSOM_ADPTO_CONT'
    #DESCRIPCION:	Count funcionarios
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_ADPTO_CONT')then
		v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');
		begin
			--Sentencia de la consulta de conteo de registros

			v_codigo_parametro = v_parametros.p_codigo_parametro;
			v_id_uo_i = v_parametros.p_id_uo_i;

			select id_depto
						 into v_id_depto
			from param.tdepto
			where codigo = ''||v_codigo_dpto||'' and estado_reg = 'activo';

			if (v_codigo_parametro = 'MEQ') then
				v_codigo_dpto = pxp.f_get_variable_global('ssom_parametro_codigo_dpto');

				v_consulta:='select count (vfcx.id_funcionario)
                                from param.tdepto_usuario depusu
                                inner join segu.tusuario usu1 on usu1.id_usuario = depusu.id_usuario_reg
                                left join segu.tusuario usu2 on usu2.id_usuario = depusu.id_usuario_mod
                                inner join segu.tusuario usudep on usudep.id_usuario=depusu.id_usuario
                                inner join segu.vpersona person on person.id_persona=usudep.id_persona
                                inner join orga.vfuncionario_cargo_xtra vfcx on vfcx.id_persona = person.id_persona
                                where depusu.id_depto = '||v_id_depto||' and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()) and';

			end if;

			if (v_codigo_parametro = 'ETI' or v_codigo_parametro = 'RESP') then

				v_consulta:= 'select count(vfcx.id_funcionario)

                                  from orga.vfuncionario_cargo_xtra vfcx
                                  where vfcx.id_funcionario not in (

                                  select
                                      --ss.id_persona
                                      ss.id_funcionario
                                      /*,ss.desc_funcionario1
                                      ,ss.desc_funcionario2
                                      ,ss.nombre_cargo
                                      ,ss.descripcion_cargo
                                      ,ss.cargo_codigo
                                      ,ss.id_uo
                                      ,ss.nombre_unidad*/
                                  from (WITH RECURSIVE uo_mas_subordinados(id_uo_hijo,id_uo_padre) AS (
                                                     SELECT
                                                        euo.id_uo_hijo,--id
                                                        id_uo_padre---padre
                                                     FROM orga.testructura_uo euo
                                                     WHERE euo.id_uo_hijo = '||v_id_uo_i||' and euo.estado_reg = ''activo''
                                                     UNION
                                                        SELECT
                                                           e.id_uo_hijo,
                                                           e.id_uo_padre
                                                        FROM
                                                           orga.testructura_uo e
                                                        INNER JOIN uo_mas_subordinados s ON s.id_uo_hijo = e.id_uo_padre and e.estado_reg = ''activo''
                                                  )
                                                  SELECT
                                                    suo.id_uo_hijo
                                                    ,suo.id_uo_padre
                                                    ,vfc.id_persona
                                                    ,vfc.id_funcionario
                                                    ,vfc.desc_funcionario1
                                                    ,vfc.desc_funcionario2
                                                    ,vfc.nombre_cargo
                                                    ,vfc.descripcion_cargo
                                                    ,vfc.cargo_codigo
                                                    ,vfc.id_uo
                                                    ,vfc.nombre_unidad
                                                  FROM uo_mas_subordinados suo
                                                  inner join orga.vfuncionario_cargo_xtra vfc on suo.id_uo_hijo = vfc.id_uo
                                                  where (vfc.fecha_finalizacion is null or vfc.fecha_finalizacion >= now()::date)) ss) and (vfcx.fecha_finalizacion is null or vfcx.fecha_finalizacion >= now()::date) and ';
			end if;

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
   #TRANSACCION:  'SSOM_AOMX3_SEL'
   #DESCRIPCION:	Consult area list
   #AUTOR:		max.camacho
   #FECHA:		17-07-2019 17:41:55
   ***********************************/

	elsif(p_transaccion='SSOM_AOMX3_SEL')then
		begin
			--Sentencia de la consulta
			v_consulta:='select id_aom, codigo_aom
                            from ssom.tauditoria_oportunidad_mejora
                            where codigo_aom <> ''''  and';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			RAISE NOTICE 'v_consulta %',v_consulta ;
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_AOMX3_CONT'
    #DESCRIPCION:	Count area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AOMX3_CONT')then
		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_aom)
                             from ssom.tauditoria_oportunidad_mejora
                        where codigo_aom <> ''''  and';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_RPTA1_SEL'
    #DESCRIPCION:	Consult area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_RPTA1_SEL')then
		begin
			--Sentencia de la consulta
			--raise EXCEPTION 'Hola valor de unidad exception %',v_parametros.p_unidad;
			--raise EXCEPTION 'valor del filtro estado %', v_parametros.p_estado;
			v_estado = ''||v_parametros.p_estado||'';
			v_codigo_tipo_aom = pxp.f_get_variable_global('ssom_codigo_tipo_auditoria_interna');


			if(v_parametros.p_id_unidad = 0) then
				begin
					v_filtro_unidad = '';
				end;
			elsif (v_parametros.p_id_unidad > 0) then

				begin
					v_filtro_unidad = ' and aom.id_uo = '||v_parametros.p_id_unidad;
				end;
			end if;

			v_consulta:='select
						aom.id_aom,
                        aom.codigo_aom,
                        aom.nro_tramite_wf,
                        aom.id_tipo_auditoria,
                        tau.tipo_auditoria,
                        tau.codigo_tpo_aom,
                        aom.nombre_aom1,
                        aom.descrip_aom1,
                        aom.id_tnorma,
                        vptn.valor_parametro_tn as tipo_ctrl_auditoria,
                        aom.id_uo,
                        uo.nombre_unidad,
                        aom.fecha_prog_inicio::date,
                        aom.fecha_prog_fin::date,
                        aom.id_tipo_om,
                        vptom.valor_parametro_tom as valor_tipo_om,
                        aom.estado_wf,
                        --pwf.fill_codigo,
                        pwf.fill_nombre_estado,
                        aom.id_funcionario,
                        --vfc.desc_funcionario1::varchar
                        (select ssom.f_list_funcionarios_responsables(aom.id_aom,'''||v_estado||''')) as desc_funcionario1
                        --aom.id_gconsultivo,
                        --gct.nombre_gconsultivo
						from ssom.tauditoria_oportunidad_mejora aom
						inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                        left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                        left join orga.tuo as uo on aom.id_uo=uo.id_uo
                        --left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                        left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                        left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                        --left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                        left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                        --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                        join (select * from ssom.f_list_process_wf_audit_rfe('''||v_parametros.p_fecha_de||''','''||v_parametros.p_fecha_hasta||''', '''||v_parametros.p_estado||''',null)) as pwf on aom.id_proceso_wf = pwf.fill_id_proceso_wf
				        where aom.nro_tramite_wf is not null and aom.nro_tramite_wf <> '''' '||v_filtro_unidad||' and tau.codigo_tpo_aom in ('||v_codigo_tipo_aom||') order by nro_tramite_wf asc ';

			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
			--v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			RAISE NOTICE 'v_consulta %',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_RPTA1_CONT'
    #DESCRIPCION:	Count area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_RPTA1_CONT')then
		begin
			--Sentencia de la consulta de conteo de registros
			v_codigo_tipo_aom = pxp.f_get_variable_global('ssom_codigo_tipo_auditoria_interna');
			v_consulta:='select count(aom.id_aom)
                              from ssom.tauditoria_oportunidad_mejora aom
                              inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
                              left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                              left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                              left join orga.tuo as uo on aom.id_uo=uo.id_uo
                              --left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                              left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                              left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                              --left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                              left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                              --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                              join (select * from ssom.f_list_process_wf_audit_rfe('''||v_parametros.p_fecha_de||''','''||v_parametros.p_fecha_hasta||''', '''||v_parametros.p_estado||''',null)) as pwf on aom.id_proceso_wf = pwf.fill_id_proceso_wf
                              where aom.nro_tramite_wf is not null and aom.nro_tramite_wf <> '''' '||v_filtro_unidad||' and tau.codigo_tpo_aom in ('||v_codigo_tipo_aom||') ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;
		end;

		/*********************************
   #TRANSACCION:  'SSOM_RPTOM_SEL'
   #DESCRIPCION:	Consult area list
   #AUTOR:		max.camacho
   #FECHA:		17-07-2019 17:41:55
   ***********************************/

	elsif(p_transaccion='SSOM_RPTOM_SEL')then
		begin
			--Sentencia de la consulta
			--raise EXCEPTION 'Hola valor de unidad exception %',v_parametros.p_unidad;
			--raise EXCEPTION 'valor del filtro estado %', v_parametros.p_estado;
			v_estado = ''||v_parametros.p_estado||'';
			v_codigo_tipo_aom = pxp.f_get_variable_global('ssom_codigo_tipo_oportunidad_mejora');

			--raise EXCEPTION 'ohhlhlhlhlho %',v_parametros.p_id_gconsultivo;

			if(v_parametros.p_id_unidad = 0) then
				begin
					v_filtro_unidad = '';
				end;
			elsif (v_parametros.p_id_unidad > 0) then

				begin
					v_filtro_unidad = ' and aom.id_uo = '||v_parametros.p_id_unidad;
				end;
			end if;

			v_consulta:='select
						aom.id_aom,
                        aom.codigo_aom,
                        aom.nro_tramite_wf,
                        aom.id_tipo_auditoria,
                        tau.tipo_auditoria,
                        tau.codigo_tpo_aom,
                        aom.nombre_aom1,
                        aom.descrip_aom1,
                        aom.id_tnorma,
                        vptn.valor_parametro_tn as tipo_ctrl_auditoria,
                        aom.id_uo,
                        uo.nombre_unidad,
                        aom.fecha_prog_inicio::date,
                        aom.fecha_prog_fin::date,
                        aom.id_tipo_om,
                        vptom.valor_parametro_tom as valor_tipo_om,
                        aom.estado_wf,
                        --pwf.fill_codigo,
                        pwf.fill_nombre_estado,
                        aom.id_funcionario,
                        --vfc.desc_funcionario1::varchar
                        (select ssom.f_list_funcionarios_responsables(aom.id_aom,'''||v_estado||''')) as desc_funcionario1,
                        aom.id_gconsultivo,
                        gct.nombre_gconsultivo
						from ssom.tauditoria_oportunidad_mejora aom
						inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                        left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                        left join orga.tuo as uo on aom.id_uo=uo.id_uo
                        left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                        left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                        left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                        --left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                        left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                        --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                        join (select * from ssom.f_list_process_wf_audit_rfe('''||v_parametros.p_fecha_de||''','''||v_parametros.p_fecha_hasta||''', '''||v_parametros.p_estado||''',null)) as pwf on aom.id_proceso_wf = pwf.fill_id_proceso_wf
				        where aom.nro_tramite_wf is not null and aom.nro_tramite_wf <> '''' '||v_filtro_unidad||' and tau.codigo_tpo_aom in ('||v_codigo_tipo_aom||') and gct.id_gconsultivo = '||v_parametros.p_id_gconsultivo||' order by nro_tramite_wf asc ';

			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
			--v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			RAISE NOTICE 'v_consulta %',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_RPTOM_CONT'
    #DESCRIPCION:	Count area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_RPTOM_CONT')then
		begin
			--Sentencia de la consulta de conteo de registros
			v_codigo_tipo_aom = pxp.f_get_variable_global('ssom_codigo_tipo_oportunidad_mejora');
			v_consulta:='select count(aom.id_aom)
                              from ssom.tauditoria_oportunidad_mejora aom
                              inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
                              left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                              left join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                              left join orga.tuo as uo on aom.id_uo=uo.id_uo
                              left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                              left join orga.vfuncionario_cargo vfc on aom.id_funcionario = vfc.id_funcionario
                              left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                              --left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                              left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                              --left join ssom.vestado_wf_aom ewfa on aom.id_estado_wf = ewfa.id_estado_wf
                              join (select * from ssom.f_list_process_wf_audit_rfe('''||v_parametros.p_fecha_de||''','''||v_parametros.p_fecha_hasta||''', '''||v_parametros.p_estado||''',null)) as pwf on aom.id_proceso_wf = pwf.fill_id_proceso_wf
                              where aom.nro_tramite_wf is not null and aom.nro_tramite_wf <> '''' '||v_filtro_unidad||' and tau.codigo_tpo_aom in ('||v_codigo_tipo_aom||') and gct.id_gconsultivo = '||v_parametros.p_id_gconsultivo||' order by nro_tramite_wf asc ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;
		end;

		/*********************************
    #TRANSACCION:  'SSOM_AUDSTATUS_SEL'
    #DESCRIPCION:	Consult area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

	elsif(p_transaccion='SSOM_AUDSTATUS_SEL')then

		begin
			--Sentencia de la consulta

			if(v_parametros.p_codigo_aom = 'AI') then
				v_param_estado = pxp.f_get_variable_global('ssom_exc_parametros_estados_ai');
			elsif (v_parametros.p_codigo_aom = 'OM') then
				v_param_estado = pxp.f_get_variable_global('ssom_exc_parametros_estados_om');
			end if;

			--raise exception ' hola %', v_param_estado;

			select
				pm.id_proceso_macro
					 ,pm.codigo
					 ,pm.nombre
					 ,tp.id_tipo_proceso
					 ,tp.codigo
					 ,tp.nombre
				into
					v_id_proceso_macro
					,v_codigo_pm
					,v_nombre_pm
					,v_id_tipo_proceso
					,v_codigo_tp
					,v_nombre_tp
			from wf.tproceso_macro pm
						 join wf.ttipo_proceso tp on pm.id_proceso_macro = tp.id_proceso_macro
			where pm.codigo = 'SAOM' and pm.estado_reg = 'activo' and pm.inicio = 'si' ;

			v_consulta:='select te.id_tipo_estado, te.id_tipo_proceso, te.codigo, te.nombre_estado, te.estado_reg
                            from wf.ttipo_estado te
                            where te.id_tipo_proceso = '||v_id_tipo_proceso||' and te.codigo in ('||v_param_estado||') and te.estado_reg = ''activo'' and ';
			--order by te.id_tipo_estado asc

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			RAISE NOTICE 'v_consulta %',v_consulta ;
			return v_consulta;

		end;

		/*********************************
    #TRANSACCION:  'SSOM_AUDSTATUS_CONT'
    #DESCRIPCION:	Count area list
    #AUTOR:		max.camacho
    #FECHA:		17-07-2019 17:41:55
    ***********************************/
	elsif(p_transaccion='SSOM_AUDSTATUS_CONT')then
		--v_param_estado = pxp.f_get_variable_global('ssom_exc_parametros_estados_ai');
		begin
			--Sentencia de la consulta de conteo de registros
			if(v_parametros.p_codigo_aom = 'AI') then
				v_param_estado = pxp.f_get_variable_global('ssom_exc_parametros_estados_ai');
			elsif (v_parametros.p_codigo_aom = 'OM') then
				v_param_estado = pxp.f_get_variable_global('ssom_exc_parametros_estados_om');
			end if;

			select
				pm.id_proceso_macro
					 ,pm.codigo
					 ,pm.nombre
					 ,tp.id_tipo_proceso
					 ,tp.codigo
					 ,tp.nombre
				into
					v_id_proceso_macro
					,v_codigo_pm
					,v_nombre_pm
					,v_id_tipo_proceso
					,v_codigo_tp
					,v_nombre_tp
			from wf.tproceso_macro pm
						 join wf.ttipo_proceso tp on pm.id_proceso_macro = tp.id_proceso_macro
			where pm.codigo = 'SAOM' and pm.estado_reg = 'activo' and pm.inicio = 'si' ;

			v_consulta:='select count(te.id_tipo_estado)
                            from wf.ttipo_estado te
                            where te.id_tipo_proceso = '||v_id_tipo_proceso||' and te.codigo in ('||v_param_estado||') and te.estado_reg = ''activo'' ';
			RAISE NOTICE 'v_consulta %',v_id_tipo_proceso ;
			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta

			return v_consulta;

		end;
		/*+++++++++++++++++   Fin   ++++++++++++++++++++*/

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