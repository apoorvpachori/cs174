<?php
function isPerfectNumber($num)
{
    $divisors = [];
    for ($i = 1; $i <= $num / 2; $i++) {
        if ($num % $i == 0) {
            $divisors[] = $i;
        }
    }

    $sum = array_sum($divisors);
    if ($sum == $num) {
        return "Yes, this is a perfect number. Proof: " . implode('+', $divisors) . " = $num";
    } else {
        return "No, this is not a perfect number. Proof: " . implode('+', $divisors) . " != $num";
    }
}

function testIsPerfectNumber()
{
    $testCases = [6, 3, 28, 12];
    foreach ($testCases as $testCase) {
        echo "Testing number $testCase: " . isPerfectNumber($testCase) . "\n";
    }
}

// Run the tester function
testIsPerfectNumber();

?>