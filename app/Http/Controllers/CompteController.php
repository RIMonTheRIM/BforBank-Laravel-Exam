<?php

namespace App\Http\Controllers;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use App\Models\Statut;
use App\Models\StatutCarte;
use App\Models\Transaction;
use App\Models\TypeCompte;
use App\Models\TypeTransaction;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

//TODO: améliorer le CSS de sidebar avec le moyen de savoir sur quelle page on se trouve
//DONE: pagination des tableaux et amélioration de la lisibilité des td
//DONE: page info compte
//DONE: for client side, style the page where user has to chose between the 2 types of accounts
//DONE: send a message when user creates a new account and waits for validation
//DONE: make dashboard for all the operations in user account
//DONE: show history of transactions
//DONE: show solde
//DONE: show operations depending on account type
//DONE: generate credit card only if it's compte courant
//DONE: PDF for both the history and the card


//DONE: manage the creation of the carte bancaire
//DONE: make the back of the card with CVV (3D transition if possible)
class CompteController extends Controller
{
//    public function dashboard($id){
//        $user = Auth::user();
//        $comptesListe = $user->comptebancaires;
//        $comptesActifs = $comptesListe->filter(function ($compte) {
//            return $compte->statut === Statut::Accepte->value;
//        });
//        $compteUser = CompteBancaire::find($id);
//        $solde = $this->decryptSolde($compteUser->solde);
//
//        $transactionsList = $compteUser->transactions;
////        $transactionsList = Transaction::with('compteBancaire')->get();
//
//        return view('dashboard', compact('user', 'id', 'comptesActifs', 'compteUser', 'solde', 'transactionsList'));
//    }
//    public function showTransaction($id)
//    {
//        $user = Auth::user();
//        $comptesListe = $user->comptebancaires;
//        $comptesActifs = $comptesListe->filter(function ($compte) {
//            return $compte->statut === Statut::Accepte->value;
//        });
//        $compteUser = CompteBancaire::find($id);
//        return view('transaction', compact('user', 'id', 'comptesActifs', 'compteUser'));
//    }
    public function depot(Request $request)
    {
        $request->validate([
            'sommeDepot' => 'required|numeric|min:1'
        ], [
            'sommeDepot.numeric' => 'Entrez un nombre',
            'sommeDepot.required' => 'Entrez une valeur',
            'sommeDepot.min' => 'Entrez une somme supérieure à 0'
        ]);
        $compte = CompteBancaire::find($request->idCompte);

        $solde = $this->getSolde($request->idCompte);

        $solde+= $request->sommeDepot;

        $solde = $this->cryptSolde($solde);
        $compte->solde = $solde;
        $compte->save();
            //DONE:: send back to database

        $transaction = new Transaction();
        $transaction->type = TypeTransaction::Depot->value;
        $transaction->montant = $request->sommeDepot;
        $transaction->date_transaction = new \DateTime();
        $transaction->comptebancaire_id = $request->idCompte;
        $transaction->save();

        return redirect("/dashboard/compte/$request->idCompte");
    }
    public function retrait(Request $request)
    {
        $request->validate([
            'sommeRetire' => 'required|numeric|min:1'
        ], [
            'sommeRetire.numeric' => 'Entrez un nombre',
            'sommeRetire.required' => 'Entrez une valeur',
            'sommeRetire.min' => 'Entrez une somme supérieure à 0'
        ]);
        $compte = CompteBancaire::find($request->idCompte);
        if (!$compte) {
            return back()
                ->withErrors(['sommeRetire' => "Compte introuvable"])
                ->withInput();
        }

        $solde = $this->getSolde($request->idCompte);
        if ($solde < $request->sommeRetire) {
            return back()
                ->withErrors(['sommeRetire' => "Solde insuffisant pour cette opération"])
                ->withInput();
        }

        if ($compte->type_compte === TypeCompte::Epargne->value) {
            $retraitCompteur = $this->checkNbrRetraits($request->idCompte);
            if ($retraitCompteur >= 2) {
                return back()
                    ->withErrors(['sommeRetire' => "Votre nombre limite de retraits mensuels a déjà été atteint"])
                    ->withInput();
            }
        }

        $this->processRetrait($compte, (float) $request->sommeRetire);

        return redirect("/dashboard/compte/$request->idCompte");
    }

    private function processRetrait(CompteBancaire $compte, float $amount)
    {
        $solde = $this->cryptSolde($this->getSolde($compte->id) - $amount);
        $compte->solde = $solde;
        $compte->save();

        Transaction::create([
            'type' => TypeTransaction::Retrait->value,
            'montant' => $amount,
            'date_transaction' => now(),
            'comptebancaire_id' => $compte->id
        ]);
    }
    public function getSolde($idCompte)
    {
        $compte = CompteBancaire::find($idCompte);
        if ($compte->type_compte == TypeCompte::Courant->value){
            $solde = $compte->solde;
            return $this->decryptSolde($solde);
        }else{
            $this->calcInterets($idCompte);
            $solde = $compte->solde;
            return $this->decryptSolde($solde);
        }
    }
    private function calcInterets($idCompte){
        $compte = CompteBancaire::find($idCompte);
        $listeTransactions = Transaction::where('comptebancaire_id',$idCompte)
            ->where('type', TypeTransaction::Depot->value)
            ->orWhere('type', TypeTransaction::Retrait->value)
            ->get();
        $solde = 0;

        //DONE: get the first depot
        $firstDepot = $listeTransactions->sortBy('created_at')->first();
        //DONE: get the date that increments the solde = TargetDate
        $firstDate = Carbon::parse($firstDepot->created_at);

        foreach ($listeTransactions as $transaction){
            $date2 = Carbon::parse('2024-04-01');
            $yearsDifference = $firstDate->diffInYears($date2);
            if ($transaction->type==TypeTransaction::Depot->value)  $solde += $transaction->montant*$yearsDifference*1.03;
            if ($transaction->type==TypeTransaction::Retrait->value)  $solde -= $transaction->montant*$yearsDifference*1.03;
        }
        $compte->solde = $this->cryptSolde($solde);
        $compte->save();
    }
    public function virement(Request $request){
        $request->validate([
            'sommeVirement' => 'required|numeric|min:1',
            'numCompteDest' => 'required|numeric'
        ], [
            'sommeVirement.numeric' => 'Entrez un nombre',
            'sommeVirement.required' => 'Entrez une valeur',
            'sommeVirement.min' => 'Entrez une somme supérieure à 0',
            'numCompteDest.numeric' => 'Entrez un numéro de compte valide',
            'numCompteDest.required' => 'Entrez une valeur',
        ]);

        $idCompteDest = CompteBancaire::where("numero_de_compte", $request->numCompteDest)->value('id');

        if(isset($idCompteDest) and $idCompteDest!=null and $request->idCompte != $idCompteDest){
            //DONE: compte expéditeur
            $compteExp = CompteBancaire::find($request->idCompte);
            $compteType = $compteExp->type_compte;
            if ($compteType == TypeCompte::Courant->value){
                $soldeExp = $compteExp->solde;
                $soldeExp = $this->decryptSolde($soldeExp);

                //DONE: compte destinataire
                $compteDest = CompteBancaire::where("numero_de_compte", $request->numCompteDest)->first();
                $soldeDest= $compteDest->solde;
                $soldeDest = $this->decryptSolde($soldeDest);


                if ($soldeExp<$request->sommeVirement){
                    return back()
                    ->withErrors(['sommeVirement' => "Solde insuffisant pour cette opération"])
                    ->withInput();
                }else {
                    $soldeExp -= $request->sommeVirement;
                    $soldeExp = $this->cryptSolde($soldeExp);

                    $soldeDest += $request->sommeVirement;
                    $soldeDest = $this->cryptSolde($soldeDest);

                    $compteDest->solde = $soldeDest;
                    $compteDest->save();

                    $compteExp->solde = $soldeExp;
                    $compteExp->save();

                    $transaction = new Transaction();
                    $transaction->type = TypeTransaction::Virement->value;
                    $transaction->montant = $request->sommeVirement;
                    $transaction->date_transaction = new \DateTime();
                    $transaction->comptebancaire_id = $request->idCompte;
                    $transaction->compte_dest_id = $idCompteDest;
                    $transaction->save();
                }
            }else{
                return back()
                    ->withErrors(['sommeVirement' => "Un compte épargne ne peut pas faire de virement"])
                    ->withInput();
            }
        }else{
            return back()
                ->withErrors(['sommeVirement' => "Vous ne pouvez pas faire un virement à votre propre compte"])
                ->withInput();
        }
        return redirect("/dashboard/compte/$request->idCompte");
    }


    public function createCarte($idCompte){
        $carteBancaire = new CarteBancaire();
        $carteBancaire->date_expiration = Carbon::now()->addYear();
        $carteBancaire->statut = StatutCarte::Active->value;
        $carteBancaire->comptebancaire_id = $idCompte;
        $carteBancaire->numero_carte = $this->getNewNumeroCarte() ;
        $carteBancaire->CVV = $this->getCVV($carteBancaire->numero_carte);
        $carteBancaire->save();

        //DONE: return somewhere
        return redirect("/dashboard/compte/$idCompte");
    }
    public function pdfCarte($id)
    {
        //DONE: go to carte page
        //DONE: download carte page
        $user = Auth::user();
        $compteUser = CompteBancaire::find($id);
        $carteBancaire = $compteUser->carteBancaire;
        $numCarte = null;
        if(isset($carteBancaire->numero_carte) and $carteBancaire->numero_carte!=null){
            $numCarte = trim(chunk_split($carteBancaire->numero_carte, 4, ' '));
        }
        $dateCarte = null;
        if(isset($carteBancaire->date_expiration) and $carteBancaire->date_expiration!=null){
            $date = new DateTime($carteBancaire->date_expiration);
            $dateCarte = $date->format('d/m');
        }

        $html = view('pdf.carte-bancaire', [
            'user' => $user,
            'id' => $id,
            'compteUser' => $compteUser,
            'carteBancaire' => $carteBancaire,
            'numCarte' => $numCarte,
            'dateCarte' => $dateCarte],

        )->render();
//        $html = '<h1>Test PDF</h1>';
//        return response()->streamDownload(function () use ($html) {
//            echo Browsershot::html($html)
//                ->format('A4')
//                ->waitUntilNetworkIdle()
//                ->pdf();
//        }, 'carte-bancaire.pdf');
        Browsershot::html($html)
            ->showBackground()
            ->save(storage_path('app/public/pdf/example.pdf'));
        return response()->download(storage_path('app/public/pdf/example.pdf'))->deleteFileAfterSend(true);
    }
    public function pdfHisto($id)
    {
        $transactionsList = Transaction::where("comptebancaire_id",$id)->orderBy('created_at', 'desc')->get();
        $html = view('pdf.historique', [
            'transactionsList' => $transactionsList
        ])->render();
        Browsershot::html($html)
            ->showBackground()
            ->save(storage_path('app/public/pdf/example.pdf'));
        return response()->download(storage_path('app/public/pdf/example.pdf'))->deleteFileAfterSend(true);
    }
    //HELPERS
    private function cryptSolde($solde)
    {
        return Crypt::encrypt($solde);
    }
    private function decryptSolde($encryptedSolde)
    {   $solde = Crypt::decryptString($encryptedSolde);
        return unserialize($solde);
    }

    private function checkNbrRetraits($id)
    {
        //DONE: check nbr retraits du compte ce mois ci
        $listeRetraits = Transaction::where('comptebancaire_id',$id)
            ->where('type', TypeTransaction::Retrait->value)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
        return count($listeRetraits);
    }

    private function getNewNumeroCarte()
    {
        $BIN = "453945";
        do{
            $numberCarte = random_int(1000000000, 9999999999);
        }while(!$this->checkIfUnique($numberCarte));
        return $BIN.$numberCarte;
    }

    private function checkIfUnique(int $numberCarte)
    {
        if(!CarteBancaire::where('numero_carte',$numberCarte)->exists()){
            return true;
        }
        return false;
    }
    private function getCVV($numeroCarte)
    {
        $SECRET = "1234";
        $str = $SECRET.$numeroCarte;
        $binhash = md5($str, true);
        $numhash = unpack('N2', $binhash);
        return substr((string)$numhash[1], 0, 3);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function returnDashboard($id): Application|Factory|\Illuminate\Foundation\Application|View
    {
        $user = Auth::user();
        $comptesListe = $user->comptebancaires;
        $comptesActifs = $comptesListe->filter(function ($compte) {
            return $compte->statut === Statut::Accepte->value;
        });
        $compteUser = CompteBancaire::find($id);
        $solde = $this->decryptSolde($compteUser->solde);

//        $transactionsList = $compteUser->transactions;
        $transactionsList = Transaction::where("comptebancaire_id",$id)->orderBy('created_at', 'desc')->paginate(5);
//        $transactionsList = Transaction::with('compteBancaire')->get();
        $carteBancaire = $compteUser->carteBancaire;
        $numCarte = null;
        if(isset($carteBancaire->numero_carte) and $carteBancaire->numero_carte!=null){
            $numCarte = trim(chunk_split($carteBancaire->numero_carte, 4, ' '));
        }
        $dateCarte = null;
        if(isset($carteBancaire->date_expiration) and $carteBancaire->date_expiration!=null){
            $date = new DateTime($carteBancaire->date_expiration);
            $dateCarte = $date->format('d/m');
        }
        return view('dashboard', compact('user', 'id', 'comptesActifs', 'compteUser', 'solde', 'transactionsList','carteBancaire','numCarte','dateCarte'));
    }
}
