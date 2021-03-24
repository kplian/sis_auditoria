create or replace function ssom.ft_cronograma_equipo_responsable_sel(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
    /**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_cronograma_equipo_responsable_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcronograma_equipo_responsable'
   AUTOR: 		 (max.camacho)
   FECHA:	        12-12-2019 20:16:51
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				12-12-2019 20:16:51								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tcronograma_equipo_responsable'
      #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion

   ***************************************************************************/

DECLARE

    v_consulta    		varchar;
    v_parametros  		record;
    v_nombre_funcion   	text;
    v_resp				varchar;

BEGIN

    v_nombre_funcion = 'ssom.ft_cronograma_equipo_responsable_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_CRER_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 20:16:51
    ***********************************/

    if(p_transaccion='SSOM_CRER_SEL')then

        begin
            --Sentencia de la consulta
            v_consulta:='select
						crer.id_cronog_eq_resp,
						crer.estado_reg,
						crer.v_participacion,
						crer.obs_participacion,
						crer.id_equipo_responsable,
						crer.id_cronograma,
						crer.fecha_reg,
						crer.usuario_ai,
						crer.id_usuario_reg,
						crer.id_usuario_ai,
						crer.id_usuario_mod,
						crer.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        crer.id_funcionario,
                        vfc.desc_funcionario1
						from ssom.tcronograma_equipo_responsable crer
						inner join segu.tusuario usu1 on usu1.id_usuario = crer.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = crer.id_usuario_mod
                        inner join ssom.tcronograma cronog on crer.id_cronograma = cronog.id_cronograma
                        inner join orga.vfuncionario vfc on vfc.id_funcionario = crer.id_funcionario
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRER_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 20:16:51
    ***********************************/

    elsif(p_transaccion='SSOM_CRER_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(id_cronog_eq_resp)
					    from ssom.tcronograma_equipo_responsable crer
					    inner join segu.tusuario usu1 on usu1.id_usuario = crer.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = crer.id_usuario_mod
                        inner join ssom.tcronograma cronog on crer.id_cronograma = cronog.id_cronograma
                        inner join orga.vfuncionario vfc on vfc.id_funcionario = crer.id_funcionario
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
