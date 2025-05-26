<?php
namespace App\Helpers\Services;

use App\Models\JobReportAfterProcessed;

class JobResportsService{

	public static function generatejobReport($data)
	{
		JobReportAfterProcessed::updateOrCreate(['job_id' => $data['job_id'] ?? null], $data);
	}





}

