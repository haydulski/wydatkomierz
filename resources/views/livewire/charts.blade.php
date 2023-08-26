<div class="py-8">
    <h1 class="text-6xl font-semibold py-8">Statystyki</h1>
    <x-menu-header userId="{{ $user->id }}" />
    <div class="mx-auto flex flex-col items-center mt-12">
        <h2 class="text-2xl font-semibold">Wydatki miesięcznie w {{ date('Y') }} roku</h2>
        <canvas id="myChart" class="max-h-[50vw] max-w-[70vw]"></canvas>
    </div>
    <div class="mx-auto flex flex-col items-center mt-48">
        <h2 class="text-2xl font-semibold">Wydatki rocznie w podziale na kategorie</h2>
        <canvas id="yearly-categories" class="max-h-[50vw] max-w-[70vw]"></canvas>
    </div>
    @if (!empty($monthExpensesByCategoryLabels))
        <div class="mx-auto flex flex-col items-center mt-48">
            <h2 class="text-2xl font-semibold">Wydatki w tym miesiącu w podziale na kategorie</h2>
            <canvas id="month-categories" class="max-h-[50vw] max-w-[70vw]"></canvas>
        </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {{ Js::from($totalCurrentYearExpensesByMonthMonths) }},
                datasets: [{
                    label: 'suma w złotych',
                    data: {{ Js::from($totalCurrentYearExpensesByMonthAmounts) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('yearly-categories');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {{ Js::from($yearExpensesByCategoryLabels) }},
                datasets: [{
                    label: 'suma w złotych',
                    data: {{ Js::from($yearExpensesByCategoryValues) }},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });

        const ctx3 = document.getElementById('month-categories');
        if (ctx3) {
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: {{ Js::from($monthExpensesByCategoryLabels) }},
                    datasets: [{
                        label: 'suma w złotych',
                        data: {{ Js::from($monthExpensesByCategoryValues) }},
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        }
    </script>

</div>
