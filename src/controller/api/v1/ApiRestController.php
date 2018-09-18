<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;

/**
 * Created on 26 lut 2018 15:10:53
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class ApiRestController extends BaseRestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function doAction()
	{
		switch($_SERVER["REQUEST_METHOD"])
		{
			case "OPTIONS":
				$this->sendCheck();
				break;
			case "GET":
				$d = new GetController();
				$d->doAction();
				break;
			case "POST":
				$d = new PostController();
				$d->doAction();
				break;
			case "PUT":
				$d = new PutContoller();
				$d->doAction();
				break;
			case "DELETE":
				$d = new DeleteController();
				$d->doAction();
				break;
			case "PATCH":
				$d = new PatchController();
				$d->doAction();
				break;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected function sendCheck()
	{
		$this->sendStandardsHeaders();
	}
	// -----------------------------------------------------------------------------------------------------------------
}