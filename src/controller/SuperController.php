<?php
namespace braga\project\controllers;
use braga\tools\api\BaseRestController;

/**
 * Created on 6 paź 2017 18:05:43
 * @author Tomasz Gajewski
 * package controllers
 * error prefix CB:291
 */
class SuperController extends BaseRestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function doAction()
	{
		$serviceName = null;
		if(isset($_REQUEST["modul"]))
		{
			$serviceName = $_REQUEST["modul"];
		}
		switch($serviceName)
		{
			case "api.v1":
				$d = new \braga\project\controller\api\v1\ApiRestController();
				$d->doAction();
				break;
			default :
				$this->sendMethodNotAllowed();
				break;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}