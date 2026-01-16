@extends('layouts.app')

@section('title', 'Nouvelle Réservation')

@section('content')

<!-- Header -->
<div class="page-header">
    <h1>➕ Nouvelle Réservation</h1>
    <p>Réservez une ressource en 3 étapes simples</p>
</div>

<!-- Wizard Container -->
<div class="wizard-container">
    <!-- Error Messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <strong>❌ Erreurs de validation :</strong>
        <ul style="margin: 10px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Wizard Steps -->
    <div class="wizard-steps">
        <div class="wizard-step active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Choix de la ressource</div>
        </div>
        <div class="wizard-step" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Période de réservation</div>
        </div>
        <div class="wizard-step" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Confirmation</div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('user.reservation.store') }}" method="POST" id="reservationForm">
        @csrf

        <!-- Step 1: Select Resource -->
        <div class="step-content active" data-step="1">
            <div class="form-section">
                <h3>🖥️ Sélectionnez une ressource</h3>
                
                <div class="form-group">
                    <label>Filtrer par catégorie</label>
                    <select id="categoryFilter" onchange="filterRessources()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="ressourcesList">
                    @forelse($ressources as $ressource)
                    <div class="ressource-card" data-category="{{ $ressource->categorie_id }}" onclick="selectRessource({{ $ressource->id }})">
                        <input type="radio" name="ressource_id" value="{{ $ressource->id }}" id="ressource_{{ $ressource->id }}" required>
                        
                        <div class="ressource-header">
                            <div>
                                <h4>{{ $ressource->nom }}</h4>
                                <p>{{ $ressource->categorie->nom ?? 'Non catégorisé' }}</p>
                            </div>
                            <div>
                                @if($ressource->etat == 'available')
                                    <span class="badge badge-success">✓ Disponible</span>
                                @else
                                    <span class="badge badge-warning">⏳ Occupé / Maint.</span>
                                @endif
                            </div>
                        </div>

                        <div class="ressource-specs">
                            @if($ressource->cpu) <div class="spec-item"><strong>CPU:</strong> {{ $ressource->cpu }}</div> @endif
                            @if($ressource->ram) <div class="spec-item"><strong>RAM:</strong> {{ $ressource->ram }}</div> @endif
                            @if($ressource->os) <div class="spec-item"><strong>OS:</strong> {{ $ressource->os }}</div> @endif
                            @if($ressource->capacite) <div class="spec-item"><strong>Stockage:</strong> {{ $ressource->capacite }}</div> @endif
                        </div>
                    </div>
                    @empty
                    <p style="text-align: center; color: #7f8c8d; padding: 40px;">
                        Aucune ressource disponible pour le moment
                    </p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Step 2: Select Period -->
        <div class="step-content" data-step="2">
            <div class="form-section">
                <h3>📅 Définissez la période de réservation</h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Date et heure de début <span class="required">*</span></label>
                        <input type="datetime-local" name="debut" id="debut" 
                               min="{{ now()->format('Y-m-d\TH:i') }}" 
                               value="{{ old('debut') }}" required>
                        <small>La date doit être au moins 24h dans le futur</small>
                        @error('debut')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Date et heure de fin <span class="required">*</span></label>
                        <input type="datetime-local" name="fin" id="fin" 
                               value="{{ old('fin') }}" required>
                        <small>Durée maximale: 30 jours</small>
                        @error('fin')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Justification de la demande <span class="required">*</span></label>
                    <textarea name="justification" rows="5" required placeholder="Expliquez pourquoi vous avez besoin de cette ressource...">{{ old('justification') }}</textarea>
                    <small>Minimum 50 caractères</small>
                    @error('justification')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div id="durationInfo" style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-top: 15px; display: none;">
                    <strong style="color: #0c5460;">📊 Durée de la réservation:</strong>
                    <p style="color: #0c5460; margin: 5px 0 0 0;" id="durationText"></p>
                </div>
            </div>
        </div>

        <!-- Step 3: Confirmation -->
        <div class="step-content" data-step="3">
            <div class="form-section">
                <h3>✅ Vérifiez et confirmez votre réservation</h3>

                <div class="summary-section">
                    <h4>📋 Récapitulatif de la réservation</h4>
                    
                    <div class="summary-item">
                        <span class="summary-label">Ressource :</span>
                        <span class="summary-value" id="summary-ressource">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Catégorie :</span>
                        <span class="summary-value" id="summary-category">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Date de début :</span>
                        <span class="summary-value" id="summary-debut">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Date de fin :</span>
                        <span class="summary-value" id="summary-fin">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Durée totale :</span>
                        <span class="summary-value" id="summary-duration">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Statut initial :</span>
                        <span class="summary-value"><span class="badge badge-warning">En attente d'approbation</span></span>
                    </div>
                </div>

                <div class="summary-section">
                    <h4>📝 Justification</h4>
                    <p id="summary-justification" style="color: #555; line-height: 1.6;">-</p>
                </div>

                <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <strong style="color: #856404;">⚠️ Informations importantes :</strong>
                    <ul style="margin: 10px 0 0 20px; color: #856404;">
                        <li>Votre demande sera examinée par un responsable</li>
                        <li>Vous recevrez une notification par email</li>
                        <li>Le délai de traitement est généralement de 24 à 48 heures</li>
                        <li>Vous pourrez annuler la réservation tant qu'elle n'est pas active</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="wizard-actions">
            <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                ← Précédent
            </button>
            <div></div>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                Suivant →
            </button>
            <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                ✓ Confirmer la réservation
            </button>
        </div>
    </form>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

// Change step
function changeStep(direction) {
    // Validate current step before moving
    if (direction === 1 && !validateStep(currentStep)) {
        return;
    }

    // Update current step
    const newStep = currentStep + direction;
    
    if (newStep < 1 || newStep > totalSteps) {
        return;
    }

    // Hide current step
    document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.remove('active');
    document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.remove('active');
    
    // Mark as completed if moving forward
    if (direction === 1) {
        document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.add('completed');
    }

    // Show new step
    currentStep = newStep;
    document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');
    document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.add('active');

    // Update buttons
    updateButtons();

    // Update summary if on step 3
    if (currentStep === 3) {
        updateSummary();
    }

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Validate step
function validateStep(step) {
    if (step === 1) {
        const ressourceId = document.querySelector('input[name="ressource_id"]:checked');
        if (!ressourceId) {
            alert('❌ Veuillez sélectionner une ressource');
            return false;
        }
    }

    if (step === 2) {
        const dateDebut = document.getElementById('debut').value;
        const dateFin = document.getElementById('fin').value;
        const justification = document.querySelector('textarea[name="justification"]').value;

        if (!dateDebut || !dateFin) {
            alert('❌ Veuillez remplir les dates de début et de fin');
            return false;
        }

        if (new Date(dateDebut) >= new Date(dateFin)) {
            alert('❌ La date de fin doit être après la date de début');
            return false;
        }

        if (justification.length < 50) {
            alert('❌ La justification doit contenir au moins 50 caractères');
            return false;
        }

        // Check max duration (30 days)
        const duration = (new Date(dateFin) - new Date(dateDebut)) / (1000 * 60 * 60 * 24);
        if (duration > 30) {
            alert('❌ La durée maximale de réservation est de 30 jours');
            return false;
        }
    }

    return true;
}

// Update navigation buttons
function updateButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-block';
    nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-block';
    submitBtn.style.display = currentStep === totalSteps ? 'inline-block' : 'none';
}

// Select resource
function selectRessource(id) {
    // Remove all selections
    document.querySelectorAll('.ressource-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Select clicked resource
    const radio = document.getElementById('ressource_' + id);
    radio.checked = true;
    radio.closest('.ressource-card').classList.add('selected');
}

// Filter resources by category
function filterRessources() {
    const categoryId = document.getElementById('categoryFilter').value;
    const cards = document.querySelectorAll('.ressource-card');

    cards.forEach(card => {
        if (!categoryId || card.dataset.category === categoryId) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Calculate and display duration
document.getElementById('debut')?.addEventListener('change', calculateDuration);
document.getElementById('fin')?.addEventListener('change', calculateDuration);

function calculateDuration() {
    const dateDebut = document.getElementById('debut').value;
    const dateFin = document.getElementById('fin').value;

    if (dateDebut && dateFin) {
        const debut = new Date(dateDebut);
        const fin = new Date(dateFin);
        const duration = (fin - debut) / (1000 * 60 * 60 * 24);

        if (duration > 0) {
            const durationInfo = document.getElementById('durationInfo');
            const durationText = document.getElementById('durationText');
            
            durationText.textContent = `${duration.toFixed(1)} jours (${(duration * 24).toFixed(0)} heures)`;
            durationInfo.style.display = 'block';

            if (duration > 30) {
                durationInfo.style.background = '#f8d7da';
                durationText.style.color = '#721c24';
                durationText.textContent += ' ⚠️ Durée maximale dépassée (30 jours max)';
            }
        }
    }
}

// Update summary
function updateSummary() {
    const ressourceRadio = document.querySelector('input[name="ressource_id"]:checked');
    if (ressourceRadio) {
        const ressourceCard = ressourceRadio.closest('.ressource-card');
        document.getElementById('summary-ressource').textContent = 
            ressourceCard.querySelector('h4').textContent;
        document.getElementById('summary-category').textContent = 
            ressourceCard.querySelector('p').textContent;
    }

    const dateDebut = document.getElementById('debut').value;
    const dateFin = document.getElementById('fin').value;
    
    if (dateDebut) {
        document.getElementById('summary-debut').textContent = 
            new Date(dateDebut).toLocaleString('fr-FR');
    }
    
    if (dateFin) {
        document.getElementById('summary-fin').textContent = 
            new Date(dateFin).toLocaleString('fr-FR');
    }

    if (dateDebut && dateFin) {
        const duration = (new Date(dateFin) - new Date(dateDebut)) / (1000 * 60 * 60 * 24);
        document.getElementById('summary-duration').textContent = 
            `${duration.toFixed(1)} jours (${(duration * 24).toFixed(0)} heures)`;
    }

    const justification = document.querySelector('textarea[name="justification"]').value;
    document.getElementById('summary-justification').textContent = justification || '-';
}

// Initialize
updateButtons();
</script>
@endsection
