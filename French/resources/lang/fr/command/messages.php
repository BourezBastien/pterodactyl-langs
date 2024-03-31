<?php

return [
    'location' => [
        'no_location_found' => 'Impossible de trouver un enregistrement correspondant au code court fourni.',
        'ask_short' => 'Code court de l\'emplacement',
        'ask_long' => 'Description de l\'emplacement',
        'created' => 'Création réussie d\'un nouvel emplacement (:name) avec un ID de :id.',
        'deleted' => 'L\'emplacement demandé a été supprimé avec succès.',
    ],
    'user' => [
        'search_users' => 'Entrez un nom d\'utilisateur, un ID d\'utilisateur ou une adresse e-mail',
        'select_search_user' => 'ID de l\'utilisateur à supprimer (Entrez \'0\' pour rechercher à nouveau)',
        'deleted' => 'Utilisateur supprimé avec succès du panneau.',
        'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur du panneau ?',
        'no_users_found' => 'Aucun utilisateur n\'a été trouvé pour le terme de recherche fourni.',
        'multiple_found' => 'Plusieurs comptes ont été trouvés pour l\'utilisateur fourni, impossible de supprimer un utilisateur en raison du drapeau --no-interaction.',
        'ask_admin' => 'Cet utilisateur est-il un administrateur ?',
        'ask_email' => 'Adresse e-mail',
        'ask_username' => 'Nom d\'utilisateur',
        'ask_name_first' => 'Prénom',
        'ask_name_last' => 'Nom de famille',
        'ask_password' => 'Mot de passe',
        'ask_password_tip' => 'Si vous souhaitez créer un compte avec un mot de passe aléatoire envoyé par e-mail à l\'utilisateur, relancez cette commande (CTRL+C) et passez le drapeau `--no-password`.',
        'ask_password_help' => 'Les mots de passe doivent comporter au moins 8 caractères et contenir au moins une lettre majuscule et un chiffre.',
        '2fa_help_text' => [
            'Cette commande désactivera l\'authentification à deux facteurs pour le compte d\'un utilisateur si elle est activée. Ceci ne doit être utilisé que comme une commande de récupération de compte si l\'utilisateur est bloqué hors de son compte.',
            'Si ce n\'est pas ce que vous vouliez faire, appuyez sur CTRL+C pour quitter ce processus.',
        ],
        '2fa_disabled' => 'L\'authentification à deux facteurs a été désactivée pour :email.',
    ],
    'schedule' => [
        'output_line' => 'Envoi de la tâche de premier ordre dans `:schedule` (:hash).',
    ],
    'maintenance' => [
        'deleting_service_backup' => 'Suppression du fichier de sauvegarde de service :file.',
    ],
    'server' => [
        'rebuild_failed' => 'La demande de reconstruction pour ":name" (#:id) sur le nest ":node" a échoué avec l\'erreur :message',
        'reinstall' => [
            'failed' => 'La demande de réinstallation pour ":name" (#:id) sur le nest ":node" a échoué avec l\'erreur :message',
            'confirm' => 'Vous êtes sur le point de réinstaller un groupe de serveurs. Souhaitez-vous continuer ?',
        ],
        'power' => [
            'confirm' => 'Vous êtes sur le point d\'effectuer une :action sur :count serveurs. Souhaitez-vous continuer ?',
            'action_failed' => 'La demande d\'action d\'alimentation pour ":name" (#:id) sur le nest ":node" a échoué avec l\'erreur :message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'Hôte SMTP (par exemple smtp.gmail.com)',
            'ask_smtp_port' => 'Port SMTP',
            'ask_smtp_username' => 'Nom d\'utilisateur SMTP',
            'ask_smtp_password' => 'Mot de passe SMTP',
            'ask_mailgun_domain' => 'Domaine Mailgun',
            'ask_mailgun_endpoint' => 'Point de terminaison Mailgun',
            'ask_mailgun_secret' => 'Secret Mailgun',
            'ask_mandrill_secret' => 'Secret Mandrill',
            'ask_postmark_username' => 'Clé API Postmark',
            'ask_driver' => 'Quel pilote doit être utilisé pour l\'envoi des e-mails ?',
            'ask_mail_from' => 'Adresse e-mail à partir de laquelle les e-mails doivent être envoyés',
            'ask_mail_name' => 'Nom à partir duquel les e-mails doivent apparaître',
            'ask_encryption' => 'Méthode de chiffrement à utiliser',
        ],
    ],
];
