@extends('layouts.app')
@section('content')
    <div id="popupMessage"
         class="fixed top-5 right-5 z-50 bg-green-500 text-white text-sm font-medium px-4 py-3 rounded-md"
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


        <div class="w-full md:w-3/4 mx-auto grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="col-span-full text-center mt-8">
                <button class="bg-green-500 hover:bg-green-600 w-32 h-10 text-white rounded-md">Click Me!</button>
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
                                <span>Letters</span>
                                <span>{{ $correctResult->letters }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Sum letters</span>
                                <span>{{ $correctResult->sum_letters }}</span>
                            </div>
                            <div class="flex justify-between bg-orange-100 px-3 py-1">
                                <span>Result</span>
                                <span>{{ $correctResult->result }}</span>
                            </div>
                            <div class="flex justify-between bg-green-100 px-3 py-1">
                                <span>Found at round</span>
                                <div class="flex justify-end">
                                    <span>{{ $correctResult->found_at_round }}</span>/<span>{{ $correctResult->max_round }}</span>
                                </div>
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
    </script>
@endsection
