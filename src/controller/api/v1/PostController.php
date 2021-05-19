<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\RequstUrl;

/**
 * error prefix ESB:210
 * @author Tomasz Gajewski
 * @package
 *
 */
class PostController extends BaseRestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function doAction()
	{
		switch(RequstUrl::get(2))
		{
			default :
				$this->sendMethodNotAllowed();
				break;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}