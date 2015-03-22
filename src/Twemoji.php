<?php

namespace JSila\Twemoji;

use Exception;

class Twemoji
{
    /**
     * Base for twemoji url.
     *
     * @var string
     */
    const TWEMOJI_URL = '//twemoji.maxcdn.com/%1$sx%1$s/%2$s.png';

    /**
     * Regular expression for finding twemoji names (surrounded by double colon)
     */
    const TWEMOJI_REGEX = '/(:[a-zA-Z0-9_]*:)/';

    /**
     * Skeleton for image html tag
     *
     * @var string
     */
    const IMAGE_TAG = '<img src="%s" alt="%s" class="%s">';

    /**
     * Icon size of twemoji image.
     *
     * @var int
     */
    protected $iconSize;

    /**
     * Supported icon sizes for twemoji.
     *
     * @var array
     */
    protected $supportedIconSizes = [16, 36, 72];

    /**
     * Array of mappings twemoji name to unicode representation and description of twemoji
     *
     * @var
     */
    protected $twemojiIndex;

    /**
     * @param int $iconSize
     */
    public function __construct($iconSize = 16)
    {
        $this->iconSize = $iconSize;

        $this->validateIconSize();

        $this->obtainTwemojiIndex();
    }

    /**
     * Returns generated url of given twemoji name (surrounded by double colon).
     *
     * @param $twemojiName
     * @return string
     */
    public function getUrl($twemojiName)
    {
        return sprintf(
            self::TWEMOJI_URL,
            $this->iconSize,
            $this->getUnicode($twemojiName)
        );
    }

    /**
     * Returns unicode representation of twemoji name (surrounded by double colon).
     *
     * @param $twemojiName
     * @return string
     */
    public function getUnicode($twemojiName)
    {
        return $this->twemojiIndex[$twemojiName]['unicode'];
    }

    /**
     * Returns description of given twemoji name (surrounded by double colon).
     *
     * @param $twemojiName
     * @return string
     */
    public function getDescription($twemojiName)
    {
        return $this->twemojiIndex[$twemojiName]['description'];
    }

    /**
     * Returns image of twemoji name (surrounded by double colon).
     *
     * @param string $twemojiName
     * @param string|array $classNames
     * @return string
     */
    public function getImage($twemojiName, $classNames = '')
    {
        return $this->makeImage($twemojiName, $classNames);
    }

    /**
     * Prints image of twemoji name (surrounded by double colon).
     *
     * @param string $twemojiName
     * @param string|array $classNames
     */
    public function image($twemojiName, $classNames = '')
    {
        echo $this->makeImage($twemojiName, $classNames);
    }

    /**
     * Replaces twemoji names (surrounded by double colon) in text with corresponding images.
     *
     * @param string $text
     * @return string
     */
    public function parseText($text, $classNames = '')
    {
        return preg_replace_callback(self::TWEMOJI_REGEX, function($matches) use ($classNames) {
            return $this->getImage($matches[1], $classNames);
        }, $text);
    }

    /**
     * Loads twemoji index json file into array.
     *
     * @see https://github.com/heyupdate/Emoji/tree/master/config
     */
    private function obtainTwemojiIndex()
    {
        $twemojiIndex = file_get_contents(__DIR__ . '/twemoji-index.json');
        $twemojiIndex = json_decode($twemojiIndex, true);

        $this->twemojiIndex = [];

        foreach ($twemojiIndex as $twemoji) {
            $this->twemojiIndex[':' . $twemoji['name'] . ':'] = [
                'unicode' => $twemoji['unicode'],
                'description' => $twemoji['description'],
            ];
        }
    }

    /**
     * Returns formatted text of image html tag for given twemoji name (surrounded by double colon)
     * with optional classes applied to it.
     *
     * @param string $twemojiName
     * @param string|array $classNames
     * @return string
     */
    private function makeImage($twemojiName, $classNames = '')
    {
        return sprintf(
            self::IMAGE_TAG,
            $this->getUrl($twemojiName),
            $this->getDescription($twemojiName),
            is_array($classNames) ? implode(' ', $classNames) : $classNames
        );
    }

    /**
     * Throws an exception if icon size is not valid/supported.
     *
     * @throws Exception
     */
    private function validateIconSize()
    {
        if (! in_array($this->iconSize, $this->supportedIconSizes)) {
            throw new Exception('Icon must be of size 16, 36 or 72');
        }
    }
}
