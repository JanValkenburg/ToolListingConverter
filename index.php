<?php

$input = $_POST['content'] ?? null;
$sortMethod = $_POST['method'] ?? 'a-Z';
$caseSensitive = isset($_POST['case_sensitive']);
$output = null;
if ($input) {
    $output = str_replace(["\r\n", "\n\r", "\r"], "\n", $input);
    $output = explode("\n", $output);

    if ($caseSensitive === false) {
        $output = array_map('strtolower', $output);
    }

    switch ($sortMethod) {
        case 'Z-a':
            if ($caseSensitive) {
                rsort($output);
            }
            else {
                natcasesort($output);
                $output = array_reverse($output);
            }
            break;
        case 'a-Z':
            if ($caseSensitive) {
                sort($output);
            }
            else {
                natcasesort($output);
            }
            break;
        case 'unique':
            $output = array_unique($output);
            sort($output);
            break;
        case 'duplicates':
            $output = array_diff_key($output, array_unique($output));
            sort($output);
            break;
        case 'shuffle':
            shuffle($output);
            break;
        case 'count':
            sort($output);
            $output = array_count_values($output);
            $out = [];
            foreach ($output as $key => $item) {
                $out[] = $key . ' | ' . $item . 'x';
            }
            $output = $out;
            break;
        case 'sortLength<':
            usort($output, function($a, $b) {
                return strlen($a) - strlen($b) ?: strcmp($a, $b);
            });
            break;
        case 'sortLength>':
            usort($output, function($a, $b) {
                return strlen($a) - strlen($b) ?: strcmp($a, $b);
            });
            $output = array_reverse($output);
            break;
        case 'random':
            shuffle($output);
            $firstItem = reset($output);
            $output = ['0' => $firstItem];
            break;
    }
    $output = implode(PHP_EOL, $output);
}

$template = file_get_contents('view/index.html');
$template = str_replace(['{{input}}', '{{output}}'], [$input, $output], $template);
if ($caseSensitive) {
    $template = str_replace('{{case_sensitive}}', 'checked', $template);
}

echo $template;