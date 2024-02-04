<div class="py-8">
    <h1 class="font-bold py-8 text-4xl">Dodaj stały wydatek</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="my-12 block"></div>
    <form wire:submit="create" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
        <label>Tytuł
            <input type="text" name="title" placeholder="Tytuł płatności" wire:model="title"></label>
        <label>Cena
            <input type="number" name="amount" min="0.01" max="100000" step="0.01"
                wire:model="amount"></label>
        <label>Kategoria
            <select wire:model="category_id">
                @foreach ($categories as $cat)
                    <option id="{{ $cat->id }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select></label>
        <label>Częstotliwość opłaty
            <select wire:model="type">
                @foreach ($types as $type)
                    <option id="{{ $type->value }}" value="{{ $type->value }}">{{ $type->getName() }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200">Dodaj</button>
        <a href="{{ route('user.fees') }}"
            class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 cursor-pointer">
            Anuluj
        </a>
    </form>
</div>
