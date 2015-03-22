<?php

namespace spec\JSila\Twemoji;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TwemojiSpec extends ObjectBehavior
{
    function it_returns_url_for_twemoji()
    {
        $this->getUrl(':sunny:')
            ->shouldReturn('//twemoji.maxcdn.com/16x16/2600.png');
    }

    function it_allows_different_size_of_icons()
    {
        $this->beConstructedWith(36);

        $this->getUrl(':sunny:')
            ->shouldReturn('//twemoji.maxcdn.com/36x36/2600.png');
    }

    function it_rejects_invalid_icon_size()
    {
        $this->beConstructedWith(32);

        $this->shouldThrow('Exception')->during('__construct', [12]);        
    }

    function it_returns_image_html_tag()
    {
        $this->getImage(':sunny:')
            ->shouldReturn('<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="">');
    }

    function it_returns_image_html_tag_with_classes_as_string()
    {
        $this->getImage(':sunny:', 'a b')
            ->shouldReturn('<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="a b">');
    }

    function it_returns_image_html_tag_with_classes_as_an_array()
    {
        $this->getImage(':sunny:', ['a', 'b'])
            ->shouldReturn('<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="a b">');
    }

    function it_parses_text_for_twemojis()
    {
        $text = 'Today is :sunny: without a single :cloud:.';

        $result = 'Today is <img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class=""> without a single <img src="//twemoji.maxcdn.com/16x16/2601.png" alt="cloud" class="">.';

        $this->parseText($text)
            ->shouldReturn($result);
    }

    function it_applies_classes_provided_as_string()
    {
        $twemojiName = ':sunny:';

        $this->getImage($twemojiName, 'twemoji')
            ->shouldReturn('<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="twemoji">');
    }

    function it_applies_classes_provided_as_an_array()
    {
        $twemojiName = ':sunny:';

        $this->getImage($twemojiName, ['twemoji', 'sunny'])
            ->shouldReturn('<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="twemoji sunny">');
    }
}
