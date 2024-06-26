<x-layout>
    <main>
        <x-admin-navbar />
        <section class="statistics container mx-auto mt-3">
            <div class="stats-cards flex justify-between">
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-user" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">@lang("Total Users")</h1>
                        <p style="font-size: 25px;">{{ $counts["users"] }}</p>
                    </div>
                </div>
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-list" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">@lang("Total Categories")</h1>
                        <p style="font-size: 25px;">{{ $counts["categories"] }}</p>
                    </div>
                </div>
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-person-chalkboard" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">@lang("Total Courses")</h1>
                        <p style="font-size: 25px;">{{ $counts["courses"] }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="charts" class="container mx-auto mt-3 mb-3">
            <div class="main-charts flex justify-between">
                <div class="chart" style="width: 28%;">
                    <h1 class="font-bold">@lang("Most Categories Used")</h1>
                    <canvas class="pie-chart" id="pie-chart"></canvas>
                </div>
                <div class="chart" style="width: 68%;">
                    <h1 class="font-bold">@lang("Most Purchased Courses")</h1>
                    <canvas class="pie-chart" id="pie-chart2"></canvas>
                </div>
            </div>
        </section>
    </main>
    @push("scripts")        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('pie-chart');

            new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($pie_chart["labels"]),
                datasets: [{
                label: '@lang("Total Courses")',
                data: @json($pie_chart["data"]),
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

            const chart2 = document.getElementById('pie-chart2');

            new Chart(chart2, {
            type: 'bar',
            data: {
                labels: @json($bar_graph["labels"]),
                datasets: [{
                label: '@lang("Most Purchased courses")',
                data: @json($bar_graph["data"]),
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
        </script>
    @endpush
</x-layout>