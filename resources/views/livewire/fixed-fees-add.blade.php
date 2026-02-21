<div class="py-4 md:py-8">
    <h1 class="font-bold">Dodaj stały wydatek</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="my-6 md:my-12 block"></div>
    <form wire:submit="create" class="p-4 border-2 border-gray-400 rounded-md new-note-form max-w-2xl">
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
        <div class="flex flex-col sm:flex-row gap-2 mt-4">
            <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 w-full sm:w-auto">Dodaj</button>
            <a href="{{ route('user.fees') }}"
                class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 cursor-pointer text-center w-full sm:w-auto">
                Anuluj
            </a>
        </div>
    </form>
</div>
