<?php
/* Copyright (c) 1998-2014 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once('Services/UIComponent/classes/class.ilUserInterfaceHookPlugin.php');

/**
 * ilContainerFilterPlugin class for Personal Desktop jQuery Search Block
 * @author            Fabian Schmid <fabian.schmid@ilub.unibe.ch>
 * @version           $Id$
 */
class ilContainerFilterPlugin extends ilUserInterfaceHookPlugin {

	function getPluginName() {
		return 'ContainerFilter';
	}
}
