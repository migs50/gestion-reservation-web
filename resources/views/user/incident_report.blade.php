@extends('layouts.app')

@section('title', 'Signaler un Incident')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-header h1 {
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #7f8c8d;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-section {
        margin-bottom: 35px;
    }

    .form-section h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group label .required {
        color: #e74c3c;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: #7f8c8d;
        font-size: 13px;
    }

    .error-message {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
    }

    .severity-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
    }

    .severity-option {
        position: relative;
    }

    .severity-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .severity-label {
        display: block;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .severity-option input[type="radio"]:checked + .severity-label {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .severity-label.critical {
        border-color: #e74c3c;
    }

    .severity-option input[type="radio"]:checked + .severity-label.critical {
        border-color: #e74c3c;
        background: rgba(231, 76, 60, 0.05);
    }

    .severity-label.high {
        border-color: #f39c12;
    }

    .severity-option input[type="radio"]:checked + .severity-label.high {
        border-color: #f39c12;
        background: rgba(243, 156, 18, 0.05);
    }

    .severity-label.medium {
        border-color: #3498db;
    }

    .severity-option input[type="radio"]:checked + .severity-label.medium {
        border-color: #3498db;
        background: rgba(52, 152, 219, 0.05);
    }

    .severity-label.low {
        border-color: #2ecc71;
    }

    .severity-option input[type="radio"]:checked + .severity-label.low {
        border-color: #2ecc71;
        background: rgba(46, 204, 113, 0.05);
    }

    .severity-icon {
        font-size: 24px;
        display: block;
        margin-bottom: 8px;
    }

    .severity-name {
        font-weight: 600;
        font-size: 13px;
        color: #2c3e50;
    }

    .file-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.02);
    }

    .file-upload-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .file-upload-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .file-list {
        margin-top: 15px;
    }

    .file-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-remove {
        color: #e74c3c;
        cursor: pointer;
        font-weight: 600;
    }

    .info-box {
        background: #e7f3ff;
        border-left: 4px solid #2196f3;
        padding: 20px;
        border-radius: 6px;
        margin: 25px 0;
    }

    .info-box h4 {
        color: #1976d2;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .info-box ul {
        margin: 10px 0 0 20px;
        color: #555;
    }

    .info-box ul li {
        margin-bottom: 5px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 25px;
        }

        .severity-options {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1>⚠️ Signaler un Incident</h1>
    <p>Décrivez le problème rencontré pour que notre équipe puisse intervenir rapidement</p>
</div>

<!-- Form Card -->
<div class="form-card">
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

    @if(session('success'))
    <div class="alert alert-success">
        <strong>✅ {{ session('success') }}</strong>
    </div>
    @endif

    <form action="{{ route('user.incident.store') }}" method="POST" enctype="multipart/form-data" id="incidentForm">
        @csrf

        <!-- Section 1: Informations générales -->
        <div class="form-section">
            <h3>📋 Informations générales</h3>

            <div class="form-grid">
                <div class="form-group">
                    <label>Réservation concernée</label>
                    <select name="reservation_id">
                        <option value="">-- Sélectionner une réservation (optionnel) --</option>
                        @foreach($reservations ?? [] as $reservation)
                            <option value="{{ $reservation->id }}" 
                                    {{ request('reservation_id') == $reservation->id ? 'selected' : '' }}>
                                #{{ $reservation->id }} - {{ $reservation->ressource->nom }}
                            </option>
                        @endforeach
                    </select>
                    <small>Si l'incident concerne une réservation spécifique</small>
                </div>

                <div class="form-group">
                    <label>Ressource concernée <span class="required">*</span></label>
                    <select name="ressource_id" required>
                        <option value="">-- Sélectionner une ressource --</option>
                        @foreach($ressources ?? [] as $ressource)
                            <option value="{{ $ressource->id }}" {{ old('ressource_id') == $ressource->id ? 'selected' : '' }}>
                                {{ $ressource->nom }} ({{ $ressource->categorie->nom ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('ressource_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Titre de l'incident <span class="required">*</span></label>
                <input type="text" name="titre" value="{{ old('titre') }}" 
                       placeholder="Ex: Impossible de se connecter au serveur" required>
                <small>Un titre court et descriptif</small>
                @error('titre')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 2: Classification -->
        <div class="form-section">
            <h3>🎯 Classification de l'incident</h3>

            <div class="form-group">
                <label>Niveau de gravité <span class="required">*</span></label>
                <div class="severity-options">
                    <div class="severity-option">
                        <input type="radio" name="gravite" value="critique" id="critique" required {{ old('gravite') == 'critique' ? 'checked' : '' }}>
                        <label for="critique" class="severity-label critical">
                            <span class="severity-icon">🔴</span>
                            <span class="severity-name">Critique</span>
                        </label>
                    </div>

                    <div class="severity-option">
                        <input type="radio" name="gravite" value="haute" id="haute" {{ old('gravite') == 'haute' ? 'checked' : '' }}>
                        <label for="haute" class="severity-label high">
                            <span class="severity-icon">🟠</span>
                            <span class="severity-name">Haute</span>
                        </label>
                    </div>

                    <div class="severity-option">
                        <input type="radio" name="gravite" value="moyenne" id="moyenne" {{ old('gravite') == 'moyenne' ? 'checked' : '' }}>
                        <label for="moyenne" class="severity-label medium">
                            <span class="severity-icon">🟡</span>
                            <span class="severity-name">Moyenne</span>
                        </label>
                    </div>

                    <div class="severity-option">
                        <input type="radio" name="gravite" value="faible" id="faible" {{ old('gravite') == 'faible' ? 'checked' : '' }}>
                        <label for="faible" class="severity-label low">
                            <span class="severity-icon">🟢</span>
                            <span class="severity-name">Faible</span>
                        </label>
                    </div>
                </div>
                @error('gravite')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Catégorie de l'incident <span class="required">*</span></label>
                <select name="categorie" required>
                    <option value="">-- Sélectionner une catégorie --</option>
                    <option value="materiel" {{ old('categorie') == 'materiel' ? 'selected' : '' }}>🖥️ Problème matériel</option>
                    <option value="logiciel" {{ old('categorie') == 'logiciel' ? 'selected' : '' }}>💿 Problème logiciel</option>
                    <option value="reseau" {{ old('categorie') == 'reseau' ? 'selected' : '' }}>🌐 Problème réseau</option>
                    <option value="performance" {{ old('categorie') == 'performance' ? 'selected' : '' }}>⚡ Performance dégradée</option>
                    <option value="securite" {{ old('categorie') == 'securite' ? 'selected' : '' }}>🔒 Problème de sécurité</option>
                    <option value="acces" {{ old('categorie') == 'acces' ? 'selected' : '' }}>🔑 Problème d'accès</option>
                    <option value="autre" {{ old('categorie') == 'autre' ? 'selected' : '' }}>📦 Autre</option>
                </select>
                @error('categorie')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 3: Description détaillée -->
        <div class="form-section">
            <h3>📝 Description détaillée</h3>

            <div class="form-group">
                <label>Description du problème <span class="required">*</span></label>
                <textarea name="description" rows="6" required placeholder="Décrivez en détail le problème rencontré...">{{ old('description') }}</textarea>
                <small>Soyez le plus précis possible (minimum 50 caractères)</small>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Étapes pour reproduire le problème</label>
                <textarea name="etapes_reproduction" rows="5" placeholder="1. J'ai essayé de...&#10;2. Ensuite j'ai...&#10;3. Le problème s'est produit quand...">{{ old('etapes_reproduction') }}</textarea>
                <small>Listez les étapes qui ont mené au problème (optionnel mais recommandé)</small>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Date et heure de l'incident <span class="required">*</span></label>
                    <input type="datetime-local" name="date_incident" 
                           value="{{ old('date_incident', now()->format('Y-m-d\TH:i')) }}" 
                           max="{{ now()->format('Y-m-d\TH:i') }}" required>
                    @error('date_incident')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Impact sur votre travail</label>
                    <select name="impact">
                        <option value="">-- Sélectionner l'impact --</option>
                        <option value="bloquant" {{ old('impact') == 'bloquant' ? 'selected' : '' }}>🚫 Bloquant - Impossible de continuer</option>
                        <option value="majeur" {{ old('impact') == 'majeur' ? 'selected' : '' }}>⚠️ Majeur - Travail fortement perturbé</option>
                        <option value="mineur" {{ old('impact') == 'mineur' ? 'selected' : '' }}>⚡ Mineur - Légère gêne</option>
                        <option value="aucun" {{ old('impact') == 'aucun' ? 'selected' : '' }}>✓ Aucun impact immédiat</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Message d'erreur (si applicable)</label>
                <textarea name="message_erreur" rows="4" placeholder="Copiez-collez ici tout message d'erreur affiché">{{ old('message_erreur') }}</textarea>
                <small>Si vous avez reçu un message d'erreur, copiez-le intégralement</small>
            </div>
        </div>

        <!-- Section 4: Pièces jointes -->
        <div class="form-section">
            <h3>📎 Pièces jointes (optionnel)</h3>

            <div class="form-group">
                <label>Captures d'écran ou fichiers</label>
                <div class="file-upload-area" id="fileUploadArea" onclick="document.getElementById('fileInput').click()">
                    <div class="file-upload-icon">📁</div>
                    <p style="color: #555; margin-bottom: 10px;">Cliquez pour sélectionner des fichiers ou glissez-déposez ici</p>
                    <small style="color: #7f8c8d;">Formats acceptés: JPG, PNG, PDF, TXT (Max: 5MB par fichier)</small>
                </div>
                <input type="file" id="fileInput" name="fichiers[]" multiple accept=".jpg,.jpeg,.png,.pdf,.txt" style="display: none;" onchange="handleFiles(this.files)">
                
                <div class="file-list" id="fileList"></div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <h4>ℹ️ Ce qui se passe après votre signalement</h4>
            <ul>
                <li>Votre incident sera transmis immédiatement à l'équipe technique</li>
                <li>Vous recevrez un numéro de suivi par email</li>
                <li>Un technicien vous contactera selon la gravité (Critique: <2h, Haute: <4h, Moyenne: <24h)</li>
                <li>Vous serez notifié de chaque mise à jour du statut</li>
            </ul>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                ← Annuler
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                ⚠️ Signaler l'incident
            </button>
        </div>
    </form>
</div>

<script>
let selectedFiles = [];

// File upload area drag and drop
const fileUploadArea = document.getElementById('fileUploadArea');

fileUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadArea.classList.add('dragover');
});

fileUploadArea.addEventListener('dragleave', () => {
    fileUploadArea.classList.remove('dragover');
});

fileUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    fileUploadArea.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

// Handle file selection
function handleFiles(files) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'text/plain'];
    
    Array.from(files).forEach(file => {
        // Check file size
        if (file.size > maxSize) {
            alert(`❌ Le fichier "${file.name}" est trop volumineux (max 5MB)`);
            return;
        }
        
        // Check file type
        if (!allowedTypes.includes(file.type)) {
            alert(`❌ Le type du fichier "${file.name}" n'est pas accepté`);
            return;
        }
        
        // Add file to array
        selectedFiles.push(file);
        
        // Display file in list
        displayFile(file, selectedFiles.length - 1);
    });
}

// Display file in list
function displayFile(file, index) {
    const fileList = document.getElementById('fileList');
    const fileItem = document.createElement('div');
    fileItem.className = 'file-item';
    fileItem.innerHTML = `
        <div class="file-info">
            <span style="font-size: 24px;">📄</span>
            <div>
                <div style="font-weight: 600; color: #2c3e50;">${file.name}</div>
                <div style="font-size: 12px; color: #7f8c8d;">${formatFileSize(file.size)}</div>
            </div>
        </div>
        <span class="file-remove" onclick="removeFile(${index})">✕ Supprimer</span>
    `;
    fileList.appendChild(fileItem);
}

// Remove file from list
function removeFile(index) {
    selectedFiles.splice(index, 1);
    
    // Rebuild file list display
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
        displayFile(file, idx);
    });
    
    // Update file input
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    document.getElementById('fileInput').files = dataTransfer.files;
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Form validation before submit
document.getElementById('incidentForm').addEventListener('submit', function(e) {
    const description = document.querySelector('textarea[name="description"]').value;
    
    if (description.length < 50) {
        e.preventDefault();
        alert('❌ La description doit contenir au moins 50 caractères');
        return false;
    }
    
    // Disable submit button to prevent double submission
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '⏳ Envoi en cours...';
});
</script>

@if(session('success'))
<script>
    setTimeout(() => {
        window.location.href = "{{ route('user.dashboard') }}";
    }, 3000);
</script>
@endif
