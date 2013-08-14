<?php
/**
 * The Freights Controller.
 */
class FreightsController extends AppController {

/**
 * The Correios WebService URL.
 */
	public $correiosWebServiceURL = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';

/**
 * Company code. (optional)
 */
	public $nCdEmpresa = '';

/**
 * Company password. (optional)
 */
	public $sDsSenha = '';

/**
 * The zipcode of origin.
 */
	public $sCepOrigem = '';

/**
 * The zipcode of destiny.
 */
	public $sCepDestino = '';

/**
 * The weight.
 */
	public $nVlPeso = '1';

/**
 * The format ('1': caixa/pacote, '2': rolo/prisma)
 */
	public $nCdFormato = '1';

/**
 * The length.
 */
	public $nVlComprimento = '16';

/**
 * The height.
 */
	public $nVlAltura = '5';

/**
 * The width.
 */
	public $nVlLargura = '15';

/**
 * The diameter.
 */
	public $nVlDiametro = '0';

/**
 * Is 'mão própria'?
 */
	public $sCdMaoPropria = 's';

/**
 * The stated value.
 */
	public $nVlValorDeclarado = '0';

/**
 * Return receipt? 's' for yes, 'n' for no.
 */
	public $sCdAvisoRecebimento = 'n';

/**
 * The return type.
 */
	public $StrRetorno = 'xml';

/**
 * The service code.
 * 
 * You can use more than one, with commas. For example: 40010,40045.
 *
 * Samples:
 * 40010 SEDEX sem contrato.
 * 40045 SEDEX a Cobrar, sem contrato.
 * 40126 SEDEX a Cobrar, com contrato.
 * 40215 SEDEX 10, sem contrato.
 * 40290 SEDEX Hoje, sem contrato.
 * 40096 SEDEX com contrato.
 * 40436 SEDEX com contrato.
 * 40444 SEDEX com contrato.
 * 40568 SEDEX com contrato.
 * 40606 SEDEX com contrato.
 * 41106 PAC sem contrato.
 * 41068 PAC com contrato.
 * 81019 e-SEDEX, com contrato.
 * 81027 e-SEDEX Prioritário, com conrato.
 * 81035 e-SEDEX Express, com contrato.
 * 81868 (Grupo 1) e-SEDEX, com contrato.
 * 81833 (Grupo 2) e-SEDEX, com contrato.
 * 81850 (Grupo 3) e-SEDEX, com contrato.
 */
	public $nCdServico = '41106';

/**
 * The fields that will be necessary to sanitize, using only numbers.
 */
	public $sanitizeFields = array(
		'nCdEmpresa',
		'sCepOrigem',
		'sCepDestino',
		'nVlPeso',
		'nCdFormato',
		'nVlComprimento',
		'nVlAltura',
		'nVlLargura',
		'nVlDiametro',
		'nCdServico',
	);

	public $curl = '';

	public $httpQuery = '';

	public $result = '';

	public $correiosAttributes = array(
		'nCdEmpresa',
		'sDsSenha',
		'sCepOrigem',
		'sCepDestino',
		'nVlPeso',
		'nCdFormato',
		'nVlComprimento',
		'nVlAltura',
		'nVlLargura',
		'nVlDiametro',
		'sCdMaoPropria',
		'nVlValorDeclarado',
		'sCdAvisoRecebimento',
		'StrRetorno',
		'nCdServico'
	);

/**
 * Main method to get shipping infos.
 */
	public function index() {
		// No use view
		$this->autoRender = false;

		// Insert all params on attributes of the controller
		$this->insertParamsOnAttributes($this->params['named']);

		// Set the HTTP Query String
		$this->setHttpQuery();

		// Now let's execute the cURL POST requisition
		$this->execCurl();
	}

/**
 * Generate the query string for the param.
 */
	public function setHttpQuery() {
		foreach($this->correiosAttributes as $correiosAttribute) {

			$this->httpQuery .= http_build_query( array($correiosAttribute => $this->$correiosAttribute) ) . '&';
		}
	}

/**
 * Method to insert all params on attributes.
 */
	public function insertParamsOnAttributes($params = array()) {

		/**
		 * Iterate all the params inserted.
		 */
		foreach($params as $key => $value) {

			/**
			 * Sanitize fields setted on $sanitizeFields.
			 */
			if(in_array($key, $this->sanitizeFields)) {
				$value = $this->Freight->sanitize($value);
			}

			/**
			 * Sets the attributes.
			 */
			$this->$key = $value;
		}
	}

/**
 * Method to execute the cURL POST requisition.
 */
	public function execCurl() {
		// Initialize the cURL
		$this->curl = curl_init($this->correiosWebServiceURL . $this->httpQuery);

		// Set return transfer equal to TRUE
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

		// Execute the cURL
		$this->result = curl_exec($this->curl);

		$this->result = simplexml_load_string($this->result);
	}
}