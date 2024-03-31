<?php

/**
 * Contient toutes les chaînes de traduction pour les différents événements de journal d'activité.
 * Celles-ci doivent être indexées par la valeur devant les deux-points (:) dans le nom de l'événement.
 * S'il n'y a pas de deux-points, elles doivent être placées au niveau supérieur.
 */
return [
    'auth' => [
        'fail' => 'Échec de la connexion',
        'success' => 'Connecté',
        'password-reset' => 'Réinitialisation du mot de passe',
        'reset-password' => 'Demande de réinitialisation du mot de passe',
        'checkpoint' => 'Demande d\'authentification à deux facteurs',
        'recovery-token' => 'Utilisation du jeton de récupération à deux facteurs',
        'token' => 'Résolution du défi à deux facteurs',
        'ip-blocked' => 'Demande bloquée à partir de l\'adresse IP non répertoriée pour :identifier',
        'sftp' => [
            'fail' => 'Échec de la connexion SFTP',
        ],
    ],
    'user' => [
        'account' => [
            'email-changed' => 'Adresse e-mail changée de :old à :new',
            'password-changed' => 'Mot de passe changé',
        ],
        'api-key' => [
            'create' => 'Nouvelle clé API créée :identifier',
            'delete' => 'Clé API supprimée :identifier',
        ],
        'ssh-key' => [
            'create' => 'Clé SSH :fingerprint ajoutée au compte',
            'delete' => 'Clé SSH :fingerprint supprimée du compte',
        ],
        'two-factor' => [
            'create' => 'Authentification à deux facteurs activée',
            'delete' => 'Authentification à deux facteurs désactivée',
        ],
    ],
    'server' => [
        'reinstall' => 'Réinstallation du serveur',
        'console' => [
            'command' => 'Exécution de ":command" sur le serveur',
        ],
        'power' => [
            'start' => 'Démarrage du serveur',
            'stop' => 'Arrêt du serveur',
            'restart' => 'Redémarrage du serveur',
            'kill' => 'Arrêt forcé du processus du serveur',
        ],
        'backup' => [
            'download' => 'Téléchargement de la sauvegarde :name',
            'delete' => 'Suppression de la sauvegarde :name',
            'restore' => 'Restauration de la sauvegarde :name (fichiers supprimés : :truncate)',
            'restore-complete' => 'Restauration complète de la sauvegarde :name',
            'restore-failed' => 'Échec de la restauration de la sauvegarde :name',
            'start' => 'Démarrage d\'une nouvelle sauvegarde :name',
            'complete' => 'Marquage de la sauvegarde :name comme terminée',
            'fail' => 'Marquage de la sauvegarde :name comme échouée',
            'lock' => 'Verrouillage de la sauvegarde :name',
            'unlock' => 'Déverrouillage de la sauvegarde :name',
        ],
        'database' => [
            'create' => 'Nouvelle base de données créée :name',
            'rotate-password' => 'Rotation du mot de passe pour la base de données :name',
            'delete' => 'Base de données supprimée :name',
        ],
        'file' => [
            'compress_one' => 'Compression de :directory:file',
            'compress_other' => 'Compression de :count fichiers dans :directory',
            'read' => 'Consultation du contenu de :file',
            'copy' => 'Création d\'une copie de :file',
            'create-directory' => 'Création du répertoire :directory:name',
            'decompress' => 'Décompression de :files dans :directory',
            'delete_one' => 'Suppression de :directory:files.0',
            'delete_other' => 'Suppression de :count fichiers dans :directory',
            'download' => 'Téléchargement de :file',
            'pull' => 'Téléchargement d\'un fichier distant depuis :url vers :directory',
            'rename_one' => 'Renommage de :directory:files.0.de en :directory:files.0.vers',
            'rename_other' => 'Renommage de :count fichiers dans :directory',
            'write' => 'Écriture de nouveau contenu dans :file',
            'upload' => 'Début d\'un téléchargement de fichier',
            'uploaded' => 'Téléchargé :directory:file',
        ],
        'sftp' => [
            'denied' => 'Accès SFTP bloqué en raison des autorisations',
            'create_one' => 'Création de :files.0',
            'create_other' => 'Création de :count nouveaux fichiers',
            'write_one' => 'Modification du contenu de :files.0',
            'write_other' => 'Modification du contenu de :count fichiers',
            'delete_one' => 'Suppression de :files.0',
            'delete_other' => 'Suppression de :count fichiers',
            'create-directory_one' => 'Création du répertoire :files.0',
            'create-directory_other' => 'Création de :count répertoires',
            'rename_one' => 'Renommage de :files.0.de en :files.0.vers',
            'rename_other' => 'Renommage ou déplacement de :count fichiers',
        ],
        'allocation' => [
            'create' => 'Ajout de :allocation au serveur',
            'notes' => 'Mise à jour des notes pour :allocation de ":old" à ":new"',
            'primary' => 'Définition de :allocation comme allocation principale du serveur',
            'delete' => 'Suppression de l\'allocation :allocation',
        ],
        'schedule' => [
            'create' => 'Création du plan :name',
            'update' => 'Mise à jour du plan :name',
            'execute' => 'Exécution manuelle du plan :name',
            'delete' => 'Suppression du plan :name',
        ],
        'task' => [
            'create' => 'Création d\'une nouvelle tâche ":action" pour le plan :name',
            'update' => 'Mise à jour de la tâche ":action" pour le plan :name',
            'delete' => 'Suppression d\'une tâche pour le plan :name',
        ],
        'settings' => [
            'rename' => 'Renommage du serveur de :old à :new',
            'description' => 'Changement de la description du serveur de :old à :new',
        ],
        'startup' => [
            'edit' => 'Modification de la variable :variable de ":old" à ":new"',
            'image' => 'Mise à jour de l\'image Docker du serveur de :old à :new',
        ],
        'subuser' => [
            'create' => 'Ajout de :email en tant que sous-utilisateur',
            'update' => 'Mise à jour des autorisations du sous-utilisateur pour :email',
            'delete' => 'Suppression de :email en tant que sous-utilisateur',
        ],
    ],
];
