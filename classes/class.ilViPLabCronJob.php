<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once "Services/Cron/classes/class.ilCronJob.php";

/**
 *
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 *
 */
class ilViPLabCronJob extends ilCronJob
{
	public function getId(): string
	{
		return ilViPLabCronPlugin::getInstance()->getId();
	}
	
	public function getTitle(): string
	{		
		return ilViPLabCronPlugin::PLUGIN_NAME;
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
		return 1;
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
        $assViPLabPlugin = ilassViPLabPlugin::getInstance();

        if ($assViPLabPlugin->isActive()) {
            $assViPLabPlugin->handleCronJob();
            $result->setStatus(ilCronJobResult::STATUS_OK);
        }

        return $result;
	}
}