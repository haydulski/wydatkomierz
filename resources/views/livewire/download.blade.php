<div class="py-8">
    <h1 class="text-6xl py-8 font-semibold text-slate-800">Pobierz raport</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="mt-12" wire:loading.class.add="opacity-25">
        <form class="new-note-form">
            <select wire:model.live='raportType'>
                <option default>Wybierz typ</option>
                @foreach ($raportTypes as $key => $raport)
                    <option value="{{ $key }}">{{ $raport }}
                    </option>
                @endforeach
            </select>
        </form>
        <form class="new-note-form">
            <select wire:model.live='fileType'>
                <option default value='xml'>Format dokumentu: xml</option>
                <option value="csv">Format dokumentu: csv</option>
            </select>
        </form>
        @if ($raportType === 1)
            <form class="raport-form mt-12" wire:submit="downloadAnnualRaport">
                <label>Rok
                    <select wire:model="annualRaportYear">
                        <option value="2023" selected>2023</option>
                        <option value="2022">2022</option>
                    </select>
                </label>
                <input type="submit" value="Pobierz"
                    class="py-2 px-4 w-[100px] mb-[1rem] bg-slate-400 max-h-[3rem] mt-auto rounded-md hover:bg-green-600 cursor-pointer">
            </form>
        @endif
        @if ($raportType === 2)
            <form class="raport-form mt-12" wire:submit="downloadMonthRaport">
                <label>Rok
                    <select wire:model="year">
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                </label>
                <label>Miesiąc
                    <select wire:model="month">
                        @foreach ($months as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </label>
                <input type="submit" value="Pobierz"
                    class="py-2 px-4 w-[100px] mb-[1rem] bg-slate-400 max-h-[3rem] mt-auto rounded-md hover:bg-green-600 cursor-pointer">
            </form>
        @endif
        @if ($raportType === 3)
            <form class="raport-form mt-12" wire:submit="downloadAllYearsRaport">
                <input type="submit" value="Pobierz raport za wszystkie lata"
                    class="py-2 px-4 mb-[1rem] bg-slate-400 max-h-[3rem] mt-auto rounded-md hover:bg-green-600 cursor-pointer">
            </form>
        @endif
    </div>
</div>
