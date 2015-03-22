# Emoji Images PHP

Main functionality of the package is parsing text for emoji names (surrounded by double colons) and converting them to corresponding images. It makes use of [Twemoji](http://twitter.github.io/twemoji/).

## Install

Via Composer

``` bash
$ composer require jsila/emoji-images-php
```

## Usage

```php
$emoji = new JSila\Twemoji\Twemoji;

echo $emoji->parseText('Today is :sunny: without a single :cloud:.');
// outputs 'Today is <img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class=""> without a single <img src="//twemoji.maxcdn.com/16x16/2601.png" alt="cloud" class="">.'
```

Icons size defaults to 16, but you can override it with 36 or 72. Just pass the appopriate number to constructor.

```php
$emoji = new JSila\Twemoji\Twemoji(36);
```

Besides parsing the text for emojis you can also get just the url address for specific emoji.

```php
$emoji->getUrl(':sunny:');
// outputs '//twemoji.maxcdn.com/16x16/2600.png' 
```

It can return image of single emoji (not printing it).

```php
$emoji->getImage(':sunny:');
// returns '<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="">' 
```

Both `parseText` and `getImage` optionally accept second parameter which represents classes to be applied to `img` tag (as a string seperated by space or an array of strings)

```php
$emoji->getImage(':sunny:', 'emoji sunny');
// returns '<img src="//twemoji.maxcdn.com/16x16/2600.png" alt="black sun with rays" class="emoji sunny">' 
```

## Testing

``` bash
$ phpspec
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
