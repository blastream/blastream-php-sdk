<?php

function processSamples($data) {
    $lines = explode("\n", $data);
    $comment = '###'.$lines[1];
    $lines[2] = str_replace('../', './', $lines[2]);
    unset($lines[1]);
    unset($lines[3]);
    return [
        'comment' => $comment,
        'sample' => '```php'."\n".implode("\n", $lines)."\n".'```'
    ];
}

$samples = scandir('./samples');
$examples = [];
foreach($samples as $sample) {
    if($sample != '.' && $sample != '..') {
        $examples[] = processSamples(file_get_contents('./samples/'.$sample));
    }
}

$readme = file_get_contents('./README_TPL.md');

$sampleItems = [];
foreach($examples as $example) {
    $sampleItems[] = "\n\r";
    $sampleItems[] = $example['comment'];
    $sampleItems[] = "\n\r";
    $sampleItems[] = $example['sample'];
}

$readme = str_replace('[SAMPLES]', implode('', $sampleItems), $readme);

file_put_contents('README.md', $readme);
?>