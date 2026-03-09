@extends('layouts.app')

@section('title', 'Dashboard — NexaDash')

@section('page_title', 'Dashboard')

@section('content')
  @php
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
      $greeting = 'Selamat pagi';
    } elseif ($hour >= 12 && $hour < 15) {
      $greeting = 'Selamat siang';
    } elseif ($hour >= 15 && $hour < 18) {
      $greeting = 'Selamat sore';
    } else {
      $greeting = 'Selamat malam';
    }
  @endphp

  <div class="animate-fade-up mb-6">
    <h1 class="text-[22px] font-extrabold text-text tracking-[-0.03em]">{{ $greeting }},
      {{ explode(' ', auth()->user()->name)[0] }} 👋
    </h1>
    <p class="text-muted text-[14px] mt-1">Berikut adalah apa yang terjadi dengan platform Anda hari
      ini.</p>
  </div>

  <!-- Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Users -->
    <div class="card p-5 flex items-center gap-4">
      <div class="w-12 h-12 rounded-2xl bg-brand-light flex items-center justify-center shrink-0">
        <iconify-icon icon="solar:users-group-two-rounded-bold-duotone" width="24" height="24"
          class="text-brand"></iconify-icon>
      </div>
      <div class="min-w-0">
        <div class="text-[22px] font-extrabold text-text leading-tight">24,521</div>
        <div class="text-[13px] text-muted font-medium">Total Pengguna</div>
      </div>
    </div>

    <!-- Revenue -->
    <div class="card p-5 flex items-center gap-4">
      <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center shrink-0">
        <iconify-icon icon="solar:wad-of-money-bold-duotone" width="24" height="24" class="text-green-500"></iconify-icon>
      </div>
      <div class="min-w-0">
        <div class="text-[22px] font-extrabold text-text leading-tight">$48,290</div>
        <div class="text-[13px] text-muted font-medium">Pendapatan</div>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="card p-5 flex items-center gap-4">
      <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center shrink-0">
        <iconify-icon icon="solar:cart-large-2-bold-duotone" width="24" height="24" class="text-amber-500"></iconify-icon>
      </div>
      <div class="min-w-0">
        <div class="text-[22px] font-extrabold text-text leading-tight">1,893</div>
        <div class="text-[13px] text-muted font-medium">Total Pesanan</div>
      </div>
    </div>

    <!-- Uptime -->
    <div class="card p-5 flex items-center gap-4">
      <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center shrink-0">
        <iconify-icon icon="solar:pulse-bold-duotone" width="24" height="24" class="text-indigo-500"></iconify-icon>
      </div>
      <div class="min-w-0">
        <div class="text-[22px] font-extrabold text-text leading-tight">99.9%</div>
        <div class="text-[13px] text-muted font-medium">Sistem Aktif</div>
      </div>
    </div>
  </div>

  <!-- Main Grid Row -->
  <div class="grid grid-cols-12 gap-5 mb-5">
    <!-- Revenue Overview -->
    <div class="col-span-12 lg:col-span-8">
      <div class="card p-6 h-full">
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
          <div>
            <div class="text-[16px] font-bold text-text">Ikhtisar Pendapatan</div>
            <div class="text-[12px] text-muted mt-0.5">Metrik performa 7 bulan terakhir</div>
          </div>
          <select class="form-input w-auto min-w-[120px] p-[8px_14px] text-[12px] h-9">
            <option>Bulanan</option>
            <option>Mingguan</option>
          </select>
        </div>
        <div class="relative w-full overflow-hidden">
          <div id="revenueChart" class="min-h-[200px]"></div>
        </div>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-span-12 lg:col-span-4">
      <div class="card p-6 h-full">
        <div class="text-[16px] font-bold text-text mb-6">Aktivitas Terbaru</div>
        <div class="flex flex-col gap-5">
          @forelse($recentActivities as $activity)
            <div class="flex gap-3.5 items-start group">
              <div
                class="w-9 h-9 bg-bg text-brand text-[11px] font-bold flex items-center justify-center rounded-2xl shrink-0 group-hover:bg-brand-light transition-colors border border-border">
                {{ $activity->causer ? substr($activity->causer->name, 0, 1) : 'S' }}
              </div>
              <div class="min-w-0">
                <p class="text-[13.5px] text-text font-semibold leading-snug">
                  @if($activity->causer)
                    {{ explode(' ', $activity->causer->name)[0] }}
                  @else
                    System
                  @endif
                  <span class="text-muted font-medium">{{ $activity->description }}</span>
                </p>
                <p class="text-[11px] text-muted-light mt-1 flex items-center gap-1">
                  <iconify-icon icon="solar:clock-circle-linear" width="12" height="12"></iconify-icon>
                  {{ $activity->created_at->diffForHumans() }}
                </p>
              </div>
            </div>
          @empty
            <div class="flex flex-col items-center justify-center py-10 text-center">
              <iconify-icon icon="solar:history-linear" width="40" height="40" class="text-border mb-3"></iconify-icon>
              <p class="text-[13px] text-muted-light">Belum ada aktivitas baru</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Social & Growth Row -->
  <div class="grid grid-cols-12 gap-5">
    <!-- Traffic Sources -->
    <div class="col-span-12 lg:col-span-5">
      <div class="card p-6">
        <div class="mb-2">
          <div class="text-[16px] font-bold text-text">Sumber Lalu Lintas</div>
          <div class="text-[12px] text-muted mt-0.5">Rincian saluran akuisisi utama</div>
        </div>
        <div class="relative w-full overflow-hidden">
          <div id="donutChart" class="min-h-[240px]"></div>
        </div>
        <div class="grid grid-cols-2 gap-3 mt-4">
          @php
            $sources = [
              ['label' => 'Organik', 'pct' => '42%', 'color' => 'bg-brand'],
              ['label' => 'Langsung', 'pct' => '28%', 'color' => 'bg-brand-mid'],
              ['label' => 'Referal', 'pct' => '18%', 'color' => 'bg-[#10b981]'],
              ['label' => 'Sosial', 'pct' => '12%', 'color' => 'bg-[#6ee7b7]'],
            ];
          @endphp
          @foreach($sources as $source)
            <div class="flex items-center gap-2 p-2 rounded-xl border border-border bg-bg/50">
              <span class="w-2.5 h-2.5 rounded-full {{ $source['color'] }} shrink-0"></span>
              <span class="text-[12px] text-muted font-medium">{{ $source['label'] }}</span>
              <span class="text-[12px] font-bold text-text ml-auto">{{ $source['pct'] }}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- User Growth -->
    <div class="col-span-12 lg:col-span-7">
      <div class="card p-6">
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
          <div>
            <div class="text-[16px] font-bold text-text">Pertumbuhan Pengguna</div>
            <div class="text-[12px] text-muted mt-0.5">Data 12 bulan terakhir</div>
          </div>
          <div class="flex gap-4 p-1.5 bg-bg rounded-xl border border-border">
            <div class="flex items-center gap-1.5 px-1.5">
              <span class="w-2 h-2 rounded-full bg-brand"></span>
              <span class="text-[11px] font-bold text-text uppercase tracking-wider">Baru</span>
            </div>
            <div class="flex items-center gap-1.5 px-1.5 opacity-50">
              <span class="w-2 h-2 rounded-full bg-brand-mid"></span>
              <span class="text-[11px] font-bold text-text uppercase tracking-wider">Lama</span>
            </div>
          </div>
        </div>
        <div class="relative w-full overflow-hidden">
          <div id="lineChart" class="min-h-[200px]"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      new ApexCharts(document.querySelector("#revenueChart"), {
        chart: { type: 'bar', height: 180, toolbar: { show: false }, fontFamily: 'Fira Sans, sans-serif', background: 'transparent' },
        series: [{ name: 'Pendapatan', data: [4200, 5800, 4800, 7200, 5600, 6800, 8400] }],
        xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'], labels: { style: { colors: 'var(--muted-light)', fontSize: '11px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { labels: { style: { colors: 'var(--muted-light)', fontSize: '11px' }, formatter: (v) => '$' + (v / 1000).toFixed(0) + 'k' } },
        colors: ['#2563eb'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '45%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: 'var(--border)', strokeDashArray: 4 },
        tooltip: { theme: 'dark', y: { formatter: (v) => '$' + v.toLocaleString() } }
      }).render();

      new ApexCharts(document.querySelector("#donutChart"), {
        chart: { type: 'donut', height: 220, fontFamily: 'Fira Sans, sans-serif', background: 'transparent' },
        series: [42, 28, 18, 12],
        labels: ['Organik', 'Langsung', 'Referal', 'Sosial'],
        colors: ['#2563eb', '#3b82f6', '#34d399', '#6ee7b7'],
        plotOptions: {
          pie: {
            donut: {
              size: '68%',
              labels: {
                show: true,
                total: {
                  show: true,
                  label: 'Total Kunjungan',
                  fontSize: '11px',
                  color: 'var(--muted-light)',
                  formatter: () => '84.2K'
                },
                value: { fontSize: '22px', fontWeight: 800, color: 'var(--text)' }
              }
            }
          }
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 0 },
        tooltip: { theme: 'dark', y: { formatter: (v) => v + '%' } }
      }).render();

      new ApexCharts(document.querySelector("#lineChart"), {
        chart: {
          type: 'area', height: 200, toolbar: { show: false },
          fontFamily: 'Fira Sans, sans-serif', background: 'transparent',
          animations: { enabled: true, easing: 'easeinout', speed: 600 }
        },
        series: [
          { name: 'Pengguna Baru', data: [820, 932, 1100, 890, 1250, 1480, 1320, 1650, 1900, 1720, 2100, 2350] },
          { name: 'Pengguna Lama', data: [420, 510, 620, 580, 740, 860, 810, 950, 1020, 980, 1150, 1280] }
        ],
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          labels: { style: { colors: 'var(--muted-light)', fontSize: '11px' } },
          axisBorder: { show: false }, axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: 'var(--muted-light)', fontSize: '11px' } } },
        colors: ['#2563eb', '#3b82f6'],
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.02,
            stops: [0, 100]
          }
        },
        stroke: { curve: 'smooth', width: [2.5, 2], dashArray: [0, 4] },
        dataLabels: { enabled: false },
        grid: { borderColor: 'var(--border)', strokeDashArray: 4, padding: { left: 0, right: 0 } },
        tooltip: { theme: 'dark', shared: true, intersect: false },
        markers: { size: 0, hover: { size: 5 } }
      }).render();

    });
  </script>
@endpush