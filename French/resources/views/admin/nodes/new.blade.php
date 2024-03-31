@extends('layouts.admin')

@section('title')
    Nodes &rarr; Nouveau
@endsection

@section('content-header')
    <h1>Nouveau node<small>Créer un nouveau node local ou distant pour l'installation des serveurs.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li class="active">Nouveau</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nodes.new') }}" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Détails de base</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Nom</label>
                        <input type="text" name="name" id="pName" class="form-control" value="{{ old('name') }}"/>
                        <p class="text-muted small">Limites de caractères : <code>a-zA-Z0-9_.-</code> et <code>[Espace]</code> (min 1, max 100 caractères).</p>
                    </div>
                    <div class="form-group">
                        <label for="pDescription" class="form-label">Description</label>
                        <textarea name="description" id="pDescription" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="pLocatioNest" class="form-label">Emplacement</label>
                        <select name="location_id" id="pLocatioNest">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Visibilité du node</label>
                        <div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pPublicTrue" value="1" name="public" checked>
                                <label for="pPublicTrue"> Public </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pPublicFalse" value="0" name="public">
                                <label for="pPublicFalse"> Privé </label>
                            </div>
                        </div>
                        <p class="text-muted small">En définissant un node comme <code>privé</code>, vous empêcherez la possibilité de déploiement automatique sur ce node.
                    </div>
                    <div class="form-group">
                        <label for="pFQDN" class="form-label">FQDN</label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" value="{{ old('fqdn') }}"/>
                        <p class="text-muted small">Veuillez entrer le nom de domaine (par exemple, <code>node.example.com</code>) à utiliser pour se connecter au démon. Une adresse IP peut être utilisée <em>uniquement</em> si vous n'utilisez pas SSL pour ce node.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Communiquer via SSL</label>
                        <div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" checked>
                                <label for="pSSLTrue"> Utiliser une connexion SSL</label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" @if(request()->isSecure()) disabled @endif>
                                <label for="pSSLFalse"> Utiliser une connexion HTTP</label>
                            </div>
                        </div>
                        @if(request()->isSecure())
                            <p class="text-danger small">Votre panneau est actuellement configuré pour utiliser une connexion sécurisée. Pour que les navigateurs puissent se connecter à votre node, il <strong>doit</strong> utiliser une connexion SSL.</p>
                        @else
                            <p class="text-muted small">Dans la plupart des cas, vous devriez sélectionner d'utiliser une connexion SSL. Si vous utilisez une adresse IP ou si vous ne souhaitez pas utiliser SSL du tout, sélectionnez une connexion HTTP.</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Derrière un proxy</label>
                        <div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" checked>
                                <label for="pProxyFalse"> Pas derrière un proxy </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy">
                                <label for="pProxyTrue"> Derrière un proxy </label>
                            </div>
                        </div>
                        <p class="text-muted small">Si vous exécutez le démon derrière un proxy tel que Cloudflare, sélectionnez ceci pour que le démon ignore la recherche de certificats au démarrage.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDaemonBase" class="form-label">Répertoire des fichiers serveur du démon</label>
                            <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="/var/lib/pterodactyl/volumes" />
                            <p class="text-muted small">Entrez le répertoire où les fichiers serveur doivent être stockés. <strong>Si vous utilisez OVH, vous devez vérifier votre schéma de partition. Vous devrez peut-être utiliser <code>/home/daemon-data</code> pour avoir suffisamment d'espace.</strong></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemory" class="form-label">Mémoire totale</label>
                            <div class="input-group">
                                <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" value="{{ old('memory') }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemoryOverallocate" class="form-label">Sur-allocation de mémoire</label>
                            <div class="input-group">
                                <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Entrez le montant total de mémoire disponible pour les nouveaux serveurs. Si vous souhaitez autoriser la surallocation de mémoire, entrez le pourcentage que vous souhaitez autoriser. Pour désactiver la vérification de surallocation, entrez <code>-1</code> dans le champ. Entrer <code>0</code> empêchera la création de nouveaux serveurs si cela mettrait le node au-dessus de la limite.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDisk" class="form-label">Espace disque total</label>
                            <div class="input-group">
                                <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" value="{{ old('disk') }}"/>
                                <span class="input-group-addon">MiB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDiskOverallocate" class="form-label">Sur-allocation de disque</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Entrez le montant total d'espace disque disponible pour les nouveaux serveurs. Si vous souhaitez autoriser la surallocation d'espace disque, entrez le pourcentage que vous souhaitez autoriser. Pour désactiver la vérification de surallocation, entrez <code>-1</code> dans le champ. Entrer <code>0</code> empêchera la création de nouveaux serveurs si cela mettrait le node au-dessus de la limite.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDaemonListen" class="form-label">Port du démon</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="8080" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDaemonSFTP" class="form-label">Port SFTP du démon</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="2022" />
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Le démon exécute son propre conteneur de gestion SFTP et n'utilise pas le processus SSHd sur le serveur physique principal. <Strong>Ne pas utiliser le même port que celui assigné au processus SSH de votre serveur physique.</strong> Si vous exécutez le démon derrière CloudFlare&reg;, vous devriez définir le port du démon sur <code>8443</code> pour permettre le proxy websocket via SSL.</p>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success pull-right">Créer un node</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pLocatioNest').select2();
    </script>
@endsection