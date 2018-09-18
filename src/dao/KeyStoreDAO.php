<?php
namespace braga\project\dao;
use braga\db\DAO;
use braga\db\DataSource;
use braga\db\mysql\DB;
/**
 * Created on 08-08-2018 16:31:43
 * @author Tomasz Gajewski
 * @package Cobrador
 * error prefix CB:111
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of
 * OVERWRITTEN WITHOUT WARNING
 */
class KeyStoreDAO implements DAO
{
	// -----------------------------------------------------------------------------------------------------------------
	protected static $instance = array();
	// -----------------------------------------------------------------------------------------------------------------
	protected $idKeyStore = null;
	protected $publicKey = null;
	protected $readed = false;
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param string $idKeyStore
	 */
	protected function __construct($idKeyStore = null)
	{
		if(!is_null($idKeyStore))
		{
			if(!$this->retrieve($idKeyStore))
			{
				throw new \Exception("CB:11101 " . DB_SCHEMA . ".key_store(" . $idKeyStore . ")  does not exists");
			}
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param int $idKeyStore
	 * @return \braga\project\obj\KeyStore
	 */
	static function get($idKeyStore = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = array();
		}
		if(!empty($idKeyStore))
		{
			if(!isset(self::$instance[$idKeyStore]))
			{
				self::$instance[$idKeyStore] = new static($idKeyStore);
			}
			return self::$instance[$idKeyStore];
		}
		else
		{
			return self::$instance["\$" . count(self::$instance)] = new static();
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param int $idKeyStore
	 * @return \braga\project\obj\KeyStore
	 */
	static function getForUpdate($idKeyStore = null)
	{
		if(!empty($idKeyStore))
		{
			if(isset(self::$instance[$idKeyStore]))
			{
				unset(self::$instance[$idKeyStore]);
			}
		}
		else
		{
			throw new \Exception("CB:11105 Empty or wrong object id type");
		}
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".key_store ";
		$sql .= "WHERE idkey_store = :IDKEY_STORE ";
		$sql .= "FOR UPDATE ";
		$db->setParam("IDKEY_STORE", $idKeyStore);
		$db->query($sql);
		if($db->nextRecord())
		{
			return self::getByDataSource($db);
		}
		else
		{
			throw new \Exception("CB:11106 " . DB_SCHEMA . ".key_store(" . $idKeyStore . ")  does not exists");
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected static function updateFactoryIndex(KeyStoreDAO $keyStore)
	{
		$key = array_search($keyStore, self::$instance, true);
		if($key !== false)
		{
			if($key !== $keyStore->getIdKeyStore())
			{
				unset(self::$instance[$key]);
				self::$instance[$keyStore->getIdKeyStore()] = $keyStore;
			}
		}
		else
		{
			self::$instance[$keyStore->getIdKeyStore()] = $keyStore;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return \braga\project\obj\KeyStore
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idkey_store");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new static();
			self::$instance[$key]->setAllFromDB($db);
		}
		return self::$instance[$key];
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected function isReaded()
	{
		return $this->readed;
	}
	// -----------------------------------------------------------------------------------------------------------------
	protected function setReaded()
	{
		$this->readed = true;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function setIdKeyStore($idKeyStore)
	{
		if(empty($idKeyStore))
		{
			$this->idKeyStore = null;
		}
		else
		{
			$this->idKeyStore = mb_substr($idKeyStore, 0, 255);
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function setPublicKey($publicKey)
	{
		$this->publicKey = $publicKey;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function getIdKeyStore()
	{
		return $this->idKeyStore;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function getPublicKey()
	{
		return $this->publicKey;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdKeyStore();
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Method read object of class KeyStore you can read all of atrib by get...() function
	 * select record from table key_store
	 * @return boolean
	 */
	protected function retrieve($idKeyStore)
	{
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".key_store ";
		$sql .= "WHERE idkey_store = :IDKEY_STORE ";
		$db->setParam("IDKEY_STORE", $idKeyStore);
		$db->query($sql);
		if($db->nextRecord())
		{
			$this->setAllFromDB($db);
			return true;
		}
		else
		{
			return false;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Methods add object of class KeyStore
	 * insert record into table key_store
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql = "INSERT INTO " . DB_SCHEMA . ".key_store(idkey_store, public_key) ";
		$sql .= "VALUES(:IDKEYSTORE, :PUBLICKEY) ";
		$db->setParam("IDKEYSTORE", $this->getIdKeyStore());
		$db->setParam("PUBLICKEY", $this->getPublicKey());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			AddAlert("CB:11102 Insert record into table key_store fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class KeyStore
	 * update record in table key_store
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql = "UPDATE " . DB_SCHEMA . ".key_store ";
		$sql .= "SET public_key = :PUBLICKEY ";
		$sql .= "WHERE idkey_store = :IDKEYSTORE ";
		$db->setParam("IDKEYSTORE", $this->getIdKeyStore());
		$db->setParam("PUBLICKEY", $this->getPublicKey());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			return true;
		}
		else
		{
			AddAlert("CB:11103 Update record in table key_store fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class KeyStore
	 * removed are record from table key_store
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql = "DELETE FROM " . DB_SCHEMA . ".key_store ";
		$sql .= "WHERE idkey_store = :IDKEY_STORE ";
		$db->setParam("IDKEY_STORE", $this->getIdKeyStore());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			return true;
		}
		else
		{
			AddAlert("CB:11104 Delete record from table key_store fail");
			return false;
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class KeyStore from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdKeyStore($db->f("idkey_store"));
		$this->setPublicKey($db->f("public_key"));
		$this->setReaded();
	}
	// -----------------------------------------------------------------------------------------------------------------
}
?>