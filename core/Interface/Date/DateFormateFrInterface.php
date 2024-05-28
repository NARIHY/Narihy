<?php

namespace Core\Interface\Date;

use Carbon\CarbonInterface;

/**
 * Interface DateFormateFrInterface
 * Cette interface définit les méthodes pour formater et manipuler les dates.
 */
interface DateFormateFrInterface
{
    /**
     * Formate la date au format 'jour/mois/année'.
     *
     * @return string La date formatée.
     */
    public function formatage_simple(): string;
    /**
     * Recupeure l'heure à laquel quelque chose est crée
     * @return string
     */
    public function recupération_heure(): string;

    /**
     * Formate la date en français (par exemple, '12 janvier 2024').
     *
     * @return string La date formatée en français.
     */
    public function formatage_simple_fr(): string;

    /**
     * Ajoute un nombre de jours à la date.
     *
     * @param int $days Le nombre de jours à ajouter.
     * @return CarbonInterface La nouvelle date.
     */
    public function addDays(int $days): CarbonInterface;

    /**
     * Soustrait un nombre de jours à la date.
     *
     * @param int $days Le nombre de jours à soustraire.
     * @return CarbonInterface La nouvelle date.
     */
    public function subDays(int $days): CarbonInterface;

    /**
     * Calcule la différence en jours entre deux dates.
     *
     * @param mixed $date L'autre date pour laquelle calculer la différence.
     * @return int La différence en jours.
     */
    public function diffInDays($date): int;

    /**
     * Renvoie une représentation de la différence de temps en langage naturel.
     *
     * @return string La différence de temps en langage naturel.
     */
    public function diffForHumans(): string;

    /**
     * Calcule la différence en jours entre la première date et la deuxième date.
     *
     * @return int|null La différence en jours, ou null si la deuxième date est null.
     */
    public function differenceDeJourEntreDeuxDate(): ?int;

    /**
     * Calcule la différence en années entre la première date et la deuxième date.
     *
     * @return int|null La différence en années, ou null si la deuxième date est null.
     */
    public function differenceDAnneeEntreDeuxDate(): ?int;
}
