@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Statistiques globales</h1>
        <p>Vue d'ensemble de l'utilisation du Data Center</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-value">-</div>
                <div class="stat-label">Taux d'occupation</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Graphiques et rapports</h2>
        </div>
        <div class="card-body">
            <p>Fonctionnalité en cours de développement...</p>
        </div>
    </div>
</div>
@endsection
