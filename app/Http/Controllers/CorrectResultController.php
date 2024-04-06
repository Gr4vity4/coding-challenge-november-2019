<?php

namespace App\Http\Controllers;

use App\Models\CorrectResult;
use Illuminate\Http\Request;

class CorrectResultController extends Controller
{
    private $words = ['HIER', 'GIBT', 'ES', 'NEUES'];

    public function randomNumber($min = 0, $max = 9, $buffer)
    {
        while (true) {
            $random_number = rand($min, $max);

            if (!in_array($random_number, $buffer->all())) {
                $buffer->push($random_number);

                break;
            }
        }

        return $buffer->last();
    }

    public function randomNumberFromList($numbers, $buffer)
    {
        while (true) {
            if (count($numbers) == 1) {
                $randomNumber = $numbers[0];
            } else {
                $randomNumber = $numbers[rand(0, count($numbers) - 1)];
            }

            if (!in_array($randomNumber, $buffer->all())) {
                $buffer->push($randomNumber);

                break;
            }
        }

        return $buffer->last();
    }

    public function calc($maxRound = 10)
    {
        // HIER + GIBT + ES = NEUES
        $found = collect();

        for ($round = 0; $round < $maxRound; $round++) {
            $keepNumbers = collect();

//            $chars = [
//                'H' => $this->randomNumber(1, 9, $keep_numbers),
//                'I' => $this->randomNumber(0, 9, $keep_numbers),
//                'E' => $this->randomNumber(1, 9, $keep_numbers),
//                'R' => $this->randomNumber(0, 9, $keep_numbers),
//                'G' => $this->randomNumber(1, 9, $keep_numbers),
//                'B' => $this->randomNumber(0, 9, $keep_numbers),
//                'T' => $this->randomNumber(0, 9, $keep_numbers),
//                'N' => $this->randomNumber(1, 9, $keep_numbers),
//                'U' => $this->randomNumber(0, 9, $keep_numbers),
//                'S' => $this->randomNumber(0, 9, $keep_numbers)
//            ];

            /* find possible lists number from randomNumber method.
                H = [6, 9]
                I = [3]
                E = [5]
                R = [2, 8]
                G = [6, 9]
                B = [4]
                T = [2, 8]
                N = [1]
                U = [7]
                S = [0]
            */

            $chars = [
                'H' => $this->randomNumberFromList([6, 9], $keepNumbers),
                'I' => $this->randomNumberFromList([3], $keepNumbers),
                'E' => $this->randomNumberFromList([5], $keepNumbers),
                'R' => $this->randomNumberFromList([2, 8], $keepNumbers),
                'G' => $this->randomNumberFromList([6, 9], $keepNumbers),
                'B' => $this->randomNumberFromList([4], $keepNumbers),
                'T' => $this->randomNumberFromList([2, 8], $keepNumbers),
                'N' => $this->randomNumberFromList([1], $keepNumbers),
                'U' => $this->randomNumberFromList([7], $keepNumbers),
                'S' => $this->randomNumberFromList([0], $keepNumbers)
            ];

            $groupNumber = collect();

            foreach ($this->words as $word) {
                $word_number = '';

                foreach (str_split($word) as $char) {
                    $word_number .= $chars[$char];
                }

                $groupNumber->push($word_number);
            }

            $sumLetters = $groupNumber->all()[0] + $groupNumber->all()[1] + $groupNumber->all()[2];
            $result = $groupNumber->all()[3];

            if (strlen($sumLetters) == 5) { // length should be 5 because "NEUES" has 5 length
                if ($sumLetters == $result) {
                    $found->push([
                        'letters' => $chars,
                        'sum_letters' => $sumLetters,
                        'result' => $result,
                        'found_at_round' => $round
                    ]);
//                    echo 'congratulations! at round ' . $round . ' - ' . json_encode($chars) . '<br/>';
                }
            }
        }

        $uniqueLetters = $found->unique(function ($item) {
            return json_encode($item['letters']);
        });

        return $uniqueLetters->values()->toArray();
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
        $maxRound = 10;
        $lists = $this->calc($maxRound);

        foreach ($lists as $list) {
            $prepareData = [
                'letters' =>  json_encode($list['letters']),
                'sum_letters' =>  intval($list['sum_letters']),
                'result' =>  intval($list['result']),
                'found_at_round' =>  $list['found_at_round'],
                'max_round' => $maxRound
            ];

            CorrectResult::create($prepareData);
        }

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
