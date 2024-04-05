@extends('layouts.app')
@section('content')
    @php
        // Initialize letters and numbers
        $letters = ['H', 'I', 'E', 'R', 'G', 'B', 'T', 'S', 'N', 'U'];
        $numbers = ['9', '8', '7', '6', '5', '4', '3', '2', '1', '0'];
        //H=9;I=8;E=7;R=6;G=5;B=4;T=3;S=2;N=1;U=0
    @endphp

    <div id="popupMessage"
         class="fixed top-5 right-5 z-50 bg-green-500 text-white text-sm font-medium px-4 py-3 rounded-md"
         role="alert" style="display: none;">
        <p>This is your popup message!</p>
    </div>

    <div id="popupErrorMessage"
         class="fixed top-5 right-5 z-50 bg-red-500 text-white text-sm font-medium px-4 py-3 rounded-md"
         role="alert" style="display: none;">
        <p>This is your popup message!</p>
    </div>

    <form action="{{ route('correct-results.store') }}" method="POST" class="grid grid-cols-1 gap-10">
        @csrf
        <div>
        <span class="font-bold">Instructions : <a class="text-blue-600"
                                                  href="https://www.data-horizon.com/en/coding-challenge-november-2019/"
                                                  target="_blank">https://www.data-horizon.com/en/coding-challenge-november-2019/</a></span>
        </div>

        <div class="w-full md:w-3/4 mx-auto grid grid-cols-1 gap-10">
            <div>
                <h1 class="text-2xl font-bold">Fill in the numbers for the letters</h1>
                <small class="text-red-500">the 10 different letters have to be 10 different digits</small>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($letters as $index => $letter)
                    <div class="flex items-center gap-2">
                        <span class="text-center w-10">{{ $letter }}</span>
                        <input type="number" class="w-full border p-2" min="0" max="9" placeholder="Fill in the number"
                               name="{{ $letters[$index] }}"
                               value="{{ old($letters[$index]) ? old($letters[$index]) : $numbers[$index] }}">
                    </div>
                @endforeach
            </div>
        </div>

        <hr>

        <div class="w-full md:w-3/4 mx-auto grid grid-cols-1 md:grid-cols-5 gap-4">
            <h1 class="text-2xl font-bold col-span-full">Fill in the numbers for the letters</h1>
            <span class="text-red-500 col-span-full" style="display: none" id="msg-warning">* Character not in the
            list.</span>
            <div class="flex flex-col">
                <input type="text" name="first_input" class="lettersInput border p-4" maxlength="4"
                       value="{{old('first_input') ? old('first_input') : 'HIER'}}"
                       placeholder="letters" required>
            </div>
            <span class="flex justify-center items-center">
            +
        </span>
            <div class="flex flex-col">
                <input type="text" name="second_input" class="lettersInput border p-4" maxlength="4"
                       value="{{ old('second_input') ? old('second_input') : 'GIBT' }}"
                       placeholder="letters" required>
            </div>
            <span class="flex justify-center items-center">
            +
        </span>
            <div class="flex flex-col">
                <input type="text" name="third_input" class="lettersInput border p-4" maxlength="4"
                       value="{{ old('third_input') ? old('third_input') : 'ES' }}"
                       placeholder="letters" required>
            </div>
            <div class="col-span-full text-center mt-8">
                <button class="bg-green-500 hover:bg-green-600 w-32 h-10 text-white rounded-md">Submit</button>
            </div>
        </div>

        <hr>

        <div class="w-full md:w-3/4 mx-auto">
            <h1 class="text-2xl font-bold">Correct Result ({{ $correctResults->total() }})</h1>
            <div class="grid grid-cols-1 gap-6 mt-8">
                @foreach ($correctResults as $correctResult)
                    <div class="flex flex-col shadow-lg min-h-24 p-8">
                        <div class="flex flex-col gap-2">
                            <span class="text-sm text-gray-400">Created At {{$correctResult->created_at}}</span>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Letters Mapping</span>
                                <span>{{ $correctResult->letters_mapping }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>First Input</span>
                                <span>{{ $correctResult->first_input }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Second Input</span>
                                <span>{{ $correctResult->second_input }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Third Input</span>
                                <span>{{ $correctResult->third_input }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Sum Input</span>
                                <span>{{ $correctResult->sum_input }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Query First Input</span>
                                <span>{{ $correctResult->query_first_input }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Query Second Input</span>
                                <span>{{ $correctResult->query_second_input }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Query Third Input</span>
                                <span>{{ $correctResult->query_third_input }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Query Sum</span>
                                <span>{{ $correctResult->query_sum }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Attempts</span>
                                <span>{{ $correctResult->attempts }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $correctResults->links() }}
            </div>
        </div>


    </form>
@endsection
@section('scripts')
    <script>
        console.log('> home.blade.php script loaded')

        @if (session('success'))
        document.getElementById('popupMessage').style.display = 'block';
        document.getElementById('popupMessage').innerHTML = '<p>{{ session('success') }}</p>';
        setTimeout(() => {
            document.getElementById('popupMessage').style.display = 'none';
        }, 3000);
        @endif

        @if (session('error'))
        document.getElementById('popupErrorMessage').style.display = 'block';
        document.getElementById('popupErrorMessage').innerHTML = '<p>{{ session('error') }}</p>';
        setTimeout(() => {
            document.getElementById('popupErrorMessage').style.display = 'none';
        }, 3000);
        @endif

        // Define allowed characters
        const allowedChars = ['H', 'I', 'E', 'R', 'G', 'B', 'T', 'S', 'N', 'U'];

        // Get all input elements with the class 'lettersInput'
        const inputElements = document.querySelectorAll('.lettersInput');

        // Function to enforce character restrictions
        function enforceCharRestrictions(event) {
            // console.log('> enforceCharRestrictions', event)

            // Get current value of input
            const currentValue = event.target.value.toUpperCase();

            // Filter out characters not in allowedChars
            const filteredValue = Array.from(currentValue).filter(char => allowedChars.includes(char)).join('');

            // Update input value if necessary
            if (currentValue !== filteredValue) {
                event.target.value = filteredValue; // empty string if no characters are allowed
                document.getElementById('msg-warning').style.display = 'block';
            } else {
                event.target.value = filteredValue;
                document.getElementById('msg-warning').style.display = 'none';
            }
        }

        // Add event listener for input event on each input element
        inputElements.forEach(inputElement => {
            inputElement.addEventListener('input', enforceCharRestrictions);
        });
    </script>
@endsection
