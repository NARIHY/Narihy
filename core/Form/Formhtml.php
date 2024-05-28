<?php
namespace Core\Form;

/**
 * Une classe qui permet de générer des form
 * Input , text area , select
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class Formhtml
{
    private string $value = "";
    /**
     * Permet de creer dynamiquement un champt input dans la vue
     * @param string $type Type de l'input
     * @param string $label La valeur du label
     * @param string | null  $placeholder Valeur dans la placeholder
     * @param string $name le nom du champ
     * @param string $value la valeur du champ
     * @return void
     */
    public function input(string $type, string $label = null, string $name = null, string $placeholder = null, string $value = null): void
    {
        echo "<label for=\"$name\">$label</label>";
        if($value === null) {
            echo "<input type=\"$type\" name=\"$name\" id=\"$name\" class=\"form-control\" value=\"". $this->getValue() ."\"placeholder=\"".$placeholder."\" >";
        }
        echo "<input type=\"$type\" name=\"$name\" id=\"$name\" class=\"form-control\" value=\"$value\"placeholder=\"".$placeholder."\" >";
    }
    /**
     * Permet de creer un champ mots de passe
     *
     * @param string|null $label
     * @param string|null $name
     * @param string|null $placeholder
     * @return void
     */
    public function password(string $label = null, string $name = null, string $placeholder = null): void
    {
        echo "<label for=\"$name\">$label</label>";
        if($placeholder !== null) {
            echo "<input type=\"password\" name=\"$name\" class=\"form-control\" placeholder=\"".$placeholder."\" >";
        }
        echo "<input type=\"password\" name=\"$name\"  class=\"form-control\">";
    }

    /**
     * Permet de créer une instance d'une image
     *
     * @param string $name
     * @param string|null $filePath
     * @return void
     */
    public function image(string $name, string $filePath = null): void
    {
        if($filePath === null) {
            echo " <input type=\"file\" name=\"$name\" class=\"form-control\" id=\"\">";
        }
        echo "<div class=\"row mb-3\" style =\"margin-top:20px; margin-bottom:20px\">";
        echo "<div class=\"col md-6\">";
        echo "<img src=\"/storage/$filePath\" alt=\"Photo de profil\" class=\"form-cotrol\" width=\"200px\" height=\"200px\">";
        echo "</div>";
        echo "<div class=\"col md-6\">";
        echo " <input type=\"file\" name=\"$name\" class=\"form-control\" id=\"\">";
        echo "</div>";
        echo "</div>";
    }


    /**
     * Permet de créer une instance d'une textarea
     *
     * @param string $label La valeur du label
     * @param string $name le nom du champ
     * @return void
     */
    public function textarea(string $label, string $name): void
    {
        echo "<label for=\"$name\">$label</label>";
        echo "<textarea name=\"$name\" id=\"$name\" cols=\"30\" rows=\"10\" class=\"form-control\">". $this->getValue() ."</textarea>";
    }

    /**
     * Création d'un bouton input
     * Facile à utiliser
     *
     * @param string $value Valeur de la bouton
     * @param string $class class de la bouton
     * @param string $onClick si il y a un onClick
     * @return void
     */
    public function input_button(string $value, string $class, string $id = null, string $onClick = null): void
    {
        if($onClick !== null) {
            echo "<input type=\"submit\" value=\"$value\" class=\"$class\" id=\"$id\" onclick=\"$onClick\" style=\"margin-top:20px\" width=\"100%\">";
        } else {
            echo "<input type=\"submit\" value=\"$value\" class=\"$class\" id=\"$id\" width=\"100%\" style=\"margin-top:20px\">";
        }

    }
    /**
     * Modifie l'instance la valeur d'un champ de formulaire
     * de base c'est null
     *
     * @param string $value
     * @return string
     */
    public function setValue(string $value): string
    {
        return $this->value = $value;
    }

    /**
     * Récupere la valeur du champ
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
