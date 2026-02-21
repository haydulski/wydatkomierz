<div class="py-4 md:py-8">
    <h1 class="font-semibold text-slate-800">{{ $user->first_name }} {{ $user->last_name }}</h1>
    <x-menu-header userId="{{ $user->id }}" />
    @foreach ($expenses as $key => $month)
        <div class="rounded-md bg-slate-200 bg-opacity-50 my-4 border border-slate-400 p-3 md:p-4"
            wire:loading.class.add="opacity-25">
            <div class="overflow-x-auto">
                @if ($loop->first)
                    @php
                        $dateParts = explode('-', $key);
                    @endphp
                    <h3 class="font-semibold text-lg md:text-2xl">{{ $dateParts[0] . ' ' . translateMonthsToPolish($dateParts[1]) }}
                    </h3>
                @else
                    <h3 class="font-semibold text-lg md:text-2xl">
                        {{ translateMonthsToPolish($month[0]['spent_at']) }}
                    </h3>
                @endif

                {{-- Desktop table view --}}
                <ul class="hidden md:block border-t-2 border-t-slate-300 mt-4 pt-2 text-xs md:text-base">
                    <li>
                        <div class="flex gap-2 justify-between text-left">
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
                            <li wire:key="desktop-{{ $note['id'] }}">
                                <div class="flex gap-2 justify-between py-2">
                                    <p class="w-[20%]">
                                        {{ $note['title'] }}
                                    </p>
                                    <p class="w-[20%] text-right pr-8">
                                        {{ number_format($note['amount'], 2, ',', ' ') }} zł
                                    </p>
                                    <p class="w-[20%]">{{ formatDate($note['spent_at']) }}</p>
                                    <p class="w-[20%]">{{ $note['category']['name'] }}</p>
                                    <div class="w-[20%]">
                                        {{ $note['user']['first_name'] }}
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

                {{-- Mobile card view --}}
                <div class="md:hidden border-t-2 border-t-slate-300 mt-4 pt-2 space-y-3">
                    @foreach ($month as $key => $note)
                        @if (!in_array($key, $additionalValues))
                            <div wire:key="mobile-{{ $note['id'] }}" class="bg-white/30 rounded-md p-3">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="font-semibold text-sm">{{ $note['title'] }}</p>
                                    <p class="font-semibold text-sm whitespace-nowrap ml-2">
                                        {{ number_format($note['amount'], 2, ',', ' ') }} zł
                                    </p>
                                </div>
                                <div class="flex justify-between text-xs text-gray-600">
                                    <span>{{ formatDate($note['spent_at']) }}</span>
                                    <span>{{ $note['category']['name'] }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Zapłacił: {{ $note['user']['first_name'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <p class="border-t-2 border-slate-300 mt-2 pt-2 font-semibold pb-4 xl:pb-0">Suma wydatków:
                    {{ number_format($month['sum'], 2, ',', ' ') }} zł</p>
                @if (isset($month['expensers']))
                    @foreach ($month['expensers'] as $key => $amount)
                        <p class="text-sm md:text-base">{{ $key }}: {{ $amount }} zł</p>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
    <div class="flex gap-2 flex-wrap">
        <button wire:click="prevYear({{ $previousYear }})" class="btn-standard">Poprzedni rok</button>
        <button wire:click="prevYear('now')" class="btn-standard">Obecny rok</button>
    </div>
    <span class="opacity-25"></span>
</div>
