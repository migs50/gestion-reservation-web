@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

<!-- Hero Section -->
<section class="hero-section-compact">
<div class="hero-container-compact">

    <h1>Gérez vos ressources en toute simplicité</h1>
    <p>Une plateforme moderne pour réserver, suivre et gérer vos ressources partagées.</p>
    
    <div class="hero-buttons">
        <a href="{{ route('publique.ressources') }}" class="hero-link hero-link-primary">
            Explorer les ressources
        </a>

        @guest
            <a href="{{ route('demande.compte') }}" class="hero-link hero-link-secondary">
                Demander un accès
            </a>
        @endguest
    </div>
</div>
</section>


<!-- Features -->
<section class="features">
    <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3>Sécurité avancée</h3>
        <p>Vos ressources sont protégées par des systèmes de sécurité de pointe et une authentification multi-facteurs.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">⚡</div>
        <h3>Réservation rapide</h3>
        <p>Réservez vos ressources en quelques clics avec notre interface intuitive et performante.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Suivi en temps réel</h3>
        <p>Surveillez l'utilisation et la disponibilité de vos ressources avec des statistiques détaillées.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">🔔</div>
        <h3>Notifications</h3>
        <p>Recevez des alertes en temps réel sur l'état de vos réservations et la maintenance planifiée.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">👥</div>
        <h3>Gestion collaborative</h3>
        <p>Travaillez en équipe avec un système de gestion des droits et des approbations.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3>Interface responsive</h3>
        <p>Accédez à vos ressources depuis n'importe quel appareil, PC, tablette ou smartphone.</p>
    </div>
</section>
    
<!-- Statistics -->
<section class="stats-section">

   
        <div class="stat-item">
            <h4>95%</h4>
            <p>Taux de satisfaction</p>
        </div>
        <div class="stat-item">
            <h4>24/7</h4>
            <p>Support disponible</p>
        </div>
    </div>
</section>
@endsection