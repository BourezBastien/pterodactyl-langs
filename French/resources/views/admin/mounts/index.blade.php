@extends('layouts.admin')

@section('title')
    Montages
@endsection

@section('content-header')
    <h1>Montages<small>Configurer et gérer des points de montage supplémentaires pour les serveurs.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Montages</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Liste des Montages</h3>

                    <div class="box-tools">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newMountModal">Créer Nouveau</button>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Source</th>
                                <th>Cible</th>
                                <th class="text-center">Eggs</th>
                                <th class="text-center">Nodes</th>
                                <th class="text-center">Serveurs</th>
                            </tr>

                            @foreach ($mounts as $mount)
                                <tr>
                                    <td><code>{{ $mount->id }}</code></td>
                                    <td><a href="{{ route('admin.mounts.view', $mount->id) }}">{{ $mount->name }}</a></td>
                                    <td><code>{{ $mount->source }}</code></td>
                                    <td><code>{{ $mount->target }}</code></td>
                                    <td class="text-center">{{ $mount->eggs_count }}</td>
                                    <td class="text-center">{{ $mount->nodes_count }}</td>
                                    <td class="text-center">{{ $mount->servers_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newMountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.mounts') }}" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #FFFFFF">&times;</span>
                        </button>

                        <h4 class="modal-title">Créer Montage</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="pName" class="form-label">Nom</label>
                                <input type="text" id="pName" name="name" class="form-control" />
                                <p class="text-muted small">Nom unique utilisé pour distinguer ce montage d'un autre.</p>
                            </div>

                            <div class="col-md-12">
                                <label for="pDescription" class="form-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="4"></textarea>
                                <p class="text-muted small">Une description plus longue pour ce montage, doit contenir moins de 191 caractères.</p>
                            </div>

                            <div class="col-md-6">
                                <label for="pSource" class="form-label">Source</label>
                                <input type="text" id="pSource" name="source" class="form-control" />
                                <p class="text-muted small">Chemin du fichier sur le système hôte à monter dans un conteneur.</p>
                            </div>

                            <div class="col-md-6">
                                <label for="pTarget" class="form-label">Cible</label>
                                <input type="text" id="pTarget" name="target" class="form-control" />
                                <p class="text-muted small">Où le montage sera accessible à l'intérieur d'un conteneur.</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Lecture Seule</label>

                                <div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="pReadOnlyFalse" name="read_only" value="0" checked>
                                        <label for="pReadOnlyFalse">Faux</label>
                                    </div>

                                    <div class="radio radio-warning radio-inline">
                                        <input type="radio" id="pReadOnly" name="read_only" value="1">
                                        <label for="pReadOnly">Vrai</label>
                                    </div>
                                </div>

                                <p class="text-muted small">Le montage est-il en lecture seule à l'intérieur du conteneur ?</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Montable par l'Utilisateur</label>

                                <div>
                                    <div class="radio radio-success radio-inline">
                                        <input type="radio" id="pUserMountableFalse" name="user_mountable" value="0" checked>
                                        <label for="pUserMountableFalse">Faux</label>
                                    </div>

                                    <div class="radio radio-warning radio-inline">
                                        <input type="radio" id="pUserMountable" name="user_mountable" value="1">
                                        <label for="pUserMountable">Vrai</label>
                                    </div>
                                </div>

                                <p class="text-muted small">Les utilisateurs doivent-ils pouvoir monter cela eux-mêmes ?</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
