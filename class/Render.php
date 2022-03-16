<?php

class Render {
    private string $template;

    public function __construct(string $template, array $vars = []) {
        $this->template = file_get_contents($template);
        foreach($vars as $name => $value) {
            $this->template = str_replace('{{'.$name.'}}', $value, $this->template);
        }
    }

    public function render():string {
        return $this->template;
    }
}