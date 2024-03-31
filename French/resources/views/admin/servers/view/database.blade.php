@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }}: Bases de données
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Gérer les bases de données du serveur.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Bases de données</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <div class="col-sm-7">
        <div class="alert alert-info">
            Les mots de passe de la base de données peuvent être consultés en <a href="/server/{{ $server->uuidShort }}/databases">visitant ce serveur</a> sur le front-end.
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Bases de données actives</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Base de données</th>
                        <th>Nom d'utilisateur</th>
                        <th>Connexions depuis</th>
                        <th>Hôte</th>
                        <th>Connexions max</th>
                        <th></th>
                    </tr>
                    @foreach($server->databases as $database)
                        <tr>
                            <td>{{ $database->database }}</td>
                            <td>{{ $database->username }}</td>
                            <td>{{ $database->remote }}</td>
                            <td><code>{{ $database->host->host }}:{{ $database->host->port }}</code></td>
                            @if($database->max_connections != null)
                                <td>{{ $database->max_connections }}</td>
                            @else
                                <td>Illimité</td>
                            @endif
                            <td class="text-center">
                                <button data-action="reset-password" data-id="{{ $database->id }}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></button>
                                <button data-action="remove" data-id="{{ $database->id }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Créer une nouvelle base de données</h3>
            </div>
            <form action="{{ route('admin.servers.view.database', $server->id) }}" method="POST">
                <div class="box-body">
                    <div class="form-group">
                        <label for="pDatabaseHostId" class="control-label">Hôte de la base de données</label>
                        <select id="pDatabaseHostId" name="database_host_id" class="form-control">
                            @foreach($hosts as $host)
                                <option value="{{ $host->id }}">{{ $host->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Sélectionnez le serveur de base de données hôte sur lequel cette base de données doit être créée.</p>
                    </div>
                    <div class="form-group">
                        <label for="pDatabaseName" class="control-label">Base de données</label>
                        <div class="input-group">
                            <span class="input-group-addon">s{{ $server->id }}_</span>
                            <input id="pDatabaseName" type="text" name="database" class="form-control" placeholder="base_de_donnees" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pRemote" class="control-label">Connexions</label>
                        <input id="pRemote" type="text" name="remote" class="form-control" value="%" />
                        <p class="text-muted small">Cela doit refléter l'adresse IP à partir de laquelle les connexions sont autorisées. Utilise la notation MySQL standard. En cas de doute, laissez <code>%</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="pmax_connections" class="control-label">Connexions concurrentes</label>
                        <input id="pmax_connections" type="text" name="max_connections" class="form-control"/>
                        <p class="text-muted small">Cela doit refléter le nombre maximum de connexions concurrentes de cet utilisateur à la base de données. Laissez vide pour illimité.</p>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <p class="text-muted small no-margin">Un nom d'utilisateur et un mot de passe pour cette base de données seront générés de manière aléatoire après la soumission du formulaire.</p>
                    <input type="submit" class="btn btn-sm btn-success pull-right" value="Créer la base de données" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pDatabaseHost').select2();
    $('[data-action="remove"]').click(function (event) {
        event.preventDefault();
        var self = $(this);
        swal({
            title: '',
            type: 'warning',
            text: 'Êtes-vous sûr de vouloir supprimer cette base de données ? Il n\'y a pas de retour en arrière, toutes les données seront immédiatement supprimées.',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            $.ajax({
                method: 'DELETE',
                url: '/admin/servers/view/{{ $server->id }}/database/' + self.data('id') + '/delete',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            }).done(function () {
                self.parent().parent().slideUp();
                swal.close();
            }).fail(function (jqXHR) {
                console.error(jqXHR);
                swal({
                    type: 'error',
                    title: 'Oups !',
                    text: (typeof jqXHR.responseJSON.error !== 'undefined') ? jqXHR.responseJSON.error : 'Une erreur s\'est produite lors du traitement de cette demande.'
                });
            });
        });
    });
    $('[data-action="reset-password"]').click(function (e) {
        e.preventDefault();
        var block = $(this);
        $(this).addClass('disabled').find('i').addClass('fa-spin');
        $.ajax({
            type: 'PATCH',
            url: '/admin/servers/view/{{ $server->id }}/database',
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: { database: $(this).data('id') },
        }).done(function (data) {
            swal({
                type: 'success',
                title: '',
                text: 'Le mot de passe de cette base de données a été réinitialisé.',
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(jqXHR);
            var error = 'Une erreur s\'est produite lors de la tentative de traitement de cette demande.';
            if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                error = jqXHR.responseJSON.error;
            }
            swal({
                type: 'error',
                title: 'Oups !',
                text: error
            });
        }).always(function () {
            block.removeClass('disabled').find('i').removeClass('fa-spin');
        });
    });
    </script>
@endsection