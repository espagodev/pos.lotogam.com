@servers(['aws' => '-i D:\\espagodev\dev.pem ubuntu@ec2-3-131-101-33.us-east-2.compute.amazonaws.com',
'localhost' => '127.0.0.1',
'lot' => '-i D:\\espagodev\LightsailDefaultKey-eu-west-3.pem ubuntu@15.237.141.99'])
{{-- @servers([ 'aws' => ['ubuntu@3.18.107.107']]) --}}
{{-- envoy run git:clone --on=aws --}}
{{-- envoy run git:pull --on=aws --}}
{{-- envoy run lot_pull --on=lot --}}
@include('vendor/autoload.php')


@setup
    $origin = 'git remote add origin https://espagodev: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@pos.lotogam.com.git';
    //  $origin = 'https://espagodev:Y7323529KespG%40@github.com/espagodev/lotogam.espagodev.com.git';
    // $origin = 'git clone https://github.com/espagodev/lotogam.espagodev.com.git
    //             Username: espagodev
    //             Password: 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';
    $branch = isset($branch) ? $branch : 'master';


    $app_dir_pos_lotogam = '/var/www/pos.lotogam.com';


    if ( !isset($on)) {
        throw new Exception('La variable --on no está definida');
    }
@endsetup


@macro('app:deploy', ['on' => $on])
    down
    git:pull
    migrate
    composer:install
    assets:install
    cache:clear
    up
@endmacro

@task('git:clone', ['lot' => $on])
    cd {{ $app_dir1 }}
    echo "hemos entrado al directorio /var/www";
   sudo git clone {{ $origin }};
    echo "repositorio clonado correctamente";
@endtask