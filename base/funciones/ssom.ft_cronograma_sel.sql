create or replace function ssom.ft_cronograma_sel(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
    /**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_cronograma_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcronograma'
   AUTOR: 		 (max.camacho)
   FECHA:	        12-12-2019 15:50:53
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				12-12-2019 15:50:53								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcronograma'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

    v_consulta    		varchar;
    v_parametros  		record;
    v_nombre_funcion   	text;
    v_resp				varchar;

BEGIN

    v_nombre_funcion = 'ssom.ft_cronograma_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_CRONOG_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

    if(p_transaccion='SSOM_CRONOG_SEL')then

        begin
            --Sentencia de la consulta
            v_consulta:='select
						cronog.id_cronograma,
                        cronog.nueva_actividad,
						cronog.obs_actividad,
						cronog.estado_reg,
						cronog.hora_ini_activ,
						cronog.fecha_ini_activ,
						cronog.fecha_fin_activ,
						cronog.id_actividad,
						cronog.hora_fin_activ,
						cronog.id_aom,
						cronog.fecha_reg,
						cronog.usuario_ai,
						cronog.id_usuario_reg,
						cronog.id_usuario_ai,
						cronog.id_usuario_mod,
						cronog.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        atv.actividad,
                         (select pxp.list(initcap (fu.desc_funcionario1))
                        from ssom.tcronograma_equipo_responsable cc
                        inner join orga.vfuncionario fu on fu.id_funcionario = cc.id_funcionario
                        where cc.id_cronograma = cronog.id_cronograma) as lista_funcionario
						from ssom.tcronograma cronog
						inner join segu.tusuario usu1 on usu1.id_usuario = cronog.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cronog.id_usuario_mod
                        join ssom.tactividad atv on cronog.id_actividad = atv.id_actividad
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRONOG_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

    elsif(p_transaccion='SSOM_CRONOG_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(id_cronograma)
					    from ssom.tcronograma cronog
					    inner join segu.tusuario usu1 on usu1.id_usuario = cronog.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cronog.id_usuario_mod
                        join ssom.tactividad atv on cronog.id_actividad = atv.id_actividad
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
$$;


