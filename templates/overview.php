<div style="padding-top: 40px"></div>
<div class="span2">&nbsp;</div>
<div class="span8">
<div class="span7">
	<h1 align=center style="color: #222;text-shadow: 0px 2px 3px #555;"><?php foreach($this->_['allmonth'] AS $monat){echo '<a href="?script=finanzen&monat='.$monat.'">'.$monat.'</a><br>';}?></h1>
	<br />
	</div>
<?php
for ($i = 0; $i < count($this->_['finance']); $i++){

echo '<div class="span3 well">
	<div id="';
echo $this->_['finance'][$i][5];
echo '" >
		<h1>';
echo $this->_['finance'][$i][5];
echo '</h1>
		<div style="float:left;">';
echo $this->_['finance'][$i][0];
echo '<br></div>
		<div style="float:left;">';
echo $this->_['finance'][$i][1];
echo '<br></div>
		<div>';
echo $this->_['finance'][$i][2];
echo '<br></div>gesamt bezahlt:';
echo $this->_['finance'][$i][3];
echo '&euro;<br>
		1/2 Anteil:';
echo $this->_['finance'][$i][4];
echo '&euro;
	</div>
</div>';
}
?>
<div style="width: 78%"class="span6 alert alert-error">
<?php
echo $this->_['conclusion'];
?>
</div>
</div>