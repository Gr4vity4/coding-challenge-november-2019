<?php

namespace App\Http\Controllers;

use App\Models\CorrectResult;
use Illuminate\Http\Request;

class CorrectResultController extends Controller
{
    function convertStringToNumber($string, $mapping)
    {
        $result = "";
        for ($i = 0; $i < strlen($string); $i++) {
            // Append the corresponding number to the result string
            $result .= $mapping[$string[$i]];
        }
        // Convert the result string to integer
        return (int)$result;
    }

    function firstCharNotZeroMapping($input, $data)
    {
        if (isset($input[0]) && array_key_exists($input[0], $data) && $data[$input[0]] === "0") {
            return false; // The first character maps to 0, not good.
        }

        return true; // The first character does not map to 0, good.
    }

    private function findMatch($data)
    {
        // dump($data);

        // Flag to keep track of whether a match has been found
        $found = false;

        // Counter for the number of attempts
        $attempts = 0;

        // Start the search for the correct assignment of letters to numbers that matches the target sum
        while (!$found) {
            $attempts++;

            $first = rand(0, 9) * 1000 + rand(0, 9) * 100 + rand(0, 9) * 10 + rand(0, 9);
            $second = rand(0, 9) * 1000 + rand(0, 9) * 100 + rand(0, 9) * 10 + rand(0, 9);
            $last = rand(0, 9) * 10 + rand(0, 9);
            $currentSum = $first + $second + $last;

            // Check if the current sum matches the target sum
            if ($currentSum == $data['sum']) {
                $found = true;
                // dump($first, $second, $last, $currentSum);
                // echo "Found a match after {$attempts} attempts:\n";
            }
        }

        return (object)['attempts' => $attempts, 'first' => $first, 'second' => $second, 'last' => $last, 'currentSum' => $currentSum];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $correctResults = CorrectResult::latest()->paginate(5);

        return view('home')->with('correctResults', $correctResults);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Extract the mapping and inputs
        $mapping = array_slice($request->all(), 1, 10); // Extracting only the letter-to-number mappings
        $firstInput = $request->first_input;
        $secondInput = $request->second_input;
        $thirdInput = $request->third_input;

        // * validate numbers
        // Count the occurrences of each value
        $valueCounts = array_count_values($mapping);

        // Filter out the values that appear more than once
        $duplicates = array_filter($valueCounts, function ($count) {
            return $count > 1;
        });

        // Checking if there are any duplicates
        if (!empty($duplicates)) {
            return redirect()->back()->with('error', 'The numbers must be unique!')
                ->withInput();
        }

        // * validate first char not zero
        // Check the first character of each input
        $validFirstInput = $this->firstCharNotZeroMapping($firstInput, $request->all());
        $validSecondInput = $this->firstCharNotZeroMapping($secondInput, $request->all());
        $validThirdInput = $this->firstCharNotZeroMapping($thirdInput, $request->all());

        if (!$validFirstInput || !$validSecondInput || !$validThirdInput) {
            return redirect()->back()->with('error', 'The first character of each input must not map to 0!')->withInput();
        }

        // Convert and display the results
        $firstResult = $this->convertStringToNumber($firstInput, $mapping);
        $secondResult = $this->convertStringToNumber($secondInput, $mapping);
        $thirdResult = $this->convertStringToNumber($thirdInput, $mapping);

        // Sum the converted numbers
        $sum = $firstResult + $secondResult + $thirdResult;

        // echo "First input ($firstInput) converted to number: $firstResult\n";
        // echo "Second input ($secondInput) converted to number: $secondResult\n";
        // echo "Third input ($thirdInput) converted to number: $thirdResult\n";

        $result = $this->findMatch(['sum' => $sum]);

        CorrectResult::create([
            'letters_mapping' => json_encode($mapping),
            'first_input' => $firstInput,
            'second_input' => $secondInput,
            'third_input' => $thirdInput,
            'sum_input' => $sum,
            'query_first_input' => $result->first,
            'query_second_input' => $result->second,
            'query_third_input' => $result->last,
            'query_sum' => $result->currentSum,
            'attempts' => $result->attempts,
        ]);

        $correctResults = CorrectResult::latest()->paginate(5);

        return redirect()->back()->with('success', 'The correct result has been saved successfully!')
            ->with('correctResults', $correctResults);
    }

    /**
     * Display the specified resource.
     */
    public function show(CorrectResult $correctResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CorrectResult $correctResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CorrectResult $correctResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CorrectResult $correctResult)
    {
        //
    }
}
