<?php
/*               *** sqstat - Squid Proxy Server realtime stat ***
(c) Alex Samorukov, samm@os2.kiev.ua
*/

error_reporting(E_ALL);

DEFINE("SQSTAT_VERSION","1.20");

// loading sqstat class
include_once("sqstat.class.php");
$squidclass=new squidstat();

// loading configuration

if(is_file("config.inc.php")) {
	include_once "config.inc.php";
	// checking configuration. We need to have at least one 
	// squidhost/squid pair
	if(!isset($_GET["config"])) $config=0;
	else $config=(int)$_GET["config"];
	
	if(!isset($squidhost[$config]) || !isset($squidport[$config])) {
		$squidclass->errno=4;
		$squidclass->errstr="Error in the configuration file.".
		'Please, specify $squidhost['.$config.']/$squidport['.$config.']';
		$squidclass->showError();
		exit(4);
	}
	for($i=0;$i<count($squidhost);$i++){
		$configs[$i]=$squidhost[$i].':'.$squidport[$i];
	}
	@$squidhost=$squidhost[$config];
	@$squidport=$squidport[$config];
	@$cachemgr_passwd=$cachemgr_passwd[$config];
	@$resolveip=$resolveip[$config]; 
	@$hosts_file=$hosts_file[$config];
	if(isset($group_by[$config])) $group_by=$group_by[$config];
	else $group_by="ip";
	if(isset($group_by[$config]) && !preg_match('/^(host|username)$/',$group_by)) {
		$squidclass->errno=4;
		$squidclass->errstr="Error in the configuration file.<br>".
		'"group_by" can be only "username" or "host"';
		$squidclass->showError();
		exit(4);
	}
	
}
else{
	$squidclass->errno=4;
	$squidclass->errstr="Configuration file not found.".
	"Please copy file <tt>config.inc.php.defauts</tt> to <tt>config.inc.php</tt> and edit configuration settings.";
	$squidclass->showError();
	exit(4);
}


// loading hosts file
$hosts_array=array();
if(isset($hosts_file)){
	if(is_file($hosts_file)){
		$handle = @fopen($hosts_file, "r");
		if ($handle) {
			while (!feof($handle)) {
				$buffer = fgets($handle, 4096);
				unset($matches);
				if(preg_match('/^([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})[ \t]+(.+)$/i',$buffer,$matches)){
					$hosts_array[$matches[1]]=$matches[2];
				}
			}
			fclose($handle);
		}
		else {
			$squidclass->errno=4;
			$squidclass->errstr="Hosts file not found.".
			"Cant read <tt>'$hosts_file'</tt>.";
			$squidclass->showError();
			exit(4);
		}
	}
	else {
		$squidclass->errno=4;
		$squidclass->errstr="Hosts file not found.".
		"Cant read <tt>'$hosts_file'</tt>.";
		$squidclass->showError();
		exit(4);
		
	}
}
if(!$squidclass->connect($squidhost,$squidport)) {
	$squidclass->showError();
	exit(1);
}
$data=$squidclass->makeQuery($cachemgr_passwd);
if($data==false){
	$squidclass->showError();
	exit(2);
}

// print_r($data);
if(!isset($use_js)) $use_js=true;
echo $squidclass->makeHtmlReport($data,$resolveip,$hosts_array,$use_js);


?>