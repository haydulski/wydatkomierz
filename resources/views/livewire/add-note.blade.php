<div class="py-4 md:py-8">
    <h1 class="font-semibold">Dodaj nowy wydatek</h1>
    <x-menu-header userId="{{ $user_id }}" />
    <div class="my-6 md:my-12 block"></div>
    <form wire:submit="create" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
        <input type="text" name="title" placeholder="Tytuł/Nazwa" wire:model="title">
        <label for="amount">Kwota
            <input type="number" name="amount" min="0.01" max="100000" step="0.01" wire:model="amount">
        </label>
        <textarea cols="30" rows="4" wire:model="info">Opis</textarea>
        <div class="w-full md:w-[50%] lg:w-[33%]">
            <input type="datetime-local" wire:model="date" max="{{ date('Y-m-d\TH:i', strtotime('now')) }}">
        </div>
        <select wire:model="category_id">
            @foreach ($categories as $cat)
                <option id="{{ $cat->id }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <div class="w-full sm:w-[50%] lg:w-[33%] flex items-center pb-8 gap-3">
            <p class="leading-10">
                Wydatek wspólny
            </p>
            <input type="checkbox" wire:model="is_common" class="!w-auto">
        </div>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200 w-full sm:w-auto">Dodaj</button>
    </form>
</div>
