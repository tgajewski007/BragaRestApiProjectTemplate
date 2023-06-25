<?php
namespace braga\requpero\controller\api\v1;
use braga\db\mysql\DB;
use braga\tools\api\RestController;
use braga\tools\exception\NoRecordFoundException;
class HealthCheckController extends RestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function health()
	{
		try
		{
			$this->testDbConnection();
			// TODO: make next healthtest check - throw excpetion on fail
			$this->sendPlainText("LIVE");
		}
		catch(\Throwable $e)
		{
			$this->sendError($e);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function testDbConnection()
	{
		$db = new DB();
		$sql = "SELECT Now() FROM dual";
		$db->query($sql);
		if($db->nextRecord())
		{
			$dbDate = strtotime($db->f(0));
			$phpDate = time();
			if(abs($dbDate - $phpDate) > 1)
			{
				throw new \Exception("Diffrent date", 2);
			}
		}
		else
		{
			throw new NoRecordFoundException("No date found", 1);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}
