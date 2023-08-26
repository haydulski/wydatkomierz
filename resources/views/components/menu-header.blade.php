<nav class="px-2 bg-[#cfddd433] p-2 rounded-md">
    <ul class="block md:flex gap-4">
        <li class="main-menu-item">
            <a href="{{ route('home') }}" wire:navigate>Strona główna</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.notes', $attributes['userId']) }}" wire:navigate>Moje wydatki</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.charts', $attributes['userId']) }}">Statystyki</a>
        </li>
        <li class="main-menu-item">
            <a href="{{ route('user.download', $attributes['userId']) }}">Raporty</a>
        </li>
        <li class="main-menu-item hover:bg-orange-400">
            <a href="{{ route('user.notes.new', $attributes['userId']) }}" wire:navigate>Dodaj wydatek</a>
        </li>
    </ul>
</nav>
