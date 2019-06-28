<?php

namespace Folospace\ChineseHoliday;

use Folospace\ChineseHoliday\Foundation\LunarSolarConverter;
use Folospace\ChineseHoliday\Foundation\Solar;

class ChineseHoliday
{
    private  $lunarHoliday;
    private  $lunar24;
    private  $specialHoliday;
    private  $solarHoliday;

    public function __construct()
    {
        $this->lunarHoliday = config('chineseholiday.lunar');
        $this->lunar24 = config('chineseholiday.lunar24');
        $this->specialHoliday = config('chineseholiday.special');
        $this->solarHoliday = config('chineseholiday.solar');
    }

    /**
     * 获取所有节日
     * @param $timestamp
     */
    public function getAllHolidays($timestamp)
    {
        $days = [];
        if ($data = $this->getSolorHoliday($timestamp)) {
            $days[] = $data;
        }
        if ($data = $this->getLunarHoliday($timestamp)) {
            $days[] = $data;
        }
        if ($data = $this->getLunar24($timestamp)) {
            $days[] = $data;
        }
        if ($data = $this->getSpecialHoliday($timestamp)) {
            $days[] = $data;
        }
    }

    /**
     * 获取阳历节日
     * @param $timestamp
     * @return false|string
     */
    public function getSolorHoliday($timestamp)
    {
        $date = date('md', $timestamp);

        if (isset($this->solarHoliday[$date])) {
            return $this->solarHoliday[$date];
        }
        return '';
    }

    /**
     * 获取中国传统节日
     * @param $timestamp
     * @return mixed|string
     */
    public function getLunarHoliday($timestamp)
    {
        $solar = new Solar();
        $solar->solarYear = date('Y', $timestamp);
        $solar->solarMonth = date('m', $timestamp);
        $solar->solarDay = date('d', $timestamp);

        if (!$lunar = LunarSolarConverter::SolarToLunar($solar)) {
            return '';
        }

        $lunarStr = ($lunar->lunarMonth > 9 ? $lunar->lunarMonth : ('0' . $lunar->lunarMonth))
            . ($lunar->lunarDay > 9 ? $lunar->lunarDay : '0' . $lunar->lunarDay);

        if (isset($this->lunarHoliday[$lunarStr])) {
            return $this->lunarHoliday[$lunarStr];
        } else if (isset($this->lunarHoliday['0000']) && $lunar->lunarMonth == 12 and in_array($lunar->lunarDay, [29, 30])) { //可能是除夕
            if (self::getLunarHoliday($timestamp + 3600 * 24)) {
                return $this->lunarHoliday['0000'];
            }
        }
        return '';
    }

    /**
     * 获取特殊节日
     * @param $timestamps
     * @return string
     */
    public function getSpecialHoliday($timestamps)
    {
        $month = date('m', $timestamps);
        if ($month == 5 && in_array('母亲节', $this->specialHoliday)) {
            $start = strtotime(date('Y-m-01', $timestamps));
            $weekDay = date('w', $start);
            $dest = ($weekDay ? (7 * 2 - $weekDay) : 7) * 3600 * 24 + $start;
            if (date('Y-m-d', $timestamps) == date('Y-m-d', $dest)) {
                return '母亲节';
            }

        } else if ($month == 6 && in_array('父亲节', $this->specialHoliday)) {
            $start = strtotime(date('Y-m-01', $timestamps));
            $weekDay = date('w', $start);
            $dest = ($weekDay ? (7 * 3 - $weekDay) : 7 * 2) * 3600 * 24 + $start;
            if (date('Y-m-d', $timestamps) == date('Y-m-d', $dest)) {
                return '父亲节';
            }
        } else if ($month == 11 && in_array('感恩节', $this->specialHoliday)) {
            $start = strtotime(date('Y-m-01', $timestamps));
            $weekDay = date('w', $start);

            $distance = $weekDay <= 4 ? 4 - $weekDay : 7 + 4 - $weekDay;
            $dest = ($distance + 21) * 3600 * 24 + $start;

            if (date('Y-m-d', $timestamps) == date('Y-m-d', $dest)) {
                return '感恩节';
            }
        }
        return '';
    }

    /**
     * 获取二十四节气 中文名
     * @param $timestamps
     * @return mixed|string
     */
    public function getLunar24($timestamps)
    {
        $_year = date('Y', $timestamps);
        $month = date('m', $timestamps);
        $day = date('d', $timestamps);
        $year = substr($_year, -2) + 0;
        $coefficient = array(
            array(5.4055, 2019, -1),//小寒
            array(20.12, 2082, 1),//大寒
            array(3.87),//立春
            array(18.74, 2026, -1),//雨水
            array(5.63),//惊蛰
            array(20.646, 2084, 1),//春分
            array(4.81),//清明
            array(20.1),//谷雨
            array(5.52, 1911, 1),//立夏
            array(21.04, 2008, 1),//小满
            array(5.678, 1902, 1),//芒种
            array(21.37, 1928, 1),//夏至
            array(7.108, 2016, 1),//小暑
            array(22.83, 1922, 1),//大暑
            array(7.5, 2002, 1),//立秋
            array(23.13),//处暑
            array(7.646, 1927, 1),//白露
            array(23.042, 1942, 1),//秋分
            array(8.318),//寒露
            array(23.438, 2089, 1),//霜降
            array(7.438, 2089, 1),//立冬
            array(22.36, 1978, 1),//小雪
            array(7.18, 1954, 1),//大雪
            array(21.94, 2021, -1)//冬至
        );
        $term_name = array(
            "小寒", "大寒", "立春", "雨水", "惊蛰", "春分", "清明", "谷雨",
            "立夏", "小满", "芒种", "夏至", "小暑", "大暑", "立秋", "处暑",
            "白露", "秋分", "寒露", "霜降", "立冬", "小雪", "大雪", "冬至");

        $idx1 = ($month - 1) * 2;
        $_leap_value = floor(($year - 1) / 4);
        $day1 = floor($year * 0.2422 + $coefficient[$idx1][0]) - $_leap_value;
        if (isset($coefficient[$idx1][1]) && $coefficient[$idx1][1] == $_year) $day1 += $coefficient[$idx1][2];
        $day2 = floor($year * 0.2422 + $coefficient[$idx1 + 1][0]) - $_leap_value;
        if (isset($coefficient[$idx1 + 1][1]) && $coefficient[$idx1 + 1][1] == $_year) $day1 += $coefficient[$idx1 + 1][2];

        $data = array();
        if ($day < $day1) {
            $data['name1'] = $term_name[$idx1 - 1];
            $data['name2'] = $term_name[$idx1 - 1] . '后';
        } else if ($day == $day1) {
            $data['name1'] = $term_name[$idx1];
            $data['name2'] = $term_name[$idx1];
        } else if ($day > $day1 && $day < $day2) {
            $data['name1'] = $term_name[$idx1];
            $data['name2'] = $term_name[$idx1] . '后';
        } else if ($day == $day2) {
            $data['name1'] = $term_name[$idx1 + 1];
            $data['name2'] = $term_name[$idx1 + 1];
        } else if ($day > $day2) {
            $data['name1'] = $term_name[$idx1 + 1];
            $data['name2'] = $term_name[$idx1 + 1] . '后';
        }
        if ($data['name1'] == $data['name2'] && in_array($data['name1'], $this->lunar24)) {
            return $data['name1'];
        }
        return '';
    }
}