--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ssom.f_list_funcionarios_responsables (
  p_id_aom integer,
  p_estado varchar
)
  RETURNS varchar AS'
/**************************************************************************
 SISTEMA:		Sistema de Seguimiento a Oportunidades de Mejora
 FUNCION: 		ssom.f_list_funcionarios_responsables
 DESCRIPCION:   Funcion que devuelve en una cadena la lista Funcionarios responsables de la Auditoria, la consultas esta relacionada con la tabla ''ssom.tequipo_responsable''
 AUTOR: 		 (max.camacho)
 FECHA:	        15-10-2019 14:31:07
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				15-10-2019 14:31:07								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla ''ssom.tequipo_responsable''
 #
 ***************************************************************************/
DECLARE
v_nombre_funcion   				text;
v_resp							varchar;

v_record						record;
v_funcionarios_resp 			varchar = '''';

v_cont_query					integer;
v_cant_filas					integer = 1;
v_bandera 						boolean = false;

BEGIN

	 v_nombre_funcion = ''ssom.f_list_funcionarios_responsables'';

    select count(eqre.id_equipo_responsable) into v_cont_query from ssom.tequipo_responsable eqre where eqre.id_aom = p_id_aom and eqre.estado_reg = ''activo'';

    if( v_cont_query > 0 ) then

          for v_record in (select eqre.id_equipo_responsable, eqre.id_funcionario, eqre.id_aom , vfc.desc_funcionario1::varchar, par.codigo_parametro
                      from ssom.tequipo_responsable eqre
                      join orga.vfuncionario_cargo vfc on eqre.id_funcionario = vfc.id_funcionario
                      inner join ssom.tparametro par on eqre.id_parametro = par.id_parametro
                      where eqre.id_aom = p_id_aom and eqre.estado_reg=''activo''
                      GROUP by eqre.id_aom, eqre.id_equipo_responsable,2,3,4,5 ORDER BY eqre.id_equipo_responsable) loop

                      if ((p_estado = ''programado'' or p_estado = ''prog_aprob'') and v_bandera is false ) then
                      	v_funcionarios_resp = v_funcionarios_resp||v_record.desc_funcionario1||'' (''||v_record.codigo_parametro||'')'';
                        v_cant_filas = v_cant_filas + 1;
                        v_bandera = true;
                      end if;

                      if (p_estado <> ''programado'' and p_estado <> ''prog_aprob'') then

                          if ( v_cont_query = 1 ) then
                            v_funcionarios_resp = v_funcionarios_resp||v_record.desc_funcionario1||'' (''||v_record.codigo_parametro||'')'';
                            v_cant_filas = v_cant_filas + 1;
                          end if;

                          if ( v_cont_query > 1 and v_cant_filas < v_cont_query) then
                              v_funcionarios_resp = v_funcionarios_resp||v_record.desc_funcionario1||'' (''||v_record.codigo_parametro||''), '';
                              v_cant_filas = v_cant_filas + 1;
                          elsif (v_cant_filas = v_cont_query ) then
                              v_funcionarios_resp = v_funcionarios_resp||v_record.desc_funcionario1||'' (''||v_record.codigo_parametro||'')'';
                          end if;

                      end if;


          end loop;

  	elsif (v_cont_query = 0) then
       v_funcionarios_resp = ''(No Aplica)'';
    end if;



    --ETURN QUERY  select * from tmp_estado_auditoria;

    RETURN v_funcionarios_resp;


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