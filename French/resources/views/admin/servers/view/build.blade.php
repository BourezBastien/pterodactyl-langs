@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }}: Détails de construction
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Contrôlez les allocations et les ressources système pour ce serveur.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Configuration de construction</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
        <div class="col-sm-5">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des ressources</h3>
                </div>
                <div class="box-body">
                <div class="form-group">
                        <label for="cpu" class="control-label">Limite de CPU</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="text-muted small">Chaque cœur (thread) virtuel sur le système est considéré comme <code>100%</code>. Définir cette valeur à <code>0</code> permettra à un serveur d'utiliser le temps CPU sans restrictions.</p>
                    </div>
                    <div class="form-group">
                        <label for="threads" class="control-label">Épinglage de CPU</label>
                        <div>
                            <input type="text" name="threads" class="form-control" value="{{ old('threads', $server->threads) }}"/>
                        </div>
                        <p class="text-muted small"><strong>Avancé :</strong> Entrez les cœurs CPU spécifiques sur lesquels ce processus peut s'exécuter, ou laissez vide pour autoriser tous les cœurs. Il peut s'agir d'un seul nombre ou d'une liste séparée par des virgules. Exemple : <code>0</code>, <code>0-1,3</code>, ou <code>0,1,3,4</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="memory" class="control-label">Mémoire allouée</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">La quantité maximale de mémoire autorisée pour ce conteneur. Définir cette valeur à <code>0</code> permettra une mémoire illimitée dans un conteneur.</p>
                    </div>
                    <div class="form-group">
                        <label for="swap" class="control-label">Espace d'échange alloué</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Définir cette valeur à <code>0</code> désactivera l'espace d'échange sur ce serveur. Définir à <code>-1</code> permettra un échange illimité.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">Limite d'espace disque</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Ce serveur ne sera pas autorisé à démarrer s'il utilise plus que cette quantité d'espace. Si un serveur dépasse cette limite en cours d'exécution, il sera arrêté en toute sécurité et verrouillé jusqu'à ce que suffisamment d'espace soit disponible. Définissez sur <code>0</code> pour permettre une utilisation illimitée du disque.</p>
                    </div>
                    <div class="form-group">
                        <label for="io" class="control-label">Proportion du bloc IO</label>
                        <div>
                            <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        </div>
                        <p class="text-muted small"><strong>Avancé :</strong> Les performances IO de ce serveur par rapport à d'autres conteneurs <em>en cours d'exécution</em> sur le système. La valeur doit être comprise entre <code>10</code> et <code>1000</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif>
                                <label for="pOomKillerEnabled">Activé</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif>
                                <label for="pOomKillerDisabled">Désactivé</label>
                            </div>
                            <p class="text-muted small">
                                Activer l'OOM killer peut entraîner la sortie inattendue des processus du serveur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Limites des fonctionnalités de l'application</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="database_limit" class="control-label">Limite de la base de données</label>
                                    <div>
                                        <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Le nombre total de bases de données qu'un utilisateur est autorisé à créer pour ce serveur.</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="allocation_limit" class="control-label">Limite d'allocation</label>
                                    <div>
                                        <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Le nombre total d'allocations qu'un utilisateur est autorisé à créer pour ce serveur.</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="backup_limit" class="control-label">Limite de sauvegarde</label>
                                    <div>
                                        <input type="text" name="backup_limit" class="form-control" value="{{ old('backup_limit', $server->backup_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Le nombre total de sauvegardes pouvant être créées pour ce serveur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gestion des allocations</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="pAllocation" class="control-label">Port de jeu</label>
                                <select id="pAllocation" name="allocation_id" class="form-control">
                                    @foreach ($assigned as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            @if($assignment->id === $server->allocation_id)
                                                selected="selected"
                                            @endif
                                        >{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">L'adresse de connexion par défaut qui sera utilisée pour ce serveur de jeu.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAddAllocations" class="control-label">Attribuer des ports supplémentaires</label>
                                <div>
                                    <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                                        @foreach ($unassigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Veuillez noter qu'en raison de limitations logicielles, vous ne pouvez pas attribuer des ports identiques sur différentes IPs au même serveur.</p>
                            </div>
                            <div class="form-group">
                                <label for="pRemoveAllocations" class="control-label">Supprimer des ports supplémentaires</label>
                                <div>
                                    <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                                        @foreach ($assigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Sélectionnez simplement les ports que vous souhaitez supprimer dans la liste ci-dessus. Si vous souhaitez attribuer un port sur une IP différente déjà utilisée, vous pouvez le sélectionner dans la liste de gauche et le supprimer ici.</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-primary pull-right">Mettre à jour la configuration de construction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection
