<?php
// Session running
session_start();

// Include the Pagination class
require_once 'Pagination.class.php';

// Define the current "Number of articles per page", if not defined by user, the default value will be used instead
$_SESSION['perPage'] = (isset($_POST['artPerPage'])) ? $_POST['artPerPage'] : ((isset($_SESSION['perPage'])) ? $_SESSION['perPage'] : null);

// Define the current page, if not defined by user, the default value will be used
$pageNumber = (isset($_GET['p'])) ? $_GET['p'] : null;

// Define the total count of articles : IMPORTANT
$total = 54;

// Define the list of "Number of articles per page", if empty array given, than the default list will be used
$artPerPageList = array(Pagination::DEFAULT_ALL, 14, 14, -5, 345, 3, 6, 25, 4, -1);


// METHOD 1
	// Create an instance of Pagination, using all the constructor's arguments : OBLIGATORY
	//$paginObj = new Pagination($total, $artPerPageList, $_SESSION['perPage'], 'p', $pageNumber);


// METHOD 2
	// Create an instance of Pagination, with only the first parameter => "The total count" : OBLIGATORY
	$paginObj = new Pagination($total);
	
	// Set the list of "Number of articles per page" : NOT OBLIGATORY
	$paginObj->setElemPerPageList($artPerPageList);

	// Set the current "Number of articles per page" : OBLIGATORY
	$paginObj->setElemPerPage($_SESSION['perPage']);

	// Set the current page : OBLIGATORY
	$paginObj->setCurrentPage('p', $pageNumber);

	
// FORMS ------------------
	// Show the "number of articles per page" list
	echo '<form method="post">',
			$paginObj->getElemPerPageList('artPerPage'),
			'<input type="submit" value="Organize">',
		'</form>';

	// Show the articles content
	echo '<br><p>CONTENT.</p><br>';

	// Show the pagination
	echo $paginObj->getPagination();
?>