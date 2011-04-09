<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div id="birthdays">

<?php 
$db =& JFactory::getDBO();
$query = "SELECT * FROM " . $db->nameQuote('#__birthdays') . " WHERE " . $db->nameQuote('birthday') . " = " . $db->quote(date("j-n-Y"));
$db->setQuery($query);
$db->query();    					

$heading = $params->get("heading", 0);
$show_heading = $params->get("show_heading", 0);			
if ($show_heading == 1){
	echo "<h3>$heading</h3>";
}
?>

<ul>														    
<?php     
foreach ($db->loadAssocList() as $i) {
	echo "<li> $i[firstname]  $i[lastname]</li>";
}
?>
</ul>
</div>
