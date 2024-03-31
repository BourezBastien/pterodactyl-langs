@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'mail'])

@section('title')
    Paramètres de messagerie
@endsection

@section('content-header')
    <h1>Paramètres de messagerie<small>Configurez comment Pterodactyl doit gérer l'envoi d'e-mails.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Paramètres</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Paramètres de messagerie électronique</h3>
                </div>
                @if($disabled)
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info no-margin-bottom">
                                    Cette interface est limitée aux instances utilisant SMTP comme pilote de messagerie. Veuillez soit utiliser la commande <code>php artisan p:environment:mail</code> pour mettre à jour vos paramètres de messagerie, ou définir <code>MAIL_DRIVER=smtp</code> dans votre fichier d'environnement.
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Hôte SMTP</label>
                                    <div>
                                        <input required type="text" class="form-control" name="mail:mailers:smtp:host" value="{{ old('mail:mailers:smtp:host', config('mail.mailers.smtp.host')) }}" />
                                        <p class="text-muted small">Entrez l'adresse du serveur SMTP à travers lequel les e-mails doivent être envoyés.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">Port SMTP</label>
                                    <div>
                                        <input required type="number" class="form-control" name="mail:mailers:smtp:port" value="{{ old('mail:mailers:smtp:port', config('mail.mailers.smtp.port')) }}" />
                                        <p class="text-muted small">Entrez le port du serveur SMTP à travers lequel les e-mails doivent être envoyés.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Chiffrement</label>
                                    <div>
                                        @php
                                            $encryption = old('mail:mailers:smtp:encryption', config('mail.mailers.smtp.encryption'));
                                        @endphp
                                        <select name="mail:mailers:smtp:encryption" class="form-control">
                                            <option value="" @if($encryption === '') selected @endif>Aucun</option>
                                            <option value="tls" @if($encryption === 'tls') selected @endif>Transport Layer Security (TLS)</option>
                                            <option value="ssl" @if($encryption === 'ssl') selected @endif>Secure Sockets Layer (SSL)</option>
                                        </select>
                                        <p class="text-muted small">Sélectionnez le type de chiffrement à utiliser lors de l'envoi d'e-mails.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Nom d'utilisateur <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:mailers:smtp:username" value="{{ old('mail:mailers:smtp:username', config('mail.mailers.smtp.username')) }}" />
                                        <p class="text-muted small">Le nom d'utilisateur à utiliser lors de la connexion au serveur SMTP.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Mot de passe <span class="field-optional"></span></label>
                                    <div>
                                        <input type="password" class="form-control" name="mail:mailers:smtp:password"/>
                                        <p class="text-muted small">Le mot de passe à utiliser avec le nom d'utilisateur SMTP. Laissez vide pour continuer à utiliser le mot de passe existant. Pour définir le mot de passe sur une valeur vide, entrez <code>!e</code> dans le champ.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr />
                                <div class="form-group col-md-6">
                                    <label class="control-label">Expéditeur</label>
                                    <div>
                                        <input required type="email" class="form-control" name="mail:from:address" value="{{ old('mail:from:address', config('mail.from.address')) }}" />
                                        <p class="text-muted small">Entrez une adresse e-mail à partir de laquelle tous les e-mails sortants seront envoyés.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Nom de l'expéditeur <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:from:name" value="{{ old('mail:from:name', config('mail.from.name')) }}" />
                                        <p class="text-muted small">Le nom sous lequel les e-mails doivent apparaître.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            {{ csrf_field() }}
                            <div class="pull-right">
                                <button type="button" id="testButton" class="btn btn-sm btn-success">Test</button>
                                <button type="button" id="saveButton" class="btn btn-sm btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent

    <script>
        function saveSettings() {
            return $.ajax({
                method: 'PATCH',
                url: '/admin/settings/mail',
                contentType: 'application/json',
                data: JSON.stringify({
                    'mail:mailers:smtp:host': $('input[name="mail:mailers:smtp:host"]').val(),
                    'mail:mailers:smtp:port': $('input[name="mail:mailers:smtp:port"]').val(),
                    'mail:mailers:smtp:encryption': $('select[name="mail:mailers:smtp:encryption"]').val(),
                    'mail:mailers:smtp:username': $('input[name="mail:mailers:smtp:username"]').val(),
                    'mail:mailers:smtp:password': $('input[name="mail:mailers:smtp:password"]').val(),
                    'mail:from:address': $('input[name="mail:from:address"]').val(),
                    'mail:from:name': $('input[name="mail:from:name"]').val()
                }),
                headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
            }).fail(function (jqXHR) {
                showErrorDialog(jqXHR, 'save');
            });
        }

        function testSettings() {
            swal({
                type: 'info',
                title: 'Test des paramètres de messagerie',
                text: 'Cliquez sur "Test" pour commencer le test.',
                showCancelButton: true,
                confirmButtonText: 'Test',
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    method: 'POST',
                    url: '/admin/settings/mail/test',
                    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
                }).fail(function (jqXHR) {
                    showErrorDialog(jqXHR, 'test');
                }).done(function () {
                    swal({
                        title: 'Succès',
                        text: 'Le message de test a été envoyé avec succès.',
                        type: 'success'
                    });
                });
            });
        }

        function saveAndTestSettings() {
            saveSettings().done(testSettings);
        }

        function showErrorDialog(jqXHR, verb) {
            console.error(jqXHR);
            var errorText = '';
            if (!jqXHR.responseJSON) {
                errorText = jqXHR.responseText;
            } else if (jqXHR.responseJSON.error) {
                errorText = jqXHR.responseJSON.error;
            } else if (jqXHR.responseJSON.errors) {
                $.each(jqXHR.responseJSON.errors, function (i, v) {
                    if (v.detail) {
                        errorText += v.detail + ' ';
                    }
                });
            }

            swal({
                title: 'Oups !',
                text: 'Une erreur s\'est produite lors de la tentative de ' + verb + ' des paramètres de messagerie : ' + errorText,
                type: 'error'
            });
        }

        $(document).ready(function () {
            $('#testButton').on('click', saveAndTestSettings);
            $('#saveButton').on('click', function () {
                saveSettings().done(function () {
                    swal({
                        title: 'Succès',
                        text: 'Les paramètres de messagerie ont été mis à jour avec succès et le travailleur de file d'attente a été redémarré pour appliquer ces modifications.',
                        type: 'success'
                    });
                });
            });
        });
    </script>
@endsection
