@extends('layouts.admin')

@section('title')
    Nests &rarr; Nouvel Egg
@endsection

@section('content-header')
    <h1>Nouvel Egg<small>Créer un nouvel Egg à attribuer aux serveurs.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li class="active">Nouvel Egg</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.egg.new') }}" method="POST">
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
                                <label for="pNestId" class="form-label">Nest Associé</label>
                                <div>
                                    <select name="nest_id" id="pNestId">
                                        @foreach($nests as $nest)
                                            <option value="{{ $nest->id }}" {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted small">Pensez à un Nest comme une catégorie. Vous pouvez mettre plusieurs Eggs dans un Nest, mais envisagez de ne mettre que des Eggs qui sont liés les uns aux autres dans chaque Nest.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pName" class="form-label">Nom</label>
                                <input type="text" id="pName" name="name" value="{{ old('name') }}" class="form-control" />
                                <p class="text-muted small">Un nom simple et lisible par l'homme à utiliser comme identifiant pour cet Egg. C'est ce que les utilisateurs verront comme leur type de serveur de jeu.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDescription" class="form-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                <p class="text-muted small">Une description de cet Egg.</p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" {{ \Pterodactyl\Helpers\Utilities::checked('force_outgoing_ip', 0) }} />
                                    <label for="pForceOutgoingIp" class="strong">Forcer l'IP Sortante</label>
                                    <p class="text-muted small">
                                        Force tout le trafic réseau sortant à avoir son IP Source NATée vers l'IP de l'allocation IP principale du serveur.
                                        Nécessaire pour que certains jeux fonctionnent correctement lorsque le Node a plusieurs adresses IP publiques.
                                        <br>
                                        <strong>
                                            En activant cette option, vous désactiverez le réseau interne pour tous les serveurs utilisant cet Egg,
                                            les empêchant ainsi d'accéder internement à d'autres serveurs sur le même Node.
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Images Docker</label>
                                <textarea id="pDockerImages" name="docker_images" rows="4" placeholder="quay.io/pterodactyl/service" class="form-control">{{ old('docker_images') }}</textarea>
                                <p class="text-muted small">Les images docker disponibles pour les serveurs utilisant cet Egg. Entrez une par ligne. Les utilisateurs pourront sélectionner parmi cette liste d'images si plus d'une valeur est fournie.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Commande de Démarrage</label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="10">{{ old('startup') }}</textarea>
                                <p class="text-muted small">La commande de démarrage par défaut qui doit être utilisée pour les nouveaux serveurs créés avec cet Egg. Vous pouvez le modifier par serveur au besoin.</p>
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
                                <p>Tous les champs sont obligatoires à moins que vous ne sélectionniez une option différente dans le menu déroulant 'Copier les Paramètres De', auquel cas les champs peuvent être laissés vides pour utiliser les valeurs de cette option.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Copier les Paramètres De</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">Aucun</option>
                                </select>
                                <p class="text-muted small">Si vous souhaitez utiliser par défaut les paramètres d'un autre Egg, sélectionnez-le dans le menu déroulant ci-dessus.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Commande d'Arrêt</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ old('config_stop') }}" />
                                <p class="text-muted small">La commande qui doit être envoyée aux processus serveur pour les arrêter correctement. Si vous devez envoyer un <code>SIGINT</code>, vous devez entrer <code>^C</code> ici.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Configuration des Logs</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                                <p class="text-muted small">Ceci devrait être une représentation JSON de l'endroit où les fichiers journaux sont stockés, et si oui ou non le démon doit créer des journaux personnalisés.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Fichiers de Configuration</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                                <p class="text-muted small">Ceci devrait être une représentation JSON des fichiers de configuration à modifier et des parties à modifier.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Configuration de Démarrage</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                                <p class="text-muted small">Ceci devrait être une représentation JSON des valeurs que le démon doit rechercher lors du démarrage d'un serveur pour déterminer l'achèvement.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Créer</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function() {
        $('#pNestId').select2().change();
        $('#pConfigFrom').select2();
    });
    $('#pNestId').on('change', function (event) {
        $('#pConfigFrom').html('<option value="">Aucun</option>').select2({
            data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                return {
                    id: item.id,
                    text: item.name + ' <' + item.author + '>',
                };
            }),
        });
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
