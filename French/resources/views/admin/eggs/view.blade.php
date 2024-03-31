@extends('layouts.admin')

@section('title')
    nests &rarr; Egg : {{ $egg->name }}
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>{{ str_limit($egg->description, 50) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">nests</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li class="active">{{ $egg->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.nests.egg.view', $egg->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}">Variables</a></li>
                <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">Install Script</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group no-margin-bottom">
                                <label for="pName" class="control-label">Fichier Egg</label>
                                <div>
                                    <input type="file" name="import_file" class="form-control" style="border: 0;margin-left:-10px;" />
                                    <p class="text-muted small no-margin-bottom">Si vous souhaitez remplacer les paramètres pour cet Egg en téléchargeant un nouveau fichier JSON, sélectionnez-le ici et appuyez sur "Mettre à jour Egg". Cela ne changera pas les chaînes de démarrage existantes ni les images Docker pour les serveurs existants.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            {!! csrf_field() !!}
                            <button type="submit" name="_method" value="PUT" class="btn btn-sm btn-danger pull-right">Mettre à jour Egg</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pName" class="control-label">Nom <span class="field-required"></span></label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p class="text-muted small">Un nom simple et lisible par l'homme à utiliser comme identifiant pour cet Egg.</p>
                            </div>
                            <div class="form-group">
                                <label for="pUuid" class="control-label">UUID</label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" />
                                <p class="text-muted small">C'est l'identifiant unique mondial pour cet Egg que le Daemon utilise comme identifiant.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAuthor" class="control-label">Auteur</label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" />
                                <p class="text-muted small">L'auteur de cette version de l'Egg. Le téléchargement d'une nouvelle configuration d'Egg à partir d'un auteur différent changera cela.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Images Docker <span class="field-required"></span></label>
                                <textarea id="pDockerImages" name="docker_images" class="form-control" rows="4">{{ implode(PHP_EOL, $images) }}</textarea>
                                <p class="text-muted small">
                                    Les images docker disponibles pour les serveurs utilisant cet egg. Entrez une par ligne. Les utilisateurs
                                    pourront sélectionner dans cette liste d'images s'il y en a plus d'une fournie.
                                    Facultativement, un nom d'affichage peut être fourni en préfixant l'image avec le nom
                                    suivi d'un caractère de pipe, puis l'URL de l'image. Exemple : <code>Nom Affiché|ghcr.io/my/egg</code>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" @if($egg->force_outgoing_ip) checked @endif />
                                    <label for="pForceOutgoingIp" class="strong">Forcer l'IP sortante</label>
                                    <p class="text-muted small">
                                        Force tout le trafic réseau sortant à avoir son adresse IP source NATée vers l'IP d'allocation primaire du serveur.
                                        Nécessaire pour que certains jeux fonctionnent correctement lorsque le Node a plusieurs adresses IP publiques.
                                        <br>
                                        <strong>
                                            Activer cette option désactivera le réseau interne pour tous les serveurs utilisant cet Egg,
                                            les empêchant ainsi d'accéder internement à d'autres serveurs sur le même node.
                                        </strong>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDescription" class="control-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ $egg->description }}</textarea>
                                <p class="text-muted small">Une description de cet Egg qui sera affichée dans le Panneau selon les besoins.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Commande de démarrage <span class="field-required"></span></label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="8">{{ $egg->startup }}</textarea>
                                <p class="text-muted small">La commande de démarrage par défaut qui doit être utilisée pour les nouveaux serveurs utilisant cet Egg.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des Processus</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-warning">
                                <p>Les options de configuration suivantes ne doivent pas être modifiées à moins que vous compreniez comment ce système fonctionne. En cas de mauvaise modification, il est possible que le démon soit endommagé.</p>
                                <p>Tous les champs sont obligatoires sauf si vous sélectionnez une option différente dans le menu déroulant "Copier les paramètres à partir de", auquel cas les champs peuvent être laissés vides pour utiliser les valeurs de cet Egg.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Copier les paramètres à partir de</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">Aucun</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Si vous souhaitez utiliser les paramètres par défaut d'un autre Egg, sélectionnez-le dans le menu ci-dessus.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Commande d'arrêt</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" />
                                <p class="text-muted small">La commande qui doit être envoyée aux processus de serveur pour les arrêter correctement. Si vous devez envoyer un <code>SIGINT</code>, vous devez entrer <code>^C</code> ici.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Configuration des journaux</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cela devrait être une représentation JSON de l'endroit où les fichiers journaux sont stockés et si le démon doit créer des journaux personnalisés.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Fichiers de configuration</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cela devrait être une représentation JSON des fichiers de configuration à modifier et des parties à modifier.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Configuration de démarrage</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cela devrait être une représentation JSON des valeurs que le démon doit rechercher lors du démarrage d'un serveur pour déterminer la fin.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm pull-right">Enregistrer</button>
                    <a href="{{ route('admin.nests.egg.export', $egg->id) }}" class="btn btn-sm btn-info pull-right" style="margin-right:10px;">Exporter</a>
                    <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn btn-danger btn-sm muted muted-hover">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pConfigFrom').select2();
    $('#deleteButton').on('mouseenter', function (event) {
        $(this).find('i').html(' Supprimer l\'Egg');
    }).on('mouseleave', function (event) {
        $(this).find('i').html('');
    });
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();

            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);

            $(this).val(prepend + '    ' + append);
        }
    });
    </script>
@endsection