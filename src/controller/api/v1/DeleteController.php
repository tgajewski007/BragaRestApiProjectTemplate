<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\PostChecker;

/**
 * Created on 26 lut 2018 17:47:08
 * error prefix OD:202
 * @author Tomasz Gajewski
 * @package
 *
 */
class DeleteController extends BaseRestController
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