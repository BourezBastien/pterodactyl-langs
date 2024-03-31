@extends('layouts.admin')

@section('title')
    Nouveau Nest
@endsection

@section('content-header')
    <h1>Nouveau Nest<small>Configurer un nouveau nest à déployer sur tous les nodes.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li class="active">Nouveau</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.new') }}" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Nouveau Nest</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Nom</label>
                        <div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            <p class="text-muted"><small>Ceci devrait être un nom de catégorie descriptif qui englobe tous les eggs dans le nest.</small></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary pull-right">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
