@extends('layouts.guest')

@section('title', "demande de compte - Data Center")
@section('content')
   @push('styles')
    <style>
        .request-page{min-height:calc(100vh - 200px);display:flex;align-items:center;padding:2rem 0}
        .request-container{max-width:700px;margin:0 auto;width:100%}
        .request-header{text-align:center;margin-bottom:2rem}
        .request-header h1{font-size:2rem;color:#0f172a;margin-bottom:.5rem}
        .request-header p{color:#64748b;font-size:1.05rem}
        .progress-bar{display:flex;justify-content:space-between;margin-bottom:2rem;position:relative}
        .progress-bar::before{content:'';position:absolute;top:20px;left:0;right:0;height:2px;background:#e2e8f0;z-index:0}
        .progress-step{display:flex;flex-direction:column;align-items:center;position:relative;z-index:1;flex:1}
        .progress-circle{width:40px;height:40px;border-radius:50%;background:#fff;border:3px solid #e2e8f0;display:flex;align-items:center;justify-content:center;font-weight:700;color:#94a3b8;margin-bottom:.5rem;transition:all .3s ease}
        .progress-step.active .progress-circle{background:#2563eb;border-color:#2563eb;color:#fff}
        .progress-step.completed .progress-circle{background:#10b981;border-color:#10b981;color:#fff}
        .progress-label{font-size:.875rem;color:#64748b;text-align:center}.form-section{display:none}
        .form-section.active{display:block;animation:fadeIn .4s ease}
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .form-buttons{display:flex;gap:1rem;margin-top:2rem;justify-content:space-between}
        .info-box{background:linear-gradient(135deg,#dbeafe,#eff6ff);border-left:4px solid #2563eb;padding:1rem;border-radius:8px;margin-bottom:1.5rem}
        .info-box-title{font-weight:600;color:#1e40af;margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem}
        .info-box-text{font-size:.95rem;color:#1e3a8a;margin:0}.success-message{text-align:center;padding:3rem}
        .success-icon{width:80px;height:80px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:#fff;margin:0 auto 1.5rem;animation:scaleIn .5s ease}
        @keyframes scaleIn{from{transform:scale(0)}to{transform:scale(1)}}.success-message h2{color:#0f172a;margin-bottom:1rem}.success-message p{color:#64748b;margin-bottom:2rem}
        .account-type-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem}.account-type-option{border:2px solid #e2e8f0;border-radius:8px;padding:1rem;cursor:pointer;transition:all .3s ease;text-align:center}
        .account-type-option:hover{border-color:#2563eb;background:#f8fafc}.account-type-option input[type=radio]{display:none}.account-type-option input[type=radio]:checked+label{color:#2563eb}
        .account-type-option.selected{border-color:#2563eb;background:linear-gradient(135deg,#dbeafe,#eff6ff)}
        .account-type-icon{font-size:2rem;margin-bottom:.5rem}.account-type-label{font-weight:600;color:#0f172a;display:block;cursor:pointer}.account-type-desc{font-size:.875rem;color:#64748b;margin-top:.25rem}
        .form-group{margin-bottom:1.5rem}.form-label{display:block;font-weight:600;color:#0f172a;margin-bottom:.5rem}
        .form-label.required::after{content:' *';color:#ef4444}.form-input,.form-textarea,.form-select{width:100%;padding:.75rem;border:2px solid #e2e8f0;border-radius:8px;font-size:1rem;transition:all .2s ease}
        .form-input:focus,.form-textarea:focus,.form-select:focus{outline:0;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
        .form-input.error,.form-textarea.error,.form-select.error{border-color:#ef4444}.form-textarea{min-height:120px;resize:vertical}.form-help{display:block;font-size:.875rem;color:#64748b;margin-top:.25rem}.form-error{display:none;font-size:.875rem;color:#ef4444;margin-top:.25rem}
        .form-group.error .form-error{display:block}
        .btn{padding:.75rem 2rem;border-radius:8px;font-weight:600;cursor:pointer;transition:all .2s ease;border:none;font-size:1rem}.btn-primary{background:#2563eb;color:#fff}.btn-primary:hover:not(:disabled){background:#1d4ed8;transform:translateY(-1px);box-shadow:0 4px 12px rgba(37,99,235,.4)}
        .btn-secondary{background:#e2e8f0;color:#475569}.btn-secondary:hover{background:#cbd5e1}.btn-outline{background:#fff;color:#2563eb;border:2px solid #2563eb;text-decoration:none;display:inline-block}.btn-outline:hover{background:#2563eb;color:#fff}.btn:disabled{opacity:.6;cursor:not-allowed}
        .spinner{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;margin-right:.5rem}
        @keyframes spin{to{transform:rotate(360deg)}}.summary-box{background:#f8fafc;border-radius:8px;padding:1.5rem;margin-bottom:1.5rem;border:2px solid #e2e8f0}.summary-title{font-weight:700;color:#0f172a;margin-bottom:1rem;font-size:1.1rem}
        .summary-item{display:flex;margin-bottom:.75rem;padding-bottom:.75rem;border-bottom:1px solid #e2e8f0}.summary-item:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0}.summary-label{font-weight:600;color:#64748b;min-width:150px}
        .summary-value{color:#0f172a;flex:1}@media (max-width:768px){
        .progress-label{font-size:.75rem}.form-buttons{flex-direction:column}
        .account-type-grid{grid-template-columns:1fr}.summary-item{flex-direction:column}.summary-label{margin-bottom:.25rem}}
    </style>
    @endpush
   
    <div class="request-page">
        <div class="container">
            <div class="request-container">
                <div class="request-header">
                    <h1>Demande de création de compte</h1>
                    <p>Suivez les étapes pour créer votre compte utilisateur</p>
                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                  @if(session('success'))
    <div style="background:#ecfdf5;color:#065f46;padding:1rem;border-radius:8px;margin-bottom:1.5rem;text-align:center">
        ✅ {{ session('success') }}
    </div>
@endif


                <div class="progress-bar">
                    <div class="progress-step active" data-step="1">
                        <div class="progress-circle">1</div>
                        <div class="progress-label">Informations personnelles</div>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="progress-circle">2</div>
                        <div class="progress-label">Type de compte</div>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="progress-circle">3</div>
                        <div class="progress-label">Justification</div>
                    </div>
                    <div class="progress-step" data-step="4">
                        <div class="progress-circle">4</div>
                        <div class="progress-label">Confirmation</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('demande.compte.store') }}" id="requestForm" class="form-container" >
                    @csrf

                    {{-- STEP 1: Informations personnelles --}}
                    <div class="form-section active" data-section="1">
                        <div class="info-box">
                            <div class="info-box-title"><span>ℹ️</span>Information</div>
                            <p class="info-box-text">Veuillez utiliser votre adresse email pour cette demande.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-input" placeholder="Votre nom" value="{{ old('nom') }}" required maxlength="150">
                            <span class="form-error">Veuillez saisir votre nom</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" class="form-input" placeholder="Votre prénom" value="{{ old('prenom') }}" required maxlength="150">
                            <span class="form-error">Veuillez saisir votre prénom</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="email">Adresse Email</label>
                            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required maxlength="191" placeholder="emailprofessionnelle@gmail.ma">
                            <span class="form-help">Utilisez votre adresse email professionnelle</span>
                            <span class="form-error">Veuillez saisir une adresse email valide</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" class="form-input" value="{{ old('telephone') }}" maxlength="15" placeholder="+212 6XX-XXXXXX" required>
                            <span class="form-help">Indiquez votre numéro de téléphone</span>
                            <span class="form-error">Veuillez saisir votre telephone</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="affiliation">Affiliation institutionnelle</label>
                            <input type="text" id="affiliation" name="affiliation" class="form-input" value="{{ old('affiliation') }}" placeholder="Ex: Département Informatique, Laboratoire de Recherche..." required>
                            <span class="form-help">Indiquez votre département, laboratoire ou service</span>
                            <span class="form-error">Veuillez saisir votre affiliation</span>
                        </div>
                    </div>

                    {{-- STEP 2: Type de compte --}}
                    <div class="form-section" data-section="2">
                        <div class="info-box">
                            <div class="info-box-title"><span>🎯</span>Choisissez le type de compte adapté à vos besoins</div>
                            <p class="info-box-text">Le type de compte déterminera vos privilèges et les ressources accessibles.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Type de compte souhaité</label>
                            <div class="account-type-grid">
                                <div class="account-type-option" data-type="ingenieur">
                                    <input type="radio" name="accountType" id="type-ingenieur" value="ingenieur" required>
                                    <label for="type-ingenieur">
                                        <div class="account-type-icon">👨‍💻</div>
                                        <div class="account-type-label">Ingénieur</div>
                                        <div class="account-type-desc">Projets professionnels</div>
                                    </label>
                                </div>
                                <div class="account-type-option" data-type="enseignant">
                                    <input type="radio" name="accountType" id="type-enseignant" value="enseignant">
                                    <label for="type-enseignant">
                                        <div class="account-type-icon">🎓</div>
                                        <div class="account-type-label">Enseignant</div>
                                        <div class="account-type-desc">Cours et formations</div>
                                    </label>
                                </div>
                                <div class="account-type-option" data-type="doctorant">
                                    <input type="radio" name="accountType" id="type-doctorant" value="doctorant">
                                    <label for="type-doctorant">
                                        <div class="account-type-icon">🔬</div>
                                        <div class="account-type-label">Doctorant</div>
                                        <div class="account-type-desc">Recherche académique</div>
                                    </label>
                                </div>
                            </div>
                            <span class="form-error">Veuillez sélectionner un type de compte</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="fonction">Fonction / Titre</label>
                            <input type="text" id="fonction" name="fonction" class="form-input" placeholder="Ex: Ingénieur système, Professeur, Doctorant en IA..." required>
                            <span class="form-error">Veuillez saisir votre fonction</span>
                        </div>
                    </div>

                    {{-- STEP 3: Justification --}}
                    <div class="form-section" data-section="3">
                        <div class="info-box">
                            <div class="info-box-title"><span>📝</span>Décrivez vos besoins</div>
                            <p class="info-box-text">Une justification claire et détaillée accélérera le traitement de votre demande.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="projet">Nom du projet / Thématique</label>
                            <input type="text" id="projet" name="projet" class="form-input" placeholder="Intitulé de votre projet ou thématique de recherche" required>
                            <span class="form-error">Veuillez indiquer le nom de votre projet</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="justification">Justification détaillée</label>
                            <textarea id="justification" name="justification" class="form-textarea" placeholder="Décrivez vos besoins en ressources informatiques, l'objectif de votre projet, la durée estimée et les types de ressources nécessaires (serveurs, machines virtuelles, stockage, etc.)" required></textarea>
                            <span class="form-help">Minimum 50 caractères</span>
                            <span class="form-error">Veuillez fournir une justification détaillée (min. 50 caractères)</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ressources">Types de ressources envisagées</label>
                            <select id="ressources" name="ressources[]" class="form-select" multiple size="4">
                                <option value="serveur">Serveurs physiques</option>
                                <option value="vm">Machines virtuelles</option>
                                <option value="stockage">Stockage</option>
                                <option value="reseau">Équipements réseau</option>
                            </select>
                            <span class="form-help">Maintenez Ctrl/Cmd pour sélectionner plusieurs options</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="duree">Durée estimée d'utilisation</label>
                            <select id="duree" name="duree" class="form-select">
                                <option value="">Sélectionnez une durée</option>
                                <option value="1mois">1 mois</option>
                                <option value="3mois">3 mois</option>
                                <option value="6mois">6 mois</option>
                                <option value="12mois">12 mois</option>
                                <option value="plus">Plus de 12 mois</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                                <input type="checkbox" id="acceptRules" name="acceptRules" required>
                                <span>J'ai lu et j'accepte les <a href="{{ url('/regles') }}" target="_blank" style="color:#2563eb">règles d'utilisation</a></span>
                            </label>
                            <span class="form-error">Vous devez accepter les règles d'utilisation</span>
                        </div>
                    </div>

                    {{-- STEP 4: Confirmation --}}
                    <div class="form-section" data-section="4">
                        <div class="info-box">
                            <div class="info-box-title"><span>✅</span>Vérification de vos informations</div>
                            <p class="info-box-text">Veuillez vérifier attentivement les informations avant d'envoyer votre demande.</p>
                        </div>

                        <div class="summary-box">
                            <div class="summary-title">👤 Informations personnelles</div>
                            <div class="summary-item">
                                <span class="summary-label">Nom complet :</span>
                                <span class="summary-value" id="summary-nom"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Email :</span>
                                <span class="summary-value" id="summary-email"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Téléphone :</span>
                                <span class="summary-value" id="summary-telephone"></span>

                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Affiliation :</span>
                                <span class="summary-value" id="summary-affiliation"></span>
                            </div>
                        </div>

                        <div class="summary-box">
                            <div class="summary-title">🎯 Type de compte</div>
                            <div class="summary-item">
                                <span class="summary-label">Type :</span>
                                <span class="summary-value" id="summary-accountType"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Fonction :</span>
                                <span class="summary-value" id="summary-fonction"></span>
                            </div>
                        </div>

                        <div class="summary-box">
                            <div class="summary-title">📝 Projet et justification</div>
                            <div class="summary-item">
                                <span class="summary-label">Projet :</span>
                                <span class="summary-value" id="summary-projet"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Justification :</span>
                                <span class="summary-value" id="summary-justification"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Durée :</span>
                                <span class="summary-value" id="summary-duree"></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Ressources :</span>
                                <span class="summary-value" id="summary-ressources"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
      <div class="form-buttons" id="formButtons">
    <button type="button" class="btn btn-secondary" id="prevBtn" style="display:none">Précédent</button>
    <button type="button" class="btn btn-primary" id="nextBtn">Suivant</button>
    <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none">
        Envoyer la demande
    </button>
</div>

                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script>
(function () {
    let currentStep = 1;
    const totalSteps = 4;

    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showStep(step) {
        document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
        document.querySelector(`[data-section="${step}"]`).classList.add('active');

        document.querySelectorAll('.progress-step').forEach((p, i) => {
            p.classList.remove('active', 'completed');
            if (i + 1 < step) p.classList.add('completed');
            if (i + 1 === step) p.classList.add('active');
        });

        prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
        nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
        submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';

        if (step === 4) fillSummary();
        currentStep = step;
    }

    function validateStep(step) {
        let valid = true;
        const section = document.querySelector(`[data-section="${step}"]`);
        section.querySelectorAll('[required]').forEach(input => {
            if ((input.type === 'checkbox' && !input.checked) || (!input.value && input.type !== 'checkbox')) {
                valid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });
        return valid;
    }

    function fillSummary() {
        document.getElementById('summary-nom').textContent =
            document.getElementById('prenom').value + ' ' + document.getElementById('nom').value;
        document.getElementById('summary-email').textContent = document.getElementById('email').value;
        document.getElementById('summary-telephone').textContent = document.getElementById('telephone').value;
        document.getElementById('summary-affiliation').textContent = document.getElementById('affiliation').value;
        document.getElementById('summary-fonction').textContent = document.getElementById('fonction').value;
        document.getElementById('summary-projet').textContent = document.getElementById('projet').value;
        document.getElementById('summary-justification').textContent = document.getElementById('justification').value;
        const accountType = document.querySelector('input[name="accountType"]:checked');
        document.getElementById('summary-accountType').textContent = accountType ? accountType.value : 'Non spécifié';
        document.getElementById('summary-duree').textContent = document.getElementById('duree').value || 'Non spécifiée';
        const ressourcesSelect = document.getElementById('ressources');
        const selectedRessources = Array.from(ressourcesSelect.selectedOptions).map(opt => opt.text).join(', ') || 'Aucune';
        document.getElementById('summary-ressources').textContent = selectedRessources;
    }

    nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            showStep(currentStep + 1);
        }
    });

    prevBtn.addEventListener('click', () => {
        showStep(currentStep - 1);
    });

    showStep(1);
})();
</script>

@endpush