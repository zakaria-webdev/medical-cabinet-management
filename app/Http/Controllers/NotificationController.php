<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// [Houcine] Contrôleur des notifications - Sprint 2
// Ce contrôleur gère 3 actions liées aux notifications de l'utilisateur connecté :
//   1. index()        → afficher la liste de toutes ses notifications (lues + non lues)
//   2. markAsRead()   → marquer UNE notification spécifique comme lue
//   3. markAllAsRead()→ marquer TOUTES ses notifications non lues comme lues
//
// On utilise $request->user() au lieu de auth()->user() car c'est
// la méthode recommandée dans les contrôleurs avec injection de Request

class NotificationController extends Controller
{
    // index() = affiche toutes les notifications de l'utilisateur connecté
    // Accessible via GET /notifications
    // ->notifications() = relation disponible grâce au trait Notifiable dans User.php
    // ->paginate(15) = afficher 15 notifications par page (évite surcharge si beaucoup)
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()    // récupère toutes les notifications (lues + non lues)
            ->paginate(15);      // paginées par 15

        // On passe les notifications à la vue notifications/index.blade.php
        return view('notifications.index', compact('notifications'));
    }

    // markAsRead() = marque UNE seule notification comme lue
    // Accessible via POST /notifications/{id}/read
    // $id = UUID de la notification (clé primaire dans la table notifications)
    public function markAsRead(Request $request, string $id)
    {
        // On cherche la notification UNIQUEMENT parmi celles de l'utilisateur connecté
        // Sécurité : un utilisateur ne peut pas marquer la notification d'un autre
        // findOrFail() = lance une erreur 404 si la notification n'existe pas
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        // markAsRead() = méthode Laravel qui remplit la colonne read_at avec now()
        // Si read_at est NULL → non lue / Si read_at a une date → lue
        $notification->markAsRead();

        // Rediriger vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Notification marquée comme lue.');
    }

    // markAllAsRead() = marque TOUTES les notifications non lues comme lues
    // Accessible via POST /notifications/read-all
    // ->unreadNotifications = relation Laravel qui filtre où read_at IS NULL
    // ->markAsRead() sur une collection = UPDATE en masse (1 seule requête SQL)
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Toutes les notifications ont été lues.');
    }
}