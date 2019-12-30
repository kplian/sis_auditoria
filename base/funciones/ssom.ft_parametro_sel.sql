--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.ft_parametro_sel (
	p_administrador integer,
	p_id_usuario integer,
	p_tabla varchar,
	p_transaccion varchar
)
	RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_parametro_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tparametro''
 AUTOR: 		 (max.camacho)
 FECHA:	        03-07-2019 16:18:31
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				03-07-2019 16:18:31								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tparametro''
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
	v_tipo_parametro_tn    varchar;
	v_tipo_parametro_oa    varchar;
	v_tipo_parametro_tom    varchar;

BEGIN

	v_nombre_funcion = ''ssom.ft_parametro_sel'';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  ''SSOM_PRM_SEL''
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 16:18:31
	***********************************/

	if(p_transaccion=''SSOM_PRM_SEL'')then

    	begin
    		--Sentencia de la consulta
				v_consulta:=''select
							prm.id_parametro,
							prm.id_tipo_parametro,
							prm.estado_reg,
							prm.valor_parametro,
													prm.codigo_parametro,
							prm.id_usuario_reg,
							prm.fecha_reg,
							prm.usuario_ai,
							prm.id_usuario_ai,
							prm.fecha_mod,
							prm.id_usuario_mod,
							usu1.cuenta as usr_reg,
							usu2.cuenta as usr_mod,
													tpp.tipo_parametro,
													tpp.descrip_parametro
							from ssom.tparametro prm
							inner join segu.tusuario usu1 on usu1.id_usuario = prm.id_usuario_reg
							left join segu.tusuario usu2 on usu2.id_usuario = prm.id_usuario_mod
													join ssom.ttipo_parametro tpp on tpp.id_tipo_parametro = prm.id_tipo_parametro
									where  '';

				--Definicion de la respuesta

				v_consulta:=v_consulta||v_parametros.filtro;
				v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;
				raise notice ''%'',v_consulta;

				--Devuelve la respuesta
				return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  ''SSOM_PRM_CONT''
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		max.camacho
 	#FECHA:		03-07-2019 16:18:31
	***********************************/

	elsif(p_transaccion=''SSOM_PRM_CONT'')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:=''select count(prm.id_parametro)
					    from ssom.tparametro prm
							inner join segu.tusuario usu1 on usu1.id_usuario = prm.id_usuario_reg
							left join segu.tusuario usu2 on usu2.id_usuario = prm.id_usuario_mod
              join ssom.ttipo_parametro tpp on tpp.id_tipo_parametro = prm.id_tipo_parametro
					    where '';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        /**************  Inicio **********/
        /*********************************
        #TRANSACCION:  ''SSOM_PRMX1_SEL''
        #DESCRIPCION:	Consulta de datos
        #AUTOR:		max.camacho
        #FECHA:		03-07-2019 16:18:31
        ***********************************/

        elsif(p_transaccion=''SSOM_PRMX1_SEL'')then
            begin
                	v_tipo_parametro_tn = pxp.f_get_variable_global(''ssom_parametro_tipo_norma'');

                --Sentencia de la consulta
                v_consulta:=''select
                            prm.id_parametro,
                            prm.id_tipo_parametro,
                            prm.valor_parametro,
                            tpp.tipo_parametro
                            from ssom.tparametro prm
                            join ssom.ttipo_parametro tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                            where tpp.tipo_parametro = ''''''||v_tipo_parametro_tn||'''''' and '';

                --Definicion de la respuesta
                v_consulta:=v_consulta||v_parametros.filtro;
                v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;
                raise notice ''%'',v_consulta;
                --Devuelve la respuesta
                return v_consulta;

            end;
            /*********************************
            #TRANSACCION:  ''SSOM_PRMX1_CONT''
            #DESCRIPCION:	Conteo de registros
            #AUTOR:		max.camacho
            #FECHA:		03-07-2019 16:18:31
            ***********************************/

            elsif(p_transaccion=''SSOM_PRMX1_CONT'')then
                begin
                				v_tipo_parametro_tn = pxp.f_get_variable_global(''ssom_parametro_tipo_norma'');

                    --Sentencia de la consulta de conteo de registros
                    v_consulta:=''select count(prm.id_parametro)
                                from ssom.tparametro prm
                            	join ssom.ttipo_parametro tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                                where tpp.tipo_parametro = ''''''||v_tipo_parametro_tn||'''''' and '';
                                --tpp.tipo_parametro = ''''''||v_tipo_parametro_tn||'''''' and

                    --Definicion de la respuesta
                    v_consulta:=v_consulta||v_parametros.filtro;
					raise notice ''%'',v_consulta;
                    --Devuelve la respuesta
                    return v_consulta;

                end;
                /*********************************
                #TRANSACCION:  ''SSOM_PRMX2_SEL''
                #DESCRIPCION:	Consulta de datos
                #AUTOR:		max.camacho
                #FECHA:		03-07-2019 16:18:31
                ***********************************/

                elsif(p_transaccion=''SSOM_PRMX2_SEL'')then
                    v_tipo_parametro_oa = pxp.f_get_variable_global(''ssom_parametro_objeto_auditoria'');
                    begin
                        --Sentencia de la consulta
                        v_consulta:=''select
                                    prm.id_parametro,
                                    prm.id_tipo_parametro,
                                    prm.valor_parametro,
                                    tpp.tipo_parametro
                                    from ssom.tparametro prm
                                    join ssom.ttipo_parametro as tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                                    where  tpp.tipo_parametro = ''''''||v_tipo_parametro_oa||'''''' and'';

                        --Definicion de la respuesta
                        v_consulta:=v_consulta||v_parametros.filtro;
                        v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;
                        raise notice ''%'',v_consulta;
                        --Devuelve la respuesta
                        return v_consulta;

                    end;
                    /*********************************
                    #TRANSACCION:  ''SSOM_PRMX2_CONT''
                    #DESCRIPCION:	Conteo de registros
                    #AUTOR:		max.camacho
                    #FECHA:		03-07-2019 16:18:31
                    ***********************************/

                    elsif(p_transaccion=''SSOM_PRMX2_CONT'')then
                        v_tipo_parametro_oa = pxp.f_get_variable_global(''ssom_parametro_objeto_auditoria'');
                        begin
                            --Sentencia de la consulta de conteo de registros
                            v_consulta:=''select count(prm.id_parametro)
                                        from ssom.tparametro prm
                                        join ssom.ttipo_parametro as tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                                        where tpp.tipo_parametro = ''''''||v_tipo_parametro_oa||'''''' and'';

                            --Definicion de la respuesta
                            v_consulta:=v_consulta||v_parametros.filtro;

                            --Devuelve la respuesta
                            return v_consulta;

                        end;
                 /*********************************
                #TRANSACCION:  ''SSOM_PRMX3_SEL''
                #DESCRIPCION:	Consulta de datos
                #AUTOR:		max.camacho
                #FECHA:		03-07-2019 16:18:31
                ***********************************/

                elsif(p_transaccion=''SSOM_PRMX3_SEL'')then
                    v_tipo_parametro_tom = pxp.f_get_variable_global(''ssom_parametro_tipo_om'');
                    begin
                        --Sentencia de la consulta
                        v_consulta:=''select
                                    prm.id_parametro,
                                    prm.id_tipo_parametro,
                                    prm.valor_parametro,
                                    tpp.tipo_parametro
                                    from ssom.tparametro prm
                                    join ssom.ttipo_parametro as tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                                    where  tpp.tipo_parametro = ''''''||v_tipo_parametro_tom||'''''' and'';

                        --Definicion de la respuesta
                        v_consulta:=v_consulta||v_parametros.filtro;
                        v_consulta:=v_consulta||'' order by '' ||v_parametros.ordenacion|| '' '' || v_parametros.dir_ordenacion || '' limit '' || v_parametros.cantidad || '' offset '' || v_parametros.puntero;
                        raise notice ''%'',v_consulta;
                        --Devuelve la respuesta
                        return v_consulta;

                    end;
                    /*********************************
                    #TRANSACCION:  ''SSOM_PRMX3_CONT''
                    #DESCRIPCION:	Conteo de registros
                    #AUTOR:		max.camacho
                    #FECHA:		03-07-2019 16:18:31
                    ***********************************/

                    elsif(p_transaccion=''SSOM_PRMX3_CONT'')then
                        v_tipo_parametro_tom = pxp.f_get_variable_global(''ssom_parametro_tipo_om'');
                        begin
                            --Sentencia de la consulta de conteo de registros
                            v_consulta:=''select count(prm.id_parametro)
                                        from ssom.tparametro prm
                                        join ssom.ttipo_parametro as tpp on prm.id_tipo_parametro = tpp.id_tipo_parametro
                                        where tpp.tipo_parametro = ''''''||v_tipo_parametro_tom||'''''' and'';

                            --Definicion de la respuesta
                            v_consulta:=v_consulta||v_parametros.filtro;

                            --Devuelve la respuesta
                            return v_consulta;

                        end;
        /***************  Fin ************/

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