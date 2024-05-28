<?php

namespace Core\Banque;

use App\Models\CompteBancaire;
use App\Models\TransactionReference;
use Core\Chiffre\BaseChiffre;
use Core\Chiffre\VerificationNumero;
use Core\Interface\Banque\GestionDeCompteInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class GestionDeCompte implements GestionDeCompteInterface
{
    /** @var string $numero_compte récupération d'un numero de compte */
    private $numero_compte;
    /**
     * On a besoin de récupérer les éléments dans les table transaction référence
     * pour pouvoir lancer notre script
     *
     * @param string $numero_compte_expediteu le numero de compte de l'utilisateur connecter ou l'expediteur
     */
    public function __construct($numero_compte)
    {
        $this->numero_compte = $numero_compte;
    }

    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent envoyer par un utilisateur
     *
     * @return string
     */
    public function calculerSommeTotaleDesMontantsDebiteur(): string
    {
        // Récupérer l'instance de TransactionReference
        $transactionReference = TransactionReference::where('expediteur_argent', $this->numero_compte)
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        // Calculer la somme totale des montants
        $sommeTotale = $transactionReference->sum('montant');
        $argent_formater = new BaseChiffre($sommeTotale, 3);
        return $argent_formater->formatage_argent();
    }

    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent reçu par un utilisateur
     *
     * @return string
     */
    public function calculerSommeTotaleDesMontantCrediteur(): string
    {
        // Récupérer l'instance de TransactionReference
        $transactionReference = TransactionReference::where('destinataire_argent', $this->numero_compte)
                                                        ->orderBy('created_at', 'desc')
                                                        ->get();
        // Calculer la somme totale des montants
        $sommeTotale = $transactionReference->sum('montant');
        $argent_formater = new BaseChiffre($sommeTotale, 3);
        return $argent_formater->formatage_argent();
    }

    /**
     * Effectue un dépôt sur le compte.
     * Tout d'abord je vais récupérer le solde déjàs incluse dans le compte bancaire
     * Ensuite, je vais ajouter aux solde qui est déjàs incluse dans le compte bancaire le
     * montant qui vient d'être ajouter
     * ensuite, retourner vrai si tous c'est bien passer sinon retourner faux
     *
     * @param float $montant Montant à déposer
     * @param int $compte_id Identification du compte bancaire
     * @return bool Retourne vrai si le dépôt est effectué avec succès, sinon faux
     */
    public function deposer(float $montant, int $compte_id): bool
    {
        /** @var CompteBancaire $compte_bancaire Instance du compte bancaire de l'utilisateur */
        $compte_bancaire = CompteBancaire::findOrFail($compte_id);
        try {
            /** @var float $solde_bancaire_recent Conversion en float de l'ancien solde bancaire de l'utilisateur */
            $solde_bancaire_recent = floatval($compte_bancaire->solde);
            $solde_actuelle = $solde_bancaire_recent + $montant;
            //injection dans un tableau
            $solde_a_jour = [
                'solde' => $solde_actuelle
            ];
            $compte_bancaire->update($solde_a_jour);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Effectue un retrait sur le compte.
     * Récuperer le compte bancaire
     * Avant toutes chose on vérifie d'abord le nuémro de téléphone de l'utilisateur
     * L'action que fait le retrait:
     * On retire de l'argent dans le solde du compte bancaire de l'utilisateur + frais,
     * c'est à dire si l'utilisateur retire 5000 ar dans son compte bancaire le programe
     * vas retirer 5000 + 150 (frais) = 5150 MGA d'où on vas faire une petite règle de trois
     *  5000 -> 150
     *  6000 -> ?
     *  Formule = Montant_a_retirer * frais / base
     *
     * puis on envoie la solde directement dans le mobile money de l'utilisateur
     * On envoie le montant demander par l'utilisateur dans son mobile money, ensuite on envoye le
     * frais dans le compte bancaire de notre société
     *
     * Nb:
     * Action 1 -> débiter vers le compte bancaire
     * Action 2 -> le compte Bancaire debite le numéro de téléphone de l'utilisateur
     *
     * @param float $montant Montant à retirer
     * @param string $telephone le numéro de téléphone à débiter
     * @return bool | RedirectResponse Retourne vrai si le retrait est effectué avec succès, sinon faux
     */
    public function retirer(float $montant, string $telephone): bool | RedirectResponse
    {
        try {
            $verification_numero = new VerificationNumero();
            if($verification_numero::verifierNumero($telephone) !== true) {
                return redirect()->back()->with('erreurs', 'Le numéro que vous nous avez envoyez n\'éxiste pas. Veuillez réésseiller avec une autre numéro de téléphone valide');
            }
            /** @var CompteBancaire $compte_bancaire_debit Recup du compte de l'utilisateur */
            $compte_bancaire_debit = CompteBancaire::where('users_id', Auth::user()->id)->firstOrFail();
            /** @var CompteBancaire $compte_bancaire_credit Recuperation du compte banacire de notre entreprise */
            $compte_bancaire_credit = CompteBancaire::where('numero_compte', '00000000000000')->firstOrFail();
            //récupération du frais
            $frais = $montant * 150 / 5000;
            $montant_totale = $montant + $frais;
            //Verifier si l'utilisateur à le solde totale à retirer
            if($montant_totale > $compte_bancaire_debit->solde) {
                return redirect()->back()->with('erreurs', 'Votre compte ne possèdent pas le solde nécéssaire pour faire cette transaction');
            }
            //Envoyer de l'argent dans le compte de l'entreprise
            $envoyer_argent_dans_cbc = $this->deposer($montant_totale, $compte_bancaire_credit->id);
            if($envoyer_argent_dans_cbc !== true) {
                return redirect()->back()->with('erreurs', 'Il y eu une erreur veuillez rééseillez plus tard.');
            }
            //Action à faire pour renvoyer la solde dans le numéro de téléphone de l'utilisateur, pour le moment on vas se contenter de ne pas le faire mais de retirer seulement le montant a retirer de l'utilisateur dans le compte de l'entreprise
            $nouveau_solde = $compte_bancaire_debit->solde - $montant_totale;
            $data_solde = [
                'solde' => $nouveau_solde
            ];
            $compte_bancaire_debit->update($data_solde);
            //solde de l'entreprise = solde present + nouveau solde
            $nouveau_solde_entreprise = $compte_bancaire_credit->solde + $frais;
            $compte_bancaire_credit->update([
                'solde' => $nouveau_solde_entreprise
            ]);
            //On créer une instance de transaction référance
            $transaction_reference = [
                'description_transfert' => 'demande de retrait d\'argent par '.$compte_bancaire_debit->users->last_name. ' '. $compte_bancaire_debit->users->name,
                'expediteur_argent' =>  $compte_bancaire_debit->numero_compte,
                'destinataire_argent' =>  $compte_bancaire_credit->numero_compte,
                'transaction_reference' => $this->reference_tansaction(),
                'telephone' => $telephone,
                'montant' => $montant_totale
            ];
            $transaction = TransactionReference::create($transaction_reference);
            return true;
        } catch(\Exception $e) {
            // decommenter si il y a eu une erreur
            //return redirect()->back()->with('erreurs', $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie le solde disponible sur le compte.
     * Nécessaire uniquement pour l'api
     *
     * @return float|null Retourne le solde disponible, ou null en cas d'erreur
     */
    public function verifierSolde(): ?float
    {
        // Code pour vérifier le solde disponible sur le compte
        // Retourne le solde disponible ou null en cas d'erreur
        return 6.2;
    }

    /**
     * Effectue un virement depuis ce compte vers un autre compte.
     * On envoye directement l'argent dans un autre compte, le principe n'est pas le même
     * les frais ne change mais on ajoute seulement un taxe de transfert: Taxe = 2% de l'argent à envoyer
     * d'ou formule = Montant_a_retirer * frais / base + taxe, on injincte directement le taxe dans la transaction référence
     *  Gros bug ici, le montant totale retirer ne correspond pas au reste du solde de l'utilisateur
     * par exemple,  si je retire 1000 Ar d'où le frais est de 50 Ar, donc si on fait le
     * calcule on doit retirer 1050 Ar du compte du débiteur, mais il retire plus que ça
     * Et faire que si il y a une erreur reseau, les actions ne doivent pas être enregistrer
     * @param array $donner infection des données valider dans une tableau
     * @return bool | RedirectResponse Retourne vrai si le virement est effectué avec succès, sinon faux
     */
    public function effectuerVirement(array $donner): bool | RedirectResponse
    {
        /** @var CompteBancaire $compte_bancaire_debit Recup du compte de l'utilisateur */
        $compte_bancaire_debit = CompteBancaire::where('users_id', Auth::user()->id)->firstOrFail();
        /** @var CompteBancaire $compte_bancaire_credit Recuperation du compte banacire de notre entreprise  normalement si faux ça renvoye une erreur 404 */
        $compte_bancaire_credit = CompteBancaire::where('numero_compte', $donner['destinataire_argent'])->firstOrFail();
        try {
            //Récuperation des données valider par l'utilisateur
            /** @var string $transaction_refenrence Référence de la transaction  */
            $transaction_refenrence =  $this->reference_tansaction();
            //Calcule Montant
            $montant_intiale = $donner['montant'];
            //Récup du taux
            $taux_recuperer = ($montant_intiale * 2) / 100;
            //récupération du frais
            $frais = ($montant_intiale * 150 / 5000) + $taux_recuperer;
            $montant_totale = $montant_intiale + $frais;
            //Pour le solde debiteur récupérer le solde + mis à jour du nouveau solde
            if ($this->verification_solde($compte_bancaire_debit->id, $montant_totale) !== true) {
                return redirect()->back()->with('erreur', 'Erreur, solde insuffisant');
            }
            $montant_debiteur_finale = $compte_bancaire_debit->solde - $montant_totale;
            $compte_bancaire_debit->update(
                [
                    'solde' => $montant_debiteur_finale
                ]
            );
            //Pour le créditeur
            $montant_crediteur_finale = $compte_bancaire_credit->solde + $montant_intiale;
            $compte_bancaire_credit->update(
                [
                    'solde' => $montant_crediteur_finale
                ]
                );
            //Formulation des requete
            $description = 'Votre demande pour le transfert d\'argent vers le compte de '. $compte_bancaire_credit->users->last_name.' '. strtoupper($compte_bancaire_credit->users->name) .' s\'est bien déroulé avec succès. Description:' .$donner['description_transfert'];
            $ref = [
                'description_transfert' => $description,
                'expediteur_argent' => $compte_bancaire_debit->numero_compte,
                'destinataire_argent' => $compte_bancaire_credit->numero_compte,
                'transaction_reference' => $transaction_refenrence,
                'montant' => $montant_totale,
                'taux_recuperer' => $taux_recuperer
            ];
            try {
                $transaction = TransactionReference::create($ref);
            } catch (\Exception $e) {
                return redirect()->back()->with('erreur', $e->getMessage());
            }
            return true;
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur', $e->getMessage());
        }
    }

    /**
     * Permet de récupérer le frais d'une transaction
     * Formule = Montant_a_retirer * frais / base
     * on devrait calculer le frais fait par la transaction
     * Le problématique c'est comment calculer le frais d'une transaction déjàs fait
     * et non refaire le calcule du tranction.
     * cela rend à 149,555......6
     * On ajoute 4 ar pour récupérer la différence entre les formule
     * Nb: !! important
     * SI on prend la premiere formule, il y a une manque de 4,555......9 Ar
     * Si on prend la deuxieme formule, il y a une suplus de 4,555......9 Ar
     * D'ou j'ai ajouter 4 ar à 150 pour comblé le manque ou le surplus
     * d'ou le taux de frais est monter à 3.08%
     * Gros bug?????
     * Le gros bug est résolu avec le calcule de la différence
     * @param float $montant Montant totale
     *
     * @return float
     */
    private function recuperation_frais(float $montant):float
    {
        //Calcule difference entre les montant du notez bien car les 4 Ar dépend du montant en question
        $difference = $montant * 4.5 /  5150;
        //Ajouter la différence dans le frasi minimale pour corriger les bug de frais
       // FAux -> $frais =  5000 * (150 + $difference) / $montant;
       $frais =  ($montant /5000 * 150 ) - $difference ;
        return floor($frais);
    }

    /**
     * Avec formatage
     *
     * @param float $montant
     * @return string
     */
    public function frais_formater_transaction(float $montant): string
    {
        $montant_recuperer = $this->recuperation_frais($montant);
        $arg = new BaseChiffre($montant_recuperer, 3);
        return $arg->formatage_argent();
    }

    /**
     * Permet de recuperer le frais avec un taux
     *
     * @param string $transId l'id de la transaction
     * @return string
     */
    public function recuperation_frais_virement(string $transId): string
    {
        $transaction = TransactionReference::findOrFail($transId);
        $montant_sans_taux = $transaction->montant - $transaction->taux_recuperer;
        $difference = $montant_sans_taux * 4.5 /  5150;
        $frais =  ($montant_sans_taux /5000 * 150 ) - $difference ;
        $frais_totale = $frais + $transaction->taux_recuperer;
        $arg = new BaseChiffre($frais_totale, 3);
        return $arg->formatage_argent();
    }

    /**
     * Retourne la référence d'une transaction
     *
     * @return string
     */
    private function reference_tansaction(): string
    {
        return uuid_create();
    }

    /**
     * Verifie si l'utilisateur à le solde à retirer ou pas
     * @param string $compteBancaireId Identification du compte bancaire à vérifier
     * @param string $montant_totale Montant à vérifier
     * @return bool
     */
    private function verification_solde(string $compteBancaireId, string $montant_totale): bool
    {
        $compte = CompteBancaire::findOrFail($compteBancaireId);
        if($compte->solde >= $montant_totale) {
            return true;
        }
        return false;
    }
}


