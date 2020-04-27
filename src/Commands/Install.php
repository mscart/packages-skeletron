<?php

namespace MsCart\:uc:package\Commands;

use App\Models\Package;
use Illuminate\Console\Command;
use MsCart\:uc:package\Models\:sg:package;
use Spatie\Permission\Models\Permission;


/**
 * List all locally installed packages.
 *
 * @author JeroenG
 **/
class Install extends Command
{
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = ':lc:package:install';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Installing the package!';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info('Install package...');
		$p = new :sg:package();
		$package_model = $p->getMorphClass();
		$package_version = '1.0.0';
		$package_options = [
			'name' => 'orders::order.name',
			'permissions' => [
				':lc:package::role.create',
				':lc:package::role.read',
				':lc:package::role.edit',
				':lc:package::role.delete',
			]
		];

		Package::updateOrCreate(['model' => $package_model],
			[
				'options' => json_encode($package_options),
				'version' => $package_version,
			]
		);
		$this->info('Done.');
		$this->info('Install permissions...');
		foreach ($package_options['permissions'] as $permission) {
			Permission::firstOrCreate(['name' => $permission], [
				'guard_name' => 'admin'
			]);
		}
		$this->info('Done.');

	}
}
