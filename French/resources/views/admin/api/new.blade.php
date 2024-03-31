@extends('layouts.admin')

@section('title')
    API de l'application
@endsection

@section('content-header')
    <h1>API de l'application<small>Créer une nouvelle clé API pour l'application.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.api.index') }}">API de l'application</a></li>
        <li class="active">Nouvelles identifications</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.api.new') }}">
            <div class="col-sm-8 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sélectionner les autorisations</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            @foreach($resources as $resource)
                                <tr>
                                    <td class="col-sm-3 strong">{{ str_replace('_', ' ', title_case($resource)) }}</td>
                                    <td class="col-sm-3 radio radio-primary text-center">
                                        <input type="radio" id="r_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['r'] }}">
                                        <label for="r_{{ $resource }}">Lire</label>
                                    </td>
                                    <td class="col-sm-3 radio radio-primary text-center">
                                        <input type="radio" id="rw_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['rw'] }}">
                                        <label for="rw_{{ $resource }}">Lire &amp; Écrire</label>
                                    </td>
                                    <td class="col-sm-3 radio text-center">
                                        <input type="radio" id="n_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['n'] }}" checked>
                                        <label for="n_{{ $resource }}">Aucun</label>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label" for="memoField">Description <span class="field-required"></span></label>
                            <input id="memoField" type="text" name="memo" class="form-control">
                        </div>
                        <p class="text-muted">Une fois que vous avez attribué des autorisations et créé cet ensemble d'identifiants, vous ne pourrez plus revenir en arrière pour le modifier. Si vous avez besoin de faire des modifications plus tard, vous devrez créer un nouvel ensemble d'identifiants.</p>
                    </div>
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn-sm pull-right">Créer les identifiants</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    </script>
@endsection
