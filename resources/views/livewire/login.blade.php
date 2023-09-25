<div class="py-8">
    <h1 class="font-bold py-8 text-4xl">Zaloguj się do aplikacji</h1>
    <div class="my-12 block">
    </div>
    <form wire:submit="login" class="p-4 border-2 border-gray-400 rounded-md new-note-form">
        <label>Twój email<input type="text" name="email" wire:model="email">
            <div>
                @error('email')
                    <p class="text-sm text-red-500 mt-[-1rem]">{{ $message }}</p>
                @enderror
            </div>
        </label>
        <label>Hasło<input type="password" name="password" wire:model="password">
            <div>
                @error('password')
                    <p class="text-sm text-red-500 mt-[-1rem] mb-4">{{ $message }}</p>
                @enderror
            </div>
        </label>
        <button type="submit"
            class="px-4 py-2 rounded-md bg-green-600 hover:bg-orange-600 duration-200">Zaloguj</button>
    </form>

</div>
