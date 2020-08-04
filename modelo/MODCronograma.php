<?php
/**
*@package pXP
*@file gen-MODCronograma.php
*@author  (max.camacho)
*@date 12-12-2019 15:50:53
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-12-2019 15:50:53								CREACION

*/

class MODCronograma extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarCronograma(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ssom.ft_cronograma_sel';
		$this->transaccion='SSOM_CRONOG_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Definicion de la lista del resultado del query
		$this->captura('id_cronograma','int4');
		$this->captura('nueva_actividad','varchar');
		$this->captura('obs_actividad','text');
		$this->captura('estado_reg','varchar');
		$this->captura('hora_ini_activ','time');
		$this->captura('fecha_ini_activ','date');
		$this->captura('fecha_fin_activ','date');
		$this->captura('id_actividad','int4');
		$this->captura('hora_fin_activ','time');
		$this->captura('id_aom','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('actividad','varchar');
		$this->captura('lista_funcionario','text');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function insertarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_INS';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('nueva_actividad','nueva_actividad','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('hora_ini_activ','hora_ini_activ','time');
		$this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
		$this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
		$this->setParametro('id_actividad','id_actividad','int4');
		$this->setParametro('hora_fin_activ','hora_fin_activ','time');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function modificarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_cronograma','id_cronograma','int4');
		$this->setParametro('nueva_actividad','nueva_actividad','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('hora_ini_activ','hora_ini_activ','time');
		$this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
		$this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
		$this->setParametro('id_actividad','id_actividad','int4');
		$this->setParametro('hora_fin_activ','hora_fin_activ','time');
		$this->setParametro('id_aom','id_aom','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function eliminarCronograma(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ssom.ft_cronograma_ime';
		$this->transaccion='SSOM_CRONOG_ELI';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_cronograma','id_cronograma','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function insertarCronogramaRecord() {

        $cone = new conexion();
        $link = $cone->conectarpdo();

        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ssom.ft_cronograma_ime';
        $this->transaccion='SSOM_CRONOG_INS';
        $this->tipo_procedimiento='IME';

        $json_detalle = $this->aParam->_json_decode($this->aParam->getParametro('json_new_records'));

        foreach ($json_detalle as $f) {
            $this->resetParametros();
            $this->arreglo['id_aom'] = $f['id_aom'];
            $this->arreglo['id_actividad'] = $f['id_actividad'];
            $this->arreglo['nueva_actividad'] = $f['nueva_actividad'];
            $this->arreglo['fecha_ini_activ'] = $f['fecha_ini_activ'];
            $this->arreglo['fecha_fin_activ'] = $f['fecha_fin_activ'];
            $this->arreglo['hora_ini_activ'] = $f['hora_ini_activ'];
            $this->arreglo['hora_fin_activ'] = $f['hora_fin_activ'];

            //Define los parametros para la funcion
            $this->setParametro('id_aom','id_aom','int4');
            $this->setParametro('id_actividad','id_actividad','int4');
            $this->setParametro('nueva_actividad','nueva_actividad','varchar');
            $this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
            $this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
            $this->setParametro('hora_ini_activ','hora_ini_activ','time');
            $this->setParametro('hora_fin_activ','hora_fin_activ','time');

            //Ejecuta la instruccion
            $this->armarConsulta();
            $stmt = $link->prepare($this->consulta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //recupera parametros devuelto depues de insertar ... (id_solicitud)
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
            if ($resp_procedimiento['tipo_respuesta'] == 'ERROR') {
                throw new Exception("Error al insertar detalle  en la bd", 3);
            }

        }
        // $link->commit();
        $this->respuesta = new Mensaje();
        $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'], $this->nombre_archivo, $resp_procedimiento['mensaje'], $resp_procedimiento['mensaje_tec'], 'base', $this->procedimiento, $this->transaccion, $this->tipo_procedimiento, $this->consulta);
        $this->respuesta->setDatos($result);

        //Devuelve la respuesta
        return $this->respuesta;
    }
		function itemCronograma(){
			//Definicion de variables para ejecucion del procedimiento
			$this->procedimiento='ssom.ft_cronograma_ime';
			$this->transaccion='SSOM_CROIN_INS';
			$this->tipo_procedimiento='IME';

			//Define los parametros para la funcion
			$this->setParametro('id_aom','id_aom','int4');
			$this->setParametro('id_cronograma','id_cronograma','int4');
			$this->setParametro('fecha_ini_activ','fecha_ini_activ','date');
			$this->setParametro('fecha_fin_activ','fecha_fin_activ','date');
			$this->setParametro('hora_ini_activ','hora_ini_activ','time');
			$this->setParametro('hora_fin_activ','hora_fin_activ','time');
			$this->setParametro('id_actividad','id_actividad','int4');
			$this->setParametro('funcionarios','funcionarios','text');

			//Ejecuta la instruccion
			$this->armarConsulta();
			$this->ejecutarConsulta();

			//Devuelve la respuesta
			return $this->respuesta;
		}

}
?>
