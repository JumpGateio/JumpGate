<?php

namespace App\Traits\Console;

/**
 * Class ProgressBarTrait
 *
 * @property \Illuminate\Console\OutputStyle $output
 */
trait ProgressBarTrait
{
    /**
     * The active progress bar.
     *
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $bar = null;

    /**
     * Set up the bar and the label.
     *
     * @param string $originalTable
     * @param string $newTable
     * @param array  $collection
     * @param bool   $new
     */
    public function startBar($originalTable, $newTable, $collection, $new = false)
    {
        static $even = false;

        $this->bar = $this->output->createProgressBar(count($collection));

        // Set up the label.
        $this->setUpLabel($originalTable, $newTable, $new, $even);

        $even = ! $even;
    }

    /**
     * Move the bar forward one step.
     */
    public function advanceBar()
    {
        $this->bar->advance();
    }

    /**
     * Finish the bar.
     */
    public function finishBar()
    {
        $this->bar->finish();
        $this->info("\r");
    }

    /**
     * Set up the format for the progress bar.
     *
     * @param string $originalTable
     * @param string $newTable
     * @param bool   $new
     * @param bool   $even
     */
    private function setUpLabel($originalTable, $newTable, $new, $even)
    {
        $bgColor = $this->getRowColor($even);
        $new     = $new ? '<fg=green;bg=' . $bgColor . '>NEW</> ' : '';
        $name    = $originalTable . ' -> ' . $newTable;
        $tabs    = $this->getTabs($name, $new);

        $label = '<fg=black;bg=' . $bgColor . ';options=bold>' . $new . $name . $tabs . '</>';

        $this->bar->setFormat(
            $label .
            ' %current:6s%/%max:-6s% [%bar%] %percent:3s%%'
        );
    }

    /**
     * Determine the spacing needed after the label for the bars to appear in line.
     *
     * @param string $string
     * @param bool   $new
     *
     * @return string
     */
    private function getTabs($string, $new)
    {
        $length = strlen($string);
        $max    = $new ? 56 : 60;

        $range = range(1, $max - $length);

        $tabs = '';

        foreach ($range as $item) {
            $tabs .= " ";
        }

        return $tabs;
    }

    /**
     * Determine which color to use for a table row.
     *
     * @param bool $even
     *
     * @return string
     */
    private function getRowColor($even)
    {
        return $even ? 'blue' : 'cyan';
    }
}
