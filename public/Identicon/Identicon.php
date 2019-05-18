<?php
require_once(dirname(__FILE__)."/Generator/GdGenerator.php");
require_once(dirname(__FILE__)."/Generator/GeneratorInterface.php");

/**
 * @author Benjamin Laugueux <benjamin@yzalis.com>
 */
class Identicon
{
    /**
     * @var \Identicon\Generator\GeneratorInterface
     */
    private $generator;

    /**
     * Identicon constructor.
     *
     * @param \Identicon\Generator\GeneratorInterface|null $generator
     */
    public function __construct($generator = null)
    {
        if (null === $generator) {
            $this->generator = new GdGenerator();
        } else {
            $this->generator = $generator;
        }
    }

    /**
     * Set the image generator.
     *
     * @param \Identicon\Generator\GeneratorInterface $generator
     *
     * @return $this
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Display an Identicon image.
     *
     * @param string $string
     * @param int    $size
     * @param string $color
     * @param string $backgroundColor
     */
    public function displayImage($string, $size = 64, $color = null, $backgroundColor = null)
    {
        header('Content-Type: '.$this->generator->getMimeType());
        echo $this->getImageData($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image data.
     *
     * @param string $string
     * @param int    $size
     * @param string $color
     * @param string $backgroundColor
     *
     * @return string
     */
    public function getImageData($string, $size = 64, $color = null, $backgroundColor = null)
    {
        return $this->generator->getImageBinaryData($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image resource.
     *
     * @param string $string
     * @param int    $size
     * @param string $color
     * @param string $backgroundColor
     *
     * @return string
     */
    public function getImageResource($string, $size = 64, $color = null, $backgroundColor = null)
    {
        return $this->generator->getImageResource($string, $size, $color, $backgroundColor);
    }

    /**
     * Get an Identicon PNG image data as base 64 encoded.
     *
     * @param string $string
     * @param int    $size
     * @param string $color
     * @param string $backgroundColor
     *
     * @return string
     */
    public function getImageDataUri($string, $size = 64, $color = null, $backgroundColor = null)
    {
        return sprintf('data:%s;base64,%s', $this->generator->getMimeType(), base64_encode($this->getImageData($string, $size, $color, $backgroundColor)));
    }
}
