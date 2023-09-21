<?php

class PrimeCalculator
{

    /**
     * Check if a number is prime
     * 
     * @param int $num
     * @return bool
     */
    private function isPrime($num)
    {
        if ($num <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * Computes and prints all the prime numbers between two numbers
     * 
     * @param int $a
     * @param int $b
     * @return string
     */
    public function primesInRange($a, $b)
    {
        $primes = [];
        for ($i = $a; $i <= $b; $i++) {
            if ($this->isPrime($i)) {
                $primes[] = $i;
            }
        }
        $output = implode(", ", $primes);
        echo $output . "\n";
        return $output;
    }

    /**
     * Tester method for primesInRange
     */
    public function testPrimesInRange()
    {
        $testCases = [
            [5, 10, "5, 7"],
            [1, 4, "2, 3"],
            [1, 12, "2, 3, 5, 7, 11"],
            [1, 1, ""]
        ];

        foreach ($testCases as $testCase) {
            $output = $this->primesInRange($testCase[0], $testCase[1]);
            if ($output == $testCase[2]) {
                echo "Test for range {$testCase[0]} to {$testCase[1]} passed!\n";
            } else {
                echo "Test for range {$testCase[0]} to {$testCase[1]} failed. Expected {$testCase[2]} but got $output\n";
            }
            echo "<br>";
        }
    }
}

// Create an instance of the class and run the tester method
$primeCalculator = new PrimeCalculator();
$primeCalculator->testPrimesInRange();

?>