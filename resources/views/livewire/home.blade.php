<div class="mx-auto text-center mt-[10vh] md:mt-[20vh] relative">
    <div class="btn-standard absolute right-2 top-2 sm:right-8 sm:top-8 bg-opacity-25 text-xs xl:text-sm text-gray-200 cursor-pointer"
        wire:click="logout">
        Wyloguj się
    </div>
    <h1 class="uppercase text-black font-bold text-3xl md:text-5xl xl:text-8xl !py-4">
        Wydatkomierz
    </h1>
    <x-heroicon-o-banknotes class="w-16 h-16 md:w-24 md:h-24 text-black mx-auto" />
    <div id="user-panel" class="mt-8 md:mt-16 px-4 sm:px-[15%] md:px-[25%]">
        <h3 class="font-semibold text-xl md:text-2xl">Cześć {{ $user->first_name }}!</h3>
        <p class="text-basic">Twój email: {{ $user->email }}</p>
        <a class="btn-standard mt-8 block" href="{{ route('user.notes') }}">Zobacz wydatki</a>
    </div>
</div>
