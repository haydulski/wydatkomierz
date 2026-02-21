<nav class="bg-[#cfddd433] py-2 px-2 rounded-md">
    <ul class="grid grid-cols-2 sm:grid-cols-3 md:flex gap-2 md:gap-4">
        <li class="main-menu-item">
            <a href="{{ route('home') }}" wire:navigate>Strona główna</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.notes') }}" wire:navigate>Moje wydatki</a>
        </li>
        <li class="main-menu-item hover:bg-orange-400">
            <a href="{{ route('user.fees') }}" wire:navigate>Stałe wydatki</a>
        </li>
        <li class="main-menu-item hover:bg-orange-400">
            <a href="{{ route('user.notes.common') }}" wire:navigate>Wspólne wydatki</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.charts', ['yearString' => date('Y')]) }}">Statystyki</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.download') }}">Raporty</a>
        </li>
        <li class="main-menu-item hover:bg-orange-400 col-span-2 sm:col-span-1">
            <a href="{{ route('user.notes.new') }}" wire:navigate>Dodaj wydatek</a>
        </li>
    </ul>
</nav>
