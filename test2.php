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

$str = '';
foreach ($array as $rowKey => $rowColumns) {
    $line = '';
    $line .= '+';

    foreach ($rowColumns as $colKey => $colValue) {
        $l = $columnLength[$colKey] + 2;
        for ($i = 0; $i < $l; $i++)
            $line .= '-';

        $line .= '+';
    }

    $str .= $line . "\n";

    foreach ($rowColumns as $colKey => $colValue) {
        $l = $columnLength[$colKey] + 1 - mb_strlen($colValue, 'UTF-8');

        $str .= '| '.$colValue;

        for ($i = 0; $i < $l; $i++)
            $str .= ' ';

        if (max(array_keys($columnLength)) == $colKey) {
            $str .= '|';
        }
    }

    $str .= "\n";
}

$str .= $line;

echo $str . "\n\n";