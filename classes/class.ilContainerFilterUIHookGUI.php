<?php
/* Copyright (c) 1998-2014 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once('Services/UIComponent/classes/class.ilUIHookPluginGUI.php');
require_once('class.ilContainerFilterConfigGUI.php');

/**
 * ilContainerFilterUIHookGUI class for Personal Desktop jQuery Search Block
 * @author            Fabian Schmid <fabian.schmid@ilub.unibe.ch>
 * @version           $Id$
 */
class ilContainerFilterUIHookGUI extends ilUIHookPluginGUI {

	const PERSONAL_DESKTOP_SELECTOR = '#block_pditems_0';
	const REPOSITORY_SELECTOR = '.ilContainerBlock';


	/**
	 * Get html for a user interface area
	 *
	 * @param string $a_comp
	 * @param string $a_part
	 * @param array  $a_par
	 *
	 * @return array
	 */
	function getHTML($a_comp, $a_part, $a_par = array()) {
		if (ilContainerFilterConfigGUI::_getValue('show_on_desktop') == 1) {
			if ($a_comp == 'Services/PersonalDesktop' && $a_part == 'right_column') {

				return array('mode' => ilUIHookPluginGUI::PREPEND,
					'html' => $this->getBlockHTML(self::PERSONAL_DESKTOP_SELECTOR));
			}
		}

		if (ilContainerFilterConfigGUI::_getValue('show_in_repository') == 1) {
			if ($a_comp == 'Services/Container' && $a_part == 'right_column') {

				return array('mode' => ilUIHookPluginGUI::PREPEND,
					'html' => $this->getBlockHTML(self::REPOSITORY_SELECTOR));
			}
		}

		// in all other cases, keep everything as it is
		return array('mode' => ilUIHookPluginGUI::KEEP, 'html' => '');
	}


	/**
	 * @param string $content_selector jQuery selector
	 *
	 * @return string
	 */
	function getBlockHTML($content_selector) {
		include_once('class.ilContainerFilterBlockGUI.php');
		$block = new ilContainerFilterBlockGUI($content_selector);

		return $block->getHTML();
	}
}
