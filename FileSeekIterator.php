<?php


/**
 * Class FileSeekIterator
 *
 * usage:
 *
 * ```
 * $file = new FileSeekIterator($fileName);
 * $file->readSize = 10;
 * $file->seek(1000);
 * echo $file->current() . PHP_EOL;
 *
 * $file->readSize = 9;
 * $file->seek(1001);
 * echo ' ' . $seekFile->current() . PHP_EOL;
 * ```
 */
class FileSeekIterator implements SeekableIterator
{
    private $resource;
    private $current = '';

    /**
     * Maximal length of string, which return current()
     * @var int
     */
    public $readSize = 256;

    /**
     * FileSeekIterator constructor.
     * @param $file - path to file
     */
    public function __construct($file)
    {
        $resource = fopen($file, 'rb');
        $this->resource = $resource;
        $this->rewind();
    }

    /**
     * Return the current string
     * @return string
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * Read next string from file
     * @return void
     */
    public function next()
    {
        $this->read();
    }

    /**
     * Return current position
     * @return integer
     */
    public function key()
    {
        return ftell($this->resource);
    }

    /**
     * Check is eof
     * @return boolean
     */
    public function valid()
    {
        return !feof($this->resource);
    }

    /**
     * Rewind position to start file
     * @return void
     */
    public function rewind()
    {
        rewind($this->resource);
        $this->read();
    }

    /**
     * Set position for read
     * @param int $position
     * @return void
     */
    public function seek($position)
    {
        fseek($this->resource, $position, SEEK_SET);
        $this->read();
    }

    /**
     * Read current string from file
     * @return void
     */
    private function read()
    {
        $this->current = fread($this->resource, $this->readSize);
    }

    /**
     * @inheritdoc
     */
    public function __destruct()
    {
        fclose($this->resource);
    }
}