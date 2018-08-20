<?php 

class CommonCrontab extends Crontab {

   	public static function cron()
	{
		echo 'Start crontab';
		echo '<br/>';
		echo 'End crontab';
		die();
		return FALSE;#Stop Route
	}
}
