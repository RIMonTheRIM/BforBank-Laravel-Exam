<?php
//DONE: encryption of solde
//DONE: create CompteController
//DONE: encryption of solde
//DONE: Dépot
//DONE: Retrait
//DONE: Virement
//DONE: Affichage du solde
//DONE: Historike des transactions
//DONE: !IMPORTANT verify the email on signup
//DONE: make sure when user disconnects you can't go back
//DONE: make sure that comptesActifs are accessible from every page
namespace App\Http\Controllers;

use App\Models\CompteBancaire;
use App\Models\Demande;
use App\Models\Statut;
use App\Models\TypeCompte;
use App\Models\TypeDemande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Random\RandomException;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->isGestionnaire()){
            $listDemandeAttente = Demande::where('statut', Statut::En_Attente)->paginate(5);
            $histoDemande = Demande::whereIn('statut', [Statut::Accepte, Statut::Rejete])->paginate(5);
            return view('gestion.gestionDemandes', compact('user','listDemandeAttente', 'histoDemande'));
        }
        $comptesListe = $user->comptebancaires;
        $comptesActifs = $comptesListe->filter(function ($compte) {
            return $compte->statut === Statut::Accepte->value;
        });
        $isEnAttente = $this->checkDemandeOuvertureByUserId();
        return view('home', compact('user','comptesActifs', 'isEnAttente'));
    }

    public function choice()
    {
        $user = Auth::user();
        $comptesListe = $user->comptebancaires;
        $comptesActifs = $comptesListe->filter(function ($compte) {
            return $compte->statut === Statut::Accepte->value;
        });
        $isEnAttente = $this->checkDemandeOuvertureByUserId();
        return view('accountchoice', compact('user', 'comptesActifs', 'isEnAttente'));
    }
    public function checkDemandeOuvertureByUserId(): bool
    {
        $user = Auth::user();
        $listAttenteCompteIds = Demande::where('statut', Statut::En_Attente)->where('typeDemande', 'validation')->pluck('comptebancaire_id')->toArray();
        foreach ($listAttenteCompteIds as $compteId){
            $compte = CompteBancaire::find($compteId);
            if ($compte && $compte->user_id == $user->id) {
                return true;
            }
        }
        return false;
    }
    public function createDemande($type)
    {
        //DONE: check that user is not gestionnaire
        //TODO: check for different bank and guichet
        //DONE: return confirmation message
        $user = Auth::user();
        $codeBanque = 24242;
        $codeGuichet = 78004;
        $numeroDeCompte = $this->getNewNumeroCompte();
        $comptebancaire = new CompteBancaire();

        $comptebancaire->numero_de_compte = $numeroDeCompte;
        $comptebancaire->code_banque = $codeBanque;
        $comptebancaire->code_guichet = $codeGuichet;
        $comptebancaire->cle_RIB = $this->getCleRIB($numeroDeCompte,$codeBanque,$codeGuichet);
        $comptebancaire->solde = Crypt::encrypt('0');;
        $comptebancaire->statut = Statut::En_Attente->value;
        $comptebancaire->user_id = $user->id;

        if ($type==='courant'){
            $comptebancaire->type_compte = TypeCompte::Courant->value;
        }
        elseif ($type==='epargne'){
            $comptebancaire->type_compte = TypeCompte::Epargne->value;
        }

        $comptebancaire->save();

        $checkCompte = CompteBancaire::where('numero_de_compte',$numeroDeCompte)->first();
        //Creating new demande de création;
        $this->compteCreationValidation($checkCompte->id, TypeDemande::Validation->value);
        return redirect("/home");
    }
    /**
     * @throws RandomException
     */
    private function getNewNumeroCompte()
    {
        do{
            $numero = random_int(10000000000, 99999999999);
        }while(!$this->checkIfUnique($numero));
        return $numero;
    }

    private function checkIfUnique($numero): bool
    {
        if(!CompteBancaire::where('numero_de_compte',$numero)->exists()){
            return true;
        }
        return false;
    }

    private function getCleRIB($numero, $codeBanque, $codeGuichet): int
    {
        $calc1 = 89*$codeBanque;
        $calc2 = 15*$codeGuichet;
        $calc3 = 3*$numero;
        $res1 = ($calc1+$calc2+$calc3)%97;
        return 97-$res1;
    }




    public function compteCreationValidation($id, $typeDemande)
    {
        //TODO: return confirmation message
        $demande = new Demande();
        $demande->comptebancaire_id = $id;
        $demande->typeDemande = $typeDemande;
        $demande->statut = Statut::En_Attente->value;
        $demande->date_demande = new \DateTime();
        $demande->save();
    }
    public function demandeCloture($id)
    {
        $this->compteCreationValidation($id, TypeDemande::Cloture->value);
        return redirect()->back()->with('notification', 'Votre demande de clôture a été enregistrée, Vous recevrez une confirmation via email.');
    }
}
