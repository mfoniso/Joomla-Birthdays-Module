<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

switch( JRequest::getVar( 'task' )) {
	case 'edit':
		editEntry();
		break;
	case 'update':
		updateEntry();
		break;
	default:
		displayEntries();
		break;
}



function updateEntry() {
	JToolBarHelper::title( JText::_( 'Update User information' ), 'addedit.png' );
	
	$db =& JFactory::getDBO();


	$id = $db->getEscaped(JRequest::getVar('id'));
    $firstname = "'" . $db->getEscaped(JRequest::getVar('firstname')) . "'";
	$lastname = "'" . $db->getEscaped(JRequest::getVar( 'lastname' )) . "'";
	$birthday = "'" . $db->getEscaped(JRequest::getVar( 'birthday' )) . "'";

    
    if (empty($id)){
        $query = "INSERT INTO #__birthdays(firstname, lastname, birthday) " .
        " VALUES( " . $firstname . ", " . $lastname . ", " . $birthday . ")";
    }else{
        $query = "UPDATE #__birthdays " .
        " SET firstname=" . $firstname . ", " .
        " lastname=" . $lastname . ", " .
        " birthday=" . $birthday .
        " WHERE id = " . $id ;
    }
	$db->setQuery( $query, 0);
	$db->query();
	echo "<h3>Field updated!</h3>";
    displayEntries();
    
}

function displayEntries(){
	JToolBarHelper::title( JText::_( 'Birthdays' ), 'addedit.png' );
	$db =& JFactory::getDBO();
	$query = "SELECT a.id, a.firstname, a.lastname, a.birthday" .
	" FROM #__birthdays AS a";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
?>



<table class="adminlist">
<tr>
	<td class='title' width='30%'>
        <strong><?php echo JText::_( 'Firstname')?></td></strong>
    </td>
	<td class='title' width='30%'>
        <strong><?php echo JText::_( 'Lastname')?></strong>
    </td>
	<td class='title' width='30%'>
        <strong><?php echo JText::_( 'Birthday' )?></strong>
    </td>
</tr>

<?php
	foreach ($rows as $row) {
		$link = 'index.php?option=com_birthdays&task=edit&id=' . $row->id;
		echo "<tr>" .
			 "<td class='title' width='20%'><a href='" . $link . "'>" . $row->firstname . "</a></td>" .
			 "<td class='title' width='20%'>" . $row->lastname . "</td>" .
			 "<td class='title' width='20%'>" . $row->birthday . "</td>" .
			 "</tr>";		
	}	

    echo "</table>";
    echo "<h3>Click on a name to edit that entry</h3>";
    $addlink = 'index.php?option=com_birthdays&task=edit';;
    echo "<h3><a href='" . $addlink  . "'>Add New</a></h3>";
}


function editEntry() {    
	JToolBarHelper::title( JText::_( 'Birthdays Editor' ), 'addedit.png' );
	$db =& JFactory::getDBO();
    
    $id = JRequest::getVar( 'id' );
    if (empty($id)){
?>
	<form id="formBirthdays" name="formBirthdays" method="post" action="index.php?option=com_birthdays&task=update">
		Firstname <input type="text" name="firstname" id="firstname" value="<?php echo $rows[0]->firstname; ?>" /><br />
		Lastname <input type="text" name="lastname" id="lastname" value="<?php echo $rows[0]->lastname; ?>" /><br />
		Birthday <input type="text" name="birthday" id="birthday" value="<?php echo $rows[0]->birthday; ?>" /><br />        
		<input type="submit" name="submit" value="Save" />	
        <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php?option=com_birthdays'"/>
	</form>

<?php
    }
	$query = "SELECT a.id, a.firstname, a.lastname, a.birthday" . 
	" FROM #__birthdays AS a" . 
	" WHERE a.id = " . JRequest::getVar( 'id' );
	$db->setQuery( $query );
	if($rows = $db->LoadObjectList()) {
?>
	<form id="formBirthdays" name="formBirthdays" method="post" action="index.php?option=com_birthdays&task=update">
		Firstname <input type="text" name="firstname" id="firstname" value="<?php echo $rows[0]->firstname; ?>" /><br />
		Lastname <input type="text" name="lastname" id="lastname" value="<?php echo $rows[0]->lastname; ?>" /><br />
		Birthday <input type="text" name="birthday" id="birthday" value="<?php echo $rows[0]->birthday; ?>" /><br />
        <input type="hidden" name="id" id="id" value="<?php echo $rows[0]->id; ?>" />
		<input type="submit" name="submit" value="Save" />	
        <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php?option=com_birthdays'"/>
	</form>

<?php 
	}
}
?>
