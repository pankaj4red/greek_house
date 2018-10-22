<?php

namespace App\Contracts\Report;

abstract class Report
{
    /**
     * @var string[]
     */
    protected $values = [];

    /**
     * @param string $key
     * @param string $value
     */
    public function put($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return $this->values[$key];
    }

    /**
     * @return array
     */
    abstract public function generate();

    /**
     * @return string
     */
    public function csv()
    {
        $data = $this->generate();
        for ($i = 0; $i < count($data['header']); $i++) {
            $data['header'][$i] = str_replace(',', ' ', $data['header'][$i]);
        }
        for ($i = 0; $i < count($data['body']); $i++) {
            for ($j = 0; $j < count($data['body'][$i]); $j++) {
                $data['body'][$i][$j] = str_replace(',', ' ', $data['body'][$i][$j]);
            }
        }
        $output = implode(',', $data['header'])."\r\n";
        foreach ($data['body'] as $line) {
            $output .= implode(',', $line)."\r\n";
        }
        foreach ($data['footer'] as $line) {
            $output .= implode(',', $line)."\r\n";
        }

        return $output;
    }

    /**
     * @return string
     */
    public function html()
    {
        $data = $this->generate();
        $output = '<table class="table table-condensed"><thead><tr>';
        foreach ($data['header'] as $column) {
            $output .= '<th>'.process_text($column).'</th>';
        }
        $output .= '</tr></thead><tbody>';
        foreach ($data['body'] as $line) {
            $output .= '<tr>';
            foreach ($line as $column) {
                $output .= '<td>'.process_text($column).'</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        if (! empty($data['footer'])) {
            $output .= '<tfoot>';
            foreach ($data['footer'] as $line) {
                $output .= '<tr>';
                foreach ($line as $column) {
                    $output .= '<td>'.process_text($column).'</td>';
                }
                $output .= '</tr>';
            }
            $output .= '</tfoot>';
        }
        $output .= '</table>';

        return $output;
    }
}
