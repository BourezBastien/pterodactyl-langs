@extends('layouts.admin')

@section('title')
    Liste des serveurs
@endsection

@section('content-header')
    <h1>Serveurs<small>Tous les serveurs disponibles sur le système.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Serveurs</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des serveurs</h3>
                <div class="box-tools search01">
                    <form action="{{ route('admin.servers') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" name="filter[*]" class="form-control pull-right" value="{{ request()->input()['filter']['*'] ?? '' }}" placeholder="Rechercher des serveurs">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                <a href="{{ route('admin.servers.new') }}"><button type="button" class="btn btn-sm btn-primary" style="border-radius: 0 3px 3px 0;margin-left:-1px;">Créer nouveau</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Nom du serveur</th>
                            <th>UUID</th>
                            <th>Propriétaire</th>
                            <th>Node</th>
                            <th>Connexion</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach ($servers as $server)
                            <tr data-server="{{ $server->uuidShort }}">
                                <td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>
                                <td><code title="{{ $server->uuid }}">{{ $server->uuid }}</code></td>
                                <td><a href="{{ route('admin.users.view', $server->user->id) }}">{{ $server->user->username }}</a></td>
                                <td><a href="{{ route('admin.nodes.view', $server->node->id) }}">{{ $server->node->name }}</a></td>
                                <td>
                                    <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                                </td>
                                <td class="text-center">
                                    @if($server->isSuspended())
                                        <span class="label bg-maroon">Suspendu</span>
                                    @elseif(! $server->isInstalled())
                                        <span class="label label-warning">Installation en cours</span>
                                    @else
                                        <span class="label label-success">Actif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-default" href="/server/{{ $server->uuidShort }}"><i class="fa fa-wrench"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($servers->hasPages())
                <div class="box-footer with-border">
                    <div class="col-md-12 text-center">{!! $servers->appends(['filter' => Request::input('filter')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('.console-popout').on('click', function (event) {
            event.preventDefault();
            window.open($(this).attr('href'), 'Pterodactyl Console', 'width=800,height=400');
        });
    </script>
@endsection