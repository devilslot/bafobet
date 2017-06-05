<?php
/*==================================================
*  Author : Tirapant Tongpann
*  Created Date : 11/09/2554 01:30
*  Module : Compile
*  Description : _SEARCH_ _VIEWLIST_ _ADDEDIT_
*  Involve People : -
*  Last Updated : 11/09/2554 01:30
==================================================*/

header("Content-type: text/html; charset=utf-8");
require_once 'PHPExcel.php';

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Tirapant Tongpann")
            ->setLastModifiedBy("Tirapant Tongpann")
            ->setTitle("Office 2007 XLSX Document")
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Document for Office 2007 XLSX.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Result file");

//title
$tittles[] = 'id';
$tittles[] = 'name';
$tittles[] = 'นามสกุล';
$tittles[] = 'Date';

$objPHPExcel->setActiveSheetIndex(0);

$letters = range('A','Z');
$count =0;
$cell_name="";
foreach($tittles as $tittle){
 $cell_name = $letters[$count]."1";
 $count++;
 $value = $tittle;
 $objPHPExcel->getActiveSheet()->SetCellValue($cell_name, $value);
 $objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFont()->setBold(true);
}

//data
$data[] = array('id'=>01, 'name'=>'12.0', 'surname'=>'บอย', 'create'=>'2013-12-02 12:30');
$data[] = array('id'=>2, 'name'=>'01.1', 'surname'=>'บางคล้า', 'create'=>'2013-12-03 12:30');
$data[] = array('id'=>3, 'name'=>'12.4', 'surname'=>'boy', 'create'=>'2013-12-04');

$n=2;
$string = PHPExcel_Cell_DataType::TYPE_STRING;
$worksheet = $objPHPExcel->getActiveSheet();
foreach($data as $value){
  $worksheet->getCell("A$n")->setValueExplicit($value['id']);
  $worksheet->getCell("B$n")->setValueExplicit($value['name'], $string);
  $worksheet->getCell("C$n")->setValueExplicit($value['surname']);
  $worksheet->getCell("D$n")->setValueExplicit($value['create'], $string);
  $n++;
}

$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "test/Sheet_" . time() . ".xlsx";
$objWriter->save($strFileName);

@header("location:$strFileName");
?>