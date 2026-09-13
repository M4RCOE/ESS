<?php

namespace App\Classes;

use Francerz\DateTimeTools\DateTimeHelper;
use Luecano\NumeroALetras\NumeroALetras;

class DateTimeSpanish
{
    public static function toString($start, $end = null)
    {
        if (isset($start) && !isset($end)) {
            $start = DateTimeHelper::toDateTime($start);
            return sprintf(
                '%d de %s de %d',
                $start->format('d'),
                static::getMonthString($start),
                $start->format('Y')
            );
        }
        $start = DateTimeHelper::min([$start, $end]);
        $end = DateTimeHelper::max([$start, $end]);

        $y1 = $start->format('Y');
        $m1 = $start->format('m');
        $d1 = $start->format('j');
        $y2 = $end->format('Y');
        $m2 = $end->format('m');
        $d2 = $end->format('j');

        if ($d1 == $d2 && $m1 == $m2 && $y1 == $y2) {
            // 22 de marzo de 2023
            return sprintf(
                '%d de %s de %d',
                $start->format('j'),
                static::getMonthString($start),
                $start->format('Y')
            );
        }
        if ($m1 == $m2 && $y1 == $y2) {
            // 16 al 22 de marzo de 2023
            return sprintf(
                '%d al %d de %s de %d',
                $start->format('j'),
                $end->format('j'),
                static::getMonthString($start),
                $start->format('Y')
            );
        }
        if ($y1 == $y2) {
            // 6 de febrero al 22 de marzo de 2023
            return sprintf(
                '%d de %s al %d de %s de %d',
                $start->format('j'),
                static::getMonthString($start),
                $end->format('j'),
                static::getMonthString($end),
                $start->format('Y')
            );
        }

        // 17 de octubre de 1995 al 22 de marzo de 2023
        return sprintf(
            '%d de %s de %d al %d de %s de %d',
            $start->format('j'),
            static::getMonthString($start),
            $start->format('Y'),
            $end->format('j'),
            static::getMonthString($end),
            $end->format('Y')
        );
    }

    public static function toLongString($date)
    {
        $date = DateTimeHelper::toDateTime($date);
        $n2l = new NumeroALetras();
        $n2l->apocope = true;
        return sprintf(
            '%s días del mes de %s del año %s',
            mb_strtolower($n2l->toString($date->format('j'), 0)),
            static::getMonthString($date),
            mb_strtolower($n2l->toString($date->format('Y'), 0))
        );
    }

    private static function getMonthString($date)
    {
        $month = $date->format('m');

        switch ($month) {
            case 1:
                return 'enero';
            case 2:
                return 'febrero';
            case 3:
                return 'marzo';
            case 4:
                return 'abril';
            case 5:
                return 'mayo';
            case 6:
                return 'junio';
            case 7:
                return 'julio';
            case 8:
                return 'agosto';
            case 9:
                return 'septiembre';
            case 10:
                return 'octubre';
            case 11:
                return 'noviembre';
            case 12:
                return 'diciembre';
        }
    }
}
