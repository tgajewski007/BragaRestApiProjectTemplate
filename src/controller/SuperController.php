<?php
namespace braga\project\controller;
use braga\project\controller\api\v1\ApiRestController;
use braga\project\utils\logger\APILogger;
use braga\tools\api\ApiFiltr;
use braga\tools\api\RestController;

/**
 * Created on 6 paź 2017 18:05:43
 * @author Tomasz Gajewski
 * package controllers
 * error prefix BR:851
 */
class SuperController extends RestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->setLoggerClassNama(APILogger::class);
		$this->addApiFiltr(new ApiFiltr(ApiFiltr::ANY, "/api.v1(.*)", function () {
			(new ApiRestController("/api.v1"))->doAction();
		}));
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function doAction()
	{
		try
		{
			parent::doAction();
		}
		catch(\Throwable $e)
		{
			$this->sendError($e);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}