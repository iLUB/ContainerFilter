<#1>
<?php
/**
 * @var ilDB $db
 */
$db = $ilDB;
require_once('Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ContainerFilter/classes/class.ilContainerFilterConfigGUI.php');
if (!$db->tableExists(ilContainerFilterConfigGUI::TABLE_NAME)) {
	$fields = array(
		'config_key' => array(
			'type' => 'text',
			'length' => 64,
		),
		'config_value' => array(
			'type' => 'integer',
			'length' => 1,
		)
	);

	$db->createTable(ilContainerFilterConfigGUI::TABLE_NAME, $fields);
	$db->addPrimaryKey(ilContainerFilterConfigGUI::TABLE_NAME, array('config_key'));
	$stmt = $db->prepare('INSERT INTO ' . ilContainerFilterConfigGUI::TABLE_NAME .
		' (config_key, config_value) VALUES (?, ?)', array('text', 'integer'));
	$db->execute($stmt, array('show_on_desktop', 1));
	$db->execute($stmt, array('show_in_repository', 1));
	$db->execute($stmt, array('show_quicksilver_info', 1));
}
?>