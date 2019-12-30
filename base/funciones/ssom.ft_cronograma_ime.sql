CREATE OR REPLACE FUNCTION ssom.ft_cronograma_ime (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS
$body$
	/**************************************************************************
   SISTEMA:		Seguimiento de Oportunidades de Mejora
   FUNCION: 		ssom.ft_cronograma_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma'
   AUTOR: 		 (max.camacho)
   FECHA:	        12-12-2019 15:50:53
   COMENTARIOS:
  ***************************************************************************
   HISTORIAL DE MODIFICACIONES:
  #ISSUE				FECHA				AUTOR				DESCRIPCION
   #0				12-12-2019 15:50:53								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ssom.tcronograma'
   #
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


BEGIN

	v_nombre_funcion = 'ssom.ft_cronograma_ime';
	v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'SSOM_CRONOG_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		max.camacho
 	#FECHA:		12-12-2019 15:50:53
	***********************************/

	if(p_transaccion='SSOM_CRONOG_INS')then

		begin
			--Sentencia de la insercion
			select count(id_cronograma) into v_cant_actividad from ssom.tcronograma where id_aom = v_parametros.id_aom and  id_actividad = v_parametros.id_actividad;
			--raise EXCEPTION 'Holaaaaaaaaaa %', v_cant_actividad;
			if(v_cant_actividad > 0) then
				RAISE EXCEPTION ' Ya tiene registrado la actividad en el Cronograma, verifique por favor...!!! ';
			end if;

			insert into ssom.tcronograma(
				nueva_actividad,
				obs_actividad,
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
								v_parametros.obs_actividad,
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
								null



							)RETURNING id_cronograma into v_id_cronograma;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cronograma almacenado(a) con exito (id_cronograma'||v_id_cronograma||')');
			v_resp = pxp.f_agrega_clave(v_resp,'id_cronograma',v_id_cronograma::varchar);

			--Devuelve la respuesta
			return v_resp;

		end;

		/*********************************
     #TRANSACCION:  'SSOM_CRONOG_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		max.camacho
     #FECHA:		12-12-2019 15:50:53
    ***********************************/

	elsif(p_transaccion='SSOM_CRONOG_MOD')then

		begin
			--Sentencia de la modificacion


			select count(id_cronograma) into v_cant_actividad from ssom.tcronograma where (id_aom = v_parametros.id_aom and id_actividad = v_parametros.id_actividad);
			--raise EXCEPTION '%',v_cant_actividad;
			--if(v_cant_actividad > 0)then
			select
				id_cronograma
					 ,id_aom
					 ,id_actividad
					 ,fecha_ini_activ
					 ,fecha_fin_activ
					 ,hora_ini_activ
					 ,hora_fin_activ
				into
					v_record_activ
			from ssom.tcronograma where id_aom = v_parametros.id_aom and  id_actividad = v_parametros.id_actividad;

			/* if( v_record_activ.id_actividad = v_parametros.id_actividad) then
         if ((v_parametros.fecha_ini_activ = v_record_activ.fecha_ini_activ and v_parametros.fecha_fin_activ = v_record_activ.fecha_fin_activ) ) then
             if ((v_parametros.hora_ini_activ = v_record_activ.hora_ini_activ and v_parametros.hora_fin_activ = v_record_activ.hora_fin_activ)) then
                 RAISE EXCEPTION ' Ya tiene registrado la actividad en el Cronograma, verifique por favor...!!! ';
               end if;
           end if;
       else
         select count(id_cronograma) into v_cant_actividad from ssom.tcronograma where (id_aom = v_parametros.id_aom and id_actividad = v_parametros.id_actividad);
           --raise EXCEPTION '%',v_cant_actividad;
         if (v_cant_actividad > 0) then
             RAISE EXCEPTION ' Ya tiene registrado la actividad en el Cronograma, verifique por favor...!!! ';
           end if;

       end if;  */

			--end if;

			update ssom.tcronograma set
																nueva_actividad = v_parametros.nueva_actividad,
																obs_actividad = v_parametros.obs_actividad,
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
     #AUTOR:		max.camacho
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
	COST 100;