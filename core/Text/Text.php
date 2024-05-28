<?php
namespace Core\Text;

/**
 * Cette class contient tous les méthodes relatives concernant
 * les chaines de caractère
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class Text
{
    /**
     * Retourne la premier lettre d'un mots en majuscule
     *
     * @param string $mot Mots à mettre en majuscule
     * @return string
     */
    public function mettre_en_majuscule_premier_lettre(string $mot): string
    {
        return ucfirst(strtolower($mot));
    }

    /**
     * Retourne un mots ou groupe de mots en majuscule
     *
     * @param string $mots Mots à mettre en majuscule
     * @return string
     */
    public function mettre_un_mots_en_majuscule(string $mots): string
    {
        return strtoupper($mots);
    }

    /**
     * Retourne un mots ou groupe de mots en miniscule
     *
     * @param string $mots
     * @return string
     */
    public function mettre_un_mots_en_minuscule(string $mots): string
    {
        return strtolower($mots);
    }

    /**
     * Recuperation avec limitation de mots récupérer
     *
     * @param string $content
     * @param integer $limit
     * @return string
     */
    public static function excerpt(string $content, int $limit = 60): string
    {
        if(mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}
