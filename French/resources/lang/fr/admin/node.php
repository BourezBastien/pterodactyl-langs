<?php

return [
    'validation' => [
        'fqdn_not_resolvable' => 'Le FQDN ou l\'adresse IP fournis ne se résout pas à une adresse IP valide.',
        'fqdn_required_for_ssl' => 'Un nom de domaine entièrement qualifié qui se résout à une adresse IP publique est requis pour utiliser SSL sur cette node.',
    ],
    'notices' => [
        'allocations_added' => 'Les allocations ont été ajoutées avec succès à cette node.',
        'node_deleted' => 'La node a été supprimée avec succès du panneau de contrôle.',
        'location_required' => 'Vous devez avoir au moins un emplacement configuré avant de pouvoir ajouter une node à ce panneau de contrôle.',
        'node_created' => 'Une node a été créée avec succès. Vous pouvez configurer automatiquement le démon sur cette machine en visitant l\'onglet "Configuration". <strong>Avant de pouvoir ajouter des serveurs, vous devez d\'abord allouer au moins une adresse IP et un port.</strong>',
        'node_updated' => 'Les informations de la node ont été mises à jour. Si des paramètres de démon ont été modifiés, vous devrez le redémarrer pour que ces modifications prennent effet.',
        'unallocated_deleted' => 'Tous les ports non alloués pour l\'adresse IP :ip ont été supprimés.',
    ],
];
