<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once("./Services/Cron/classes/class.ilCronHookPlugin.php");

/**
 * Viplab cron plugin
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 */
class ilViPLabCronPlugin extends ilCronHookPlugin
{
	private static $instance = null;

	const PLUGIN_NAME = 'ViPLabCron';
    const PLUGIN_ID = 'viplabcron';


	public static function getInstance()
	{
        if (self::$instance) {
            return self::$instance;
        }

        global $DIC;
        $component_factory = $DIC["component.factory"];
        return self::$instance = $component_factory->getPlugin(self::PLUGIN_ID);
	}
	
	public function getPluginName(): string
	{
		return self::PLUGIN_NAME;
	}
	
	/**
	 * Init auto load
	 */
	protected function init(): void
	{
		$this->initAutoLoad();
	}
		
	/**
	 * Init auto loader
	 * @return void
	 */
	protected function initAutoLoad()
	{
		spl_autoload_register(
			array($this,'autoLoad')
		);
	}

	/**
	 * Auto load implementation
	 *
	 * @param string class name
	 */
	private function autoLoad($a_classname)
	{
		$class_file = $this->getClassesDirectory().'/class.'.$a_classname.'.php';
		if(@include_once($class_file)) {
			return;
		}
	}

	public function getCronJobInstance($jobId): ilCronJob
	{
		return new ilViPLabCronJob();
	}

	public function getCronJobInstances(): array
	{
		return array(new ilViPLabCronJob());
	}

    protected function getClassesDirectory() : string
    {
        return $this->getDirectory() . "/classes";
    }

}