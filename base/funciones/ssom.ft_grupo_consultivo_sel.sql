--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_grupo_consultivo_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_grupo_consultivo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tgrupo_consultivo''
 AUTOR: 		 (max.camacho)
 FECHA:	        22-07-2019 23:01:14
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-07-2019 23:01:14								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tgrupo_consultivo''
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_banderaE          varchar;

BEGIN

	v_nombre_funcion = ''ssom.ft_grupo_consultivo_sel'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_GCT_SEL''
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		22-07-2019 23:01:14
	***********************************/

	if(p_transaccion=''SSOM_GCT_SEL'')then

    	begin
    		--Sentencia de la consulta
			v_consulta:=''select
						gct.id_gconsultivo,
						gct.nombre_programacion,
						gct.id_empresa,
						gct.descrip_gconsultivo,
						gct.nombre_gconsultivo,
						gct.requiere_programacion,
						gct.nombre_formulario,
						gct.estado_reg,
						gct.requiere_formulario,
						gct.id_usuario_ai,
						gct.fecha_reg,
						gct.usuario_ai,
						gct.id_usuario_reg,
						gct.fecha_mod,
						gct.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        uo.nombre_unidad as empresa
						from ssom.tgrupo_consultivo gct
						inner join segu.tusuario usu1 on usu1.id_usuario = gct.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = gct.id_usuario_mod
                        join orga.tuo as uo on gct.id_empresa = uo.id_uo
				        where  '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_GCT_CONT''
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho
 	#FECHA:		22-07-2019 23:01:14
	***********************************/

	elsif(p_transaccion=''SSOM_GCT_CONT'')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:=''select count(id_gconsultivo)
					    from ssom.tgrupo_consultivo gct
					    inner join segu.tusuario usu1 on usu1.id_usuario = gct.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = gct.id_usuario_mod
					    where '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        /*+++++++++++++  Inicio  +++++++++++++++*/
        /*********************************
        #TRANSACCION:  ''SSOM_GCTX1_SEL''
        #DESCRIPCION:	Lista de Empresa
        #AUTOR:		max.camacho
        #FECHA:		22-07-2019 23:01:14
        ***********************************/

        elsif(p_transaccion=''SSOM_GCTX1_SEL'')then
            v_banderaE = pxp.f_get_variable_global(''ssom_obtener_lista_empresa'');
            begin
                --Sentencia de la consulta
                v_consulta:=''select
                                id_uo as id_empresa,
                                nombre_unidad as empresa
                                from orga.tuo
                                where id_nivel_organizacional in (''||v_banderaE||'') and'';

                --Definicion de la respuesta
                v_consulta:=v_consulta||v_parametros.filtro;
                v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;

                --Devuelve la respuesta
                return v_consulta;

            end;
            /*********************************
            #TRANSACCION:  ''SSOM_GCTX1_CONT''
            #DESCRIPCION:	Conteo de registros
            #AUTOR:		max.camacho
            #FECHA:		22-07-2019 23:01:14
            ***********************************/

            elsif(p_transaccion=''SSOM_GCTX1_CONT'')then
				v_banderaE = pxp.f_get_variable_global(''ssom_obtener_lista_empresa'');
                begin
                    --Sentencia de la consulta de conteo de registros
                    v_consulta:=''select count(uo.id_uo)
                                from orga.tuo as uo
                                where id_nivel_organizacional in (''||v_banderaE||'') and'';

                    --Definicion de la respuesta
                    v_consulta:=v_consulta||v_parametros.filtro;

                    --Devuelve la respuesta
                    return v_consulta;

                end;
            /*+++++++++++++++++   Fin   ++++++++++++++++++++*/

	else

		raise exception ''Transaccion inexistente'';

	end if;

EXCEPTION

	WHEN OTHERS THEN
			v_resp='''';
			v_resp = pxp.f_agrega_clave(v_resp,''mensaje'',SQLERRM);
			v_resp = pxp.f_agrega_clave(v_resp,''codigo_error'',SQLSTATE);
			v_resp = pxp.f_agrega_clave(v_resp,''procedimientos'',v_nombre_funcion);
			raise exception ''%'',v_resp;
END;
'LANGUAGE 'plpgsql'
 VOLATILE
 CALLED ON NULL INPUT
 SECURITY INVOKER
 COST 100;