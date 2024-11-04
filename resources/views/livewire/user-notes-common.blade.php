<div class="py-8">
    <h1 class="text-xl xl:text-6xl py-8 font-semibold text-slate-800">{{ $user->first_name }} {{ $user->last_name }}</h1>
    <x-menu-header userId="{{ $user->id }}" />
    @foreach ($expenses as $key => $month)
        <div class="rounded-md bg-slate-200 bg-opacity-50 my-4 border border-slate-400 p-4"
            wire:loading.class.add="opacity-25">
            <div class="overflow-x-auto">
                @if ($loop->first)
                    @php
                        $dateParts = explode('-', $key);
                    @endphp
                    <h3 class="font-semibold text-2xl">{{ $dateParts[0] . ' ' . translateMonthsToPolish($dateParts[1]) }}
                    </h3>
                @else
                    <h3 class="font-semibold text-2xl">
                        {{ translateMonthsToPolish($month[0]['spent_at']) }}
                    </h3>
                @endif
                <ul class="border-t-2 border-t-slate-300 mt-4 pt-2 text-xs md:text-base min-w-[600px]">
                    <li>
                        <div class="flex gap-2 justify-between text-left child: ">
                            <p class="table-header-active" wire:click="groupBy('title', {{ $currentYear }})">
                                nazwa
                            </p>
                            <p class="table-header-active text-right pr-8"
                                wire:click="groupBy('amount', {{ $currentYear }})">
                                cena
                            </p>
                            <p class="table-header-active" wire:click="groupBy('spent_at', {{ $currentYear }})">
                                data
                            </p>
                            <p class="table-header-active" wire:click="groupBy('category_id', {{ $currentYear }})">
                                kategoria
                            </p>
                            <p class="table-header-active cursor-default hover:text-gray-400">kto zapłacił</p>
                        </div>
                    </li>
                    @foreach ($month as $key => $note)
                        @if (!in_array($key, $additionalValues))
                            <li wire:key="{{ $note['id'] }}">
                                <div class="flex gap-2 justify-between py-2">
                                    <p class="w-[20%]">
                                        {{ $note['title'] }}
                                    </p>
                                    <p class="w-[20%] text-right pr-8">
                                        {{ number_format($note['amount'], 2, ',', ' ') }} zł
                                    </p>
                                    <p class="w-[20%]">{{ formatDate($note['spent_at']) }}</p>
                                    <p class="w-[20%]">{{ $note['category']['name'] }}</p>
                                    <div class="w-[20%] block md:flex gap-2">
                                        {{ $note['user']['first_name'] }}
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <p class="border-t-2 border-slate-300 mt-2 font-semibold pb-4 xl:pb-0">Suma wydatków:
                    {{ number_format($month['sum'], 2, ',', ' ') }} zł</p>
                @if (isset($month['expensers']))
                    @foreach ($month['expensers'] as $key => $amount)
                        <p>{{ $key }}: {{ $amount }} zł</p>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
    <button wire:click="prevYear({{ $previousYear }})" class="btn-standard">Poprzedni rok</button>
    <button wire:click="prevYear('now')" class="btn-standard">Obecny rok</button>
    <span class="opacity-25"></span>
</div>
