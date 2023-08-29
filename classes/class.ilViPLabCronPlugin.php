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

	const CTYPE = 'Services';
	const CNAME = 'Cron';
	const SLOT_ID = 'crnhk';
	const PNAME = 'ViPLabCron';

	/**
	 * Get singleton instance
	 * @global ilPluginAdmin $ilPluginAdmin
	 * @return \ilViPLabCronPlugin
	 */
	public static function getInstance()
	{
        if (self::$instance) {
            return self::$instance;
        }

        global $DIC;

        $component_factory = $DIC['component.factory'];
        $instance = $component_factory->getPlugin('viplabcron');

        return self::$instance = $instance;
	}

	/**
	 * Get plugin name
	 * @return string
	 */
	public function getPluginName(): string
	{
		return self::PNAME;
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
	private final function autoLoad($a_classname)
	{
		$class_file = $this->getClassesDirectory().'/class.'.$a_classname.'.php';
		if(@include_once($class_file))
		{
			return;
		}
	}

	/**
	 * Get cron job instance
	 * @param type $a_id
	 * @return \ilViPLabCronJob
	 */
	public function getCronJobInstance($a_id): ilCronJob
	{
		return new ilViPLabCronJob();
	}


	/**
	 * Get cron job instances
	 * @global type $ilLog
	 * @return \ilViPLabCronJob[]
	 */
	public function getCronJobInstances(): array
	{
		$job = new ilViPLabCronJob();
		return array($job);
	}

    protected function getClassesDirectory() : string
    {
        return $this->getDirectory() . "/classes";
    }

}