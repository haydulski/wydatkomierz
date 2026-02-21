<div class="py-4 md:py-8">
    <h1 class="font-bold">Edytuj wydatek "{{ $note->title }}"</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="my-6 md:my-12 block"></div>
    <form wire:submit="change" class="p-4 border-2 border-gray-400 rounded-md new-note-form max-w-2xl">
        <label>Tytuł
            <input type="text" name="title" placeholder="{{ $note->title }}" wire:model="title"></label>
        <label>Cena
            <input type="number" name="amount" min="0.01" max="100000" step="0.01"
                wire:model="amount"></label>
        <label>Opis
            <textarea cols="30" rows="2" wire:model="info">Opis</textarea>
        </label>
        <label>Kategoria
            <select wire:model="category_id">
                @foreach ($categories as $cat)
                    <option id="{{ $cat->id }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select></label>
        <div class="w-full sm:w-[50%] lg:w-[33%] flex items-center gap-3">
            <p class="leading-10">
                Wydatek wspólny
            </p>
            <input type="checkbox" wire:model="is_common" class="!w-auto">
        </div>
        <div class="flex flex-col sm:flex-row gap-2 mt-4">
            <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 w-full sm:w-auto">Zmień</button>
            <a href="{{ route('user.notes', $user->id) }}"
                class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 cursor-pointer text-center w-full sm:w-auto">Anuluj</a>
        </div>
    </form>
</div>
