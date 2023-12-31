<?php

use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Groups;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Group;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once __DIR__ . '/data.php';

if ( file_exists( __DIR__ . '/../../../autoload.php' ) )
{
	require_once __DIR__ . '/../../../autoload.php';
}
// Required for the original implementation
elseif ( file_exists( __DIR__ . '/../vendor/autoload.php' ) )
{
	require_once __DIR__ . '/../vendor/autoload.php';
}
else
{
	throw new Exception("Unable to autoload classes");
}

// Only load the bootstrap files directly if they have not been loaded by Composer already
// Required for the original implementation
$files = get_included_files();
$bootstrap = realpath( __DIR__ . '/../phpspreadsheet/Spreadsheet.php' );
if ( ! in_array( $bootstrap, $files ) )
{
	require_once __DIR__ . '/../phpspreadsheet/Spreadsheet.php';
}

$outputFileName = __DIR__ . '/generated.xlsx';

$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
	->setCreator("XBRL Query Generator")
	->setLastModifiedBy("XBRL Query Generator")
	->setTitle("Microsoft 2018 QK")
	->setSubject("Pivot table report")
	->setDescription("This could be an explanation")
	->setKeywords("xbrl microsoft 2018 10k")
	->setCategory("Reports");

$data = load_data();

$networks = array(
	// All pivot tables are added to sheets to which the data is added starting at cell B2.

	// The first PT is added to a sheet called 'Worksheet'.  It has two groups on the rows
	// (Account/Genre) that are filtered to three of the accounts.  Because there is filtering
	// the sort type must be 'manual'.  There are no groups added to the columns.  Instead,
	// the columns are the values of three numeric columns.
	// Note that while the row groups object is created passing an explicit 'Group' instance
	// the value groups instance is created by passing an array of string names.  This is a
	// simple ay to create groups if the default group values (no filtering and sort type
	// ascending) are acceptable.


		array(	'data' => $data,
		'args' => array(
			"Worksheet1",
			2 + count( $data ) + 1 + 3, 2,
			new Groups( new Group( 'Account' ) ),
			new Groups( ),
			new Groups( )
		)
	),
	// The second PT is added to a sheet called 'Worksheet2'.  It has just one group on the rows
	// (Account) that is not filtered but the account names will be displayed in descending order.
	// This PT has two groups on the columns (Genre/Images).  The values are from the 'Total Size'
	// column.
	// array(	'data' => $data,
	// 		'args' => array(
	// 			"Worksheet2",
	// 			2 + count( $data ) + 1 + 3, 2,
	// 			new Groups( new Group( 'Account', 'descending' ) ),
	// 			new Groups( array( 'Genre', 'Images' ) ),
	// 			new Groups( array( 'Total Size' ) )
	// 		)
	// ),

	// // The third PT is added to a sheet called 'Worksheet3'. It has two groups on the rows
	// // (Account/Genre).  There is one group on the columns (Images) and the values are from the
	// // 'Total Size' column.
	// array(	'data' => $data,
	// 		'args' => array(
	// 			"Worksheet3",
	// 			2 + count( $data ) + 1 + 3, 2,
	// 			new Groups( array( 'Account', 'Genre' ) ) ,
	// 			new Groups( array( 'Images' ) ),
	// 			new Groups( array( 'Total Size'  ) )
	// 		)
	// )
);
$arrayData = $data; 

$arrayTitle = array_keys($data[0]);
// For title 
$spreadsheet->getActiveSheet()->fromArray(
	$arrayTitle,  // The data to set
	NULL ,     // Array values with this value will not be set
	'A1'); 

// For Data
	$spreadsheet->getActiveSheet()->fromArray(
		$arrayData,  // The data to set
		NULL ,     // Array values with this value will not be set
		'A2'); 


foreach ( $networks as $index => $network )
{
	$range = $spreadsheet->addData( $data, $network['args'][0] );

	$spreadsheet->addNewPivotTable( $data, $range, ...$network['args'] );
	
}

$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $spreadsheet, 'Xlsx' );
$writer->save($outputFileName);

$spreadsheet->disconnectWorksheets();
unset( $spreadsheet );
