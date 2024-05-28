<?php

namespace Core\Date;

use Core\Interface\Date\DateFormateFrInterface;
use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * C'est une classe qui formate les dates anglaises en françaises.
 *
 * Prérequis: Carbon pour parser la date pour éviter les erreurs de formatage.
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class DateFormaterFr implements DateFormateFrInterface
{
    /** @var mixed $date L'instance de la première date à formater. */
    private $date;

    /** @var mixed|null $date2 L'instance de la deuxième date, optionnelle et nullable. */
    private $date2;

    /**
     * Constructeur de la classe.
     *
     * @param mixed $date La première date.
     * @param mixed|null $date2 La deuxième date (nullable, par défaut null).
     * @return void
     */
    public function __construct($date, $date2 = null)
    {
        $this->date = $date;
        $this->date2 = $date2;
    }

    /**
     * Formate la date au format 'jour/mois/année'.
     *
     * @return string La date formatée.
     */
    public function formatage_simple(): string
    {
        $dateToFormat = Carbon::parse($this->date);
        return $dateToFormat->format('d/m/Y');
    }

    /**
     * Retourne l'heure dans une table qui a une format dateTime
     * @return string
     */
    public function recupération_heure(): string
    {
        $heure_recuperer = Carbon::parse($this->date);
        $heure = explode(':', $heure_recuperer->format('H:i:s'));
        return $heure[0] . 'h' . $heure[1] . 'mn';
    }

    /**
     * Retourne une date en français (par exemple, '12 janvier 2024').
     *
     * @return string La date formatée en français.
     */
    public function formatage_simple_fr(): string
    {
        $tableauDate = explode('/', $this->formatage_simple());
        $moisFr = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];

        $dateFr = $tableauDate[0] . ' ' . $moisFr[intval($tableauDate[1])] . ' ' . $tableauDate[2];
        return $dateFr;
    }

    /**
     * Ajoute un nombre spécifié de jours à la date actuelle.
     *
     * @param int $days Le nombre de jours à ajouter.
     * @return CarbonInterface La nouvelle date après l'ajout des jours.
     */
    public function addDays(int $days): CarbonInterface
    {
        return Carbon::parse($this->date)->addDays($days);
    }

    /**
     * Soustrait un nombre spécifié de jours à la date actuelle.
     *
     * @param int $days Le nombre de jours à soustraire.
     * @return CarbonInterface La nouvelle date après la soustraction des jours.
     */
    public function subDays(int $days): CarbonInterface
    {
        return Carbon::parse($this->date)->subDays($days);
    }

    /**
     * Calcule la différence en jours entre la date actuelle et une autre date spécifiée.
     *
     * @param mixed $date L'autre date pour laquelle calculer la différence.
     * @return int La différence en jours.
     */
    public function diffInDays($date): int
    {
        return Carbon::parse($this->date)->diffInDays($date);
    }

    /**
     * Renvoie une représentation de la différence de temps entre la date actuelle et maintenant, en langage naturel.
     *  Retourne 34 years ago de base mais je vais le formater en fr
     * Maintenant elle vas retourner une instance de l'age en francait
     * @return string La différence de temps en langage naturel.
     */
    public function diffForHumans(): string
    {
        $string = Carbon::parse($this->date)->diffForHumans();
        $array = explode(' ', $string);
        $anne = '';
        if ($array[0] > 1) {
            $anne = 'ans';
        } else {
            $anne = 'an';
        }
       return $array[0]. ' '. $anne;
    }

    /**
     * Calcule la différence en jours entre la première date et la deuxième date.
     *
     * @return int|null La différence en jours, ou null si la deuxième date est null.
     */
    public function differenceDeJourEntreDeuxDate(): ?int
    {
        if ($this->date2 === null) {
            return null;
        }

        return Carbon::parse($this->date)->diffInDays($this->date2);
    }

    /**
     * Calcule la différence en années entre la première date et la deuxième date.
     *
     * @return int|null La différence en années, ou null si la deuxième date est null.
     */
    public function differenceDAnneeEntreDeuxDate(): ?int
    {
        if ($this->date2 === null) {
            return null;
        }
        return Carbon::parse($this->date)->diffInYears($this->date2);
    }
}
