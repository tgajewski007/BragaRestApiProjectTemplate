<?php
namespace braga\project\base;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Rsa\Sha512;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use braga\project\config\Config;
use braga\project\obj\KeyStore;

/**
 * Created on 22 lip 2018 11:04:05
 * error prefix CB:903
 * @author Tomasz Gajewski
 * @package
 *
 */
class Perms
{
	// -----------------------------------------------------------------------------------------------------------------
	const KEYCLOAK_CLIENT_NAME = "braga";
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var self
	 */
	private static $instance = null;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @var Plain
	 */
	private $jwt;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @return Plain
	 */
	public function getJwt()
	{
		return $this->jwt;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param Plain $jwt
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
	/**
	 * @return Perms
	 */
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $roleName
	 */
	private function check($roleName)
	{
		$tokenString = self::getTokenStringFromHttpHeader();
		$this->jwt = self::getValidTokenFromString($tokenString);
		$this->authorize($roleName);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $jwt
	 * @throws \Exception
	 * @return \Lcobucci\JWT\Token\Plain|\Lcobucci\JWT\Token
	 */
	public static function getValidTokenFromString($jwt)
	{
		$parser = new Parser(new JoseEncoder());
		$token = $parser->parse($jwt);
		if($token instanceof Plain)
		{
			$typ = $token->claims()->get("typ");
			if($typ == "Bearer")
			{
				if($token->headers()->get("alg") == "RS256")
				{
					$signer = new Sha256();
				}
				elseif($token->headers()->get("alg") == "RS512")
				{
					$signer = new Sha512();
				}
				else
				{
					throw new \Exception("GO:90201 Nieobsugiwany algorytm weryfikacji tokenu", 90201);
				}
				$key = InMemory::plainText(KeyStore::get($token->headers()->get("kid"))->getPublicKey());

				$v = new Validator();
				$issuedBy = new IssuedBy(Config::getIssuerRealms());
				$validAt = new LooseValidAt(SystemClock::fromSystemTimezone());
				$signedWith = new SignedWith($signer, $key);
				if($v->validate($token, $issuedBy, $validAt, $signedWith))
				{
					return $token;
				}
				else
				{
					throw new \Exception("DE:90202 Błąd veryfikacji tokenu", 90202);
				}
			}
			else
			{
				throw new \Exception("DE:90203 Niewłaściwy typ tokenu", 90203);
			}
		}
		else
		{
			throw new \Exception("DE:90204 Błąd parsowania tokenu", 90204);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @throws \Exception
	 * @return string
	 */
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
		throw new \Exception("DE:90205 Brak tokenu w nagłówku", 90205);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @throws \Exception
	 * @return string
	 */
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
		throw new \Exception("DE:90206 Brak nagłówka Authorization", 90206);
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $roleName
	 * @throws \Exception
	 */
	public static function authorize($roleName)
	{
		if(!empty($roleName))
		{
			$realmAccess = self::getInstance()->jwt->claims()->get("resource_access");
			if(isset($realmAccess->{self::KEYCLOAK_CLIENT_NAME}))
			{
				if(array_search($roleName, $realmAccess->{self::KEYCLOAK_CLIENT_NAME}->roles) === false)
				{
					throw new \Exception("DE:90207 Błąd autoryzacji", 90207);
				}
			}
			else
			{
				throw new \Exception("DE:90208 Błąd autoryzacji", 90208);
			}
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $roleName
	 * @throws \Exception
	 */
	public static function pageOpen($roleName = null)
	{
		Perms::getInstance()->check($roleName);
	}
	// -----------------------------------------------------------------------------------------------------------------
}
