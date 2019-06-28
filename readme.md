# ChineseHoliday

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Laravel get Chinese Holiday by date.
根据日期获取中国节日。

## Installation

Via Composer

``` bash
$ composer require folospace/chineseholiday
```

## Usage
``` bash
use \Folospace\ChineseHoliday\Facades\ChineseHoliday;
//获取指定日期所有节日
$test = ChineseHoliday::getAllHolidays(strtotime('2019-06-21')); [夏至]
//获取指定日期传统中国节日
$test = ChineseHoliday::getLunarHoliday(strtotime('2019-09-13')); //中秋
//获取指定日期二十四节气
$test = ChineseHoliday::getLunar24(strtotime('2019-06-21'));  //夏至
//获取指定日期特殊节日
$test = ChineseHoliday::getSpecialHoliday(strtotime('2019-06-16')); //父亲节
//获取指定日期相关的公历节日
$test = ChineseHoliday::getSolorHoliday(strtotime('2019-02-14')); //情人节
```

## Publish and modify config

``` bash
//自定义节日
$ php artisan vendor:publish --provider="Folospace\ChineseHoliday\ChineseHolidayServiceProvider"

```


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email folospace@gmail.com instead of using the issue tracker.

## Credits

- [magacy][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/folospace/chineseholiday.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/folospace/chineseholiday.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/folospace/chineseholiday/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/folospace/chineseholiday
[link-downloads]: https://packagist.org/packages/folospace/chineseholiday
[link-travis]: https://travis-ci.org/folospace/chineseholiday
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/folospace
[link-contributors]: ../../contributors
