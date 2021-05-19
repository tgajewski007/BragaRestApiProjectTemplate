<?php
namespace braga\project\controllers;
use braga\tools\api\BaseRestController;
use braga\tools\tools\RequstUrl;

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
		try
		{
			switch(RequstUrl::get(1))
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
		catch(\Throwable $e)
		{
			$this->sendError($e);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}