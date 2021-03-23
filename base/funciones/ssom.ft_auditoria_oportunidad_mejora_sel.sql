create or replace function soom.ft_auditoria_oportunidad_mejora_sel(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_auditoria_oportunidad_mejora_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_oportunidad_mejora'
   AUTOR: 		 MMV
   FECHA:	        17-07-2019 17:41:55
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				17-07-2019 17:41:55								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tauditoria_oportunidad_mejora'
   #2				4/8/20202				MMV						Refactorización funciones auditoria oportunidad de mejora
   ***************************************************************************/

DECLARE

    v_consulta    		varchar;
    v_parametros  		record;
    v_nombre_funcion   	text;
    v_resp				varchar;
    v_filtro			varchar;

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
            v_consulta:='select	aom.id_aom,
                            aom.id_proceso_wf,
                            replace(aom.nro_tramite_wf, ''AUD'', tau.codigo_tpo_aom)::varchar as nro_tramite_wf,
                            aom.id_funcionario,
                            aom.id_uo,
                            aom.id_gconsultivo,
                            aom.id_tobjeto,
                            aom.id_estado_wf,
                            aom.id_tnorma,
                            aom.id_tipo_om,
                            aom.id_tipo_auditoria,
                            aom.fecha_prog_inicio,
                            aom.fecha_prog_fin,
                            aom.fecha_prev_inicio,
                            aom.fecha_prev_fin,
                            aom.recomendacion,
                            aom.codigo_aom,
                            initcap(aom.nombre_aom1)::varchar as nombre_aom1,
                            aom.descrip_aom1,
                            aom.estado_reg,
                            aom.estado_wf,
                            te.etapa as nombre_estado,----
                            aom.fecha_eje_inicio,
                            aom.fecha_eje_fin,
                            aom.lugar,
                            aom.formulario_ingreso,
                            aom.estado_form_ingreso,
                            aom.id_usuario_ai,
                            aom.fecha_reg,
                            aom.usuario_ai,
                            aom.id_usuario_reg,
                            aom.id_usuario_mod,
                            aom.fecha_mod,
                            usu1.cuenta as usr_reg,
                            usu2.cuenta as usr_mod,
                            initcap(uni.nombre_unidad)::varchar as nombre_unidad,
                            vfc.desc_funcionario2,
                            gct.nombre_gconsultivo,
                            vpto.valor_parametro_to as desc_tipo_objeto,
                            vptn.valor_parametro_tn as desc_tipo_norma,
                            vptn.codigo_parametro,
                            vptom.valor_parametro_tom as desc_tipo_om,
                            initcap(tau.tipo_auditoria) as tipo_auditoria,
							tau.codigo_tpo_aom,
                            gct.requiere_programacion,
                            gct.requiere_formulario,
                            aom.id_destinatario,
                            df.desc_funcionario1 as desc_funcionario_destinatario,
                            aom.resumen,
                            aom.id_gestion,
                            aom.nro_tramite
                            from ssom.tauditoria_oportunidad_mejora aom
                            inner join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
                            inner join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                            inner join orga.tuo uni on uni.id_uo = aom.id_uo
                            inner join wf.testado_wf es on es.id_estado_wf = aom.id_estado_wf
        					inner join wf.ttipo_estado te on te.id_tipo_estado = es.id_tipo_estado
                            left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                            left join orga.vfuncionario vfc on aom.id_funcionario = vfc.id_funcionario
                            left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                            left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                            left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                            left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
                            left join orga.vfuncionario df on df.id_funcionario = aom.id_destinatario
                            where ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

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
					   	    join segu.tusuario usu1 on usu1.id_usuario = aom.id_usuario_reg
                            inner join ssom.ttipo_auditoria as tau on aom.id_tipo_auditoria=tau.id_tipo_auditoria
                            inner join orga.tuo uni on uni.id_uo = aom.id_uo
                            inner join wf.testado_wf es on es.id_estado_wf = aom.id_estado_wf
        					inner join wf.ttipo_estado te on te.id_tipo_estado = es.id_tipo_estado
                            left join segu.tusuario usu2 on usu2.id_usuario = aom.id_usuario_mod
                            left join orga.vfuncionario vfc on aom.id_funcionario = vfc.id_funcionario
                            left join ssom.tgrupo_consultivo as gct on aom.id_gconsultivo = gct.id_gconsultivo
                            left join ssom.vparametro_tnorma vptn on aom.id_tnorma::integer = vptn.id_parametro_tn
                            left join ssom.vparametro_tobjeto vpto on aom.id_tobjeto::integer = vpto.id_parametro_to
                            left join ssom.vparametro_tipo_om vptom on aom.id_tipo_om = vptom.id_parametro_tom
            				left join orga.vfuncionario df on df.id_funcionario = aom.id_destinatario
					        where ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
        #TRANSACCION:  'SSOM_RESU_SEL'
        #DESCRIPCION:	Resumen
        #AUTOR:		MMV
        #FECHA:
        ***********************************/
    elsif(p_transaccion='SSOM_RESU_SEL')then
        begin


            --Sentencia de la consulta de conteo de registros
            v_consulta:='select  som.id_aom,
                               som.fecha_prev_inicio,
                               som.fecha_prev_fin,
                               som.nombre_aom1,
                               som.descrip_aom1,
                               som.nro_tramite_wf,
                               fun.desc_funcionario1
                        from ssom.tauditoria_oportunidad_mejora som
                        inner join ssom.tequipo_responsable equ on equ.id_aom = som.id_aom
                        inner join orga.vfuncionario fun on fun.id_funcionario = equ.id_funcionario
                        where som.id_proceso_wf = '||v_parametros.id_proceso_wf;
            --Devuelve la respuesta
            return v_consulta;
        end;


        /*********************************
        #TRANSACCION:  'SSOM_AOMX2_SEL'
        #DESCRIPCION:	Consult lista funcionario activos
        #AUTOR:		MMV
        #FECHA:		17-07-2019 17:41:55
        ***********************************/

    elsif(p_transaccion='SSOM_AOMX2_SEL')then
        begin
            v_consulta:='select   eus.id_funcionario,
                                  initcap(fun.desc_funcionario1) as desc_funcionario1,
                                  fun.codigo,
                                  ger.nombre_unidad as gerencia,
                                  initcap(fun.descripcion_cargo)::varchar as descripcion_cargo,
                                  pa.valor_parametro as cargo_equipo
                          from ssom.tequipo_auditores eus
                          inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                          inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                          inner join orga.tuo ger ON ger.id_uo = orga.f_get_uo_gerencia(fun.id_uo, NULL::integer, NULL::date)
                          where fun.fecha_asignacion <= now()::date and (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date)
                          and pa.valor_parametro = ''Responsable'' and ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --Devuelve la respuesta
            return v_consulta;

        end;
        /*********************************
    #TRANSACCION:  'SSOM_AOMX2_CONT'
    #DESCRIPCION:	Count funcionarios
    #AUTOR:		MMV
    #FECHA:		17-07-2019 17:41:55
    ***********************************/

    elsif(p_transaccion='SSOM_AOMX2_CONT')then
        begin

            v_consulta:=' select count(eus.id_funcionario)
                          from ssom.tequipo_auditores eus
                          inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                          inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                          inner join orga.tuo ger ON ger.id_uo = orga.f_get_uo_gerencia(fun.id_uo, NULL::integer, NULL::date)
                          where fun.fecha_asignacion <= now()::date and (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date)
                          and pa.valor_parametro = ''Responsable'' and';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
        #TRANSACCION:  'SSOM_ADPTO_SEL'
        #DESCRIPCION:	Consult lista funcionario activos
        #AUTOR:			MMV
        #FECHA:		    17-07-2019 17:41:55
        ***********************************/
    elsif(p_transaccion='SSOM_ADPTO_SEL')then

        begin

            if(v_parametros.codigo = 'RESP' or v_parametros.codigo = 'MEQ' )then

                if (v_parametros.codigo = 'RESP')then
                    v_filtro = ' pa.valor_parametro = ''Responsable'' and ';
                else
                    v_filtro = ' pa.valor_parametro = ''Equipo Auditor'' and';
                end if;

                v_consulta:='select  eus.id_funcionario,
                                  fun.desc_funcionario1,
                                  fun.descripcion_cargo,
                                  pa.valor_parametro as cargo_equipo
                        from ssom.tequipo_auditores eus
                        inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                        inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                        where (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date)
                        and '||v_filtro;

            else

                v_consulta:= 'with recursive uo_mas_subordinados(id_uo_hijo,id_uo_padre) as (
                                                     select euo.id_uo_hijo,--id
                                                           id_uo_padre---padre
                                                     from orga.testructura_uo euo
                                                     where euo.id_uo_hijo = '||v_parametros.id_uo||' and euo.estado_reg = ''activo''
                                                     union
                                                     select e.id_uo_hijo,
                                                            e.id_uo_padre
                                                     from orga.testructura_uo e
                                                     inner join uo_mas_subordinados s on s.id_uo_hijo = e.id_uo_padre
                                                     and e.estado_reg = ''activo''
                                                  )select fu.id_funcionario,
                                                          fun.desc_funcionario1,
                                                          fu.descripcion_cargo,
                                                          ''''::varchar as cargo_equipo
                                                   from uo_mas_subordinados suo
                                                   inner join orga.vfuncionario_cargo fu on fu.id_uo = suo.id_uo_hijo
                                                   where (fu.fecha_finalizacion is null or fu.fecha_finalizacion >= now()::date)
                                                   and ';

            end if;

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            raise notice '%',v_consulta;
            return v_consulta;

        end;
        /*********************************
        #TRANSACCION:  'SSOM_ADPTO_CONT'
        #DESCRIPCION:	Count funcionarios
        #AUTOR:		MMV
        #FECHA:		17-07-2019 17:41:55
        ***********************************/
    elsif(p_transaccion='SSOM_ADPTO_CONT')then

        begin

            if(v_parametros.codigo = 'RESP' or v_parametros.codigo = 'MEQ' )then

                if (v_parametros.codigo = 'RESP')then
                    v_filtro = ' pa.valor_parametro = ''Responsable'' and ';
                else
                    v_filtro = ' pa.valor_parametro = ''Equipo Auditor'' and';
                end if;


                v_consulta:='select count(eus.id_funcionario)
                            from ssom.tequipo_auditores eus
                            inner join orga.vfuncionario_cargo fun on fun.id_funcionario = eus.id_funcionario
                            inner join ssom.tparametro  pa on  pa.id_parametro = eus.id_tipo_participacion
                            where (fun.fecha_finalizacion is null or fun.fecha_finalizacion >= now()::date)
                            and '||v_filtro;

            else

                v_consulta:= 'with recursive uo_mas_subordinados(id_uo_hijo,id_uo_padre) as (
                                                     select euo.id_uo_hijo,--id
                                                           id_uo_padre---padre
                                                     from orga.testructura_uo euo
                                                     where euo.id_uo_hijo = '||v_parametros.id_uo||' and euo.estado_reg = ''activo''
                                                     union
                                                     select e.id_uo_hijo,
                                                            e.id_uo_padre
                                                     from orga.testructura_uo e
                                                     inner join uo_mas_subordinados s on s.id_uo_hijo = e.id_uo_padre
                                                     and e.estado_reg = ''activo''
                                                  )select count(fu.id_funcionario)
                                                   from uo_mas_subordinados suo
                                                   inner join orga.vfuncionario_cargo fu on fu.id_uo = suo.id_uo_hijo
                                                   where (fu.fecha_finalizacion is null or fu.fecha_finalizacion >= now()::date)
                                                   and ';


            end if;

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --Devuelve la respuesta
            return v_consulta;

        end;
        /*********************************
        #TRANSACCION:  'SSOM_REPA_SEL'
        #DESCRIPCION:	Reporte general Auditoria
        #AUTOR:		MMV
        #FECHA:		1/7/2020
        ***********************************/
    elsif(p_transaccion='SSOM_REPA_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select  au.id_aom,
                               au.nro_tramite_wf,
                               au.estado_wf,
                               initcap(fu.desc_funcionario1)::varchar as Responsable,
                               initcap(uo.nombre_unidad)::varchar as area,
                               au.nombre_aom1 as titulo,
                               au.descrip_aom1,
                                to_char( au.fecha_prog_inicio,''DD/MM/YYYY'') as fecha_prog_inicio,
                                to_char( au.fecha_prog_fin,''DD/MM/YYYY'') as fecha_prog_fin,
                               au.fecha_prev_inicio,
                               au.fecha_prev_fin,
                               au.fecha_eje_inicio,
                               au.fecha_eje_fin,
                               au.lugar,
                               initcap(pn.valor_parametro)::varchar as tipo_norma,
                               initcap(po.valor_parametro)::varchar as tipo_objeto,
                               tt.tipo_auditoria,
                                tt.codigo_tpo_aom
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join orga.vfuncionario fu on fu.id_funcionario = au.id_funcionario
                        inner join orga.tuo uo on uo.id_uo = au.id_uo
                        inner join ssom.tparametro pn on pn.id_parametro = au.id_tnorma
                        inner join ssom.tparametro po on po.id_parametro = au.id_tobjeto
                        inner join ssom.ttipo_auditoria tt on tt.id_tipo_auditoria = au.id_tipo_auditoria
                        where au.id_proceso_wf =' ||v_parametros.id_proceso_wf;
            --Devuelve la respuesta
            return v_consulta;
        end;

        /*********************************
        #TRANSACCION:  'SSOM_REPP_SEL'
        #DESCRIPCION:	Reporte general Auditoria
        #AUTOR:		MMV
        #FECHA:		1/7/2020
        ***********************************/
    elsif(p_transaccion='SSOM_REPP_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select   au.id_aom,
                                au.nombre_aom1,
                                au.nro_tramite_wf,
                                au.fecha_prog_inicio,
                                au.fecha_prog_fin,
                                pr.proceso,
                                initcap(fu.desc_funcionario1)::varchar as responsable_proceso
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join ssom.tauditoria_proceso ap on ap.id_aom = au.id_aom
                        inner join ssom.tproceso pr on pr.id_proceso = ap.id_proceso
                        inner join orga.vfuncionario fu on fu.id_funcionario = pr.id_responsable
                        where au.id_proceso_wf =' ||v_parametros.id_proceso_wf;
            --Devuelve la respuesta
            return v_consulta;
        end;

        /*********************************
       #TRANSACCION:  'SSOM_REPE_SEL'
       #DESCRIPCION:	Reporte general Auditoria
       #AUTOR:		MMV
       #FECHA:		1/7/2020
       ***********************************/
    elsif(p_transaccion='SSOM_REPE_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select   au.id_aom,
                                au.nombre_aom1,
                                au.nro_tramite_wf,
                                au.fecha_prog_inicio,
                                au.fecha_prog_fin,
                                pa.valor_parametro as tipo_equipo,
                                initcap(fun.desc_funcionario1)::varchar as funcionario
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join ssom.tequipo_responsable ep on ep.id_aom = au.id_aom
                        inner join ssom.tparametro pa on pa.id_parametro = ep.id_parametro
                        inner join orga.vfuncionario fun on fun.id_funcionario = ep.id_funcionario
                        where au.id_proceso_wf =' ||v_parametros.id_proceso_wf;
            --Devuelve la respuesta
            return v_consulta;
        end;

        /*********************************
       #TRANSACCION:  'SSOM_REPN_SEL'
       #DESCRIPCION:	Reporte general Auditoria
       #AUTOR:		MMV
       #FECHA:		1/7/2020
       ***********************************/
    elsif(p_transaccion='SSOM_REPN_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select   au.id_aom,
                                au.nombre_aom1,
                                au.nro_tramite_wf,
                                au.fecha_prog_inicio,
                                au.fecha_prog_fin,
                                nr.sigla_norma,
                                nr.nombre_norma,
                                pn.nombre_pn
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join ssom.tauditoria_npn np on np.id_aom = au.id_aom
                        inner join ssom.tnorma nr on nr.id_norma = np.id_norma
                        inner join ssom.tpunto_norma pn on pn.id_pn = np.id_pn
                        where au.id_proceso_wf = ' ||v_parametros.id_proceso_wf||'
                        order by nombre_norma' ;
            --Devuelve la respuesta
            return v_consulta;
        end;

        /*********************************
       #TRANSACCION:  'SSOM_REPC_SEL'
       #DESCRIPCION:	Reporte general Auditoria
       #AUTOR:		MMV
       #FECHA:		1/7/2020
       ***********************************/
    elsif(p_transaccion='SSOM_REPC_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select  au.id_aom,
                                au.nombre_aom1,
                                au.nro_tramite_wf,
                                au.fecha_prog_inicio,
                                au.fecha_prog_fin,
                                ac.actividad,
                                to_char( co.fecha_ini_activ,''DD/MM/YYYY'') as fecha_ini_activ,
                                to_char( co.fecha_fin_activ,''DD/MM/YYYY'') as fecha_fin_activ,
                                co.hora_ini_activ,
                                co.hora_fin_activ,
                                ( select pxp.list( initcap(fu.desc_funcionario1))
                                         from ssom.tcronograma_equipo_responsable er
                                         inner join ssom.tequipo_responsable eqr  on eqr.id_equipo_responsable = er.id_equipo_responsable
                                         inner join orga.vfuncionario fu on fu.id_funcionario = eqr.id_funcionario
                                         where er.id_cronograma =  co.id_cronograma) as funcionarios
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join ssom.tcronograma co on co.id_aom = au.id_aom
                        inner join ssom.tactividad ac on ac.id_actividad = co.id_actividad
                        where au.id_proceso_wf = ' ||v_parametros.id_proceso_wf||'
                        order by fecha_ini_activ' ;
            --Devuelve la respuesta
            return v_consulta;
        end;


        /*********************************
      #TRANSACCION:  'SSOM_REPAA_SEL'
      #DESCRIPCION:	Reporte general Auditoria
      #AUTOR:		MMV
      #FECHA:		1/7/2020
      ***********************************/
    elsif(p_transaccion='SSOM_REPAA_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select  au.estado_wf,
                               initcap(fu.desc_funcionario1)::varchar as Responsable,
                               initcap(uo.nombre_unidad)::varchar as area,
                               au.nombre_aom1 as titulo,
                               pxp.f_fecha_literal(au.fecha_prog_inicio) as fecha_prog_inicio,
                               pxp.f_fecha_literal(au.fecha_eje_inicio) as fecha_eje_inicio
                        from ssom.tauditoria_oportunidad_mejora au
                        inner join orga.vfuncionario fu on fu.id_funcionario = au.id_funcionario
                        inner join orga.tuo uo on uo.id_uo = au.id_uo' ;
            --Devuelve la respuesta
            return v_consulta;
        end;


        /*********************************
        #TRANSACCION:  'SSOM_AOMX1_SEL'
        #DESCRIPCION:	Consult area list
        #AUTOR:		max.camacho
        #FECHA:		17-07-2019 17:41:55
        ***********************************/

    elsif(p_transaccion='SSOM_AOMX1_SEL')then

        begin
            --Sentencia de la consulta
            v_consulta:='select   uo.id_uo,
                                  uo.nombre_unidad,
                                  uo.codigo,
                                  n.numero_nivel
                          from orga.tuo uo
                          inner join orga.tnivel_organizacional n on n.id_nivel_organizacional = uo.id_nivel_organizacional
                          where uo.estado_reg = ''activo'' and';

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

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(uo.id_uo)
                            from orga.tuo uo
                            inner join orga.tnivel_organizacional n on n.id_nivel_organizacional = uo.id_nivel_organizacional
                            where uo.estado_reg = ''activo''  and';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --raise notice '%',v_consulta;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
        #TRANSACCION:  'SSOM_AOES_SEL'
        #DESCRIPCION:	Consult area list
        #AUTOR:		MMV
        #FECHA:		17-07-2019 17:41:55
        ***********************************/

    elsif(p_transaccion='SSOM_AOES_SEL')then

        begin
            --Sentencia de la consulta
            v_consulta:=' select ts.id_tipo_estado,
                                 ts.codigo,
                                 ts.nombre_estado
                          from wf.tproceso_macro mp
                          inner join wf.ttipo_proceso tp on tp.id_proceso_macro = mp.id_proceso_macro
                          inner join wf.ttipo_estado ts on ts.id_tipo_proceso = tp.id_tipo_proceso
                          where mp.codigo = ''AUD'' and tp.codigo = ''AUDSE''  and ts.estado_reg = ''activo'' and';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
        #TRANSACCION:  'SSOM_AOES_CONT'
        #DESCRIPCION:	Count area list
        #AUTOR:		MMV
        #FECHA:		17-07-2019 17:41:55
        ***********************************/

    elsif(p_transaccion='SSOM_AOES_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:=' select count(ts.id_tipo_estado)
                          from wf.tproceso_macro mp
                          inner join wf.ttipo_proceso tp on tp.id_proceso_macro = mp.id_proceso_macro
                          inner join wf.ttipo_estado ts on ts.id_tipo_proceso = tp.id_tipo_proceso
                          where mp.codigo = ''AUD'' and tp.codigo = ''AUDSE''  and ts.estado_reg = ''activo'' and';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --Devuelve la respuesta
            return v_consulta;

        end;
        /*********************************
      #TRANSACCION:  'SSOM_VANC_SEL'
      #DESCRIPCION:	Verificacion de accion
      #AUTOR:		MMV
      #FECHA:		1/7/2020
      ***********************************/
    elsif(p_transaccion='SSOM_VANC_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select   som.nombre_aom1,
                                som.nro_tramite_wf,
                                vpto.valor_parametro_to as desc_tipo_objeto,
                                som.fecha_prog_inicio,
                                som.fecha_prog_fin,
                                fu.desc_funcionario1,
                                pn.valor_parametro as tipo_nc,
                                mo.estado_wf,
                                mo.descrip_nc,
                                acp.valor_parametro as tipo_accion,
                                ap.descripcion_ap,
                                ap.fecha_inicio_ap,
                                ap.fecha_fin_ap,
                                ''afk''::varchar as funcionario_implementado,
                                ''IMP''::varchar as imp,
                                ''V''::varchar as v,
                                uo.nombre_unidad
                                from ssom.tauditoria_oportunidad_mejora som
                                inner join orga.vfuncionario fu on fu.id_funcionario = som.id_funcionario
                                inner join ssom.tno_conformidad mo on mo.id_aom = som.id_aom
                                inner join ssom.tparametro pn on pn.id_parametro = mo.id_parametro
                                inner join ssom.taccion_propuesta ap on ap.id_nc = mo.id_nc
                                inner join ssom.tparametro acp on acp.id_parametro = ap.id_parametro
                                inner join orga.tuo uo on uo.id_uo = som.id_uo
                                left join ssom.vparametro_tobjeto vpto on som.id_tobjeto = vpto.id_parametro_to
                                where som.id_proceso_wf ='||v_parametros.id_proceso_wf;
            --Devuelve la respuesta
            return v_consulta;
        end;
        /*********************************
        #TRANSACCION:  'SSOM_FUN_SEL'
        #DESCRIPCION:	Lista Funcionarios vigentes
        #AUTOR:		MMV
        #FECHA:		3/9/2020
        ***********************************/
    elsif(p_transaccion='SSOM_FUN_SEL')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select   fc.id_funcionario,
                                fc.desc_funcionario1,
                                fc.codigo,
                                fc.descripcion_cargo
                        from orga.vfuncionario_cargo fc
                        where fc.fecha_asignacion <= now()::date and(fc.fecha_finalizacion is null
                                    or fc.fecha_finalizacion >= now()::date) and';
            --Devuelve la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            return v_consulta;
        end;

        /*********************************
        #TRANSACCION:  'SSOM_FUN_CONT'
        #DESCRIPCION:	Lista Funcionarios vigentes
        #AUTOR:		MMV
        #FECHA:		3/9/2020
        ***********************************/
    elsif(p_transaccion='SSOM_FUN_CONT')then
        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select  count(fc.id_funcionario)
                              from orga.vfuncionario_cargo fc
                              where fc.fecha_asignacion <= now()::date and (fc.fecha_finalizacion is null
                                          or fc.fecha_finalizacion >= now()::date) and';
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
$$;

