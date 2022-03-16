<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'class/Sorter.php';
require_once 'class/Render.php';

class App {

    function __construct() {
        $this->caseSensitive = isset($_POST['case_sensitive']);
        $this->input = $_POST['content'] ?? '';
        $this->method = $_POST['method'] ?? 'a-Z';
        $this->output = (new Sorter($this->input, $this->caseSensitive))->handleSorting($this->method);
    }

    function run() {
        return (new Render(
            'view/index.html',
            [
                'input' => $this->input, 
                'output'=> $this->output,
                'case_sensitive' => $this->caseSensitive ? 'checked' : ''
            ]
        ))->render();
    }
}

echo (new App())->run();