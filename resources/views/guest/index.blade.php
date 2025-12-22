@extends('layouts.guest')

@section('title', 'Accueil - Data Center')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>Plateforme de Gestion des Ressources du Data Center</h1>
            <p>Consultez les ressources informatiques disponibles et déposez une demande d'accès pour réserver : serveurs, machines virtuelles, stockage et équipements réseau.</p>
            <div class="hero-buttons">
                <a href="{{ route('catalogue') }}" class="btn btn-primary btn-large">Explorer les ressources</a>
                <a href="{{ route('demande.compte') }}" class="btn btn-outline btn-large">Demander un compte</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <p class="section-subtitle">Découvrez les ressources disponibles dans notre Data Center</p>
            
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">🖥️</div>
                    <h3>Serveurs Physiques</h3>
                    <p>Accédez à des serveurs physiques haute performance pour vos projets nécessitant des ressources dédiées et une puissance de calcul maximale.</p>
                </div>

                <div class="card">
                    <div class="card-icon">☁️</div>
                    <h3>Machines Virtuelles</h3>
                    <p>Déployez rapidement des machines virtuelles configurables selon vos besoins spécifiques en CPU, RAM et stockage.</p>
                </div>

                <div class="card">
                    <div class="card-icon">💾</div>
                    <h3>Stockage</h3>
                    <p>Bénéficiez de solutions de stockage sécurisées et performantes avec différentes options : SSD, HDD, NAS et SAN.</p>
                </div>

                <div class="card">
                    <div class="card-icon">🌐</div>
                    <h3>Équipements Réseau</h3>
                    <p>Utilisez nos équipements réseau professionnels : switches, routeurs, pare-feu pour vos architectures réseau.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section">
        <div class="container text-center">
            <h2 class="section-title">Prêt à commencer ?</h2>
            <p class="section-subtitle">Déposez votre demande de compte pour accéder aux ressources du Data Center</p>
            <div class="flex-center gap-2">
                <a href="{{ route('demande.compte') }}" class="btn btn-primary btn-large">Demander un compte</a>
                <a href="{{ route('regles') }}" class="btn btn-outline btn-large">Consulter les règles</a>
            </div>
        </div>
    </section>
@endsection