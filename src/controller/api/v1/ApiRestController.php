<?php
namespace braga\project\controller\api\v1;
use braga\project\utils\logger\APILogger;
use braga\tools\api\RestController;

/**
 * Created on 26 lut 2018 15:10:53
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class ApiRestController extends RestController
{
	// -----------------------------------------------------------------------------------------------------------------
	public function __construct($urlPrefix)
	{
		$this->setLoggerClassNama(APILogger::class);
		$this->setUrlPrefix($urlPrefix);
	}
	// -----------------------------------------------------------------------------------------------------------------
}