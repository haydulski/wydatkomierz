<div class="mx-auto text-center mt-[20vh]">
    <div class="absolute btn-standard right-8 top-8 bg-opacity-25 text-xs xl:text-sm text-gray-200 cursor-pointer"
        wire:click="logout">
        Wyloguj się z aplikacji
    </div>
    <h1 class="uppercase text-black font-bold md:text-2xl xl:text-8xl">
        Wydatkomierz
    </h1>
    <x-heroicon-o-banknotes class="w-24 h-24 text-black mx-auto" />
    <div id="user-panel" class="mt-16 px-[25%]">
        <h3 class="font-semibold text-2xl">Cześć {{ $user->first_name }}!</h3>
        <p class="text-basic">Twój email: {{ $user->email }}</p>
        <a class="btn-standard mt-8 block" href="{{ route('user.notes') }}">Zobacz wydatki</a>
    </div>
</div>
