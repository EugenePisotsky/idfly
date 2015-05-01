<?php
$array = json_decode(file_get_contents('file.json'), true);

$columnLength = [];

foreach ($array as $rowKey => $rowColumns) {
    foreach ($rowColumns as $colKey => $colValue) {
        $l = mb_strlen($colValue, 'UTF-8');

        if (!isset($columnLength[$colKey])) {
            $columnLength[$colKey] = $l;
            continue;
        }

        if ($l > $columnLength[$colKey]) {
            $columnLength[$colKey] = $l;
        }
    }
}

$maxColumnLength = max(array_keys($columnLength));
$str = '';
$line = '+';

foreach ($array[0] as $colKey => $colValue) {
    $l = $columnLength[$colKey] + 2;
    for ($i = 0; $i < $l; $i++)
        $line .= '-';

    $line .= '+';
}

foreach ($array as $rowKey => $rowColumns) {
    $str .= $line . "\n";

    foreach ($rowColumns as $colKey => $colValue) {
        $l = $columnLength[$colKey] + 1 - mb_strlen($colValue, 'UTF-8');

        $str .= '| '.$colValue;

        for ($i = 0; $i < $l; $i++)
            $str .= ' ';

        if ($maxColumnLength == $colKey) {
            $str .= '|';
        }
    }

    $str .= "\n";
}

$str .= $line;

echo $str . "\n\n";