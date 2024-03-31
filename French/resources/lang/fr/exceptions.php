<?php

return [
    'daemon_connection_failed' => 'Une exception s\'est produite lors de la tentative de communication avec le démon, ce qui a entraîné un code de réponse HTTP/:code. Cette exception a été journalisée.',
    'node' => [
        'servers_attached' => 'Une node doit avoir aucun serveur lié à elle pour être supprimée.',
        'daemon_off_config_updated' => 'La configuration de la node <strong>a été mise à jour</strong>, cependant une erreur est survenue lors de la tentative de mise à jour automatique du fichier de configuration sur la node. Vous devrez mettre à jour manuellement le fichier de configuration (config.yml) pour que la node applique ces changements.',
    ],
    'allocations' => [
        'server_using' => 'Un serveur est actuellement affecté à cette allocation. Une allocation ne peut être supprimée que si aucun serveur n\'est actuellement affecté.',
        'too_many_ports' => 'L\'ajout de plus de 1000 ports dans une seule plage à la fois n\'est pas pris en charge.',
        'invalid_mapping' => 'La correspondance fournie pour :port était invalide et n\'a pas pu être traitée.',
        'cidr_out_of_range' => 'La notation CIDR n\'autorise que les masques entre /25 et /32.',
        'port_out_of_range' => 'Les ports dans une allocation doivent être supérieurs à 1024 et inférieurs ou égaux à 65535.',
    ],
    'nest' => [
        'delete_has_servers' => 'Un nest avec des serveurs actifs attachés à lui ne peut pas être supprimé du panneau.',
        'egg' => [
            'delete_has_servers' => 'Un egg avec des serveurs actifs attachés à lui ne peut pas être supprimé du panneau.',
            'invalid_copy_id' => 'L\'egg sélectionné pour copier un script n\'existe pas ou copie lui-même un script.',
            'must_be_child' => 'La directive "Copier les paramètres de" pour cet egg doit être une option enfant pour le nest sélectionné.',
            'has_children' => 'Cet egg est parent de un ou plusieurs autres eggs. Veuillez supprimer ces eggs avant de supprimer cet egg.',
        ],
        'variables' => [
            'env_not_unique' => 'La variable d\'environnement :name doit être unique pour cet egg.',
            'reserved_name' => 'La variable d\'environnement :name est protégée et ne peut pas être attribuée à une variable.',
            'bad_validation_rule' => 'La règle de validation ":rule" n\'est pas une règle valide pour cette application.',
        ],
        'importer' => [
            'json_error' => 'Une erreur s\'est produite lors de la tentative d\'analyse du fichier JSON : :error.',
            'file_error' => 'Le fichier JSON fourni n\'était pas valide.',
            'invalid_json_provided' => 'Le fichier JSON fourni n\'est pas dans un format reconnaissable.',
        ],
    ],
    'subusers' => [
        'editing_self' => 'La modification de votre propre compte de sous-utilisateur n\'est pas autorisée.',
        'user_is_owner' => 'Vous ne pouvez pas ajouter le propriétaire du serveur en tant que sous-utilisateur pour ce serveur.',
        'subuser_exists' => 'Un utilisateur avec cette adresse e-mail est déjà attribué en tant que sous-utilisateur pour ce serveur.',
    ],
    'databases' => [
        'delete_has_databases' => 'Impossible de supprimer un serveur d\'hôte de base de données qui a des bases de données actives liées à lui.',
    ],
    'tasks' => [
        'chain_interval_too_long' => 'Le temps d\'intervalle maximum pour une tâche en chaîne est de 15 minutes.',
    ],
    'locations' => [
        'has_nodes' => 'Impossible de supprimer un emplacement qui a des nodes actives attachées à lui.',
    ],
    'users' => [
        'node_revocation_failed' => 'Échec de la révocation des clés sur <a href=":link">Node #:node</a>. :error',
    ],
    'deployment' => [
        'no_viable_nodes' => 'Aucune node satisfaisant les exigences spécifiées pour le déploiement automatique n\'a pu être trouvée.',
        'no_viable_allocations' => 'Aucune allocation satisfaisant les exigences pour le déploiement automatique n\'a été trouvée.',
    ],
    'api' => [
        'resource_not_found' => 'La ressource demandée n\'existe pas sur ce serveur.',
    ],
];
