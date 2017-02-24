<?php
/* Copyright (c) 1998-2014 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once('Services/Block/classes/class.ilBlockGUI.php');
require_once('class.ilContainerFilterPlugin.php');

/**
 * BlockGUI class for Content Filter jQuery Search Block
 * @author            Fabian Schmid <fabian.schmid@ilub.unibe.ch>
 * @version           $Id$
 * @ilCtrl_IsCalledBy ilContainerFilterBlockGUI: ilColumnGUI
 */
class ilContainerFilterBlockGUI extends ilBlockGUI {
	static $block_type = 'containerfilter';
	protected $container_selector;

	/**
	 * Constructor
	 */
	public function __construct($container_selector) {
		parent::__construct();
		$this->container_selector = $container_selector;
		$this->plugin = new ilContainerFilterPlugin();
		$this->setTitle($this->plugin->txt('title'));
	}

	/**
	 * Get block type
	 * @return    string    Block type.
	 */
	static function getBlockType() {
		return self::$block_type;
	}

	/**
	 * Get block type
	 * @return    string    Block type.
	 */
	static function isRepositoryObject() {
		return false;
	}

	/**
	 * Fill data section
	 */
	public function fillDataSection() {
		$search = $this->plugin->getTemplate('tpl.jquerysearch.html', true, true);
		$search->touchBlock('container_filter');
		$search->setVariable('LIST', $this->getContainerSelector());
		if (ilContainerFilterConfigGUI::_getValue('show_quicksilver_info')) {
			$search->setCurrentBlock('container_filter_info');
			$search->setVariable('INFOTEXT', $this->plugin->txt('quicksilver_infotext'));
			$search->parseCurrentBlock();
		}
		$this->setDataSection($search->get());
	}


	/**
	 * @param string $container_selector
	 */
	public function setContainerSelector($container_selector) {
		$this->container_selector = $container_selector;
	}


	/**
	 * @return string
	 */
	public function getContainerSelector() {
		return $this->container_selector;
	}
}