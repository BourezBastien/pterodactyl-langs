<?php

return [
    'exceptions' => [
        'no_new_default_allocation' => 'Vous essayez de supprimer l\'allocation par défaut de ce serveur mais il n\'y a pas d\'allocation de secours à utiliser.',
        'marked_as_failed' => 'Ce serveur a été marqué comme ayant échoué lors d\'une installation précédente. Le statut actuel ne peut pas être basculé dans cet état.',
        'bad_variable' => 'Il y a eu une erreur de validation avec la variable :name.',
        'daemon_exception' => 'Une exception s\'est produite lors de la tentative de communication avec le démon, ce qui a entraîné un code de réponse HTTP/:code. Cette exception a été journalisée. (identifiant de la requête : :request_id)',
        'default_allocation_not_found' => 'L\'allocation par défaut demandée n\'a pas été trouvée parmi les allocations de ce serveur.',
    ],
    'alerts' => [
        'startup_changed' => 'La configuration de démarrage de ce serveur a été mise à jour. Si le nest ou l\'egg de ce serveur a été modifié, une réinstallation aura lieu maintenant.',
        'server_deleted' => 'Le serveur a été supprimé avec succès du système.',
        'server_created' => 'Le serveur a été créé avec succès sur le panneau. Veuillez accorder quelques minutes au démon pour installer complètement ce serveur.',
        'build_updated' => 'Les détails de construction de ce serveur ont été mis à jour. Certaines modifications peuvent nécessiter un redémarrage pour prendre effet.',
        'suspension_toggled' => 'Le statut de suspension du serveur a été changé en :status.',
        'rebuild_on_boot' => 'Ce serveur a été marqué comme nécessitant une reconstruction du conteneur Docker. Cela se produira la prochaine fois que le serveur sera démarré.',
        'install_toggled' => 'Le statut d\'installation de ce serveur a été basculé.',
        'server_reinstalled' => 'Ce serveur a été mis en file d\'attente pour une réinstallation commençant maintenant.',
        'details_updated' => 'Les détails du serveur ont été mis à jour avec succès.',
        'docker_image_updated' => 'Changement réussi de l\'image Docker par défaut à utiliser pour ce serveur. Un redémarrage est nécessaire pour appliquer ce changement.',
        'node_required' => 'Vous devez avoir au moins un nest configuré avant de pouvoir ajouter un serveur à ce panneau.',
        'transfer_nodes_required' => 'Vous devez avoir au moins deux nests configurés avant de pouvoir transférer des serveurs.',
        'transfer_started' => 'Le transfert de serveur a été lancé.',
        'transfer_not_viable' => 'Le nest que vous avez sélectionné n\'a pas l\'espace disque ou la mémoire disponibles nécessaires pour accueillir ce serveur.',
    ],
];
