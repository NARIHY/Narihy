<?php
namespace Core\Interface\Date;

/**
 * Interface pour les classes de calendrier.
 */
interface CalendrierInterface {
    /**
     * Affiche le calendrier pour le mois donné.
     */
    public function afficherCalendrier();

    /**
     * Affiche le calendrier avec des boutons next et previous
     *
     * @return void
     */
    public function afficherCalendrierAvecBouton();

    /**
     * Affiche tous les mois de l'année.
     */
    public function afficherAnnee();
}
