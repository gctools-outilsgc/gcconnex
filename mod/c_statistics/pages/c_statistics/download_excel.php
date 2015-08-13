<?php
require_once elgg_get_plugins_path() . "c_statistics/vendors/PHPExcel-develop/Classes/PHPExcel.php";
elgg_load_library('c_statistics');
elgg_load_library('c_statistics_html');

$group_id = $_GET["group_guid"];

global $CONFIG;
$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);


$sheetID = 1;
$query = group_activity_statistics_query($group_id);


$headings = array('Time Created', 'Total Members', 'Total Entities', 'Total Replies'); 

if ($result = mysqli_query($connection, $query) or die(mysql_error())) 
{ 
    // Create a new PHPExcel object 
    $objPHPExcel = new PHPExcel(); 
    $objPHPExcel->createSheet(NULL,0);
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet(0)->setTitle('Group Activity Statistics'); 

    $rowNumber = 1; 
    $col = 'A'; 
    foreach($headings as $heading) { 
       $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading); 
       $col++; 
    } 

    // Loop through the result set 
    $rowNumber = 2; 
    while ($row = mysqli_fetch_row($result)) { 
      $col = 'A'; 
      foreach($row as $cell) { 
        if (!$cell) $cell = 0;
        $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,convert_html_to_text($cell)); 
        $col++; 
      } 
      $rowNumber++; 
    } 

    // Freeze pane so that the heading line won't scroll 
    $objPHPExcel->getActiveSheet()->freezePane('A2'); 
}


$query = detailed_discussion_statistics($group_id);

$headings = array('Discussion Thread', 'Author', 'Date Created', 'Number of Replies'); 

if ($result = mysqli_query($connection, $query) or die(mysql_error())) 
{ 

    $objPHPExcel->createSheet(NULL,1);
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet(1)->setTitle('Group Activity Statistics'); 

    $rowNumber = 1; 
    $col = 'A'; 
    foreach($headings as $heading) { 
       $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading); 
       $col++; 
    } 

    // Loop through the result set 
    $rowNumber = 2; 
    while ($row = mysqli_fetch_row($result)) { 
      $col = 'A'; 
      foreach($row as $cell) { 
        if (!$cell) $cell = 0;
        $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,convert_html_to_text($cell)); 
        $col++; 
      } 
      $rowNumber++; 
    } 

    // Freeze pane so that the heading line won't scroll 
    $objPHPExcel->getActiveSheet()->freezePane('A2'); 
}


// Save as an Excel BIFF (xls) file 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
mysqli_close($connection);

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="GCconnex Report - '.date("Y-m-d h:m:s").'.xls"'); 
header('Cache-Control: max-age=0'); 

ob_end_clean();
$objWriter->save('php://output'); 
exit; 

echo 'a problem has occurred... no data retrieved from the database'; 
























































// require_once elgg_get_plugins_path() . "c_statistics/vendors/PHPExcel-develop/Classes/PHPExcel.php";
// elgg_load_library('c_statistics');

// $group_id = $_GET["group_guid"];
// $result = get_result(group_activity_statistics_query($group_id));

// $heading = array('Year-Month', 'Total Members Joined', 'Total Entities', 'Total Topic Replies');

// $phpExcel = new PHPExcel();
// $phpExcel->getActiveSheet()->setTitle("Report for ".$group_id);

// // grind some queries!
// $col = 'A';
// $row_num = 1;
// foreach ($heading as $column_title)
// {
// 	$phpExcel->getActiveSheet()->setCellValue($col.$row_num,$column_title);
// 	$col++;
// }

// $row_num = 3;
// while($row = mysqli_fetch_array($result))
// {
// 	$phpExcel->getActiveSheet()->setCellValue('A'.$row_num,'hello');
// 	//$phpExcel->getActiveSheet()->setCellValue('A'.$row_num,$row['permonth']);
// 	//$phpExcel->getActiveSheet()->setCellValue('B'.$row_num,$row['num_of_members']);
// 	//$phpExcel->getActiveSheet()->setCellValue('C'.$row_num,$row['num_of_entities']);
// 	//$phpExcel->getActiveSheet()->setCellValue('D'.$row_num,$row['num_of_replies']);
// 	$row_num++;
// }

// // foreach ($heading as $column_title)
// // {
// // 	$phpExcel->getActiveSheet()->setCellValue('A'.$row,$column_title);
// // 	$row++;
// // }


// //$phpExcel->setActiveSheetIndex(0);
// //$worksheet = $phpExcel->SetCellValueByColumnAndRow(0, 1, 'Hello World');

// // save as an excel biff (xls) file
// $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");

// header("Content-Type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename='file.xls'");
// header("Cache-Control: max-age=0");

// $objWriter->save("php://output");
// exit();