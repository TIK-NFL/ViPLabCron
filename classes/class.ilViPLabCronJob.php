<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once "Services/Cron/classes/class.ilCronJob.php";

/**
 * fhoev import plugin
 * 
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 *
 */
class ilViPLabCronJob extends ilCronJob
{
	protected $plugin; // [ilCronHookPlugin]
	
	/**
	 * Get id
	 * @return type
	 */
	public function getId()
	{
		return ilViPLabCronPlugin::getInstance()->getId();
	}
	
	public function getTitle()
	{		
		return ilViPLabCronPlugin::PNAME;
	}
	
	public function getDescription()
	{
		return ilViPLabCronPlugin::getInstance()->txt('cron_job_info');
	}
	
	public function getDefaultScheduleType()
	{
		return self::SCHEDULE_TYPE_IN_MINUTES;
	}
	
	public function getDefaultScheduleValue()
	{
		return parent::SCHEDULE_TYPE_IN_HOURS;
	}
	
	public function hasAutoActivation()
	{
		return false;
	}
	
	public function hasFlexibleSchedule()
	{
		return true;
	}
	
	public function hasCustomSettings() 
	{
		return false;
	}
	
	public function run()
	{
		$result = new ilCronJobResult();

		$active = $GLOBALS['ilPluginAdmin']->getActivePluginsForSlot(
			IL_COMP_MODULE,
			'TestQuestionPool',
			'qst'
		);
		foreach($active as $num => $info)
		{
			if($info == 'assViPLab')
			{
				$obj = ilPluginAdmin::getPluginObject(
					IL_COMP_MODULE,
					'TestQuestionPool',
					'qst', 
					$info
				);
					
				if($obj instanceof ilassViPLabPlugin )
				{
					$obj->handleCronJob();
					$result->setStatus(ilCronJobResult::STATUS_OK);
				}
			}
		}		

		return $result;
	}

	/**
	 * get viplab plugin
	 * @return \ilViPLabCronPlugin
	 */
	public function getPlugin()
	{
		return ilViPLabCronPlugin::getInstance();
	}

}

?>