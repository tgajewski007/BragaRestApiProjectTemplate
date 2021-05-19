<?php
namespace braga\project\controller\api\v1;
use braga\tools\api\BaseRestController;
use braga\tools\tools\RequstUrl;
/**
 * Created on 26 lut 2018 17:47:08
 * error prefix OD:202
 * @author Tomasz Gajewski
 * @package
 *
 */
class PatchController extends BaseRestController
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