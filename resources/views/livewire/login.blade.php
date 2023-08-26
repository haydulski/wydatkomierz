<div class="py-8">
    <h1 class="font-bold py-8 text-4xl">Zaloguj się do aplikacji</h1>
    <div class="my-12 block"></div>
    <form wire:submit="login" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
        <label>Użytkownik<input type="text" name="user" wire:model="user"></label>
        <label>Hasło<input type="password" name="password" wire:model="password"></label>
        <button type="submit"
            class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200">Zaloguj</button>
    </form>

</div>
