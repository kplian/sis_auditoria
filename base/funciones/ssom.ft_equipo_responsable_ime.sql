CREATE OR REPLACE FUNCTION ssom.ft_equipo_responsable_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
   FUNCION: 		ssom.ft_equipo_responsable_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tequipo_responsable'
   AUTOR: 		 (max.camacho)
   FECHA:	        02-08-2019 14:03:25
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				02-08-2019 14:03:25								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tequipo_responsable'
   #4				04-08-2029 15:51:56		 MMV				    Refactorizacion Planificacion
   ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_equipo_responsable	integer;

	v_cantidad					integer = 0;
	v_id_funcionario		integer;
BEGIN

	v_nombre_funcion = 'ssom.ft_equipo_responsable_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_EQRE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		MMV
 	#FECHA:		02-08-2019 14:03:25
	***********************************/

	if(p_transaccion='SSOM_EQRE_INS')then

		begin

        if exists ( select 1
                    from ssom.tequipo_responsable re
                    inner join ssom.tparametro pa on pa.id_parametro = re.id_parametro
                    where re.id_aom = v_parametros.id_aom
                          and re.id_parametro = v_parametros.id_parametro and pa.codigo_parametro = 'RESP')then
              raise  exception 'Ya existe un Responsabre asignado al equipo.';
       end if;

                                insert into ssom.tequipo_responsable(
                                    id_funcionario,
                                    exp_tec_externo,
                                    id_parametro,
                                    estado_reg,
                                    id_aom,
                                    id_usuario_ai,
                                    id_usuario_reg,
                                    usuario_ai,
                                    fecha_reg,
                                    id_usuario_mod,
                                    fecha_mod
                                ) values(
								v_parametros.id_funcionario,
								v_parametros.exp_tec_externo,
								v_parametros.id_parametro,
								'activo',
								v_parametros.id_aom,
								v_parametros._id_usuario_ai,
								p_id_usuario,
								v_parametros._nombre_usuario_ai,
								now(),
								null,
								null

							)RETURNING id_equipo_responsable into v_id_equipo_responsable;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipo Responsable almacenado(a) con exito (id_equipo_responsable'||v_id_equipo_responsable||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_id_equipo_responsable::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_EQRE_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		MMV
     #FECHA:		02-08-2019 14:03:25
    ***********************************/

	elsif(p_transaccion='SSOM_EQRE_MOD')then

		begin
			--Sentencia de la modificacion
			update ssom.tequipo_responsable set
            id_funcionario = v_parametros.id_funcionario,
            exp_tec_externo = v_parametros.exp_tec_externo,
            id_parametro = v_parametros.id_parametro,
            id_aom = v_parametros.id_aom,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
			where id_equipo_responsable=v_parametros.id_equipo_responsable;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipo Responsable modificado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_parametros.id_equipo_responsable::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

	/*********************************
     #TRANSACCION:  'SSOM_EQRE_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		02-08-2019 14:03:25
    ***********************************/

	elsif(p_transaccion='SSOM_EQRE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ssom.tequipo_responsable
			where id_equipo_responsable=v_parametros.id_equipo_responsable;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipo Responsable eliminado(a)');
			v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_parametros.id_equipo_responsable::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

    /*********************************
     #TRANSACCION:  'SSOM_EQRE_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		max.camacho
     #FECHA:		02-08-2019 14:03:25
    ***********************************/

  elsif(p_transaccion='SSOM_EQIS_INS')then

      begin
          --Sentencia de la eliminacion
          delete from ssom.tequipo_responsable
          where id_aom=v_parametros.id_aom;


          insert into ssom.tequipo_responsable(
                                    id_funcionario,
                                    -- exp_tec_externo,
                                    id_parametro,
                                    estado_reg,
                                    id_aom,
                                    id_usuario_ai,
                                    id_usuario_reg,
                                    usuario_ai,
                                    fecha_reg,
                                    id_usuario_mod,
                                    fecha_mod
                                    ) values(
                                    v_parametros.id_responsable,
                                    -- v_parametros.exp_tec_externo,
                                    (select pa.id_parametro
                                    from  ssom.tparametro pa
                                    where  pa.codigo_parametro = 'RESP'),
                                    'activo',
                                    v_parametros.id_aom,
                                    v_parametros._id_usuario_ai,
                                    p_id_usuario,
                                    v_parametros._nombre_usuario_ai,
                                    now(),
                                    null,
                                    null);


          if (v_parametros.id_interno is not null)then
          insert into ssom.tequipo_responsable(
                                    id_funcionario,
                                    -- exp_tec_externo,
                                    id_parametro,
                                    estado_reg,
                                    id_aom,
                                    id_usuario_ai,
                                    id_usuario_reg,
                                    usuario_ai,
                                    fecha_reg,
                                    id_usuario_mod,
                                    fecha_mod
                                    ) values(
                                    v_parametros.id_interno,
                                    -- v_parametros.exp_tec_externo,
                                    (select pa.id_parametro
                                    from  ssom.tparametro pa
                                    where  pa.codigo_parametro = 'ETI'),
                                    'activo',
                                    v_parametros.id_aom,
                                    v_parametros._id_usuario_ai,
                                    p_id_usuario,
                                    v_parametros._nombre_usuario_ai,
                                    now(),
                                    null,
                                    null);
          end if;

            if (v_parametros.externo <> '')then


            insert into ssom.tequipo_responsable(
                                      id_funcionario,
                                      exp_tec_externo,
                                      id_parametro,
                                      estado_reg,
                                      id_aom,
                                      id_usuario_ai,
                                      id_usuario_reg,
                                      usuario_ai,
                                      fecha_reg,
                                      id_usuario_mod,
                                      fecha_mod
                                      ) values(
                                      null,
                                      upper(v_parametros.externo)::varchar,
                                        (select pa.id_parametro
                                    from  ssom.tparametro pa
                                    where  pa.codigo_parametro = 'EXT'),
                                      'activo',
                                      v_parametros.id_aom,
                                      v_parametros._id_usuario_ai,
                                      p_id_usuario,
                                      v_parametros._nombre_usuario_ai,
                                      now(),
                                      null,
                                      null);
            end if;


            foreach v_id_funcionario IN  array (string_to_array(v_parametros.id_equipo_auditor::varchar,','))  loop

               insert into ssom.tequipo_responsable(
                                    id_funcionario,
                                    -- exp_tec_externo,
                                    id_parametro,
                                    estado_reg,
                                    id_aom,
                                    id_usuario_ai,
                                    id_usuario_reg,
                                    usuario_ai,
                                    fecha_reg,
                                    id_usuario_mod,
                                    fecha_mod
                                    ) values(
                                    v_id_funcionario,
                                    -- v_parametros.exp_tec_externo,
                                    (select pa.id_parametro
                                    from  ssom.tparametro pa
                                    where  pa.codigo_parametro = 'MEQ'),
                                    'activo',
                                    v_parametros.id_aom,
                                    v_parametros._id_usuario_ai,
                                    p_id_usuario,
                                    v_parametros._nombre_usuario_ai,
                                    now(),
                                    null,
                                    null);

            end loop;


          --Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Equipo Responsable eliminado(a)');
          v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_parametros.id_aom::varchar);

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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;

ALTER FUNCTION ssom.ft_equipo_responsable_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;