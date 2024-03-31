@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }}: Gérer
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Actions supplémentaires pour contrôler ce serveur.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Gérer</li>
    </ol>
@endsection

@section('content')
    @include('admin.servers.partials.navigation')
    <div class="row">
        <div class="col-sm-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Réinstaller le serveur</h3>
                </div>
                <div class="box-body">
                    <p>Cela réinstallera le serveur avec les scripts de service assignés. <strong>Attention !</strong> Cela pourrait écraser les données du serveur.</p>
                </div>
                <div class="box-footer">
                    @if($server->isInstalled())
                        <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-danger">Réinstaller le serveur</button>
                        </form>
                    @else
                        <button class="btn btn-danger disabled">Le serveur doit être correctement installé pour être réinstallé</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">État de l'installation</h3>
                </div>
                <div class="box-body">
                    <p>Si vous devez changer l'état de l'installation de non installé à installé, ou vice versa, vous pouvez le faire avec le bouton ci-dessous.</p>
                </div>
                <div class="box-footer">
                    <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary">Basculer l'état de l'installation</button>
                    </form>
                </div>
            </div>
        </div>

        @if(! $server->isSuspended())
            <div class="col-sm-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Suspendre le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>Cela suspendra le serveur, arrêtera tous les processus en cours d'exécution et bloquera immédiatement l'utilisateur pour qu'il ne puisse pas accéder à ses fichiers ou gérer autrement le serveur via le panneau ou l'API.</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="suspend" />
                            <button type="submit" class="btn btn-warning @if(! is_null($server->transfer)) disabled @endif">Suspendre le serveur</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Réactiver le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>Cela réactivera le serveur et restaurera l'accès normal à l'utilisateur.</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="unsuspend" />
                            <button type="submit" class="btn btn-success">Réactiver le serveur</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if(is_null($server->transfer))
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transférer le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            Transférez ce serveur vers un autre node connecté à ce panneau.
                            <strong>Attention !</strong> Cette fonctionnalité n'a pas été entièrement testée et peut contenir des bogues.
                        </p>
                    </div>

                    <div class="box-footer">
                        @if($canTransfer)
                            <button class="btn btn-success" data-toggle="modal" data-target="#transferServerModal">Transférer le serveur</button>
                        @else
                            <button class="btn btn-success disabled">Transférer le serveur</button>
                            <p style="padding-top: 1rem;">Transférer un serveur nécessite plus d'un node configuré sur votre panneau.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transférer le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            Ce serveur est actuellement en cours de transfert vers un autre node.
                            Le transfert a été initié à <strong>{{ $server->transfer->created_at }}</strong>
                        </p>
                    </div>

                    <div class="box-footer">
                        <button class="btn btn-success disabled">Transférer le serveur</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="transferServerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.servers.view.manage.transfer', $server->id) }}" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Transférer le serveur</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="pNodeId">Node</label>
                                <select name="node_id" id="pNodeId" class="form-control">
                                    @foreach($locations as $location)
                                        <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                            @foreach($location->nodes as $node)

                                                @if($node->id != $server->node_id)
                                                    <option value="{{ $node->id }}"
                                                            @if($location->id === old('location_id')) selected @endif
                                                    >{{ $node->name }}</option>
                                                @endif

                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="small text-muted no-margin">Le node vers lequel ce serveur sera transféré.</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocation">Allocation par défaut</label>
                                <select name="allocation_id" id="pAllocation" class="form-control"></select>
                                <p class="small text-muted no-margin">L'allocation principale qui sera attribuée à ce serveur.</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocationAdditional">Allocation(s) supplémentaire(s)</label>
                                <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                                <p class="small text-muted no-margin">Allocations supplémentaires à attribuer à ce serveur lors de la création.</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}

    @if($canTransfer)
        {!! Theme::js('js/admin/server/transfer.js') !!}
    @endif
@endsection
