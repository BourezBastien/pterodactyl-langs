@extends('layouts.admin')

@section('title')
    Nouveau serveur
@endsection

@section('content-header')
    <h1>Créer un serveur<small>Ajouter un nouveau serveur au panel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li class="active">Créer un serveur</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.servers.new') }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Détails principaux</h3>
                </div>

                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pName">Nom du serveur</label>
                            <input type="text" class="form-control" id="pName" name="name" value="{{ old('name') }}" placeholder="Nom du serveur">
                            <p class="small text-muted no-margin">Limites de caractères : <code>a-z A-Z 0-9 _ - .</code> et <code>[Espace]</code>.</p>
                        </div>

                        <div class="form-group">
                            <label for="pUserId">Propriétaire du serveur</label>
                            <select id="pUserId" name="owner_id" class="form-control" style="padding-left:0;"></select>
                            <p class="small text-muted no-margin">Adresse e-mail du propriétaire du serveur.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pDescription" class="control-label">Description du serveur</label>
                            <textarea id="pDescription" name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            <p class="text-muted small">Une brève description de ce serveur.</p>
                        </div>

                        <div class="form-group">
                            <div class="checkbox checkbox-primary no-margin-bottom">
                                <input id="pStartOnCompletion" name="start_on_completion" type="checkbox" {{ \Pterodactyl\Helpers\Utilities::checked('start_on_completion', 1) }} />
                                <label for="pStartOnCompletion" class="strong">Démarrer le serveur lors de l'installation</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des allocations</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-sm-4">
                        <label for="pNodeId">Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                @foreach($location->nodes as $node)

                                <option value="{{ $node->id }}"
                                    @if($location->id === old('location_id')) selected @endif
                                >{{ $node->name }}</option>

                                @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        <p class="small text-muted no-margin">Le node sur lequel ce serveur sera déployé.</p>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pAllocation">Allocation par défaut</label>
                        <select id="pAllocation" name="allocation_id" class="form-control"></select>
                        <p class="small text-muted no-margin">L'allocation principale qui sera assignée à ce serveur.</p>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pAllocationAdditional">Allocations supplémentaires</label>
                        <select id="pAllocationAdditional" name="allocation_additional[]" class="form-control" multiple></select>
                        <p class="small text-muted no-margin">Allocations supplémentaires à attribuer à ce serveur lors de la création.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-header with-border">
                    <h3 class="box-title">Limites des fonctionnalités de l'application</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-6">
                        <label for="pDatabaseLimit" class="control-label">Limite de base de données</label>
                        <div>
                            <input type="text" id="pDatabaseLimit" name="database_limit" class="form-control" value="{{ old('database_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">Le nombre total de bases de données qu'un utilisateur est autorisé à créer pour ce serveur.</p>
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="pAllocationLimit" class="control-label">Limite d'allocation</label>
                        <div>
                            <input type="text" id="pAllocationLimit" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">Le nombre total d'allocations qu'un utilisateur est autorisé à créer pour ce serveur.</p>
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="pBackupLimit" class="control-label">Limite de sauvegarde</label>
                        <div>
                            <input type="text" id="pBackupLimit" name="backup_limit" class="form-control" value="{{ old('backup_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">Le nombre total de sauvegardes pouvant être créées pour ce serveur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des ressources</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-6">
                        <label for="pCPU">Limite de CPU</label>

                        <div class="input-group">
                            <input type="text" id="pCPU" name="cpu" class="form-control" value="{{ old('cpu', 0) }}" />
                            <span class="input-group-addon">%</span>
                        </div>

                        <p class="text-muted small">Si vous ne souhaitez pas limiter l'utilisation du CPU, définissez la valeur sur <code>0</code>. Pour déterminer une valeur, prenez le nombre de threads et multipliez-le par 100. Par exemple, sur un système quadricœur sans hyperthreading <code>(4 * 100 = 400)</code> il y a <code>400%</code> disponible. Pour limiter un serveur à utiliser la moitié d'un seul thread, vous définiriez la valeur sur <code>50</code>. Pour permettre à un serveur d'utiliser jusqu'à deux threads, définissez la valeur sur <code>200</code>.</p>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="pThreads">CPU Pinning</label>

                        <div>
                            <input type="text" id="pThreads" name="threads" class="form-control" value="{{ old('threads') }}" />
                        </div>

                        <p class="text-muted small"><strong>Avancé:</strong> Entrez les threads CPU spécifiques sur lesquels ce processus peut s'exécuter, ou laissez vide pour autoriser tous les threads. Il peut s'agir d'un seul nombre ou d'une liste séparée par des virgules. Exemple : <code>0</code>, <code>0-1,3</code> ou <code>0,1,3,4</code>.</p>
                    </div>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-6">
                        <label for="pMemory">Mémoire</label>

                        <div class="input-group">
                            <input type="text" id="pMemory" name="memory" class="form-control" value="{{ old('memory') }}" />
                            <span class="input-group-addon">MiB</span>
                        </div>

                        <p class="text-muted small">La quantité maximale de mémoire autorisée pour ce conteneur. Définir cela sur <code>0</code> permettra une utilisation illimitée de la mémoire dans un conteneur.</p>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="pSwap">Swap</label>

                        <div class="input-group">
                            <input type="text" id="pSwap" name="swap" class="form-control" value="{{ old('swap', 0) }}" />
                            <span class="input-group-addon">MiB</span>
                        </div>

                        <p class="text-muted small">Définir cela sur <code>0</code> désactivera l'espace d'échange sur ce serveur. Définir sur <code>-1</code> permettra un échange illimité.</p>
                    </div>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-6">
                        <label for="pDisk">Espace disque</label>

                        <div class="input-group">
                            <input type="text" id="pDisk" name="disk" class="form-control" value="{{ old('disk') }}" />
                            <span class="input-group-addon">MiB</span>
                        </div>

                        <p class="text-muted small">Ce serveur ne sera pas autorisé à démarrer s'il utilise plus que cette quantité d'espace. Si un serveur dépasse cette limite en cours d'exécution, il sera arrêté et verrouillé en toute sécurité jusqu'à ce qu'assez d'espace soit disponible. Définissez sur <code>0</code> pour autoriser une utilisation illimitée du disque.</p>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="pIO">Poids d'E/S de bloc</label>

                        <div>
                            <input type="text" id="pIO" name="io" class="form-control" value="{{ old('io', 500) }}" />
                        </div>

                        <p class="text-muted small"><strong>Avancé</strong>: Les performances d'E/S de ce serveur par rapport à d'autres conteneurs <em>en cours d'exécution</em> sur le système. La valeur doit être comprise entre <code>10</code> et <code>1000</code>. Veuillez consulter <a href="https://docs.docker.com/engine/reference/run/#block-io-bandwidth-blkio-constraint" target="_blank">cette documentation</a> pour plus d'informations à ce sujet.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input type="checkbox" id="pOomDisabled" name="oom_disabled" value="0" {{ \Pterodactyl\Helpers\Utilities::checked('oom_disabled', 0) }} />
                            <label for="pOomDisabled" class="strong">Activer OOM Killer</label>
                        </div>

                        <p class="small text-muted no-margin">Termine le serveur s'il dépasse les limites de mémoire. Activer OOM killer peut entraîner la sortie inattendue des processus du serveur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration du nest</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pNestId">Nest</label>

                        <select id="pNestId" name="nest_id" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === old('nest_id'))
                                        selected="selected"
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>

                        <p class="small text-muted no-margin">Sélectionnez le nest sous lequel ce serveur sera regroupé.</p>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="pEggId">Egg</label>
                        <select id="pEggId" name="egg_id" class="form-control"></select>
                        <p class="small text-muted no-margin">Sélectionnez l'Egg qui définira le fonctionnement de ce serveur.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input type="checkbox" id="pSkipScripting" name="skip_scripts" value="1" {{ \Pterodactyl\Helpers\Utilities::checked('skip_scripts', 0) }} />
                            <label for="pSkipScripting" class="strong">Ignorer le script d'installation de l'egg</label>
                        </div>

                        <p class="small text-muted no-margin">Si l'Egg sélectionné a un script d'installation attaché, le script s'exécutera pendant l'installation. Si vous souhaitez ignorer cette étape, cochez cette case.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration Docker</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pDefaultContainer">Image Docker</label>
                        <select id="pDefaultContainer" name="image" class="form-control"></select>
                        <input id="pDefaultContainerCustom" name="custom_image" value="{{ old('custom_image') }}" class="form-control" placeholder="Ou saisissez une image personnalisée..." style="margin-top:1rem"/>
                        <p class="small text-muted no-margin">Il s'agit de l'image Docker par défaut qui sera utilisée pour exécuter ce serveur. Sélectionnez une image dans la liste déroulante ci-dessus ou saisissez une image personnalisée dans le champ de texte ci-dessus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration de démarrage</h3>
                </div>

                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pStartup">Commande de démarrage</label>
                        <input type="text" id="pStartup" name="startup" value="{{ old('startup') }}" class="form-control" />
                        <p class="small text-muted no-margin">Les substitutions de données suivantes sont disponibles pour la commande de démarrage : <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code> et <code>@{{SERVER_PORT}}</code>. Ils seront remplacés par la mémoire allouée, l'adresse IP du serveur et le port du serveur respectivement.</p>
                    </div>
                </div>

                <div class="box-header with-border" style="margin-top:-10px;">
                    <h3 class="box-title">Variables de service</h3>
                </div>

                <div class="box-body row" id="appendVariablesTo"></div>

                <div class="box-footer">
                    {!! csrf_field() !!}
                    <input type="submit" class="btn btn-success pull-right" value="Créer le serveur" />
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}

    <script type="application/javascript">
        // Persist 'Service Variables'
        function serviceVariablesUpdated(eggId, ids) {
            @if (old('egg_id'))
                // Check if the egg id matches.
                if (eggId != '{{ old('egg_id') }}') {
                    return;
                }

                @if (old('environment'))
                    @foreach (old('environment') as $key => $value)
                        $('#' + ids['{{ $key }}']).val('{{ $value }}');
                    @endforeach
                @endif
            @endif
            @if(old('image'))
                $('#pDefaultContainer').val('{{ old('image') }}');
            @endif
        }
        // END Persist 'Service Variables'
    </script>

    {!! Theme::js('js/admin/new-server.js?v=20220530') !!}

    <script type="application/javascript">
        $(document).ready(function() {
            // Persist 'Server Owner' select2
            @if (old('owner_id'))
                $.ajax({
                    url: '/admin/users/accounts.json?user_id={{ old('owner_id') }}',
                    dataType: 'json',
                }).then(function (data) {
                    initUserIdSelect([ data ]);
                });
            @else
                initUserIdSelect();
            @endif
            // END Persist 'Server Owner' select2

            // Persist 'Node' select2
            @if (old('node_id'))
                $('#pNodeId').val('{{ old('node_id') }}').change();

                // Persist 'Default Allocation' select2
                @if (old('allocation_id'))
                    $('#pAllocation').val('{{ old('allocation_id') }}').change();
                @endif
                // END Persist 'Default Allocation' select2

                // Persist 'Additional Allocations' select2
                @if (old('allocation_additional'))
                    const additional_allocations = [];

                    @for ($i = 0; $i < count(old('allocation_additional')); $i++)
                        additional_allocations.push('{{ old('allocation_additional.'.$i)}}');
                    @endfor

                    $('#pAllocationAdditional').val(additional_allocations).change();
                @endif
                // END Persist 'Additional Allocations' select2
            @endif
            // END Persist 'Node' select2

            // Persist 'Nest' select2
            @if (old('nest_id'))
                $('#pNestId').val('{{ old('nest_id') }}').change();

                // Persist 'Egg' select2
                @if (old('egg_id'))
                    $('#pEggId').val('{{ old('egg_id') }}').change();
                @endif
                // END Persist 'Egg' select2
            @endif
            // END Persist 'Nest' select2
        });
    </script>
@endsection
