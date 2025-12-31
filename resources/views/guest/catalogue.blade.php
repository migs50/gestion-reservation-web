@extends('layouts.guest')


@section('content')

<style>
    .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .resource-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }

        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .resource-header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .resource-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
        }

        .resource-type {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .resource-body {
            padding: 1.5rem;
        }

        .resource-specs {
            display: grid;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .spec-label {
            font-weight: 600;
            color: #475569;
            min-width: 80px;
        }

        .spec-value {
            color: #0f172a;
        }

        .resource-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            margin-top: 1rem;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-dot.available {
            background-color: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.4);
        }

        .status-dot.busy {
            background-color: #f59e0b;
            box-shadow: 0 0 8px rgba(245, 158, 11, 0.4);
        }

        .status-dot.maintenance {
            background-color: #ef4444;
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.4);
        }

        .login-notice {
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .login-notice-icon {
            font-size: 2rem;
        }

        .login-notice-content {
            flex: 1;
        }

        .login-notice-title {
            font-weight: bold;
            margin-bottom: 0.25rem;
            color: #1e40af;
        }

        .login-notice-text {
            font-size: 0.95rem;
            color: #1e3a8a;
        }

        .category-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .tab-button {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .tab-button:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        .tab-button.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .search-bar {
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>


    <!-- Main Content -->
    <div class="container">
        <h1 class="section-title mt-4">Catalogue des Ressources</h1>
        <p class="section-subtitle">Explorez les ressources disponibles dans notre Data Center</p>

        <!-- Info Notice -->
        <div class="login-notice">
            <div class="login-notice-icon">ℹ️</div>
            <div class="login-notice-content">
                <div class="login-notice-title">Mode consultation</div>
                <div class="login-notice-text">
                    Vous consultez le catalogue en mode lecture seule. 
                    Pour effectuer des réservations, 
                    <a href="demande-compte.html" style="color: #1e40af; font-weight: bold;">déposez une demande de compte</a>.
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Rechercher une ressource par nom, type ou caractéristique...">
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <button class="tab-button active" data-category="all">Toutes les ressources</button>
            <button class="tab-button" data-category="serveur">Serveurs Physiques</button>
            <button class="tab-button" data-category="vm">Machines Virtuelles</button>
            <button class="tab-button" data-category="stockage">Stockage</button>
            <button class="tab-button" data-category="reseau">Équipements Réseau</button>
        </div>

        <!-- Resources Grid -->
        <div class="resource-grid" id="resourceGrid">
            <!-- Serveurs Physiques -->
            <div class="resource-card" data-category="serveur">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">Dell PowerEdge R750</div>
                        <div class="resource-type">Serveur Physique</div>
                    </div>
                    <div style="font-size: 2rem;">🖥️</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Processeur:</span>
                            <span class="spec-value">Intel Xeon Gold 6338 (32 cœurs)</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAM:</span>
                            <span class="spec-value">256 GB DDR4</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Stockage:</span>
                            <span class="spec-value">2 TB NVMe SSD</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Réseau:</span>
                            <span class="spec-value">10 Gbps</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Emplacement:</span>
                            <span class="spec-value">Salle A - Rack 12</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot available"></span>
                            <span style="font-weight: 600; color: #10b981;">Disponible</span>
                        </div>
                        <span class="badge badge-success">Actif</span>
                    </div>
                </div>
            </div>

            <div class="resource-card" data-category="serveur">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">HP ProLiant DL380 Gen10</div>
                        <div class="resource-type">Serveur Physique</div>
                    </div>
                    <div style="font-size: 2rem;">🖥️</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Processeur:</span>
                            <span class="spec-value">Intel Xeon Silver 4214 (24 cœurs)</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAM:</span>
                            <span class="spec-value">128 GB DDR4</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Stockage:</span>
                            <span class="spec-value">4 TB HDD RAID 5</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Réseau:</span>
                            <span class="spec-value">10 Gbps</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Emplacement:</span>
                            <span class="spec-value">Salle A - Rack 15</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot busy"></span>
                            <span style="font-weight: 600; color: #f59e0b;">Occupé</span>
                        </div>
                        <span class="badge badge-warning">Réservé jusqu'au 30/12/2025</span>
                    </div>
                </div>
            </div>

            <!-- Machines Virtuelles -->
            <div class="resource-card" data-category="vm">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">VM Standard A</div>
                        <div class="resource-type">Machine Virtuelle</div>
                    </div>
                    <div style="font-size: 2rem;">☁️</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">vCPU:</span>
                            <span class="spec-value">4 cœurs</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAM:</span>
                            <span class="spec-value">16 GB</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Stockage:</span>
                            <span class="spec-value">100 GB SSD</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">OS:</span>
                            <span class="spec-value">Ubuntu 22.04 / Windows Server 2022</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Hyperviseur:</span>
                            <span class="spec-value">VMware ESXi 7.0</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot available"></span>
                            <span style="font-weight: 600; color: #10b981;">Disponible</span>
                        </div>
                        <span class="badge badge-success">Actif</span>
                    </div>
                </div>
            </div>

            <div class="resource-card" data-category="vm">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">VM Performance B</div>
                        <div class="resource-type">Machine Virtuelle</div>
                    </div>
                    <div style="font-size: 2rem;">☁️</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">vCPU:</span>
                            <span class="spec-value">8 cœurs</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAM:</span>
                            <span class="spec-value">32 GB</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Stockage:</span>
                            <span class="spec-value">250 GB NVMe SSD</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">OS:</span>
                            <span class="spec-value">Ubuntu 22.04 / CentOS 8</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Hyperviseur:</span>
                            <span class="spec-value">KVM</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot available"></span>
                            <span style="font-weight: 600; color: #10b981;">Disponible</span>
                        </div>
                        <span class="badge badge-success">Actif</span>
                    </div>
                </div>
            </div>

            <!-- Stockage -->
            <div class="resource-card" data-category="stockage">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">NetApp FAS8300</div>
                        <div class="resource-type">Baie de Stockage NAS</div>
                    </div>
                    <div style="font-size: 2rem;">💾</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Capacité:</span>
                            <span class="spec-value">50 TB (35 TB utilisables)</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Type:</span>
                            <span class="spec-value">SSD + HDD (Hybrid)</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAID:</span>
                            <span class="spec-value">RAID-DP</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Protocoles:</span>
                            <span class="spec-value">NFS, CIFS, iSCSI</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Débit:</span>
                            <span class="spec-value">10 Gbps</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot available"></span>
                            <span style="font-weight: 600; color: #10b981;">Disponible (65% libre)</span>
                        </div>
                        <span class="badge badge-success">Actif</span>
                    </div>
                </div>
            </div>

            <div class="resource-card" data-category="stockage">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">Dell EMC Unity 480</div>
                        <div class="resource-type">Baie de Stockage SAN</div>
                    </div>
                    <div style="font-size: 2rem;">💾</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Capacité:</span>
                            <span class="spec-value">30 TB All-Flash</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Type:</span>
                            <span class="spec-value">Full SSD NVMe</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">RAID:</span>
                            <span class="spec-value">RAID 5/6</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Protocoles:</span>
                            <span class="spec-value">FC, iSCSI, NVMe-oF</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Débit:</span>
                            <span class="spec-value">16 Gbps FC</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot maintenance"></span>
                            <span style="font-weight: 600; color: #ef4444;">Maintenance</span>
                        </div>
                        <span class="badge badge-danger">Disponible le 28/12/2025</span>
                    </div>
                </div>
            </div>

            <!-- Équipements Réseau -->
            <div class="resource-card" data-category="reseau">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">Cisco Catalyst 9300</div>
                        <div class="resource-type">Switch Core</div>
                    </div>
                    <div style="font-size: 2rem;">🌐</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Ports:</span>
                            <span class="spec-value">48 x 1/10 Gbps</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Uplink:</span>
                            <span class="spec-value">4 x 40 Gbps QSFP+</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Capacité:</span>
                            <span class="spec-value">880 Gbps</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Features:</span>
                            <span class="spec-value">StackWise, PoE+, VLAN</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Emplacement:</span>
                            <span class="spec-value">Salle réseau principale</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot available"></span>
                            <span style="font-weight: 600; color: #10b981;">Disponible</span>
                        </div>
                        <span class="badge badge-success">Actif</span>
                    </div>
                </div>
            </div>

            <div class="resource-card" data-category="reseau">
                <div class="resource-header">
                    <div>
                        <div class="resource-title">Fortinet FortiGate 600E</div>
                        <div class="resource-type">Firewall</div>
                    </div>
                    <div style="font-size: 2rem;">🔥</div>
                </div>
                <div class="resource-body">
                    <div class="resource-specs">
                        <div class="spec-item">
                            <span class="spec-label">Débit:</span>
                            <span class="spec-value">10 Gbps Firewall</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Interfaces:</span>
                            <span class="spec-value">16 x GbE, 2 x 10GbE SFP+</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">VPN:</span>
                            <span class="spec-value">2000 tunnels IPSec</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Features:</span>
                            <span class="spec-value">IPS, Antivirus, Web Filtering</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">HA:</span>
                            <span class="spec-value">Active-Passive</span>
                        </div>
                    </div>
                    <div class="resource-status">
                        <div class="status-indicator">
                            <span class="status-dot busy"></span>
                            <span style="font-weight: 600; color: #f59e0b;">En production</span>
                        </div>
                        <span class="badge badge-warning">Infrastructure critique</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-state-icon">🔍</div>
            <h3>Aucune ressource trouvée</h3>
            <p>Essayez de modifier vos critères de recherche ou de sélectionner une autre catégorie.</p>
        </div>
    </div>

    <!-- Footer -->

    <script>
        // Menu mobile toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        menuToggle.addEventListener('click', () => navMenu.classList.toggle('active'));

        // Category filtering
        const tabButtons = document.querySelectorAll('.tab-button');
        const resourceCards = document.querySelectorAll('.resource-card');
        const searchInput = document.getElementById('searchInput');
        const resourceGrid = document.getElementById('resourceGrid');
        const emptyState = document.getElementById('emptyState');

        let currentCategory = 'all';
        let searchTerm = '';

        function filterResources() {
            let visibleCount = 0;

            resourceCards.forEach(card => {
                const category = card.dataset.category;
                const text = card.textContent.toLowerCase();
                
                const categoryMatch = currentCategory === 'all' || category === currentCategory;
                const searchMatch = text.includes(searchTerm.toLowerCase());

                if (categoryMatch && searchMatch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                resourceGrid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                resourceGrid.style.display = 'grid';
                emptyState.style.display = 'none';
            }
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                currentCategory = button.dataset.category;
                filterResources();
            });
        });

        searchInput.addEventListener('input', (e) => {
            searchTerm = e.target.value;
            filterResources();
        });
    </script>
    
@endsection
