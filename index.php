<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'class/Sorter.php';

class App {

    function __construct() {
        $this->caseSensitive = isset($_POST['case_sensitive']);
        $this->input = $_POST['content'] ?? '';
        $this->method =  $_POST['method'] ?? 'a-Z';
    }

    function run() {
        $Sorter = new Sorter($this->input, $this->caseSensitive);
        $output = $Sorter->handleSorting($this->method);
        return $this->render($output);
    }

    function render(string $output) {
        $template = file_get_contents('view/index.html');
        $template = str_replace(['{{input}}', '{{output}}'], [$this->input, $output], $template);
        if ($this->caseSensitive) {
            $template = str_replace('{{case_sensitive}}', 'checked', $template);
        }

        return $template;
    }
}

echo (new App())->run();