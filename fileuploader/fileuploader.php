<?php // file uploader.php

function factorial($n) {
    if ($n == 0) {
        return 1;
    }
    return $n * factorial($n - 1);
}

function processNumbers($numbers) {
    $maxSum = 0;
    $bestNumbers = [];

    for ($i = 0; $i < strlen($numbers) - 4; $i++) {
        $sum = 0;
        for ($j = 0; $j < 5; $j++) {
            $sum += intval($numbers[$i + $j]);;
        }

        if ($sum > $maxSum) {
            $maxSum = $sum;
            $bestNumbers = array_map('intval', str_split(substr($numbers, $i, 5)));
        }
    }

    $factorialSum = array_sum(array_map('factorial', $bestNumbers));

    return ['numbers' => $bestNumbers, 'sum' => $factorialSum];
}

function isFileValid($fileContent) {
    $fileContent = str_replace(array("\r", "\n"), '', $fileContent);
    if (strlen($fileContent) !== 1000) {
        echo "<p> File Content not 1000</p>";
        echo "<p> Content is " . strlen($fileContent) . "</p>";
        return false;
    }
    if (!ctype_digit($fileContent)) {
        echo "<p> File Content not all numbers</p>";
        return false;
    }
    return true;
}

echo "<p>Welcome to my PHP Number Manipulator!</p>";

if ($_FILES['filename']['size'] > 0) {
    $name = $_FILES['filename']['name'];
    $name = preg_replace("/[^A-Za-z0-9.]/", "", $name);
    move_uploaded_file($_FILES['filename']['tmp_name'], $name);

    $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if ($fileType != "txt") {
        echo "Sorry, only .txt files are allowed.";
    } else {
        $fileContent = file_get_contents($name);
        
        $isValid = isFileValid($fileContent); 
        echo "<p>File is valid: " . ($isValid ? "true" : "false") . "</p>"; // Debugging statement
    
        if (!$isValid) {
            echo "<p>File is not formatted correctly.</p>";
        } else {
            $result = processNumbers($fileContent);
            echo "<p>" . $result . "</p>";
            echo "<p>The 5 adjacent numbers with the largest sum are: " . implode('', $result['numbers']) . "</p>";
            echo "<p>The sum of the factorial of each term is: " . $result['sum'] . "</p>";
        }
    }
    
}

function tester() {
    $testCases = [
        "12345123451234512345\n67890678906789067890\n12345123451234512345\n67890678906789067890\n12345123451234512345" => [0, 6, 7, 8, 9], // Expected best numbers are five 9's
        "11111111111111111111\n22222222222222222222\n33333333333333333333\n44444444444444444444\n55555555555555555555" => [5, 5, 5, 5, 5], // Expected best numbers are five 5's
        "98765987659876598765\n12345123451234512345\n67890678906789067890\n11111111111111111111\n22222222222222222222" => [9, 8, 7, 6, 5], // Expected best numbers are 9, 8, 7, 6, 5
    ];

    foreach ($testCases as $input => $expected) {
        $result = processNumbers($input);
        if ($result['numbers'] == $expected) {
            echo "Test passed for input: $input<br>";
        } else {
            echo "Test failed for input: $input. Expected " . implode('', $expected) . " but got " . implode('', $result['numbers']) . "<br>";
        }
    }
}

tester();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP Form Upload</title>
</head>
<body>
    <p>Form</p>
    <form method='post' action='fileuploader.php' enctype='multipart/form-data'>
        Select File: <input type='file' name='filename' size='10'>
        <input type='submit' value='Upload'>
    </form>
</body>
</html>
