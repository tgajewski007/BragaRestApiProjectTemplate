<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\RequstUrl;

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
		switch(RequstUrl::get(2))
		{
			default :
				$this->sendMethodNotAllowed();
				break;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}