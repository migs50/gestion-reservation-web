@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<style>
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 80px 40px;
        text-align: center;
        margin-bottom: 50px;
    }

    .hero h1 {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 20px;
        margin-bottom: 30px;
        opacity: 0.95;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-btn {
        padding: 15px 35px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .hero-btn-primary {
        background: white;
        color: #667eea;
    }

    .hero-btn-secondary {
        background:  white;
        color:#667eea;
        border: 2px solid white;
    }

    .hero-btn:hover {
        transform: translateY(-3px);
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 35px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        font-size: 50px;
        margin-bottom: 20px;
    }

    .feature-card h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .feature-card p {
        color: #7f8c8d;
        line-height: 1.6;
    }

    .stats-section {
        background: white;
        border-radius: 12px;
        padding: 50px 40px;
        margin-bottom: 50px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        text-align: center;
    }

    .stat-item h4 {
        font-size: 42px;
        color: #667eea;
        margin-bottom: 10px;
    }

    .stat-item p {
        color: #7f8c8d;
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 32px;
        }

        .hero p {
            font-size: 16px;
        }

        .hero {
            padding: 50px 20px;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-buttons">
    <a href="{{ route('publique.ressources') }}" class="hero-btn hero-btn-primary">
        Explorer les ressources
    </a>

    <a href="{{ route('demande.compte') }}" class="hero-btn hero-btn-secondary">
        Demander un accès
    </a>
</div>
@endguest


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
    <h2 style="text-align: center; margin-bottom: 40px; color: #2c3e50; font-size: 32px;">
        Nos statistiques
    </h2>
    <div class="stats-grid">
        <div class="stat-item">
            <h4>250+</h4>
            <p>Ressources disponibles</p>
        </div>
        <div class="stat-item">
            <h4>1500+</h4>
            <p>Utilisateurs actifs</p>
        </div>
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