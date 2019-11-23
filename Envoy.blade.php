@servers(['web' => 'deployer@195.110.58.197'])

@setup
    $repository = 'git@gitlab.com:aronnebrivio/blog-backend.git';
    $releases_dir = '/var/www/blog-backend/releases';
    $app_dir = '/var/www/blog-backend';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
    clone_repository
    run_composer
    update_symlinks
    migrate
    clean_workdir
    clean_old_releases
@endstory

@task('clone_repository')
    echo 'Cloning repository ({{ $release }})'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard {{ $commit }}
@endtask

@task('run_composer')
    echo 'Installing composer dependencies'
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-scripts -o
@endtask

@task('update_symlinks')
    echo 'Linking storage directory'
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('migrate')
    echo 'Running migrations'
    cd {{ $new_release_dir }};
    php artisan migrate --env=production --force;
@endtask

@task('clean_workdir')
    echo 'Cleaning working directory)'
    cd {{ $new_release_dir }}
    rm -rf .git .vscode docker tests README.md phpunit.xml -php_cd.dist .gitlab-ci.yml \
        .gitignore Envoy.blade.php .env.ci .dockerignore docker-compose.yml database \
        composer.lock composer.json artisan
@endtask

@task('clean_old_releases')
    # This will list our releases by modification time and delete all but the 3 most recent.
    purging=$(ls -dt {{ $releases_dir }}/* | tail -n +3);

    if [ "{{ $releases_dir }}" -ne "" ] && [ "{{ $purging }}" -ne "" ]; then
        echo Purging old releases: $purging;
        rm -rf $purging;
    else
        echo "No releases found for purging at this time";
    fi
@endtask

