create or replace function ssom.ft_cronograma_ime(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
    /**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_cronograma_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma'
   AUTOR: 		MMV
   FECHA:	        12-12-2019 15:50:53
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				12-12-2019 15:50:53								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

    v_nro_requerimiento    	integer;
    v_parametros           	record;
    v_id_requerimiento     	integer;
    v_resp		            varchar;
    v_nombre_funcion        text;
    v_mensaje_error         text;
    v_id_cronograma			integer;

    v_cant_actividad        integer;
    v_record_activ			record;
    v_id_funcionario		integer;


BEGIN

    v_nombre_funcion = 'ssom.ft_cronograma_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_CRONOG_INS'
     #DESCRIPCION:	Insercion de registros
     #AUTOR:		MMV
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

    if(p_transaccion='SSOM_CRONOG_INS')then

        begin

            --Sentencia de la insercion

            insert into ssom.tcronograma(
                nueva_actividad,
                estado_reg,
                hora_ini_activ,
                fecha_ini_activ,
                fecha_fin_activ,
                id_actividad,
                hora_fin_activ,
                id_aom,
                fecha_reg,
                usuario_ai,
                id_usuario_reg,
                id_usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) values(
                        v_parametros.nueva_actividad,
                        'activo',
                        v_parametros.hora_ini_activ,
                        v_parametros.fecha_ini_activ,
                        v_parametros.fecha_fin_activ,
                        v_parametros.id_actividad,
                        v_parametros.hora_fin_activ,
                        v_parametros.id_aom,
                        now(),
                        v_parametros._nombre_usuario_ai,
                        p_id_usuario,
                        v_parametros._id_usuario_ai,
                        null,
                        null)RETURNING id_cronograma into v_id_cronograma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma almacenado(a) con exito (id_cronograma'||v_id_cronograma||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronograma',v_id_cronograma::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRONOG_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		MMV
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

    elsif(p_transaccion='SSOM_CRONOG_MOD')then

        begin
            --Sentencia de la modificacion


            update ssom.tcronograma set
                                        nueva_actividad = v_parametros.nueva_actividad,
                                        hora_ini_activ = v_parametros.hora_ini_activ,
                                        fecha_ini_activ = v_parametros.fecha_ini_activ,
                                        fecha_fin_activ = v_parametros.fecha_fin_activ,
                                        id_actividad = v_parametros.id_actividad,
                                        hora_fin_activ = v_parametros.hora_fin_activ,
                                        id_aom = v_parametros.id_aom,
                                        id_usuario_mod = p_id_usuario,
                                        fecha_mod = now(),
                                        id_usuario_ai = v_parametros._id_usuario_ai,
                                        usuario_ai = v_parametros._nombre_usuario_ai
            where id_cronograma=v_parametros.id_cronograma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronograma',v_parametros.id_cronograma::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
     #TRANSACCION:  'SSOM_CRONOG_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		MMV
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

    elsif(p_transaccion='SSOM_CRONOG_ELI')then

        begin
            --Sentencia de la eliminacion
            delete from ssom.tcronograma
            where id_cronograma=v_parametros.id_cronograma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronograma',v_parametros.id_cronograma::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;


        /*********************************
         #TRANSACCION:  'SSOM_CROIN_INS'
         #DESCRIPCION:	Eliminacion de registros
         #AUTOR:		MMV
         #FECHA:		12-12-2019 15:50:53
        ***********************************/

    elsif(p_transaccion='SSOM_CROIN_INS')then

        begin
            --Sentencia de la eliminacion

            if (v_parametros.id_cronograma is not null)then

                delete from ssom.tcronograma_equipo_responsable cr
                where cr.id_cronograma = v_parametros.id_cronograma;

                delete from ssom.tcronograma c
                where c.id_cronograma = v_parametros.id_cronograma;


            end if;




            insert into ssom.tcronograma(   estado_reg,
                                            hora_ini_activ,
                                            fecha_ini_activ,
                                            fecha_fin_activ,
                                            id_actividad,
                                            hora_fin_activ,
                                            id_aom,
                                            fecha_reg,
                                            usuario_ai,
                                            id_usuario_reg,
                                            id_usuario_ai,
                                            id_usuario_mod,
                                            fecha_mod
            ) values(
                        'activo',
                        v_parametros.hora_ini_activ,
                        v_parametros.fecha_ini_activ,
                        v_parametros.fecha_fin_activ,
                        v_parametros.id_actividad,
                        v_parametros.hora_fin_activ,
                        v_parametros.id_aom,
                        now(),
                        v_parametros._nombre_usuario_ai,
                        p_id_usuario,
                        v_parametros._id_usuario_ai,
                        null,
                        null)RETURNING id_cronograma into v_id_cronograma;


            foreach v_id_funcionario IN  array (string_to_array(v_parametros.funcionarios::varchar,','))  loop

                    insert into ssom.tcronograma_equipo_responsable(
                        estado_reg,
                        id_funcionario,
                        id_cronograma,
                        fecha_reg,
                        usuario_ai,
                        id_usuario_reg,
                        id_usuario_ai,
                        id_usuario_mod,
                        fecha_mod
                    ) values(
                                'activo',
                                v_id_funcionario,
                                v_id_cronograma,
                                now(),
                                v_parametros._nombre_usuario_ai,
                                p_id_usuario,
                                v_parametros._id_usuario_ai,
                                null,
                                null
                            );

                end loop;



            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_cronograma',v_parametros.id_aom::varchar);

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


