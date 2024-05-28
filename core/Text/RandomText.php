<?php
namespace Core\Text;

/**
 * Class qui permet de regénérer des chiffre aléatoire
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class RandomText
{
    /**
     * Generer des chaine de carachtere par defaut
     *
     * @return string
     */
    public function generate(): string
    {
        $array_value = $this->array_value();
        $count = count($array_value) - 1;
        $random_int = $this->get_array_random_value($count);
        return  $this->generate_text($random_int);
    }


    /**
     * Permet de generer un nombre aléatoire min et max
     *
     * @param integer $min
     * @param integer $max
     * @return integer
     */
    private function get_random_number(int $min, int $max): int
    {
        $random = rand($min, $max);
        return $random;
    }

    /**
     * Tableau de charactere
     *
     * @return array
     */
    private function array_value(): array
    {
        $array_value = [
            'w', '2', '6','d','I','§','i','j','U','8','K','n','J','0','T','Q','f','t','S','v','a',',','y','9',
            '4', '@', '?','z','O','F','e','o','m','L',';','1','E',']','r','%','q','u','k','}','=','x','(','&',
            'N', 'b', '3', 'A', '5', 'c', '7', 'l', 'D', 'p',
            '.','X',':','M','!', 's','Y','C','Z','Y',')','[','P', 'B', 'W','R','{','V',''
        ];
        return $array_value;
    }

    /**
     * Récuperer des clefs random pour le mots de passe
     *
     * @param integer $count
     * @return array
     */
    private function get_array_random_value(int $count): array
    {
        $random = [];
        for($i = 0; $i<=8; $i++){
            array_push($random, $this->get_random_number(0,$count));
        }
        return $random;
    }

    /**
     * Generer le mots de passe de l'utilisateur
     *
     * @param array $random_int
     * @return string
     */
    private function generate_text(array $random_int): string
    {
        $value = $this->array_value();
        $final_value = $value[$random_int[3]].$value[$random_int[5]].$value[$random_int[2]].$value[$random_int[0]].$value[$random_int[4]].$value[$random_int[1]].$value[$random_int[8]].$value[$random_int[7]].$value[$random_int[6]];
        return $final_value;
    }
}
