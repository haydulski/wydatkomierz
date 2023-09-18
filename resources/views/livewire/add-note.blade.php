<div class="py-8">
    <h1 class="font-semibold py-8 text-6xl">Dodaj nowy wydatek</h1>
    <x-menu-header userId="{{ $user_id }}" />
    <div class="my-12 block"></div>
    <form wire:submit="create" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
        <input type="text" name="title" placeholder="Tytuł/Nazwa" wire:model="title">
        <label for="amount">Kwota
            <input type="number" name="amount" min="0.01" max="100000" step="0.01" wire:model="amount">
        </label>
        <textarea cols="30" rows="4" wire:model="info">Opis</textarea>
        <div class="w-full lg:w-[33%]">
            <input type="datetime-local" wire:model="date" max="{{ date('Y-m-d\TH:i:s', strtotime('now')) }}">
        </div>
        <select wire:model="category_id">
            @foreach ($categories as $cat)
                <option id="{{ $cat->id }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200">Dodaj</button>
    </form>
</div>
