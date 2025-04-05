<?php

class Sorter
{
    protected $items;
    protected $caseSensitive;

    public function __construct(string $items, $caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
        $this->processInput($items);
    }

    public function handleSorting(string $sortMethod)
    {
        switch ($sortMethod) {
            case 'Z-a':
                $output = $this->sortzA();
                break;
            case 'a-Z':
                $output = $this->sortAz();
                break;
            case 'unique':
                $output = $this->unique();
                break;
            case 'duplicates':
                $output = $this->duplicates();
                break;
            case 'shuffle':
                $output = $this->shuffle();
                break;
            case 'count':
                $output = $this->count();
                break;
            case 'sortLength<':
                $output = $this->sortLengthAsc();
                break;
            case 'sortLength>':
                $output = $this->sortLengthDesc();
                break;
            case 'toCamelCase':
                $output = $this->toCamelCase();
                break;
            case 'toSnakeCase':
                $output = $this->toSnakeCase();
                break;
            case 'toKebabCase':
                $output = $this->toKebabCase();
                break;
            case 'snakeCaseToString':
                $output = $this->snakeCaseToString();
                break;

            case 'random':
                $output = $this->random();
                break;
            case 'flipLR':
                $output = $this->flipLR();
                break;
        }
        return implode(PHP_EOL, $output);
    }

    protected function processInput(string $items)
    {
        $items = str_replace(["\r\n", "\n\r", "\r"], "\n", $items);
        $items = explode("\n", $items);

        if ($this->caseSensitive === false) {
            $items = array_map('strtolower', $items);
        }
        $this->items = $items;
    }

    public function toCamelCase(): array
    {
        $out = [];
        foreach ($this->items as $k => $item) {
            if ($item) {
                $item = ucwords(str_replace('-', ' ', $item));
                $item = str_replace('_', ' ', $item);
                $item = preg_replace("/[\s-]+/", "", $item);
                $out[] = lcfirst($item);
            }
        }
        return $out;
    }

    public function toSnakeCase(): array
    {
        $out = [];
        foreach ($this->items as $k => $item) {
            if ($item) {
                $item = preg_replace("/[\s-]+/", "_", $item);
                $out[] = strtolower($item);
            }
        }
        return $out;
    }

    public function toKebabCase(): array
    {
        $out = [];
        foreach ($this->items as $k => $item) {
            if ($item) {
                $item = preg_replace("/[\s_]+/", "-", $item);
                $out[] = strtolower($item);
            }
        }
        return $out;
    }
    public function snakeCaseToString(): array
    {
        $out = [];
        foreach ($this->items as $k => $item) {
            if ($item) {
                $item = preg_replace("/[_]+/", " ", $item);
                $out[] = ucfirst(strtolower($item));
            }
        }
        return $out;
    }

    public function sortzA(): array
    {
        if ($this->caseSensitive) {
            rsort($this->items);
        } else {
            natcasesort($this->items);
            $this->items = array_reverse($this->items);
        }
        return $this->items;
    }

    public function sortAz(): array
    {
        if ($this->caseSensitive) {
            sort($this->items);
        } else {
            natcasesort($this->items);
        }
        return $this->items;
    }

    public function unique(): array
    {
        $this->items = array_unique($this->items);
        sort($this->items);
        return $this->items;
    }

    public function random(): array
    {
        shuffle($this->items);
        $firstItem = reset($this->items);
        return ['0' => $firstItem];
    }

    public function count(): array
    {
        sort($this->items);
        $output = array_count_values($this->items);
        $out = [];
        foreach ($output as $key => $item) {
            $out[] = $key . ' | ' . $item . 'x';
        }
        return $out;
    }

    public function shuffle(): array
    {
        shuffle($this->items);
        return $this->items;
    }

    public function duplicates(): array
    {
        $this->items = array_diff_key($this->items, array_unique($this->items));
        sort($this->items);
        return $this->items;
    }

    public function sortLengthDesc(): array
    {
        $this->sortLengthAsc();
        $this->items = array_reverse($this->items);
        return $this->items;
    }

    public function sortLengthAsc(): array
    {
        usort($this->items, function ($a, $b) {
            return strlen($a) - strlen($b) ?: strcmp($a, $b);
        });
        return $this->items;
    }

    public function flipLR(): array
    {
        $arr = [];
        foreach ($this->items as $item) {
            @list($k, $v) = explode(',', $item);
            $arr[] = $v . ',' . $k;
        }
        return $arr;
    }
}
