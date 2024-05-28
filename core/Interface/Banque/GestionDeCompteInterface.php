<?php

namespace Core\Interface\Banque;

use Illuminate\Http\RedirectResponse;

interface GestionDeCompteInterface
{
    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent envoyer par un utilisateur.
     * L'argent retournée est formatée.
     *
     * @return string
     */
    public function calculerSommeTotaleDesMontantsDebiteur(): string;

    /**
     * Récupération de la référence de transaction pour calculer la somme totale
     * des argent reçu par un utilisateur.
     * L'argent retournée est formatée.
     *
     * @return string
     */
    public function calculerSommeTotaleDesMontantCrediteur(): string;

    /**
     * Effectue un dépôt sur le compte.
     *
     * @param float $montant Montant à déposer
     * @param int $compte_id Identification du compte bancaire
     * @return bool Retourne vrai si le dépôt est effectué avec succès, sinon faux
     */
    public function deposer(float $montant, int $compte_id): bool;

    /**
     * Effectue un retrait sur le compte.
     *
     * @param float $montant Montant à retirer
     * @param string $telephone le numéro de téléphone de l'utilisateur à débiter
     * @return bool | RedirectResponse Retourne vrai si le retrait est effectué avec succès, sinon faux
     */
    public function retirer(float $montant, string $telephone): bool | RedirectResponse;

    /**
     * Vérifie le solde disponible sur le compte.
     *
     * @return float|null Retourne le solde disponible, ou null en cas d'erreur
     */
    public function verifierSolde(): ?float;

    /**
     * Effectue un virement depuis ce compte vers un autre compte.
     *
     * @param string $compteDestinataire Numéro de compte du destinataire
     * @param array $donner infection des données valider dans une tableau
     * @return bool bool | RedirectResponse Retourne vrai si le virement est effectué avec succès, sinon faux
     */
    public function effectuerVirement(array $donner): bool | RedirectResponse;

     /**
     * Permet de récupérer le frais d'une transaction
     * @param $montant Montant totale
     * @return float
     */
    public function frais_formater_transaction(float $montant): string;

    /**
     * Recuperation du frais de transaction lors d'un virement d'argent
     * @param string $transId Montant totale
     *
     * @return string
     */
    public function recuperation_frais_virement(string $transId): string;

}
