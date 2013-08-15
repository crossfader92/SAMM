<?php
/**
 * class for the data access
 */
class Model{

	private static $mysqlData = array(
	'host' => 'localhost';
	'user' => 'root';
	'password' => 'root';
	'db' => 'wgverwaltung';
	);
	
	private static function connectDb(){
		$connection = mysql_connect (self::$mysqlData['host'], self::$mysqlData['user'], self::$mysqlData['password'])
		or die ("Connection failed. Username or Password might be wrong");
		mysql_select_db("$db")
		or die ("The selected Database is not existing.");
	}

	/**
	 * return a finance overview
	 *
	 * @todo return proper source code or data
	 */
	public static function getOverview(){
				@$monat = mysql_real_escape_string(htmlspecialchars($_GET["monat"]));
		if(empty($monat)){
			$monat = date('m.Y', $timestamp);
		}
		$monate = array();
		$abfrage = "SELECT timestamp FROM finanzen";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_object($ergebnis)){
			$monat_db = date('m.Y', $row->timestamp);
			if(!in_array($monat_db, $monate) && !empty($monat_db)){
				$monate[] = $monat_db;			
			}
		}
		if(!in_array(date('m.Y'), $monate)){
			$monate[] = date('m.Y');
		}
		$finanzen_jan = '';
		$description_jan = '';
		$del_jan = '';
		$gesamt_jan = '0';
		$abfrage = "SELECT * FROM finanzen WHERE user LIKE 'Jan'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_object($ergebnis)){
			if(date('m.Y', $row->timestamp) == $monat){
				$finanzen_jan .= $row->betrag.'&euro;&nbsp;&nbsp;<br>';
				$description_jan .= $row->description.'<br>';
				$del_jan .= '&nbsp;&nbsp;<a href="?script=finanzen&action=del&id='.$row->id.'">l&oumlschen</a><br>';
				$gesamt_jan = $gesamt_jan + $row->betrag;
				$half_jan = round($gesamt_jan / 2, 2);
			}
		}
		$finanzen_kevin = '';
		$description_kevin = '';
		$del_kevin = '';
		$gesamt_kevin = '0';
		$abfrage = "SELECT * FROM finanzen WHERE user  LIKE 'Kevin'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_object($ergebnis)){
			if(date('m.Y', $row->timestamp) == $monat){
				$finanzen_kevin .= $row->betrag.'&euro;&nbsp;&nbsp;<br>';
				$description_kevin .= $row->description.'<br>';
				$del_kevin .= '&nbsp;&nbsp;<a href="?script=finanzen&action=del&id='.$row->id.'">l&oumlschen</a><br>';
				$gesamt_kevin = $gesamt_kevin + $row->betrag;
				$half_kevin = round($gesamt_kevin / 2, 2);
			}
		}
		if($half_jan != 0 && $half_kevin != 0){
			if($half_jan > $half_kevin){
				$schulden_kevin = ($half_jan - $half_kevin);
				$schulden = 'kevin';
			}else{
				$schulden_jan = ($half_kevin - $half_jan);
				$schulden = 'jan';
			}
		}else{
			if($half_jan > $half_kevin){
				$schulden_kevin = $half_jan;
				$schulden = 'kevin';
			}else{
				$schulden_jan = $half_kevin;
				$schulden = 'jan';
			}
	}
	}


}
?>