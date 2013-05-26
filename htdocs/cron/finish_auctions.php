<?php
require_once 'cron.php';

$job = new Cron_Job_FinishAuctions();
$job->run();