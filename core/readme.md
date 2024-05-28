Ce namespace Core est mon propre namespace qui n'est pas globale à l'application
c'est le coeur de notre plateforme
NARIHY
Tambazako eric manana

Dans cette méthode, j'ai une instance de transaction reference.
$transaction_reference = TransactionReference::where('expediteur_argent', $compte_bancaire->numero_compte)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();
J'ai une classe Gestion de compte, dans cette classe, j'ai pour constructeur
 public function __construct($tableau)
    {
        $this->tableau = $tableau;
    }
qui injectent l'insatnce de $tansaction_reference dans ma classe. Dans le model Transaction reference, en y trouve les éléments suivant: 
        'description_transfert',
        'expediteur_argent',
        'destinataire_argent',
        'transaction_reference',
        'montant'
dans ma classe gestion de compte, je veux calculer la somme totale des montant dans les éléments récupérer dans $transaction_reference
***********************

Maintenat voici ma classe:
<?php

namespace Core\Banque;

use App\Models\TransactionReference;
use Core\Chiffre\BaseChiffre;
use Core\Interface\Banque\GestionDeCompteInterface;

class GestionDeCompte implements GestionDeCompteInterface
{
    /** @var string $numero_compte_expediteur récupération d'un numero de compte */
    private $numero_compte_expediteur;
    /**
     * On a besoin de récupérer les éléments dans les table transaction référence
     * pour pouvoir lancer notre script
     *
     * @param string $numero_compte_expediteu le numero de compte de l'utilisateur connecter ou l'expediteur
     */
    public function __construct($numero_compte_expediteur)
    {
        $this->numero_compte_expediteur = $numero_compte_expediteur;
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
        $transactionReference = TransactionReference::where('expediteur_argent', $this->numero_compte_expediteur)
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
        $transactionReference = TransactionReference::where('destinataire_argent', $this->numero_compte_expediteur)
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        // Calculer la somme totale des montants
        $sommeTotale = $transactionReference->sum('montant');
        $argent_formater = new BaseChiffre($sommeTotale, 3);
        return $argent_formater->formatage_argent();
    }
}

voici mon interface
<?php
namespace Core\Interface\Banque;

interface GestionDeCompteInterface
{
    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent envoyer par un utilisateur
     *  argent resortie est sous format formater
     * @return string
     */
    public function calculerSommeTotaleDesMontantsDebiteur(): string;

    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent reçu par un utilisateur
     *  argent resortie est sous format formater
     * @return string
     */
    public function calculerSommeTotaleDesMontantCrediteur(): string;
}

Essayer d'ajouter des méthodes qui est relative pour la gestion d'une compte bancaire en faison en sorte que cette classe est une classe mère


en php créer une classe qui permet de vérifier un numéro de téléphone:
On verifie si le numero de téléphone commence par: 032 ou 033 ou 034 ou 037 ou 038 ou +261

si le numéro commence par 032 ou 033 ou 034 ou 037 ou 038: verifier si le numero donner est de 10 chiffre, si oui retourner vrai
si le numéro commence par +261 alors retourner vrai sinon retourner faux 

*******************

Donner 4 force que peut avoir une banque avec des description sur chaqu'une des force
