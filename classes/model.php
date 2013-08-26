<?php
/**
 * class for the data access
 */
 date_default_timezone_set('UTC');
 
class Model{	
	
	function __construct(){

	}

	private static $mysqlData = array(
	'host' => 'localhost',
	'user' => 'root',
	'password' => 'root',
	'db' => 'wgverwaltung'
	);
	
	
	public static function connectDb(){
		$connection = mysql_connect (self::$mysqlData['host'], self::$mysqlData['user'], self::$mysqlData['password'])
		or die ("Connection failed. Username or Password might be wrong");
		mysql_select_db(self::$mysqlData['db'])
		or die ("The selected Database is not existing.");
	}

	/**
	 * return [0] value, [1] description, [2] delete link, [3] total sum, [4] half sum
	 *
	 * @todo return proper source code or data
	 */
	public static function getFinance($user,$month){
	self::connectDb();
	
	$users = explode(',',$user);
	$uservars = array(array('','','','',''));
	$index = 0;
	
	foreach ($users as $user){
		if(empty($monat)){
				$monat = date('m.Y', time());
			}
		$month = self::getMonthByUser($user);
			

			
			
			$abfrage = "SELECT * FROM finanzen WHERE user LIKE '$user'";
			$ergebnis = mysql_query($abfrage);
			
			
			while($row = mysql_fetch_object($ergebnis)){
				if(date('m.Y', $row->timestamp) == $monat){
					$uservars[$index]['user'] = $user;
					$uservars[$index]['id'] = $row->id;
					$uservars[$index]['articlePrice'] .= $row->betrag . '|';
					$uservars[$index]['articleDesc'] .= $row->description.'|';
					$uservars[$index]['toPay'] = '';
					$uservars[$index]['sum'] += $row->betrag;				
					
				}
			}
			$uservars[$index]['sum'] = round($uservars[$index]['sum'], 2);
			$index++;
			
		}
	return $uservars;
	}
	
	public static function getMonthByUser($user){
	
	$month = array();
			$query = "SELECT timestamp FROM finanzen WHERE user = '$user'";
			$result = mysql_query($query);
			while($row = mysql_fetch_object($result)){
				$month_db = date('m.Y', $row->timestamp);
				if(!in_array($month_db, $month) && !empty($month_db)){
					$month[] = $month_db;			
				}
			}
			if(!in_array(date('m.Y'), $month)){
				$month[] = date('m.Y');
			}
	return $month;
	
	}
	
	public static function getAllMonth(){
	
	$month = array();
			$query = "SELECT timestamp FROM finanzen";
			$result = mysql_query($query);
			while($row = mysql_fetch_object($result)){
				$month_db = date('m.Y', $row->timestamp);
				if(!in_array($month_db, $month) && !empty($month_db)){
					$month[] = $month_db;			
				}
			}
			if(!in_array(date('m.Y'), $month)){
				$month[] = date('m.Y');
			}
	return $month;
	
	}
	
	public static 	function getSchuldenFazit($finance){
		
		$users = count($finance);
		$empty = false;
		$total = 0;
		foreach($finance AS $financeUser){
			$total += $financeUser['sum'];
		}
		$average = round(($total / $users),2);
		for ($i = 0; $i < $users; $i++){
			$finance[$i]['toPay'] = $average - $finance[$i]['sum'];
		}
		for ($i = 0; $i < $users; $i++){
			echo $finance[$i]['user'].$finance[$i]['toPay'].'<br>';
			$tempInt = $i;
			while(round($finance[$i]['toPay'],1) != 0){
				$tempInt++;
				if($finance[$i]['toPay'] > 0 && $finance[$tempInt]['toPay'] < 0){
					if($finance[$i]['toPay'] < ($finance[$tempInt]['toPay'] *(-1))){
						echo $finance[$i]['user'].' muss '.$finance[$tempInt]['user'].' '.$finance[$i]['toPay'].'&euro; bezahlen<br>';
						$finance[$tempInt]['toPay'] += $finance[$i]['toPay'];
						$finance[$i]['toPay'] -= $finance[$i]['toPay'];
					}else{
						echo $finance[$i]['user'].' muss '.$finance[$tempInt]['user'].' '.$finance[$tempInt]['toPay'] * (-1).'&euro; bezahlen<br>';
						$tempFinance = $finance[$i]['toPay'];
						$finance[$i]['toPay'] -= $finance[$tempInt]['toPay'] *(-1);
						$finance[$tempInt]['toPay'] += $finance[$tempInt]['toPay'] *(-1);
					}
				}else if($finance[$i]['toPay'] < 0 && $finance[$tempInt]['toPay'] > 0){
					if($finance[$i]['toPay'] < ($finance[$tempInt]['toPay'] *(-1))){
						echo $finance[$i]['user'].' bekommt von '.$finance[$tempInt]['user'].' '.$finance[$tempInt]['toPay'].'&euro;<br>';
						$finance[$i]['toPay'] += $finance[$tempInt]['toPay'];
						$finance[$tempInt]['toPay'] -= $finance[$tempInt]['toPay'];
					}else{
						echo $finance[$i]['user'].' bekommt von '.$finance[$tempInt]['user'].' '.$finance[$i]['toPay']*(-1).'&euro;<br>';
						$tempFinance = $finance[$i]['toPay'];
						$finance[$i]['toPay'] -= $finance[$i]['toPay'];
						$finance[$tempInt]['toPay'] -= $tempFinance * (-1);
					}
				}
			}	
		}
		foreach($finance AS $financeUser){
			echo $financeUser['user'].$financeUser['toPay'].'<br>';
			
		}
	}
	


	
	 
	// public static function getOverview($timestamp, $monat){
		
		// self::connectDb();
		
		// if(empty($monat)){
			// $monat = date('m.Y', $timestamp);
		// }
		// $monate = array();
		// $abfrage = "SELECT timestamp FROM finanzen";
		// $ergebnis = mysql_query($abfrage);
		// while($row = mysql_fetch_object($ergebnis)){
			// $monat_db = date('m.Y', $row->timestamp);
			// if(!in_array($monat_db, $monate) && !empty($monat_db)){
				// $monate[] = $monat_db;			
			// }
		// }
		// if(!in_array(date('m.Y'), $monate)){
			// $monate[] = date('m.Y');
		// }
		// $view->assign('finanzen_jan', '');
		// $description_jan = '';
		// $del_jan = '';
		// $gesamt_jan = '0';
		// $abfrage = "SELECT * FROM finanzen WHERE user LIKE 'Jan'";
		// $ergebnis = mysql_query($abfrage);
		// while($row = mysql_fetch_object($ergebnis)){
			// if(date('m.Y', $row->timestamp) == $monat){
				// $finanzen_jan .= $row->betrag.'&euro;&nbsp;&nbsp;<br>';
				// $description_jan .= $row->description.'<br>';
				// $del_jan .= '&nbsp;&nbsp;<a href="?script=finanzen&action=del&id='.$row->id.'">l&oumlschen</a><br>';
				// $gesamt_jan = $gesamt_jan + $row->betrag;
				// $half_jan = round($gesamt_jan / 2, 2);
			// }
		// }
		// $finanzen_kevin = '';
		// $description_kevin = '';
		// $del_kevin = '';
		// $gesamt_kevin = '0';
		// $abfrage = "SELECT * FROM finanzen WHERE user  LIKE 'Kevin'";
		// $ergebnis = mysql_query($abfrage);
		// while($row = mysql_fetch_object($ergebnis)){
			// if(date('m.Y', $row->timestamp) == $monat){
				// $finanzen_kevin .= $row->betrag.'&euro;&nbsp;&nbsp;<br>';
				// $description_kevin .= $row->description.'<br>';
				// $del_kevin .= '&nbsp;&nbsp;<a href="?script=finanzen&action=del&id='.$row->id.'">l&oumlschen</a><br>';
				// $gesamt_kevin = $gesamt_kevin + $row->betrag;
				// $half_kevin = round($gesamt_kevin / 2, 2);
			// }
		// }
		// if($half_jan != 0 && $half_kevin != 0){
			// if($half_jan > $half_kevin){
				// $schulden_kevin = ($half_jan - $half_kevin);
				// $schulden = 'kevin';
			// }else{
				// $schulden_jan = ($half_kevin - $half_jan);
				// $schulden = 'jan';
			// }
		// }else{
			// if($half_jan > $half_kevin){
				// $schulden_kevin = $half_jan;
				// $schulden = 'kevin';
			// }else{
				// $schulden_jan = $half_kevin;
				// $schulden = 'jan';
			// }
	// }
	// }



?>
