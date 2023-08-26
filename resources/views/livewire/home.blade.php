<div class="mx-auto text-center mt-[20vh]">
    <div class="absolute btn-standard right-8 top-8 bg-opacity-25 text-xs xl:text-sm text-gray-200 cursor-pointer"
        wire:click="logout">
        Wyloguj się z aplikacji
    </div>
    <h1 class="uppercase text-black font-bold md:text-2xl xl:text-8xl">
        Wydatkomierz
    </h1>
    <x-heroicon-o-banknotes class="w-24 h-24 text-black mx-auto" />
    <div id="choice-user" class="mt-16 px-[25%]">
        <ul class="block xl:flex gap-4">
            @foreach ($users as $user)
                <li wire:key="{{ $user->id }}" wire:click="showUser({{ $user->id }})"
                    class="text-center p-4 border-2 border-teal-600 hover:border-teal-300 rounded-full w-[150px]
                     h-[150px] cursor-pointer group mb-4 xl:mb-0">
                    <x-heroicon-o-finger-print class="w-8 h-8 text-teal-600 mx-auto" />
                    <p class="text-black group-hover:text-teal-300 font-semibold text-basic xl:text-4xl">
                        {{ $user->first_name }}</p>
                </li>
            @endforeach
            {{-- <li
                class="text-center p-4 border-2 border-teal-600 hover:border-teal-300 rounded-full w-[150px] h-[150px] cursor-pointer group flex align-center">
                <x-heroicon-o-plus class="w-8 h-8 text-teal-600 m-auto group-hover:text-teal-300" />
            </li> --}}
        </ul>
    </div>
</div>
