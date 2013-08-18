<div style="padding-top: 40px"></div>
<div class="span2">&nbsp;</div>
<div class="span8">
<div class="span7">
	<h1 align=center style="color: #222;text-shadow: 0px 2px 3px #555;"><?php foreach($this->_['$monate'] AS $monat){echo '<a href="?script=finanzen&monat='.$monat.'">'.$monat.'</a><br>';}?></h1>
	<br />
	</div>
<div class="span3 well">
	<div id="jan" >
		<h1>Jan</h1>
		<div style="float:left;">
			<?php echo $this->_['finance'][0][0];?><br>
		</div>
		<div style="float:left;">
			<?php echo $this->_['finance'][0][1];?><br>
		</div>
		<div>
			<?php echo $this->_['finance'][0][2];?><br>
		</div>
		gesamt bezahlt: <?php echo $this->_['finance'][0][3];?>&euro;<br>
		1/2 Anteil: <?php echo $this->_['finance'][0][4];?>&euro;
	</div>
</div>
<div class="span3 well">
	<div id="kevin">
		<h1>Kevin</h1>
		<div style="float:left;">
			<?php echo $this->_['finance'][1][0];?><br>
		</div>
		<div style="float:left;">
			<?php echo $this->_['finance'][1][1];?><br>
		</div>
		<div>
			<?php echo $this->_['finance'][1][2];?><br>
		</div>
		gesamt bezahlt: <?php echo $this->_['finance'][1][3];?>&euro;<br>
		1/2 Anteil: <?php echo $this->_['finance'][1][4];?>&euro;
	</div>
</div>
<div style="width: 78%"class="span6 alert alert-error">
<?php
switch ($schulden){
	case "jan":
		$fazit = 'Jan schuldet Kevin '.$this->_['$schulden_jan'].'&euro;';
	break;
	case "kevin":
		$fazit = 'Kevin schuldet Jan '.$this->_['$schulden_kevin'].'&euro;';
	break;
}
echo $this->_['$fazit'];
?>
</div>
</div>