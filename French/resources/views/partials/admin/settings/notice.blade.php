@section('settings::notice')
    @if(config('pterodactyl.load_environment_only', false))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    Votre panneau est actuellement configuré pour lire les paramètres uniquement à partir de l'environnement. Vous devrez définir <code>APP_ENVIRONMENT_ONLY=false</code> dans votre fichier d'environnement pour charger les paramètres dynamiquement.
                </div>
            </div>
        </div>
    @endif
@endsection
