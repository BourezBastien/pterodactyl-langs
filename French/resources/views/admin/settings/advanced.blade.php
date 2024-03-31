@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'advanced'])

@section('title')
    Paramètres avancés
@endsection

@section('content-header')
    <h1>Paramètres avancés<small>Configurer les paramètres avancés pour Pterodactyl.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Paramètres</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">reCAPTCHA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Statut</label>
                                <div>
                                    <select class="form-control" name="recaptcha:enabled">
                                        <option value="true">Activé</option>
                                        <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>Désactivé</option>
                                    </select>
                                    <p class="text-muted small">Si activé, les formulaires de connexion et de réinitialisation de mot de passe effectueront une vérification de captcha silencieuse et afficheront un captcha visible si nécessaire.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Clé de site</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Clé secrète</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}">
                                    <p class="text-muted small">Utilisé pour la communication entre votre site et Google. Assurez-vous de le garder secret.</p>
                                </div>
                            </div>
                        </div>
                        @if($showRecaptchaWarning)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="alert alert-warning no-margin">
                                        Vous utilisez actuellement des clés reCAPTCHA qui ont été livrées avec ce panneau. Pour une sécurité améliorée, il est recommandé de <a href="https://www.google.com/recaptcha/admin">générer de nouvelles clés reCAPTCHA invisibles</a> spécifiquement liées à votre site web.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Connexions HTTP</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Délai de connexion</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:connect_timeout" value="{{ old('pterodactyl:guzzle:connect_timeout', config('pterodactyl.guzzle.connect_timeout')) }}">
                                    <p class="text-muted small">Le temps en secondes à attendre pour qu'une connexion soit ouverte avant de générer une erreur.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Délai de demande</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:timeout" value="{{ old('pterodactyl:guzzle:timeout', config('pterodactyl.guzzle.timeout')) }}">
                                    <p class="text-muted small">Le temps en secondes à attendre pour qu'une demande soit terminée avant de générer une erreur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Création automatique d'allocations</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Statut</label>
                                <div>
                                    <select class="form-control" name="pterodactyl:client_features:allocations:enabled">
                                        <option value="false">Désactivé</option>
                                        <option value="true" @if(old('pterodactyl:client_features:allocations:enabled', config('pterodactyl.client_features.allocations.enabled'))) selected @endif>Activé</option>
                                    </select>
                                    <p class="text-muted small">Si activé, les utilisateurs auront la possibilité de créer automatiquement de nouvelles allocations pour leur serveur via l'interface.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Port de départ</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_start" value="{{ old('pterodactyl:client_features:allocations:range_start', config('pterodactyl.client_features.allocations.range_start')) }}">
                                    <p class="text-muted small">Le port de départ dans la plage qui peut être allouée automatiquement.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Port de fin</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_end" value="{{ old('pterodactyl:client_features:allocations:range_end', config('pterodactyl.client_features.allocations.range_end')) }}">
                                    <p class="text-muted small">Le port de fin dans la plage qui peut être allouée automatiquement.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
