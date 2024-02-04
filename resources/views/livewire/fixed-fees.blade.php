<div class="py-8">
    <h1 class="text-xl xl:text-6xl py-8 font-semibold text-slate-800">Stałe wydatki</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <ul class="mt-4 pt-2 text-xs md:text-base min-w-[600px]">
        <li>
            <div
                class="flex gap-2 justify-between [&>p]:font-bold
            text-left [&>p]:w-[21%] [&>p]:text-gray-800 [&>p]:uppercase">
                <p>
                    nazwa
                </p>
                <p>
                    cena
                </p>
                <p>
                    częstotliwość
                </p>
                <p>
                    kategoria
                </p>
                <p>zarządzaj</p>
            </div>
        </li>
    </ul>
    <div>
        <ul class="mt-4 pt-2 text-xs md:text-base min-w-[600px] mb-12">
            @foreach ($fees as $key => $fee)
                <li class="py-2">
                    <div class="flex gap-2 justify-between text-left [&>p]:w-[21%] [&>p]:text-gray-600">
                        <p>
                            {{ $fee->title }}
                        </p>
                        <p>
                            {{ $fee->amount }}
                        </p>
                        <p>
                            {{ $fee->type->getName() }}
                        </p>
                        <p>
                            {{ $fee->category->name }}
                        </p>
                        <p>
                            <a href="{{ route('user.fees.edit', ['fee' => $fee->id]) }}"
                                class="btn-standard bg-green-400 cursor-pointer">Edytuj</a>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="my-12">
        <a class="btn-standard mt-8" href="{{ route('user.fees.add') }}">Dodaj stały wydatek</a>
    </div>
</div>
