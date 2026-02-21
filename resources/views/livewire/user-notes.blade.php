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
                            <p class="table-header-active cursor-default hover:text-gray-400">zarządzaj</p>
                        </div>
                    </li>
                    @foreach ($month as $key => $note)
                        @if ($key !== 'sum')
                            <li wire:key="desktop-{{ $note['id'] }}">
                                <div class="flex gap-2 justify-between py-2">
                                    <p class="w-[20%]">
                                        {{ $note['title'] }}
                                        @if ($note['is_common'])
                                            <span
                                                class="text-slate-100 bg-orange-300 p-0.5 text-xs rounded-md">Wspólny</span>
                                        @endif
                                    </p>
                                    <p class="w-[20%] text-right pr-8">
                                        {{ number_format($note['amount'], 2, ',', ' ') }} zł
                                    </p>
                                    <p class="w-[20%]">{{ formatDate($note['spent_at']) }}</p>
                                    <p class="w-[20%]">{{ $note['category']['name'] }}</p>
                                    <div class="w-[20%] flex gap-2">
                                        <a class="px-2 py-1 bg-green-600 hover:bg-green-700 rounded-md text-slate-100 block duration-200"
                                            href="{{ route('user.notes.edit', [$note['id']]) }}">Edytuj</a>
                                        <p class="px-2 py-1 bg-red-600 hover:bg-red-700 text-slate-100 rounded-md cursor-pointer duration-200"
                                            wire:confirm="Na pewno chcesz usunąć?"
                                            wire:click="delete({{ $note['id'] }},{{ $currentYear }})">
                                            Usuń
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

                {{-- Mobile card view --}}
                <div class="md:hidden border-t-2 border-t-slate-300 mt-4 pt-2 space-y-3">
                    @foreach ($month as $key => $note)
                        @if ($key !== 'sum')
                            <div wire:key="mobile-{{ $note['id'] }}" class="bg-white/30 rounded-md p-3">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="font-semibold text-sm">
                                        {{ $note['title'] }}
                                        @if ($note['is_common'])
                                            <span class="text-slate-100 bg-orange-300 p-0.5 text-xs rounded-md">Wspólny</span>
                                        @endif
                                    </p>
                                    <p class="font-semibold text-sm whitespace-nowrap ml-2">
                                        {{ number_format($note['amount'], 2, ',', ' ') }} zł
                                    </p>
                                </div>
                                <div class="flex justify-between text-xs text-gray-600 mb-2">
                                    <span>{{ formatDate($note['spent_at']) }}</span>
                                    <span>{{ $note['category']['name'] }}</span>
                                </div>
                                <div class="flex gap-1.5">
                                    <a class="px-2 py-1 bg-green-600 hover:bg-green-700 rounded text-slate-100 text-[11px] duration-200"
                                        href="{{ route('user.notes.edit', [$note['id']]) }}">Edytuj</a>
                                    <p class="px-2 py-1 bg-red-600 hover:bg-red-700 text-slate-100 rounded text-[11px] cursor-pointer duration-200"
                                        wire:confirm="Na pewno chcesz usunąć?"
                                        wire:click="delete({{ $note['id'] }},{{ $currentYear }})">
                                        Usuń
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <p class="border-t-2 border-slate-300 mt-2 pt-2 font-semibold pb-4 xl:pb-0">Suma wydatków:
                    {{ number_format($month['sum'], 2, ',', ' ') }} zł</p>
            </div>
        </div>
    @endforeach
    <div class="flex gap-2 flex-wrap">
        <button wire:click="prevYear({{ $previousYear }})" class="btn-standard">Poprzedni rok</button>
        <button wire:click="prevYear('now')" class="btn-standard">Obecny rok</button>
    </div>
    <span class="opacity-25"></span>
</div>
