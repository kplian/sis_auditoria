create or replace function ssom.ft_cronograma_equipo_responsable_ime(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
    /**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_cronograma_equipo_responsable_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma_equipo_responsable'
   AUTOR: 		 (max.camacho)
   FECHA:	        12-12-2019 20:16:51
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				12-12-2019 20:16:51								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma_equipo_responsable'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

    v_parametros           	record;
    v_resp		            varchar;
    v_nombre_funcion        text;
    v_id_cronog_eq_resp	integer;

    v_cantidad				integer = 0;
    v_ids_responsable       varchar[];
    v_i						integer;
    v_id_funcionario		integer;

BEGIN

    v_nombre_funcion = 'ssom.ft_cronograma_equipo_responsable_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_CRER_INS'
     #DESCRIPCION:	Insercion de registros
     #AUTOR:		MMV
     #FECHA:		12-12-2019 20:16:51
    ***********************************/

    if(p_transaccion='SSOM_CRER_INS')then

        begin

            v_ids_responsable = string_to_array(v_parametros.id_equipo_responsable,',');



            FOREACH v_id_funcionario in ARRAY (v_ids_responsable) LOOP

                    insert into ssom.tcronograma_equipo_responsable(
                        estado_reg,
                        --obs_participacion,
                        id_equipo_responsable,
                        id_cronograma,
                        fecha_reg,
                        usuario_ai,
                        id_usuario_reg,
                        id_usuario_ai,
                        id_usuario_mod,
                        fecha_mod
                    ) values(
                                'activo',
                                -- v_parametros.obs_participacion,
                                v_id_funcionario,
                                v_parametros.id_cronograma,
                                now(),
                                v_parametros._nombre_usuario_ai,
                                p_id_usuario,
                                v_parametros._id_usuario_ai,
                                null,
                                null
                            )RETURNING id_cronog_eq_resp into v_id_cronog_eq_resp;

                END LOOP;




            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma Equipo Responsable almacenado(a) con exito (id_cronog_eq_resp'||v_id_cronog_eq_resp||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronog_eq_resp',v_id_cronog_eq_resp::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRER_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 20:16:51
    ***********************************/

    elsif(p_transaccion='SSOM_CRER_MOD')then

        begin
            --Sentencia de la modificacion
            select count(id_cronog_eq_resp) into v_cantidad from ssom.tcronograma_equipo_responsable where id_cronograma = v_parametros.id_cronograma and id_equipo_responsable = v_ids_responsable[v_i]::integer;--v_parametros.id_equipo_responsable::integer;

            if(v_cantidad > 0) then
                RAISE EXCEPTION ' Ya tiene Registrado el Auditor no es posible asignar mas de una ves a una Actividad...!!! ';
            end if;

            update ssom.tcronograma_equipo_responsable set
                                                           v_participacion = v_parametros.v_participacion,
                                                           --  obs_participacion = v_parametros.obs_participacion,
                                                           id_equipo_responsable = v_parametros.id_equipo_responsable,
                                                           id_cronograma = v_parametros.id_cronograma,
                                                           id_usuario_mod = p_id_usuario,
                                                           fecha_mod = now(),
                                                           id_usuario_ai = v_parametros._id_usuario_ai,
                                                           usuario_ai = v_parametros._nombre_usuario_ai
            where id_cronog_eq_resp=v_parametros.id_cronog_eq_resp;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma Equipo Responsable modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronog_eq_resp',v_parametros.id_cronog_eq_resp::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRER_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 20:16:51
    ***********************************/

    elsif(p_transaccion='SSOM_CRER_ELI')then

        begin
            --Sentencia de la eliminacion
            delete from ssom.tcronograma_equipo_responsable
            where id_cronog_eq_resp=v_parametros.id_cronog_eq_resp;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma Equipo Responsable eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronog_eq_resp',v_parametros.id_cronog_eq_resp::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    else

        raise exception 'Transaccion inexistente: %',p_transaccion;

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
