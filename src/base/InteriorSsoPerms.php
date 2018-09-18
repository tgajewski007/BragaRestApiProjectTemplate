<?php
namespace braga\project\base;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Rsa\Sha512;
use braga\project\config\Config;
use braga\project\obj\KeyStore;

/**
 * Created on 22 lip 2018 11:04:05
 * error prefix CB:903
 * @author Tomasz Gajewski
 * @package
 *
 */
class InteriorSsoPerms
{ // -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var InteriorSsoPerms
	 */
	private static $instance = null;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var \Lcobucci\JWT\Token
	 */
	private $jwt;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return \Lcobucci\JWT\Token
	 */
	public function getJwt()
	{
		return $this->jwt;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param \Lcobucci\JWT\Token $jwt
	 */
	public function setJwt($jwt)
	{
		$this->jwt = $jwt;
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function __construct()
	{
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function __clone()
	{
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	// -----------------------------------------------------------------------------------------------------------------
	private function check()
	{
		$tokenString = self::getTokenStringFromHttpHeader();
		$this->jwt = self::getTokenFromString($tokenString);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $jwt
	 * @throws \Exception
	 * @return \Lcobucci\JWT\Token
	 */
	public static function getTokenFromString($jwt)
	{
		$parser = new Parser();
		$token = $parser->parse($jwt);

		$data = new ValidationData();
		$data->setIssuer(Config::getIssuerRealms());
		$typ = $token->getClaim("typ");
		if($typ == "Bearer")
		{
			if($token->validate($data))
			{
				if($token->getHeader("alg") == "RS256")
				{
					$signer = new Sha256();
				}
				elseif($token->getHeader("alg") == "RS512")
				{
					$signer = new Sha512();
				}
				else
				{
					throw new \Exception("BP:90201 Nieobsugiwany algorytm weryfikacji tokenu", 90201);
				}
				$key = new Key(KeyStore::get($token->getHeader("kod"))->getPublicKey());

				if($token->verify($signer, $key))
				{
					return $token;
				}
				else
				{
					throw new \Exception("BP:90202 Błąd veryfikacji tokenu", 90202);
				}
			}
			else
			{
				throw new \Exception("BP:90203 Błąd veryfikacji tokenu", 90203);
			}
		}
		else
		{
			throw new \Exception("BP:90204 Niewłaściwy typ tokenu", 90204);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getTokenStringFromHttpHeader()
	{
		$headers = self::getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if(!empty($headers))
		{
			$matches = array();
			if(preg_match('/bearer\s(\S+)/i', $headers, $matches))
			{
				return $matches[1];
			}
		}
		throw new \Exception("BP:90205 Brak tokenu w nagłówku", 90205);
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected static function getAuthorizationHeader()
	{
		if(isset($_SERVER['Authorization']))
		{
			return trim($_SERVER["Authorization"]);
		}
		else
		{
			if(isset($_SERVER['HTTP_AUTHORIZATION']))
			{ // Nginx or fast CGI
				return trim($_SERVER["HTTP_AUTHORIZATION"]);
			}
			elseif(function_exists('apache_request_headers'))
			{
				$requestHeaders = apache_request_headers();
				// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
				$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
				// print_r($requestHeaders);
				if(isset($requestHeaders['Authorization']))
				{
					return trim($requestHeaders['Authorization']);
				}
			}
		}
		throw new \Exception("BP:90206 Brak nagłówka Authorization", 90206);
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function pageOpen()
	{
		InteriorSsoPerms::getInstance()->check();
	}
	// -----------------------------------------------------------------------------------------------------------------
}
