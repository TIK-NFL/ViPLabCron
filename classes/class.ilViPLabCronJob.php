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
	public function getId(): string
	{
		return ilViPLabCronPlugin::getInstance()->getId();
	}
	
	public function getTitle(): string
	{		
		return ilViPLabCronPlugin::PNAME;
	}
	
	public function getDescription(): string
	{
		return ilViPLabCronPlugin::getInstance()->txt('cron_job_info');
	}
	
	public function getDefaultScheduleType(): int
	{
		return self::SCHEDULE_TYPE_IN_MINUTES;
	}
	
	public function getDefaultScheduleValue(): ?int
	{
		return parent::SCHEDULE_TYPE_IN_HOURS;
	}
	
	public function hasAutoActivation(): bool
	{
		return false;
	}
	
	public function hasFlexibleSchedule(): bool
	{
		return true;
	}
	
	public function hasCustomSettings(): bool
	{
		return false;
	}
	
	public function run(): ilCronJobResult
	{
		$result = new ilCronJobResult();
        $plugin = ilassViPLabPlugin::getInstance();
        $plugin->handleCronJob();
        $result->setStatus(ilCronJobResult::STATUS_OK);

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
