create or replace function ssom.f_generar_correlativo(p_codigo character varying, p_gestion integer, p_insertar boolean) returns character varying
    language plpgsql
as
$$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.f_generar_correlativo
 DESCRIPCION:   Funcion para generar correlativos de codigos para los subprocesos 'ssom.f_generar_correlativo'
 AUTOR: 		SAZP
 FECHA:	        20-11-2019 16:36:51
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
***************************************************************************/
DECLARE
    v_resp             varchar;
    v_nombre_funcion   text;
    v_id_gestion       integer;
    v_insert           boolean;
    v_record           record;
    v_codigo_siguiente varchar;

BEGIN
    v_nombre_funcion = 'ssom.f_generar_correlativo';

    v_insert = true;

    --- Vamos obtener el id gestion actual

    select g.id_gestion
    into v_id_gestion
    from param.tgestion g
    where g.gestion = p_gestion;


    ---verificar que tengo registro el codigo

    if exists(select 1
              from ssom.tcorrelativo cor
              where cor.codigo_correlativo = p_codigo
                and cor.id_gestion = v_id_gestion) then

        v_insert = false;

        select co.id_corre,
               co.nro_actual,
               co.nro_siguiente
        into v_record
        from ssom.tcorrelativo co
        where co.codigo_correlativo = p_codigo
          and co.id_gestion = v_id_gestion;


    end if;

    if v_insert then


        if (p_insertar) then

            INSERT INTO ssom.tcorrelativo (codigo_correlativo,
                                           id_gestion,
                                           nro_actual,
                                           nro_siguiente)
            VALUES (p_codigo,
                    v_id_gestion,
                    1,
                    2);

        end if;
        v_codigo_siguiente := (p_codigo || p_gestion::varchar || '-' || 1);


        return v_codigo_siguiente;
    end if;

    if not v_insert then
        if (p_insertar) then
            update ssom.tcorrelativo
            set nro_actual    = v_record.nro_actual + 1,
                nro_siguiente = v_record.nro_siguiente + 1
            where id_corre = v_record.id_corre;

        end if;
        v_codigo_siguiente := (p_codigo || p_gestion::varchar || '-' || v_record.nro_siguiente);

        return v_codigo_siguiente;

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


