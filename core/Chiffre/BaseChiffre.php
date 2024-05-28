<?php
namespace Core\Chiffre;

use App\Models\CompteBancaire;
use Illuminate\Support\Facades\Auth;

/**
 * C'est une class qui gèrent les chiffres en générale surtout
 * pour les CIN, les numéro de compte bancaire, et divers autre.
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class BaseChiffre
{
    /** @var $chiffre instance du chiffre */
    private $chiffre;

    /** @var int $espacement nombre de nombre puis espacement */
    private int $espacement = 3;

    public function __construct(string $chiffre, int $espacement)
    {
        $this->chiffre = $chiffre;
        $this->espacement = $espacement;
    }

    /**
     * Retourn une série de chiffre avec une espacement
     * soit par groupe de 2 soit par groupe de 3, etc...
     *
     * exemple, espacement par 3:
     *          Chiffre = 444444444444
     *          valeur de retour = 444 444 444 444
     * @return string
     */
    public function espacement(): string
    {
        /** @var CompteBancaire $compte_bancaire_debit Recup du compte de l'utilisateur */
        $compte_bancaire = CompteBancaire::where('users_id', Auth::user()->id)->firstOrFail();
        $chiffre = str_split($this->chiffre, $this->espacement);
        if($compte_bancaire->numero_compte !== $this->chiffre){
            if($this->espacement === 4) {
                $noveau_tableau = [
                    '0' => $chiffre[0],
                    '1' => 'XXXX',
                    '2' => 'XXXX',
                    '3' => $chiffre[3]
                ];
                $espm = implode(' ', $noveau_tableau);
                return $espm;
            }
        }
        $espacement = implode(' ', $chiffre);
        return $espacement;
    }

    /**
     * Permet de formater n'importee quel somme d'argent suivant 3 chiffre après la virgule
     * exemple: 6000Ar -> 6,000 Ar
     *
     * @return string
     */
    public function formatage_argent(): string
    {
        return number_format($this->chiffre, 0, $this->espacement, ',');
    }


}
