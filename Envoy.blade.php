@servers(['lot' => '-i D:\\espagodev\LightsailDefaultKey-eu-west-3.pem ubuntu@15.237.141.99'])
{{-- @servers([ 'aws' => ['ubuntu@3.18.107.107']]) --}}
{{-- envoy run git:clone --on=aws --}}
{{-- envoy run git:pull --on=aws --}}
{{-- envoy run pull --on=lot --}}
@include('vendor/autoload.php')


@setup
    // $origin = 'git remote add origin https://espagodev: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@pos.lotogam.com.git';
    //  $origin = 'https://espagodev:Y7323529KespG%40@github.com/espagodev/lotogam.espagodev.com.git';
    // $origin = 'git clone https://github.com/espagodev/pos.lotogam.com.git
    //             Username: espagodev
    //             Password: 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';
    $origin = 'git@github.com:espagodev/pos.lotogam.com.git';
    $branch = isset($branch) ? $branch : 'main';

    $app_dir = '/var/www';
    $app_dir_pos = '/var/www/pos.lotogam.com';


    if ( !isset($on)) {
        throw new Exception('La variable --on no está definida');
    }
@endsetup


@story('app:deploy', ['on' => $on])
  
@endstory



@task('git:clone', ['on' => $on])
    cd {{ $app_dir }}
    echo "hemos entrado al directorio /var/www";
   sudo git clone {{ $origin }};
    echo "repositorio clonado correctamente";
@endtask

@task('pull', ['on' => $on])
    cd {{ $app_dir_pos }}
    echo "hemos entrado al directorio {{ $app_dir_pos }}";
    {{-- sudo git pull origin {{ $branch }} --allow-unrelated-histories --}}
    sudo git pull origin {{ $branch }}
    echo "código actualizado correctamente";
@endtask

@task('composer', ['on' => $on])
    cd {{ $app_dir_pos }}
 sudo   composer install --no-dev
@endtask

@task('autoload', ['on' => $on])
    cd {{ $app_dir_pos }}
 sudo   composer dump-autoload
@endtask

@task('env', ['on' => $on])
    cd {{ $app_dir_pos }}
    sudo  cp .env.example .env
     echo "Se crea archivo env";
@endtask

@task('key', ['on' => $on])
    cd {{ $app_dir_pos }}
    sudo php artisan key:generate
     echo "Se genero la llave";
@endtask

@task('storage', ['on' => $on])
    cd {{ $app_dir_pos }}
    sudo chown -R www-data:root storage/
     echo "Se dieron permisos a storage";
@endtask

@task('bootstrap', ['on' => $on])
    cd {{ $app_dir_pos }}
    sudo chown -R www-data bootstrap/cache/
     echo "Se dieron permisos a bootstrap";
@endtask

@task('assets:install', ['on' => $on])
    cd {{ $app_dir_pos }}
    yarn install
@endtask

@task('up', ['on' => $on])
    cd {{ $app_dir }}
    php artisan up
@endtask

@task('down', ['on' => $on])
    cd {{ $app_dir_pos }}
    php artisan down
@endtask

@task('lot_cache', ['on' => $on])
    cd {{ $app_dir_pos }}
 sudo   php artisan config:cache
    {{-- php artisan cache:clear --}}
    echo "caché limpiada correctamente";
@endtask

