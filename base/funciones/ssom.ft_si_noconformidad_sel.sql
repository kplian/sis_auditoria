CREATE OR REPLACE FUNCTION ssom.ft_si_noconformidad_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.ft_si_noconformidad_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tsi_noconformidad'
 AUTOR: 		 (szambrana)
 FECHA:	        09-08-2019 15:16:47
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				09-08-2019 15:16:47								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ssom.tsi_noconformidad'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ssom.ft_si_noconformidad_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SSOM_SINOCONF_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		szambrana	
 	#FECHA:		09-08-2019 15:16:47
	***********************************/

	if(p_transaccion='SSOM_SINOCONF_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						sinoconf.id_sinc,
						sinoconf.estado_reg,
						sinoconf.id_nc,
						sinoconf.id_si,
						sinoconf.usuario_ai,
						sinoconf.fecha_reg,
						sinoconf.id_usuario_reg,
						sinoconf.id_usuario_ai,
						sinoconf.id_usuario_mod,
						sinoconf.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        sinteg.nombre_si as desc_si	
						from ssom.tsi_noconformidad sinoconf
						inner join segu.tusuario usu1 on usu1.id_usuario = sinoconf.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sinoconf.id_usuario_mod
                        join ssom.tsistema_integrado sinteg on sinteg.id_si = sinoconf.id_si
            	        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SSOM_SINOCONF_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		szambrana	
 	#FECHA:		09-08-2019 15:16:47
	***********************************/

	elsif(p_transaccion='SSOM_SINOCONF_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sinc)
					    from ssom.tsi_noconformidad sinoconf
						inner join segu.tusuario usu1 on usu1.id_usuario = sinoconf.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sinoconf.id_usuario_mod
                        join ssom.tsistema_integrado sint on sint.id_si = sinoconf.id_si
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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;