@extends('layouts.contentNavbarLayout')

@section('title', 'Statistiques Utilisateurs')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Statistiques des Utilisateurs</h4>

    <div class="card p-4 mb-4">
      <h5 class="mb-3">Nombre total d'utilisateurs : {{ $totalUsers }}</h5>

      <h6>Inscriptions par mois :</h6>
      <ul>
        @foreach($usersByMonth as $stat)
          <li>{{ $stat->month }} : {{ $stat->count }} utilisateur(s)</li>
        @endforeach
      </ul>
    </div>

    <div class="card p-4">
      <h5 class="mb-3">Inscriptions par Mois</h5>
      <canvas id="usersChart" style="max-width: 600px; height: 300px;"></canvas>
    </div>
  </div>
@endsection


@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('usersChart').getContext('2d');
    const usersChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($usersByMonth->pluck('month')) !!},
        datasets: [{
          label: 'Utilisateurs inscrits',
          data: {!! json_encode($usersByMonth->pluck('count')) !!},
          backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)'
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        },
        plugins: {
          legend: { display: false },
          tooltip: { enabled: true }
        }
      }
    });
  </script>
@endpush
