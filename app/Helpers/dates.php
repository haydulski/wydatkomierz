<?php

declare(strict_types=1);

if (! function_exists('translateMonthsToPolish')) {
    function translateMonthsToPolish(string $date): string
    {
        $monthName = (new DateTime($date))->format('F');
        switch (strtolower($monthName)) {
            case 'january':
                return 'Styczeń';
            case 'february':
                return 'Luty';
            case 'march':
                return 'Marzec';
            case 'april':
                return 'Kwiecień';
            case 'may':
                return 'Maj';
            case 'june':
                return 'Czerwiec';
            case 'july':
                return 'Lipiec';
            case 'august':
                return 'Sierpień';
            case 'september':
                return 'Wrzesień';
            case 'october':
                return 'Październik';
            case 'november':
                return 'Listopad';
            case 'december':
                return 'Grudzień';
            default:
                return $monthName;
        }
    }
}

if (! function_exists('decodeMonth')) {
    function decodeMonth(int $monthNumber): string
    {
        return match ($monthNumber) {
            1 => 'Styczeń',
            2 => 'Luty',
            3 => 'Marzec',
            4 => 'Kwiecień',
            5 => 'Maj',
            6 => 'Czerwiec',
            7 => 'Lipiec',
            8 => 'Sierpień',
            9 => 'Wrzesień',
            10 => 'Październik',
            11 => 'Listopad',
            12 => 'Grudzień',
            default => 'Styczeń'
        };
    }
}

if (! function_exists('formatDate')) {
    function formatDate(string $date): string
    {
        return (new DateTime($date))->format('Y.m.d H:i');
    }
}
