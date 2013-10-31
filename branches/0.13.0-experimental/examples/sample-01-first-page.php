<?php
error_reporting(E_ALL);
set_time_limit(180);

// performance counter
$start = microtime(true);

include '../src/Cpdf.php';

// A new page parameter can be either a default layout, defined in Cpdf_Common
// or an array three numbers to define a bounding box (Example: array(20, 20,550, 800)) 
$pdf = new Cpdf_Extension(Cpdf_Common::$Layout['A4']);

// to test on windows xampp
if(strpos(PHP_OS, 'WIN') !== false){
    $pdf->TempPath = 'E:/xampp/xampp/tmp';
}

$pdf->Compression = 0;

// initialize first text object
$textObject = $pdf->NewText();
// put text, left justifed
$textObject->AddText("Hello World");
// now into the center of the document
$textObject->AddText("Hello World", 0, 'center');
// and right
$textObject->AddText("Hello World", 0, 'right');
// some directives (requires to be register in FontFamilies - see Cpdf_Common class)
$textObject->AddText('Use some directives, like <b>bold</b> or <i>italic</i>');

// add an external link annotation
$textObject->AddText('add an external link <c:alink:www.google.de>here</c:alink>');

// put some text to an exact position on the page
$t1 = $pdf->NewText(array('uy'=>600));
// used for named destionations
$t1->Name = 'HelloObject';
$t1->AddText('Use the Cpdf_Content->Name to identify an object and allow annotations to jump to its exact position');
$t1->AddText('Some PDF Viewer will display the complete page instead');
$t1->AddText('Jump to <c:ilink:2>page 2</c:ilink> without any content object associated');

// create page 2
$pdf->NewPage(Cpdf_Common::$Layout['A4']);
$t2 = $pdf->NewText();
$t2->Name = "jumpback";
// execute the callback function for internal links (some styles and a link annotion)
$t2->AddText('add an internal link <c:ilink:HelloObject>here</c:ilink>');

// Output the PDF - use parameter 1 to set a filename
$pdf->Stream(basename(__FILE__, '.php').'.pdf');

// performance counter
$end = microtime(true) - $start;
//error_log($end);

?>