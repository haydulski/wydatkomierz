<div class="py-8">
    <h1 class="font-bold py-8 text-4xl">Edytuj wydatek "{{ $note->title }}"</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="my-12 block"></div>
    <form wire:submit="change" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
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
        <div class="w-full lg:w-[33%] flex">
            <p class="flex-1 leading-10">
                Wydatek wspólny
            </p>
            <input class="flex-1" type="checkbox" wire:model="is_common">

        </div>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200">Zmień</button>
        <a
            href="{{ route('user.notes', $user->id) }}"class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 cursor-pointer">Anuluj</a>
    </form>
</div>
