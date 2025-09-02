<?php
require_once __DIR__ . '/phpword/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();

// Styled text
$section->addText(
    "Styled text example",
    array('name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => 'FF0000')
);

$phpWord->save(__DIR__ . '/styled.docx', 'Word2007');
echo "Styled document created!";
