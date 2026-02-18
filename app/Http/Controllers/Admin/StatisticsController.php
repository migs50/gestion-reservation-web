<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ressource;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // 1) Période sélectionnée (1,3,9,30 jours)
        $periode = (int) $request->get('periode', 7);

       // ✅ Corrigé — inclut passé ET futur (30 jours autour d'aujourd'hui)
$dateFin = $request->filled('date_fin')
    ? Carbon::parse($request->date_fin)->endOfDay()
    : Carbon::parse('2099-12-31')->endOfDay(); // tout le futur

$dateDebut = $request->filled('date_debut')
    ? Carbon::parse($request->date_debut)->startOfDay()
    : Carbon::parse('2000-01-01')->startOfDay(); // tout le passé

        // Période précédente pour comparer
        $diffDays      = $dateDebut->diffInDays($dateFin) + 1;
        $prevDateFin   = $dateDebut->copy()->subDay()->endOfDay();
        $prevDateDebut = $prevDateFin->copy()->subDays($diffDays - 1)->startOfDay();

        // 2) Stats de base sur la période actuelle
        $reservationsPeriod = Reservation::whereBetween('debut', [$dateDebut, $dateFin]);

        $totalReservations = (clone $reservationsPeriod)->count();

        $approvedReservations = (clone $reservationsPeriod)
            ->where('statut', 'approved')
            ->count();

        $avgDuration = (clone $reservationsPeriod)
            ->selectRaw('AVG(TIMESTAMPDIFF(DAY, debut, fin)) as avg_days')
            ->value('avg_days') ?? 0;

        // Taux d’occupation moyen = % de ressources ayant au moins une réservation approuvée
        $totalRessources = Ressource::count();

        $ressourcesOccupees = Ressource::whereHas('reservations', function ($q) use ($dateDebut, $dateFin) {
                $q->where('statut', 'approved')
                  ->whereBetween('debut', [$dateDebut, $dateFin]);
            })
            ->count();

        $tauxOccupation = $totalRessources > 0
            ? round($ressourcesOccupees / $totalRessources * 100, 2)
            : 0;

        // 3) Stats période précédente
        $prevReservations = Reservation::whereBetween('debut', [$prevDateDebut, $prevDateFin]);

        $prevTotalReservations = (clone $prevReservations)->count();

        $prevApproved = (clone $prevReservations)
            ->where('statut', 'approved')
            ->count();

        $prevAvgDuration = (clone $prevReservations)
            ->selectRaw('AVG(TIMESTAMPDIFF(DAY, debut, fin)) as avg_days')
            ->value('avg_days') ?? 0;

        $reservationsChange = $prevTotalReservations > 0
            ? round(($totalReservations - $prevTotalReservations) / $prevTotalReservations * 100, 2)
            : 0;

        $dureeChange = $prevAvgDuration > 0
            ? round(($avgDuration - $prevAvgDuration) / $prevAvgDuration * 100, 2)
            : 0;

        $tauxApprobation = $totalReservations > 0
            ? round($approvedReservations / $totalReservations * 100, 2)
            : 0;

        $prevTauxApprobation = $prevTotalReservations > 0
            ? round($prevApproved / $prevTotalReservations * 100, 2)
            : 0;

        $approbationChange = $prevTauxApprobation > 0
            ? round($tauxApprobation - $prevTauxApprobation, 2)
            : 0;

        // 4) Top utilisateurs
        $topUsers = Reservation::select('demandeur_id', DB::raw('COUNT(*) as reservations_count'))
            ->whereBetween('debut', [$dateDebut, $dateFin])
            ->groupBy('demandeur_id')
            ->orderByDesc('reservations_count')
            ->with('demandeur')
            ->limit(10)
            ->get();

        // 5) Top ressources
        $topRessources = Reservation::select('ressource_id', DB::raw('COUNT(*) as reservations_count'))
            ->whereBetween('debut', [$dateDebut, $dateFin])
            ->groupBy('ressource_id')
            ->orderByDesc('reservations_count')
            ->with('ressource.categorie')
            ->limit(10)
            ->get();

        // 6) Évolution des réservations (ligne)
        $evolution = Reservation::selectRaw('DATE(debut) as date, COUNT(*) as total')
            ->whereBetween('debut', [$dateDebut, $dateFin])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $evolution_data = [
            'labels' => $evolution->pluck('date')->map(fn ($d) => Carbon::parse($d)->format('d/m')),
            'values' => $evolution->pluck('total'),
        ];

        // 7) Répartition par statut (donut)
        $statutRaw = Reservation::select('statut', DB::raw('COUNT(*) as total'))
            ->whereBetween('debut', [$dateDebut, $dateFin])
            ->groupBy('statut')
            ->get();

        $statut_data = [
            'labels' => $statutRaw->pluck('statut'),
            'values' => $statutRaw->pluck('total'),
        ];

        // 8) Réservations par catégorie (barres)
        $categoriesRaw = Reservation::select('categories.nom as categorie', DB::raw('COUNT(*) as total'))
            ->join('ressources', 'reservations.ressource_id', '=', 'ressources.id')
            ->join('categories', 'ressources.categorie_id', '=', 'categories.id')
            ->whereBetween('reservations.debut', [$dateDebut, $dateFin])
            ->groupBy('categories.nom')
            ->orderByDesc('total')
            ->get();

        $categories_data = [
            'labels' => $categoriesRaw->pluck('categorie'),
            'values' => $categoriesRaw->pluck('total'),
        ];

        // 9) Statistiques détaillées
        $totalDemandes = $totalReservations;
        $approuvees    = $approvedReservations;
        $refusees      = (clone $reservationsPeriod)->where('statut', 'refused')->count();
        $enAttente     = (clone $reservationsPeriod)->where('statut', 'pending')->count();

        $utilisateursActifs = User::whereHas('reservations', function ($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('debut', [$dateDebut, $dateFin]);
            })->count();

        $stats = [
            'total_reservations'   => $totalReservations,
            'reservations_change'  => $reservationsChange,
            'taux_occupation'      => $tauxOccupation,
            'occupation_change'    => 0,
            'duree_moyenne'        => round($avgDuration, 2),
            'duree_change'         => $dureeChange,
            'taux_approbation'     => $tauxApprobation,
            'approbation_change'   => $approbationChange,
            'total_demandes'       => $totalDemandes,
            'approuvees'           => $approuvees,
            'refusees'             => $refusees,
            'en_attente'           => $enAttente,
            'ressources_actives'   => $ressourcesOccupees,
            'utilisateurs_actifs'  => $utilisateursActifs,
        ];

        return view('admin.statistics', [
            'stats'           => $stats,
            'top_users'       => $topUsers,
            'top_ressources'  => $topRessources,
            'evolution_data'  => $evolution_data,
            'statut_data'     => $statut_data,
            'categories_data' => $categories_data,
        ]);
    }
}
