<?php

require_once 'class/Sorter.php';

$input = $_POST['content'] ?? null;
$sortMethod = $_POST['method'] ?? 'a-Z';
$caseSensitive = isset($_POST['case_sensitive']);

$Sorter = new Sorter($input, $caseSensitive);
$output = null;

switch ($sortMethod) {
    case 'Z-a':
        $output = $Sorter->sortzA();
        break;
    case 'a-Z':
        $output = $Sorter->sortAz();
        break;
    case 'unique':
        $output = $Sorter->unique();
        break;
    case 'duplicates':
        $output = $Sorter->duplicates();
        break;
    case 'shuffle':
        $output = $Sorter->shuffle();
        break;
    case 'count':
        $output = $Sorter->count();
        break;
    case 'sortLength<':
        $output = $Sorter->sortLengthAsc();
        break;
    case 'sortLength>':
        $output = $Sorter->sortLengthDesc();
        break;
    case 'random':
        $output = $Sorter->random();
        break;
}
$output = implode(PHP_EOL, $output);

$template = file_get_contents('view/index.html');
$template = str_replace(['{{input}}', '{{output}}'], [$input, $output], $template);
if ($caseSensitive) {
    $template = str_replace('{{case_sensitive}}', 'checked', $template);
}

echo $template;