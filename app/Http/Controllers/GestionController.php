<?php

namespace App\Http\Controllers;

use App\Mail\CustomMail;
use App\Models\CompteBancaire;
use App\Models\Demande;
use App\Models\Statut;
use App\Models\Transaction;
use App\Models\TypeTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GestionController extends Controller
{
    public function demandesDashboard(){
        $user = Auth::user();
        $listDemandeAttente = Demande::where('statut', Statut::En_Attente)->orderBy('created_at', 'desc')->paginate(5 ,['*'], 'attente_page');
        $histoDemande = Demande::whereIn('statut', [Statut::Accepte, Statut::Rejete])->orderBy('created_at', 'desc')->paginate(5, ['*'], 'histo_page');
        return view('gestion.gestionDemandes', compact('user','listDemandeAttente', 'histoDemande'));
    }
    public function transactionsDashboard(){
        $user = Auth::user();
        $listeTransactions = Transaction::orderBy('created_at', 'desc')->paginate(5);
        $listeComptesActifs = CompteBancaire::where("statut", Statut::Accepte)->orderBy('created_at', 'desc') ->pluck("id");
        return view('gestion.gestionTransaction', compact('listeComptesActifs','user', 'listeTransactions'));
    }
    public function comptesDashboard(){
        $user = Auth::user();
        $listeComptes = CompteBancaire::orderBy('created_at', 'desc')->paginate(5);
        $listeComptesActifs = CompteBancaire::where("statut", Statut::Accepte)->orderBy('created_at', 'desc') ->pluck("id");
        foreach ($listeComptes as $compte){
            $solde = Crypt::decryptString($compte->solde);
            $compte->solde = unserialize($solde);
        }
        return view('gestion.gestionComptes', compact('user','listeComptesActifs', 'listeComptes'));
    }
    public function validerDemande($demandeId){
        $demande = Demande::find($demandeId);
        if ($demande) {
            $demande->statut = Statut::Accepte->value;
            $demande->date_traitement = new \DateTime();
            $demande->save();

            $compte = CompteBancaire::find($demande->comptebancaire_id);
            if($compte and $demande->typeDemande == 'validation'){
                $compte->statut = Statut::Accepte->value;
                $compte->save();
                $customMessage = "Votre demande de création de compte a été acceptée, connectez vous pour profiter des fonctionnalités de l'application";
                $email = $compte->user->email;
                Mail::to($email)->send(new CustomMail($customMessage));
            }
            elseif ($compte and $demande->typeDemande == 'cloture'){
                $compte->statut = Statut::En_Attente->value;
                $compte->save();
                $customMessage = "Votre demande de clôture de compte a été acceptée";
                $email = $compte->user->email;
                Mail::to($email)->send(new CustomMail($customMessage));
            }
        }
        return redirect("gesDemandes");
    }
    public function rejetDemande(Request $request, $demandeId){

        $demande = Demande::find($demandeId);
        if ($demande) {
            $demande->statut = Statut::Rejete->value;
            $demande->date_traitement = new \DateTime();
            $demande->raison_rejet = $request->raisonRejet;
            $demande->save();


            $compte = CompteBancaire::find($demande->comptebancaire_id);
            if($compte and $demande->typeDemande == 'validation'){
                $customMessage = "Votre demande de création de compte a été rejetée. Raison de rejet: ".$demande->raison_rejet;
                $email = $compte->user->email;
                Mail::to($email)->send(new CustomMail($customMessage));
                CompteBancaire::destroy($demande->comptebancaire_id);
            }
            elseif ($compte and $demande->typeDemande == 'cloture'){
                $customMessage = "Votre demande de clôture de compte a été rejetée. Raison de rejet: ".$demande->raison_rejet;
                $email = $compte->user->email;
                Mail::to($email)->send(new CustomMail($customMessage));
            }
        }
        return redirect("gesDemandes");
    }
    public function showCompteInfo($idCompte)
    {
        $user = Auth::user();
        $compte = CompteBancaire::find($idCompte);
        $solde = Crypt::decryptString($compte->solde);
        $solde = unserialize($solde);
        $utilisateur = User::find($compte->user_id);
        $transactionsList = Transaction::where("comptebancaire_id",$compte->id)->orderBy('created_at', 'desc')->paginate(5);
        return view('gestion.compteInfo', compact('user','compte', 'solde','utilisateur', 'transactionsList'));
    }
    public function suspendreCompte($idCompte)
    {
        $compte = CompteBancaire::find($idCompte);
        $compte->statut = Statut::En_Attente->value;
        $compte->save();
        return redirect("gesComptes");
    }
    public function revokeTransaction($idTransaction)
    {
        $transaction = Transaction::find($idTransaction);
        $montant = $transaction->montant;
        $compteId = $transaction->comptebancaire_id;
        $type = $transaction->type;
        if($type == TypeTransaction::Depot->value){
            $montant *= -1;
        }else{
            if ($type == TypeTransaction::Virement){
                $compteDest = CompteBancaire::find($transaction->compte_dest_id);
                $solde = Crypt::decryptString($compteDest->solde);
                $solde = unserialize($solde);
                $solde -= $montant;
                $compteDest->solde = Crypt::encrypt($solde);
                $compteDest->save();
            }
        }
        $compte = CompteBancaire::find($compteId);
        $solde = Crypt::decryptString($compte->solde);
        $solde = unserialize($solde);
        $solde += $montant;
        $compte->solde = Crypt::encrypt($solde);
        $compte->save();
        $transaction->delete();
        return redirect("/gesTransactions");
    }
    public function searchDemandeAttente(Request $request)
    {
        if ($request->has('searchIdAttente')) {
            $request->validate([
                'searchIdAttente' => 'numeric|min:1'
            ], [
                'searchIdAttente.numeric' => 'Entrez un nombre',
                'searchIdAttente.min' => 'Entrez une somme supérieure à 0'
            ]);
        }

        $user = Auth::user();

        $listDemandeAttente = Demande::where('statut', Statut::En_Attente);
        if ($request->filled('searchIdAttente')) {
            $listDemandeAttente->where('comptebancaire_id', $request->searchIdAttente);
        }
        $listDemandeAttente = $listDemandeAttente->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'attente_page')
            ->appends($request->only('searchIdAttente'));

        $histoDemande = Demande::whereIn('statut', [Statut::Accepte, Statut::Rejete])->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'histo_page')
            ->appends($request->only('searchIdAttente'));

        return view('gestion.gestionDemandes', compact('user', 'listDemandeAttente', 'histoDemande'));
    }

    public function searchDemande(Request $request)
    {
        if ($request->has('searchIdDemande')) {
            $request->validate([
                'searchIdDemande' => 'numeric|min:1'
            ], [
                'searchIdDemande.numeric' => 'Entrez un nombre',
                'searchIdDemande.min' => 'Entrez une somme supérieure à 0'
            ]);
        }

        $user = Auth::user();

        $listDemandeAttente = Demande::where('statut', Statut::En_Attente)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'attente_page')
            ->appends($request->only('searchIdDemande'));

        $histoDemande = Demande::whereIn('statut', [Statut::Accepte, Statut::Rejete]);
        if ($request->filled('searchIdDemande')) {
            $histoDemande->where('comptebancaire_id', $request->searchIdDemande);
        }
        $histoDemande = $histoDemande->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'histo_page')
            ->appends($request->only('searchIdDemande'));

        return view('gestion.gestionDemandes', compact('user', 'listDemandeAttente', 'histoDemande'));
    }
    public function searchTransaction(Request $request)
    {
        $searchId = $request->input('searchTransactionId');

        // Only validate if the input is present (not just pagination click)
        if ($request->has('searchTransactionId')) {
            $request->validate([
                'searchTransactionId' => 'numeric|min:1'
            ], [
                'searchTransactionId.numeric' => 'Entrez un nombre',
                'searchTransactionId.min' => 'Entrez une somme supérieure à 0'
            ]);
        }

        $user = Auth::user();

        $query = Transaction::query();

        if ($searchId) {
            $query->where('comptebancaire_id', $searchId);
        }

        $listeTransactions = $query->paginate(5)->appends(['searchTransactionId' => $searchId]);

        // Only show "Compte introuvable" if user submitted search AND nothing was found
        if ($request->has('searchTransactionId') && $listeTransactions->total() === 0) {
            return back()
                ->withErrors(['searchTransactionId' => "Compte introuvable"])
                ->withInput();
        }

        $listeComptesActifs = CompteBancaire::where("statut", Statut::Accepte)
            ->orderBy('created_at', 'desc')
            ->pluck("id");

        return view('gestion.gestionTransaction', compact('listeComptesActifs', 'user', 'listeTransactions'));
    }
    public function searchCompte(Request $request)
    {
        $request->validate([
            'searchCompteId' => 'required|numeric|min:1'
        ], [
            'searchCompteId.numeric' => 'Entrez un nombre',
            'searchCompteId.required' => 'Entrez une valeur',
            'searchCompteId.min' => 'Entrez une somme supérieure à 0'
        ]);

        $user = Auth::user();

        $compte = CompteBancaire::find($request->searchCompteId);

        if (!$compte) {
            return back()
                ->withErrors(['searchCompteId' => "Compte introuvable"])
                ->withInput();
        }

        // Just use the ID of the account if it's "Accepte"
        $listeComptesActifs = collect();
        if ($compte->statut === Statut::Accepte->value) {
            $listeComptesActifs = collect([$compte->id]);
        }

        $solde = Crypt::decryptString($compte->solde);
        $compte->solde = unserialize($solde);

        return view('gestion.gestionComptes', [
            'user' => $user,
            'listeComptesActifs' => $listeComptesActifs,
            'listeComptes' => collect([$compte])
        ]);
    }
}
