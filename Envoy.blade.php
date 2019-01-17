@servers(['web' => 'deployer@https://195.110.58.197'])

@task('list', ['on' => 'web'])
ls -l
@endtask