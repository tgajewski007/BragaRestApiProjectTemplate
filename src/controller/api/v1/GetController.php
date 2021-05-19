<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\RequstUrl;

/**
 * Created on 26 lut 2018 15:25:28
 * error prefix OD:201
 * @author Tomasz Gajewski
 * @package
 *
 */
class GetController extends BaseRestController
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