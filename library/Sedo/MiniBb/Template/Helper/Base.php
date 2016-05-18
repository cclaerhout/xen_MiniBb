<?php

class Sedo_MiniBb_Template_Helper_Base
{
	protected $_originalText = '';
	
	protected $_outputText = '';

	protected $_parserConfiguration  = array(
		'parserOpeningCharacter' => '[',
		'parserClosingCharacter' => ']',
		'htmlspecialcharsForContent' => false,
		'htmlspecialcharsForOptions' => false,
		'checkClosingTag' => true,
		'mergeAdjacentTextNodes' => true,
		'nl2br' => false,
		'trimTextNodes' => false	
	);

	protected $_bbCodes = array(
		'b' => array(
			'replace' => array('<b>', '</b>')
		),
		'i' => array(
			'replace' => array('<i>', '</i>')
		),
		'u' => array(
			'replace' => array('<span style="text-decoration: underline">', '</span>')
		),
		's' => array(
			'replace' => array('<span style="text-decoration: line-through">', '</span>')
		),
		'sub' => array(
			'replace' => array('<sub class="xen_cust" style="vertical-align:sub">', '</sub>')
		),
		'sup' => array(
			'replace' => array('<sup class="xen_cust" style="vertical-align:super">', '</sup>')
		)
	);

	public function __construct($text)
	{
		$this->setOriginalText($text); //backup if needed
		$text = $this->filterInput($text);
		$this->_bbCodes = $this->filterBbCodes($this->_bbCodes);
		
		$miniParser = new Sedo_MiniBb_Helper_MiniParser($text, $this->_bbCodes, array(), $this->_parserConfiguration);
		$output = $miniParser->render();

		$this->_outputText = $this->filterInput($output);
	}

	public function setOriginalText($text)
	{
		$this->_originalText = $text;
	}
	
	public function filterBbCodes(array $bbCodes)
	{
		return $bbCodes;
	}

	public function filterInput($text)
	{
		return $text;
	}

	public function filterOutput($text)
	{
		return $text;
	}

	public function getOutput()
	{
		return $this->_outputText;
	}

	public static function create($text = '', $class = null)
	{
		if (!$class)
		{
			$class = __CLASS__;
		}
		else if (strpos($class, '_') === false)
		{
			$class = 'Sedo_MiniBb_Template_Helper_' . $class;
		}

		$class = XenForo_Application::resolveDynamicClass($class, 'mini_bb');

		$formatter = new $class($text);
		return $formatter->getOutput();
	}
}