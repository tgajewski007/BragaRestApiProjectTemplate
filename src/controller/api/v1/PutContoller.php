<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\PostChecker;

/**
 * Created on 6 sie 2018 09:44:03
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class PutContoller extends BaseRestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function doAction()
	{
		switch(PostChecker::get("action"))
		{
			default :
				$this->sendMethodNotAllowed();
				break;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}