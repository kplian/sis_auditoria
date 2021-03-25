create or replace function ssom.ft_destinatario_sel(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_destinatario_sel
   DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tdestinatario'
   AUTOR: 		 (max.camacho)
   FECHA:	        10-09-2019 23:09:14
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				10-09-2019 23:09:14								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tdestinatario'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

    v_consulta       varchar;
    v_parametros     record;
    v_nombre_funcion text;
    v_resp           varchar;

BEGIN

    v_nombre_funcion = 'ssom.ft_destinatario_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_DEST_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		max.camacho
     #FECHA:		10-09-2019 23:09:14
    ***********************************/

    if (p_transaccion = 'SSOM_DEST_SEL') then

        begin
            --Sentencia de la consulta
            v_consulta := 'select
						dest.id_destinatario_aom,
						dest.id_parametro,
						dest.id_aom,
                        dest.id_funcionario,
                        dest.exp_tec_externo,
                        dest.obs_destinatario,
						dest.estado_reg,
						dest.id_usuario_ai,
						dest.fecha_reg,
						dest.usuario_ai,
						dest.id_usuario_reg,
						dest.fecha_mod,
						dest.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        para.valor_parametro,
                        para.codigo_parametro,
                        vfc.desc_funcionario1,
                        dest.incluir_informe
						from ssom.tdestinatario dest
						inner join segu.tusuario usu1 on usu1.id_usuario = dest.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = dest.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on dest.id_aom = aom.id_aom
                        left join ssom.tparametro para on dest.id_parametro = para.id_parametro
                        inner join orga.vfuncionario vfc on dest.id_funcionario = vfc.id_funcionario
				        where ';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;
            v_consulta := v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion ||
                          ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_DEST_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		max.camacho
     #FECHA:		10-09-2019 23:09:14
    ***********************************/

    elsif (p_transaccion = 'SSOM_DEST_CONT') then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta := 'select count(dest.id_destinatario_aom)
					    from ssom.tdestinatario dest
					    inner join segu.tusuario usu1 on usu1.id_usuario = dest.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = dest.id_usuario_mod
                        join ssom.tauditoria_oportunidad_mejora aom on dest.id_aom = aom.id_aom
                        left join ssom.tparametro para on dest.id_parametro = para.id_parametro
                        inner join orga.vfuncionario vfc on dest.id_funcionario = vfc.id_funcionario
					    where ';

            --Definicion de la respuesta
            v_consulta := v_consulta || v_parametros.filtro;

            --Devuelve la respuesta
            return v_consulta;

        end;

    else

        raise exception 'Transaccion inexistente';

    end if;

EXCEPTION

    WHEN OTHERS THEN
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
        raise exception '%',v_resp;
END;
$$;

