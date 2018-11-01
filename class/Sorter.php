<?php
/**
 * Created by PhpStorm.
 * User: vaartland
 * Date: 01/11/2018
 * Time: 16:32
 */

/**
 * Class Sorter
 */
class Sorter
{
    /** @var array  */
    protected $items;
    /**
     * @var bool
     */
    protected $caseSensitive;

    /**
     * Sorter constructor.
     * @param string $items
     * @param bool $caseSensitive
     */
    public function __construct($items, bool $caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
        $this->processInput($items);
    }

    /**
     * @param string $items
     */
    protected function processInput($items): void
    {
        $items = str_replace(["\r\n", "\n\r", "\r"], "\n", $items);
        $items = explode("\n", $items);

        if ($this->caseSensitive === false) {
            $items = array_map('strtolower', $items);
        }
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function sortzA(): array {
        if ($this->caseSensitive) {
            rsort($this->items);
        }
        else {
            natcasesort($this->items);
            $this->items = array_reverse($this->items);
        }
        return $this->items;
    }

    /**
     * @return array
     */
    public function sortAz(): array  {
        if ($this->caseSensitive) {
            sort($this->items);
        }
        else {
            natcasesort($this->items);
        }
        return $this->items;
    }

    /**
     * @return array
     */
    public function unique(): array
    {
        $this->items = array_unique($this->items);
        sort($this->items);
        return $this->items;
    }

    /**
     * @return array
     */
    public function random(): array
    {
        shuffle($this->items);
        $firstItem = reset($this->items);
        return ['0' => $firstItem];
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function shuffle(): array
    {
        shuffle($this->items);
        return $this->items;
    }

    /**
     * @return array
     */
    public function duplicates(): array
    {
        $this->items = array_diff_key($this->items, array_unique($this->items));
        sort($this->items);
        return $this->items;
    }

    /**
     * @return array
     */
    public function sortLengthDesc(): array
    {
        $this->sortLengthAsc();
        $this->items = array_reverse($this->items);
        return $this->items;
    }

    /**
     * @return array
     */
    public function sortLengthAsc(): array
    {
        usort($this->items, function($a, $b) {
            return strlen($a) - strlen($b) ?: strcmp($a, $b);
        });
        return $this->items;
    }
}