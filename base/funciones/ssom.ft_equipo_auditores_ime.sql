create or replace function ssom.ft_equipo_auditores_ime(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying) returns character varying
    language plpgsql
as
$$
/**************************************************************************
 SISTEMA:		Seguimiento de Oportunidades de Mejora
 FUNCION: 		ssom.ft_equipo_auditores_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tequipo_auditores'
 AUTOR: 		 (admin.miguel)
 FECHA:	        03-09-2020 16:11:03
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-09-2020 16:11:03								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tequipo_auditores'
 #
 ***************************************************************************/

DECLARE

    v_parametros          record;
    v_resp                varchar;
    v_nombre_funcion      text;
    v_id_equipo_auditores integer;
    v_record              record;

BEGIN

    v_nombre_funcion = 'ssom.ft_equipo_auditores_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SSOM_EUS_INS'
     #DESCRIPCION:	Insercion de registros
     #AUTOR:		admin.miguel
     #FECHA:		03-09-2020 16:11:03
    ***********************************/

    if (p_transaccion = 'SSOM_EUS_INS') then

        begin
            --Sentencia de la insercion

            if exists(select 1
                      from ssom.tequipo_auditores eu
                      where eu.id_funcionario = v_parametros.id_funcionario) then
                raise exception 'Funcionario ya esta registrado';
            end if;


            insert into ssom.tequipo_auditores(estado_reg,
                                               id_funcionario,
                                               id_tipo_participacion,
                                               id_usuario_reg,
                                               fecha_reg,
                                               id_usuario_ai,
                                               usuario_ai,
                                               id_usuario_mod,
                                               fecha_mod)
            values ('activo',
                    v_parametros.id_funcionario,
                    v_parametros.id_tipo_participacion,
                    p_id_usuario,
                    now(),
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    null)
            RETURNING id_equipo_auditores into v_id_equipo_auditores;

            for v_record in (select n.id_norma
                             from ssom.tnorma n
                             where n.estado_reg = 'activo')
                loop

                    insert into ssom.tcompetencia(estado_reg,
                                                  id_equipo_auditores,
                                                  id_norma,
                                                  nro_auditorias,
                                                  hras_formacion,
                                                  meses_actualizacion,
                                                  calificacion,
                                                  id_usuario_reg,
                                                  fecha_reg,
                                                  id_usuario_ai,
                                                  usuario_ai,
                                                  id_usuario_mod,
                                                  fecha_mod)
                    values ('activo',
                            v_id_equipo_auditores,
                            v_record.id_norma,
                            0,
                            0,
                            0,
                            'básico',
                            p_id_usuario,
                            now(),
                            v_parametros._id_usuario_ai,
                            v_parametros._nombre_usuario_ai,
                            null,
                            null);

                end loop;


            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                        'Equipo Aduitores almacenado(a) con exito (id_equipo_auditores' ||
                                        v_id_equipo_auditores || ')');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_equipo_auditores', v_id_equipo_auditores::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'SSOM_EUS_MOD'
         #DESCRIPCION:	Modificacion de registros
         #AUTOR:		admin.miguel
         #FECHA:		03-09-2020 16:11:03
        ***********************************/

    elsif (p_transaccion = 'SSOM_EUS_MOD') then

        begin

            --Sentencia de la modificacion
            update ssom.tequipo_auditores
            set id_funcionario        = v_parametros.id_funcionario,
                id_tipo_participacion = v_parametros.id_tipo_participacion,
                id_usuario_mod        = p_id_usuario,
                fecha_mod             = now(),
                id_usuario_ai         = v_parametros._id_usuario_ai,
                usuario_ai            = v_parametros._nombre_usuario_ai
            where id_equipo_auditores = v_parametros.id_equipo_auditores;


            for v_record in (select n.id_norma
                             from ssom.tnorma n
                             where n.estado_reg = 'activo')
                loop

                    if not exists(select 1
                                  from ssom.tcompetencia co
                                  where co.id_equipo_auditores = v_parametros.id_equipo_auditores
                                    and co.id_norma = v_record.id_norma) then

                        insert into ssom.tcompetencia(estado_reg,
                                                      id_equipo_auditores,
                                                      id_norma,
                                                      nro_auditorias,
                                                      hras_formacion,
                                                      meses_actualizacion,
                                                      calificacion,
                                                      id_usuario_reg,
                                                      fecha_reg,
                                                      id_usuario_ai,
                                                      usuario_ai,
                                                      id_usuario_mod,
                                                      fecha_mod)
                        values ('activo',
                                v_parametros.id_equipo_auditores,
                                v_record.id_norma,
                                0,
                                0,
                                0,
                                'básico',
                                p_id_usuario,
                                now(),
                                v_parametros._id_usuario_ai,
                                v_parametros._nombre_usuario_ai,
                                null,
                                null);
                    end if;
                end loop;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Equipo Aduitores modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_equipo_auditores', v_parametros.id_equipo_auditores::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'SSOM_EUS_ELI'
         #DESCRIPCION:	Eliminacion de registros
         #AUTOR:		admin.miguel
         #FECHA:		03-09-2020 16:11:03
        ***********************************/

    elsif (p_transaccion = 'SSOM_EUS_ELI') then

        begin
            --Sentencia de la eliminacion
            delete
            from ssom.tcompetencia
            where id_equipo_auditores = v_parametros.id_equipo_auditores;

            delete
            from ssom.tequipo_auditores
            where id_equipo_auditores = v_parametros.id_equipo_auditores;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Equipo Aduitores eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_equipo_auditores', v_parametros.id_equipo_auditores::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    else

        raise exception 'Transaccion inexistente: %',p_transaccion;

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
