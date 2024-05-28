<?php

use App\Http\Controllers\Admin\ActualiteController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CompteController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\GestionDeCompteController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PubliciteController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteController as AdminSiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\MaintenanceController;
use App\Http\Controllers\Public\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

//Pour gérer la partie public de notre application
Route::prefix('/')->name('Public.')->group( function () {
    //Acceuil du site
    Route::get('/', [SiteController::class, 'base'])->name('base');
    //Propos
    Route::prefix('/Propos')->name('Propos.')->group( function () {
        Route::get('/', [SiteController::class, 'propos'])->name('acceuil');
    });
    //Service
    Route::prefix('/Service')->name('Service.')->group( function () {
        Route::get('/', [SiteController::class, 'service'])->name('acceuil');
    });
    //Blog
    Route::prefix('/Blog')->name('Blog.')->group( function () {
        Route::get('/', [SiteController::class, 'blog'])->name('acceuil');
    });
    //Portfolio
    Route::prefix('/Portfolio')->name('Portfolio.')->group( function () {
        Route::get('/', [SiteController::class, 'portfolio'])->name('acceuil');
        //Voir un portfolio
        Route::get('/voir-portfolio-654564{portfolioId}466', [SiteController::class, 'voir_portfolio'])->name('voir_portfolio');
    });
    //Acutalités
    Route::prefix('/Actualites')->name('Actualite.')->group( function () {
        Route::get('/', [SiteController::class, 'actualite'])->name('acceuil');
    });
    //contact
    Route::prefix('/Contact')->name('Contact.')->group( function () {
        Route::get('/', [SiteController::class, 'contact'])->name('acceuil');
        Route::post('/', [SiteController::class, 'nous_contacter'])->name('nous_contacter');
    });

    //Authentification
    Route::prefix('/Auth')->name('Auth.')->middleware('guest')->group( function() {
        //Inscription
        Route::get('/Inscription', [SiteController::class, 'creation_compte'])->name('creation_compte');
        Route::post('/Inscription', [SiteController::class, 'sauvgarde_compte'])->name('sauvgarde_compte');
        //Se connecter
        Route::get('/Se-connecter', [SiteController::class,'se_connecter'])->name('se_connecter');
        Route::post('/Se-connecter',[AuthenticatedSessionController::class, 'store'])->name('connection');
    });
});

//pour la maintenance
Route::prefix('/Maintenance-simple')->name('Maintenance.')->group( function () {
    //Maintenance de base
    Route::get('/', [MaintenanceController::class, 'site'])->name('site');
});


//Pour gérer la partie administration de notre application
Route::prefix('/Administration')->middleware(['auth','isAdmin','userIsDelete'])->name('Administration.')->group(function () {
    //tableau de bord
    Route::get('/', [AdminSiteController::class, 'tableau_de_bord'])->name('tableau_de_bord');

    //Profile d'un utilisateur
    Route::prefix('/Mon-profile')->name('Profile.')->group( function () {
        //Profile de l'utilisateur
        Route::get('/', [CompteController::class, 'mon_compte'])->name('mon_compte');
        //Parametre de compte
        Route::get('/Parametre-de-mon-compte', [CompteController::class, 'parametre'])->name('parametre');
    });
    //Exceptions
    Route::prefix('/Exception')->name('Exception.')->group( function () {
        Route::get('/404&page=introuvable', [AdminSiteController::class, 'not_found'])->name('not_found');
    });
    //Pour la maintenance
    Route::prefix('/Site-Maintenance')->name('SiteMaintenance.')->middleware('isSuperAdmin')->group(function () {
        //Liste des maintenance
        Route::get('/',[App\Http\Controllers\Admin\MaintenanceController::class, 'liste'])->name('liste');
        //creation
        Route::get('/creation',[App\Http\Controllers\Admin\MaintenanceController::class, 'creation'])->name('creation');
        Route::post('/creation',[App\Http\Controllers\Admin\MaintenanceController::class, 'sauvgarde'])->name('sauvgarde');
        //modification
        Route::get('/{id}-5468452462468',[App\Http\Controllers\Admin\MaintenanceController::class, 'edition'])->name('edition');
        Route::put('/{id}-5468452462468',[App\Http\Controllers\Admin\MaintenanceController::class, 'maj'])->name('maj');
        //supression
        Route::delete('/5646546{id}645665-465456465456465465', [App\Http\Controllers\Admin\MaintenanceController::class, 'supression'])->name('supression');
   });
    //Gestion des comptes
    Route::prefix('/Gestion-des-comptes')->name('GestionCompte.')->middleware('isAdminAuthorize')->group(function () {
        //Role
        Route::prefix('/Role')->name('Role.')->group(function () {
            Route::get('/Liste', [GestionDeCompteController::class, 'liste_role'])->name('liste_role');
            //Créer un role
            Route::get('/Ajoute-un-role', [GestionDeCompteController::class, 'creer_role'])->name('creer_role');
            Route::post('/Ajoute-un-role', [GestionDeCompteController::class, 'sauvgarder_role'])->name('sauvgarder_role');
            //Modification
            Route::get('/Modification-d-un-role/45{id}78', [GestionDeCompteController::class, 'modifier_role'])->name('modifier_role');
            Route::put('/Modification-d-un-role/45{id}78', [GestionDeCompteController::class, 'maj_role'])->name('maj_role');
            //Supression indirect
            Route::delete('/Suppression-d-un-role/45{id}78', [GestionDeCompteController::class, 'suprimer_role'])->name('suprimer_role');
        });
        //Compte
        Route::prefix('/Compte')->name('Compte.')->group(function () {
            //Liste des utilisateurs
            Route::get('/',[GestionDeCompteController::class,'liste_compte'])->name('liste_compte');
            //Modification des accès des utilisateur
            Route::get('/Accès-utilisateur/46456{utilisateurId}5464', [GestionDeCompteController::class, 'modifier_compte_utilisateur'])->name('modifier_compte_utilisateur');
            Route::put('/Accès-utilisateur/46456{utilisateurId}5464', [GestionDeCompteController::class, 'sauv_compte_utilisateur'])->name('sauv_compte_utilisateur');
            //Supression d'un compte
            Route::delete('/Supression-d-un-compte/46545{utilisateurId}6546546', [GestionDeCompteController::class, 'suprimer_compte_utilisateur'])->name('suprimer_compte_utilisateur');
        });
    });
    //Lien sociale
    Route::prefix('/Lien-social')->name('SocialLinks.')->group( function () {
        //Liste des lien sociale
        Route::get('/', [AdminSiteController::class, 'social_link'])->name('social_link');
        //Ajouter un lien sociale
        Route::get('/Ajouter-lien', [AdminSiteController::class,'creer_lien_social'])->name('creer_lien_social');
        Route::post('/Ajouter-lien', [AdminSiteController::class, 'sauvgarder_lien_sociale'])->name('sauvgarder_lien_sociale');
        //Edition d'un lien sociale
        Route::get('/Edition-d-une-lien-sociale/{id}7-sa89', [AdminSiteController::class, 'edition_social_link'])->name('edition_social_link');
        Route::put('/Edition-d-une-lien-sociale/{id}7-sa89', [AdminSiteController::class, 'maj_lien_sociale'])->name('maj_lien_sociale');
        //Supression d'un lien sociale
        Route::delete('/Suppression-d-un-lien-sociale-79{id}z', [AdminSiteController::class, 'suprimer_lien_sociale'])->name('suprimer_lien_sociale');
    });

    //Mes services
    Route::prefix('/Mes-service')->name('Service.')->middleware('isSuperAdmin')->group( function () {
        //lister
        Route::get('/', [ServiceController::class, 'liste_service'])->name('liste_service');
        //Ajouter
        Route::get('/Ajouter-un-service', [ServiceController::class,'creer_service'])->name('creer_service');
        Route::post('/Ajouter-un-service', [ServiceController::class,'sauvgarder_service_creer'])->name('sauvgarder_service_creer');
        //Editer
        Route::get('/Edition-d-un-service/54646{serviceId}5456456465', [ServiceController::class,'edition_service'])->name('edition_service');
        Route::put('/Edition-d-un-service/54646{serviceId}5456456465', [ServiceController::class,'sauvgarder_edition_service'])->name('sauvgarder_edition_service');
        //Active ou desactive
        Route::patch('/Activer-service-Z{serviceId}456546', [ServiceController::class,'set_status'])->name('set_status');
        //suprimer
        Route::delete('/Supression-service-Z{serviceId}456546', [ServiceController::class,'supprimer_service'])->name('supprimer_service');
    });

    //Pour contacte
    Route::prefix('/Contact')->name('Contacte.')->middleware('isSuperAdmin')->group( function () {
        //Lister les contacte reçu
        Route::get('/', [ContactController::class, 'liste_contacte'])->name('liste_contacte');
        //Permet de voir un contact
        Route::get('/{contactId}sad-546/My-applications-message', [ContactController::class, 'voir_contacte'])->name('voir_contacte');
        //Permet de repondre un lessage
        Route::get('/Repondre-un-message/{contactId}466-Bz55', [ContactController::class,'answer_users'])->name('answer_users');
        Route::post('/Repondre-un-message/{contactId}466-Bz55', [ContactController::class,'answer_users_contacts'])->name('answer_users_contacts');
    });

    //Pour les publiciter
    Route::prefix('/Publiciter')->middleware('isSuperAdmin')->name('Publiciter.')->group( function (){
        //Route pour lister les pub
        Route::get('/',[PubliciteController::class, 'liste_publicite'])->name('liste_publicite');
        //Creation
        Route::get('/Ajouter-une-nouvelle-pub',[PubliciteController::class, 'creer_une_publiciter'])->name('creer_une_publiciter');
        Route::post('/Ajouter-une-nouvelle-pub',[PubliciteController::class, 'sauvgarder_une_publiciter'])->name('sauvgarder_une_publiciter');
        //Modification
        Route::get('/Edition-d-une-pub/Bz-{publiciteId}56-Z85',[PubliciteController::class, 'modifier_une_pub'])->name('modifier_une_pub');
        Route::put('/Edition-d-une-pub/Bz-{publiciteId}56-Z85',[PubliciteController::class, 'sauvgarde_modif_pub'])->name('sauvgarde_modif_pub');
        //Suprimer une pub
        Route::delete('/Supresion-simple-d-une-pub/{publiciteId}5465', [PubliciteController::class,'suppression_simple_pub'])->name('suppression_simple_pub');
        //Permet d'envoyer la publicite
        Route::post('/Publicite-envoyer-zA515/g56-{publiciteId}954',[PubliciteController::class, 'send_publicite'])->name('send_publicite');
    });

    //Blog
    Route::prefix('/Blog')->name('Blog.')->group( function () {
        //liste
        Route::get('/', [BlogController::class, 'liste_les_blogs'])->name('liste_les_blogs');
        //creation
        Route::get('/creation-d-une-blog', [BlogController::class, 'creer_une_blog'])->name('creer_une_blog');
        Route::post('/creation-d-une-blog', [BlogController::class, 'sauvgarder_blog_creer'])->name('sauvgarder_blog_creer');
        //Modification d'une blog
        Route::get('/edition-blog/44{blogId}664-das', [BlogController::class, 'modifier_blog'])->name('modifier_blog');
        Route::put('/edition-blog/44{blogId}664-das', [BlogController::class, 'sauvgarder_modification_blog'])->name('sauvgarder_modification_blog');
        //Changer de status
        Route::patch('/status-blog/44{blogId}664-das', [BlogController::class, 'change_status'])->name('change_status');
        //Suppression simple
        Route::delete('/supression-simple-z{blogId}564/46545845646126542654484526/79798552', [BlogController::class, 'supression_simple'])->name('supression_simple');
        //Supprimer directement
        Route::delete('/Supression-z855135468{blogId}6464687', [BlogController::class, 'forcer_suppression'])->name('forcer_suppression');
    });

    //Actualite
    Route::prefix('/Actualite')->name('Actualite.')->middleware('isSuperAdmin')->group( function () {
        //Liste
        Route::get('/', [ActualiteController::class, 'liste_des_actualite'])->name('liste_des_actualite');
        //création
        Route::get('/creation-d-un-actualite', [ActualiteController::class, 'creer_actualite'])->name('creer_actualite');
        Route::post('/creation-d-un-actualite', [ActualiteController::class, 'sauvgarde_actualite'])->name('sauvgarde_actualite');
        //Edition
        Route::get('/edition-d-une-actualite/54648{actualiteId}4565487', [ActualiteController::class, 'edition_actualite'])->name('edition_actualite');
        Route::put('/edition-d-une-actualite/54648{actualiteId}4565487', [ActualiteController::class, 'sauvgarder_modification_actualite'])->name('sauvgarder_modification_actualite');
        //Supression simple
        Route::delete('/Supression-simple/4564645{actualiteId}44665', [ActualiteController::class, 'supression_simple_actu'])->name('supression_simple_actu');
        //Supression direct
        Route::delete('/Supression-direct/4564645{actualiteId}44665', [ActualiteController::class, 'supresion_direct_actualite'])->name('supresion_direct_actualite');
        //Changer de status
        Route::patch('/status-actualite/44{actualiteId}664-das', [BlogController::class, 'changer_status_actu'])->name('changer_status_actu');
    });


    //Portfolio
    Route::prefix('/Portfolio')->name('Portfolio.')->group(function () {
        //Catégorie de portfolio
       Route::prefix('/Categorie')->name('Categorie.')->group( function () {
            //Liste
            Route::get('/', [PortfolioController::class, 'liste_category_portfolio'])->name('liste_category_portfolio');
            //creation
            Route::get('/creation-categorie', [PortfolioController::class, 'creer_categorie_portfolio'])->name('creer_categorie_portfolio');
            Route::post('/creation-categorie', [PortfolioController::class, 'sauvgarder_categorie_portfolio'])->name('sauvgarder_categorie_portfolio');
            //edition
            Route::get('/edition-categorie/46646{categPortfolioId}45645646', [PortfolioController::class, 'edition_categorie_portfolio'])->name('edition_categorie_portfolio');
            Route::put('/edition-categorie/46646{categPortfolioId}45645646', [PortfolioController::class, 'sauvgarder_edition_categorie_portfolio'])->name('sauvgarder_edition_categorie_portfolio');
            //Suppression
            Route::delete('/supression-categorie/66787995{categPortfolioId}46448', [PortfolioController::class, 'suprimer_categorie_portfolio'])->name('suprimer_categorie_portfolio');
       });
       //liste de mes portfolio
       Route::prefix('/Mes-portfolio')->name('MesPortfolio.')->group( function () {
            //liste
            Route::get('/', [PortfolioController::class, 'lister_portfolio'])->name('lister_portfolio');
            //creation
            Route::get('/ajouter-une-nouvelle-portfolio', [PortfolioController::class,'ajouter_portfolio'])->name('ajouter_portfolio');
            Route::post('/ajouter-une-nouvelle-portfolio', [PortfolioController::class,'sauvgarder_portfolio'])->name('sauvgarder_portfolio');
            //edition
            Route::get('/edition-d-une-portfolio/464654879{portfolioId}8795415', [PortfolioController::class, 'edition_portfolio'])->name('edition_portfolio');
            Route::put('/edition-d-une-portfolio/464654879{portfolioId}8795415', [PortfolioController::class, 'maj_edition_portfolio'])->name('maj_edition_portfolio');
            //suppression
            Route::delete('/suppression-d-une-portfolio/8979546{portfolioId}4454646', [PortfolioController::class, 'suprimer_portfolio'])->name('suprimer_portfolio');
            //Changer status
            Route::patch('/changement-de-status/98754{portfolioId}9652138-549484596564', [PortfolioController::class, 'changer_status'])->name('changer_status');
       });
    });

});


Route::get('/Page/Service-indisponnible', [SiteController::class, 'utilisateur_suprimer'])->name('Empty.suppresion');
