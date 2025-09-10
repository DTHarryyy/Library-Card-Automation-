<?php
session_start();
require './autoloader.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Font;
use Picqer\Barcode\BarcodeGeneratorHTML;

include("./backend/database_information.php");
function encodeToCode128A($input) {
    $startCode = chr(203); // Start A
    $stopCode  = chr(206); // Stop

    // Start A has value 103
    $checksum = 103;

    $chars = str_split($input);
    foreach ($chars as $i => $char) {
        $digitValue = 16 + (int)$char; // Map 0-9 → 16-25
        $checksum += $digitValue * ($i + 1);
    }
    $checksum = $checksum % 103;

    // Convert checksum value into a character
    // Fonts usually map 0–95 → ASCII 32–127, and 96–102 into special codes.
    if ($checksum < 95) {
        $checksumChar = chr($checksum + 32);
    } else {
        // Fallback handling for values 95–102
        $checksumChar = chr($checksum + 100);
    }

    return $startCode . $input . $checksumChar . $stopCode;
}

// Fetch students
include('./backend/fetchstudents.php');

$phpWord = new PhpWord();
$section = $phpWord->addSection([
    'paperSize' => 'Legal',
    'marginTop' => 0,
    'marginBottom' => 0,
    'marginLeft' => 0,
    'marginRight' => 0
]);

// Card dimensions in inches
$cardWidthInches  = 2.03;
$cardHeightInches = 3.03;

// Convert to Twips for table cells
$cellWidthTwips  = Converter::inchToTwip($cardWidthInches);
$rowHeightTwips  = Converter::inchToTwip($cardHeightInches);

$cardsPerRow = 3;
$cardsPerPage = 9;
$counter = 0;
$rowCells = [];
$cardImage = './template/lib_card_template.png';

foreach ($students as $student) {
    $rowCells[] = $student;
    $counter++;

    if (count($rowCells) === $cardsPerRow || $counter === count($students)) {
        $table = $section->addTable([
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0
        ]);

        $row = $table->addRow($rowHeightTwips);

        foreach ($rowCells as $cellData) {
            $cell = $row->addCell($cellWidthTwips, [
                'valign' => 'center',
                'marginTop' => 0,
                'marginBottom' => 0,
                'marginLeft' => 0,
                'marginRight' => 0
            ]);

            // Resize image to match card size
            $imageWidthPx  = Converter::inchToPixel(1.52);
            $imageHeightPx = Converter::inchToPixel(2.26);

            // Add image as background
            $cell->addImage($cardImage, [
                'width'  => $imageWidthPx,
                'height' => $imageHeightPx,
                'positioning' => 'absolute',
                'wrappingStyle' => 'behind',
                'marginTop' => 0,
                'marginLeft' => 0
            ]);

            // Add text
            if ($cellData) {
                $cell->addTextBreak(10); 
                
                $cell->addText(
                    $cellData['full_name'],
                    [
                        'size' => 9,
                        'name' => 'Trebuchet MS',
                        'bold' => true,
                        'underline' => Font::UNDERLINE_SINGLE
                    ],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
                );
                $cell->addTextBreak(1); 

                $cell->addText(
                    $cellData['address'],
                    [
                        'size' => 6,
                        'name' => 'Trebuchet MS',
                        'underline' => Font::UNDERLINE_SINGLE
                    ],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
                );

                $cell->addTextBreak(1);
                $encoded = encodeToCode128A($cellData['student_id_number']);
                $cell->addText(
                    $encoded,
                    [
                        'size' => 16,
                        'name' => 'Code 128' // make sure this is the actual font name installed
                    ],
                    [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'lineHeight' => 1.0
                    ]
                    );
                    $cell->addText(
                        $cellData['student_id_number'],
                        [
                            'size' => 5,
                            'name' => 'Trebuchet MS' // make sure this is the actual font name installed
                        ],
                        [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'lineHeight' => 1.0
                        ]
                    );
                    
                    $cell->addTextBreak(1);

                

                $cell->addText(
                $cellData['department'],
                [
                    'size' => 6.5,
                    'name' => 'Calibri',
                    'bold' => true,        
                    'color' => 'FFFFFF'  
                ],
                [
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
                ]
            );

            }

        }

        $rowCells = [];

        if ($counter % $cardsPerPage === 0 && $counter !== count($students)) {
            $section->addPageBreak();
        }
    }
}



header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="student_cards.docx"'); 
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Cache-Control: must-revalidate');
header('Expires: 0');

$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save("php://output"); // stream directly instead of saving
exit;


echo "Student cards generated successfully in $finalFile";
