<?php

namespace Core\Date;
use Core\Interface\Date\CalendrierInterface;

/**
 * Classe Calendrier pour créer et afficher des calendriers.
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class Calendrier implements CalendrierInterface
{

    /** @var int $moi le moi à afficher */
    private int $mois;
    /** @var int $annee l'année à afficher */
    private int $annee;
    /**
     * Constructeur de la classe Calendrier.
     *
     * @param int $mois Le mois du calendrier.
     * @param int $annee L'année du calendrier.
     */
    public function __construct($mois, $annee) {
        $this->mois = $mois;
        $this->annee = $annee;
    }

    /**
     * Affiche le calendrier pour le mois donné.
     */
    public function afficherCalendrier() {
        $premierJour = mktime(0, 0, 0, $this->mois, 1, $this->annee);
        $nombreJours = date('t', $premierJour);
        $premierJourSemaine = date('N', $premierJour);

        // Affichage de l'en-tête du calendrier
        echo "<h2 class='text-center'>" . date('F Y', $premierJour) . "</h2>";

        // Affichage des jours de la semaine avec Bootstrap
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='thead-light'>";
        echo "<tr><th class='text-center'>Lun</th><th class='text-center'>Mar</th><th class='text-center'>Mer</th><th class='text-center'>Jeu</th><th class='text-center'>Ven</th><th class='text-center'>Sam</th><th class='text-center'>Dim</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        // Affichage des jours du mois
        $jourCourant = 1;
        for ($i = 1; $i <= 42; $i++) {
            if ($i < $premierJourSemaine || $jourCourant > $nombreJours) {
                // Si on est avant le premier jour du mois ou après le dernier jour du mois, afficher une case vide
                echo "<td></td>";
            } else {
                // Sinon, afficher le jour du mois
                echo "<td class='text-center'>$jourCourant</td>";
                $jourCourant++;
            }
            if ($i % 7 == 0) {
                // Si on arrive à la fin d'une ligne, fermer la ligne
                echo "</tr>";
                if ($jourCourant > $nombreJours) {
                    // Si on a atteint la fin du mois, sortir de la boucle
                    break;
                }
                // Commencer une nouvelle ligne pour les jours suivants
                echo "<tr>";
            }
        }

        // Fermeture de la dernière ligne si nécessaire
        if ($i % 7 != 1) {
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }

     /**
     * Affiche le calendrier pour le mois donné. + bouton
     */
    public function afficherCalendrierAvecBouton()
    {
        $premierJour = mktime(0, 0, 0, $this->mois, 1, $this->annee);
        $nombreJours = date('t', $premierJour);
        $premierJourSemaine = date('N', $premierJour);

        // Affichage des boutons de navigation
        echo "<div class='clearfix mb-3'>";
        echo "<a href='?mois=" . date('n', strtotime('-1 month', $premierJour)) . "&annee=" . date('Y', strtotime('-1 month', $premierJour)) . "' class='btn btn-primary float-right'>Mois précédent</a>";
        echo "<a href='?mois=" . date('n', strtotime('+1 month', $premierJour)) . "&annee=" . date('Y', strtotime('+1 month', $premierJour)) . "' class='btn btn-primary float-right mr-2'>Mois suivant</a>";
        echo "</div>";

        // Affichage de l'en-tête du calendrier
        echo "<h2 class='text-center'>" . date('F Y', $premierJour) . "</h2>";

        // Affichage des jours de la semaine avec Bootstrap
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='thead-light'>";
        echo "<tr><th class='text-center'>Lun</th><th class='text-center'>Mar</th><th class='text-center'>Mer</th><th class='text-center'>Jeu</th><th class='text-center'>Ven</th><th class='text-center'>Sam</th><th class='text-center'>Dim</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        // Affichage des jours du mois
        $jourCourant = 1;
        for ($i = 1; $i <= 42; $i++) {
            if ($i < $premierJourSemaine || $jourCourant > $nombreJours) {
                // Si on est avant le premier jour du mois ou après le dernier jour du mois, afficher une case vide
                echo "<td></td>";
            } else {
                // Sinon, afficher le jour du mois
                echo "<td class='text-center'>$jourCourant</td>";
                $jourCourant++;
            }
            if ($i % 7 == 0) {
                // Si on arrive à la fin d'une ligne, fermer la ligne
                echo "</tr>";
                if ($jourCourant > $nombreJours) {
                    // Si on a atteint la fin du mois, sortir de la boucle
                    break;
                }
                // Commencer une nouvelle ligne pour les jours suivants
                echo "<tr>";
            }
        }

        // Fermeture de la dernière ligne si nécessaire
        if ($i % 7 != 1) {
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }


    /**
     * Affiche tous les mois de l'année.
     */
    public function afficherAnnee() {
        echo "<h1 class='text-center'>" . $this->annee . "</h1>";
        for ($mois = 1; $mois <= 12; $mois++) {
            $this->mois = $mois;
            $this->afficherCalendrier();
            echo "<hr>";
        }
    }
}

