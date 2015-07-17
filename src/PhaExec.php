<?php
/*
include('Net/SSH2.php');
include('Crypt/RSA.php');

$ssh = new Net_SSH2('alpha.serverever.com');
#if (!$ssh->login('absurdo', 'irpfxion')) {
#    exit('Login Failed');
#}

$key = new Crypt_RSA();
$key->setPassword('747mxcom');
$key->loadKey(file_get_contents('/home/absurdo/.ssh/id_rsa'));
if (!$ssh->login('absurdo', $key)) {
    exit('Login Failed');
}

function packet_handler($str)
{
    echo $str;
}

$ssh->exec('sh /home/absurdo/local_script.sh', 'packet_handler');

*/

namespace PhangoApp\PhaExec;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

/**
* A simple class for execute remote scripts via SSH2 saving the results on an log, with a wrapper function for obtain messages from the log. The format of messages of script is json with error how key if error exists.
* 
*/

class PhaExec {

	public $hostname;
	public $key_file;
	public $username='root';
	public $password_key='';
	public $line_read=0;
	public $table_sql='log_exec';
	public $port=21;
	public $timeout=10;
	public $root_path='/home/spanel';
	
	public __construct($hostname, $key_file, $username='root', $password_key='')
	{
	
		$this->hostname=$hostname;
		$this->key_file=$key_file;
		$this->username=$username;
		$this->password_key=$password_key;
		
		
	
	}
	
	/**
	* Method for copy a serie of scripts in the server. 
	*/
	
	public function sftp_copy_tar($tar_to_copy, $path_to_uncompress)
	{
	
		//Used for create the service
	
		//Copy to the folder.
		
		//Put the pid on the database.
		
		//Push the results on a table of the database.
		
		//define('NET_SFTP_LOGGING', NET_SFTP_LOG_COMPLEX);
		
		$sftp = new \Net_SFTP($this->hostname);
		
		$key = new \Crypt_RSA();
		
		$key->setPassword($this->password_key);
		
		$key->loadKey(file_get_contents($this->key_file));
		
		if (!$sftp->login($this->username, $key)) {
		
			return false;

		}
		$sftp->put($tar_to_copy, 'tmp/'.$tar_to_copy, NET_SFTP_LOCAL_FILE);

		//echo $sftp->getSFTPLog();
		
		//Uncompress file
		
		$this->exec('tar -xpf tmp/'.$tar_to_copy.' -C '.$path_to_uncompress.'');
	}
	
	/**
	* The method that execute the remote command.
	*
	*/

	public function exec($command)
	{

		$ssh = new \Net_SSH2($this->hostname);
	
		$key = new \Crypt_RSA();
		
		$key->setPassword($this->password_key);
		
		$key->loadKey(file_get_contents($this->key_file));
		
		if (!$ssh->login($this->username, $key)) {
		
			return false;

		}

		function packet_handler($str)
		{
			echo $str;
		}

		$ssh->exec($command, 'packet_handler');
	
		//Execute the remote command.
		
		//Put the pid on the database.
		
 		//Push the results on a table of the database.
		
	
	}
	
	/**
	* Method for obtain the last read line on the database log.
	*
	*/
	
	public function read_progress($pid)
	{
	
		
	
	}
	

}

?>