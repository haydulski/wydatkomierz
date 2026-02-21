<div class="py-4 md:py-8">
    <h1 class="font-semibold text-slate-800">Stałe wydatki</h1>
    <x-menu-header userId="{{ $user->id }}" />

    {{-- Desktop table view --}}
    <ul class="hidden md:block mt-4 pt-2 text-xs md:text-base">
        <li>
            <div
                class="flex gap-2 justify-between [&>p]:font-bold
            text-left [&>p]:w-[21%] [&>p]:text-gray-800 [&>p]:uppercase">
                <p>nazwa</p>
                <p>cena</p>
                <p>częstotliwość</p>
                <p>kategoria</p>
                <p>zarządzaj</p>
            </div>
        </li>
    </ul>
    <div>
        <ul class="hidden md:block mt-4 pt-2 text-xs md:text-base mb-12">
            @foreach ($fees as $key => $fee)
                <li class="py-2">
                    <div class="flex gap-2 justify-between text-left [&>p]:w-[21%] [&>p]:text-gray-600">
                        <p>{{ $fee->title }}</p>
                        <p>{{ $fee->amount }}</p>
                        <p>{{ $fee->type->getName() }}</p>
                        <p>{{ $fee->category->name }}</p>
                        <p>
                            <a href="{{ route('user.fees.edit', ['fee' => $fee->id]) }}"
                                class="btn-standard bg-green-400 cursor-pointer">Edytuj</a>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Mobile card view --}}
    <div class="md:hidden mt-4 space-y-3 mb-12">
        @foreach ($fees as $key => $fee)
            <div class="bg-white/30 rounded-md p-3">
                <div class="flex justify-between items-start mb-1">
                    <p class="font-semibold text-sm">{{ $fee->title }}</p>
                    <p class="font-semibold text-sm whitespace-nowrap ml-2">{{ $fee->amount }} zł</p>
                </div>
                <div class="flex justify-between text-xs text-gray-600 mb-2">
                    <span>{{ $fee->type->getName() }}</span>
                    <span>{{ $fee->category->name }}</span>
                </div>
                <a href="{{ route('user.fees.edit', ['fee' => $fee->id]) }}"
                    class="btn-standard bg-green-400 cursor-pointer inline-block text-xs">Edytuj</a>
            </div>
        @endforeach
    </div>

    <div class="my-8 md:my-12">
        <a class="btn-standard mt-4 md:mt-8" href="{{ route('user.fees.add') }}">Dodaj stały wydatek</a>
    </div>
</div>
