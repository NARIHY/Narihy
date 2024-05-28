<?php
namespace Core\Session;

/**
 * Classe relative aux session
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class SessionManager
{
    /**
     * Méthode pour démarer une session
     *
     * @return void
     */
    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Permet de définir une variable de session
     *
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public static function set(string $key,$value)
    {
        self::startSession();
        $_SESSION[$key] = $value;
    }

    /**
     * Méthode pour récuperer une variable de session
     *
     * @param string $key
     * @return void
     */
    public static function get(string $key)
    {
        self::startSession();
        return isset($_SESSION[$key]) ? $_SESSION[$key]: null;
    }

    /**
     * Méthode qui vérifie si une vraiable de session existe
     *
     * @param [type] $key
     * @return boolean
     */
    public static function has($key)
    {
        self::startSession();
        return isset($_SESSION[$key]);
    }

    /**
     * Méthode pour suprimer une session
     *
     * @param [type] $key
     * @return void
     */
    public static function delete($key)
    {
        self::startSession();
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Methode pour détruire une session
     *
     * @return void
     */
    public static function destroy()
    {
        self::startSession();
        session_unset();
        session_destroy();
    }

    /**
     * Méthode pour créer une session
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function create(string $name,mixed $value)
    {
        self::set($name, $value);
    }
}
