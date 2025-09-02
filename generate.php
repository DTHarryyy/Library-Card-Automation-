<?php
require './autoloader.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

include("./backend/database_information.php");

// Fetch students
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$stmt = $pdo->query("SELECT full_name, student_id_number, department FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                $cell->addTextBreak(10); // push text down (try adjusting the number)

                $cell->addText(
                    $cellData['full_name'],
                    ['size' => 8, 'name' => 'Arial', 'bold' => true],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
                );

                $cell->addTextBreak(5); // space between lines
                $cell->addText(
                    $cellData['student_id_number'],
                    ['size' => 5, 'name' => 'Arial'],
                    ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'lineHeight' => 1.5]
                );
                

                $cell->addText(
                $cellData['department'],
                [
                    'size' => 6.5,
                    'name' => 'Calibri',
                    'bold' => true,          // make text bold
                    'color' => 'FFFFFF'      // white color in hex
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

// Save Word document
$finalFile = './documents/student_cards.docx';
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($finalFile);

echo "Student cards generated successfully in $finalFile";
