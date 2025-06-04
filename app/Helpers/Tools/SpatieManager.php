<?php
namespace App\Helpers\Tools;



trait SpatieManager{


	public static function getPermissions(?string $data = null) : ?array
	{
		$permissions_on_users = [
			'edit users', 
			'delete users',
			'view users',
			'assign roles', 
			'access dashboard', 
			'update settings'
		];
		
		$permissions_on_epreuves = [
			'edit epreuves', 
			'delete epreuves', 
			'create epreuve'
		];

		$permissions_on_communiques = [
			'create communiques',
			'edit communiques', 
			'delete communiques',
		];

		$permissions_on_lycees = [
			'create lycees', 
			'edit lycees', 
			'delete lycees',
		];

		$permissions_on_laws_and_articles_chapters = [
			'create laws-articles-chapters', 
			'edit laws-articles-chapters', 
			'delete laws-articles-chapters',
		];

		$permissions_on_postes = [
			'create postes', 
			'edit postes', 
			'delete postes',
		];

		$permissions_on_admins = [
			'create admins', 
			'edit admins', 
			'delete admins',
		]; 
		
		$permissions_on_cards = [
			'create cards', 
			'edit cards', 
			'delete cards',
		];

		$permissions_on_cotisations = [
			'create cotisations', 
			'edit cotisations', 
			'delete cotisations',
		];
		
		$permissions_on_classes_filiars_promotions = [
			'create classes-filiars-promotions', 
			'edit classes-filiars-promotions', 
			'delete classes-filiars-promotions',
		];

		if($data){

			$existed = ${$data};

			if($data) return $existed;

			return null;


		}


		return array_merge(
			$permissions_on_users, 
			$permissions_on_epreuves,
			$permissions_on_communiques,
			$permissions_on_lycees,
			$permissions_on_laws_and_articles_chapters,
			$permissions_on_postes,
			$permissions_on_admins,
			$permissions_on_cards,
			$permissions_on_cotisations,
			$permissions_on_classes_filiars_promotions

		);
	}

	public static function getRoles() : ?array
	{
		$roles = [
			'master', 
			'admin-1', 
			'admin-2', 
			'admin-3', 
			'admin-4', 
			'admin-5', 
			'communiques-manager', 
			'epreuves-manager', 
			'postes-manager', 
			'members-manager', 
			'viewer', 
			'lycees-manager', 
			'forum-messages-manager', 
			'account-manager', 
			'lestroyer', 
			'user-account-reseter', 
			'cotisations-manager', 
			'classes-filiars-promotions-manager'

		];

		return $roles;
	}


	public static function translateRoleName($role_name)
	{
		$data = [

			'master' => "Master", 
			'admin-1' => "Admin niveau 1", 
			'admin-2' => "Admin niveau 2", 
			'admin-3'=> "Admin niveau 3",
			'admin-4'=> "Admin niveau 4",
			'admin-5'=> "Admin niveau 5",
			'communiques-manager'=> "Gestion les communiqués",
			'epreuves-manager'=> "Gestion les épreuves",
			'postes-manager'=> "Gestions les postes",
			'members-manager'=> "Gestion les membres",
			'viewer'=> "Lecture seule",
			'lycees-manager'=> "Gestion les lycées",
			'forum-messages-manager'=> "Gestions les messages sur le forum",
			'account-manager'=> "Gestion des comptes utilisateurs",
			'destroyer'=> "Destructeur",
			'user-account-reseter'=> "Réinitialisation de compte utilisateur",
			'cotisations-manager'=> "Gestion des cotisations",
			'classes-filiars-promotions-manager' => "Gestion des classes, filières et promotions",

		];

		return $role_name && isset($data[$role_name]) ? $data[$role_name] : 'inconnu';


	}


	public static function translatePermissionName($permission_name)
	{
		$data = [

			'edit users' => "Editer les utilisateurs", 
			'delete users' => "Supprimer les utilisateurs",
			'view users' => "Parcourir les utilisateurs",
			'assign roles' => "Atribuer des roles", 
			'access dashboard' => "Accès à la page d'administration", 
			'update settings' => "Mettre à jour les réglages",
			'edit epreuves' => "Editer les épreuves", 
			'delete epreuves' => "Supprimer les épreuves", 
			'create epreuve' => "Créer les épreuves",
			'create communiques' => "Créer les communiqués",
			'edit communiques' => "Editer les communiqués", 
			'delete communiques' => "Supprimer les communiqués",
			'create lycees' => "Créer les lycées", 
			'edit lycees' => "Editer les lycées", 
			'delete lycees' => "Supprimer les lycées",
			'create laws-articles-chapters' => "Créer les réglements", 
			'edit laws-articles-chapters' => "Editer les réglements", 
			'delete laws-articles-chapters' => "Supprimer les réglements",
			'create postes' => "Créer les postes", 
			'edit postes' => "Editer les postes", 
			'delete postes' => "Supprimer les postes",
			'create admins' => "Créer des roles et permissions administrateurs", 
			'edit admins' => "Editer des roles et permissions administrateurs", 
			'delete admins' => "Supprimer des roles et permissions administrateurs",
			'create cards' => "Emettre les cartes de membres", 
			'edit cards' => "Editer les cartes de membres", 
			'delete cards' => "Supprimer les cartes de membres",
			'create cotisations' => "Enregistrer une cotisation", 
			'edit cotisations' => "Editer une cotisation", 
			'delete cotisations' => "Supprimer une cotisation",
			'create classes-filiars-promotions' => "Créer les classes, filières et promotions", 
			'edit classes-filiars-promotions' => "Editer les classes, filières et promotions", 
			'delete classes-filiars-promotions' => "Supprimer les classes, filières et promotions",

		];

		return $permission_name && isset($data[$permission_name]) ? $data[$permission_name] : 'inconnu';
	}




}