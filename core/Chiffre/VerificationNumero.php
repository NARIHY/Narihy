<?php

namespace Core\Chiffre;

/**
 * C'est une classe dédie uniquement sur tous ce qui
 * atteint les numéro de téléphone
 * @author RANDRIANARISOA <maheninarandrianariosa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class VerificationNumero
{
    /**
     * Vérifie si un numéro de téléphone est valide.
     *
     * @param string $numero Le numéro de téléphone à vérifier
     * @return bool Retourne vrai si le numéro est valide, sinon faux
     */
    public static function verifierNumero($numero)
    {
        // Supprimer les espaces éventuels
        $numero = str_replace(' ', '', $numero);
        // Vérifier si le numéro commence par l'un des préfixes spécifiés
        if (preg_match('/^(032|033|034|037|038)\d{7}$/', $numero)) {
            // Si le numéro commence par l'un des préfixes spécifiés et a 10 chiffres, retourner vrai
            return true;
        } elseif (preg_match('/^\+261\d{9}$/', $numero)) {
            // Si le numéro commence par +261 et a 10 chiffres au total, retourner vrai
            return true;
        }
        // Si aucune condition n'est satisfaite, retourner faux
        return false;
    }
}

