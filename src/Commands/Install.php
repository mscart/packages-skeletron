<?php

namespace MsCart\Orders\Commands;

use App\Models\Package;
use Illuminate\Console\Command;
use MsCart\Orders\Models\Order;
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
	protected $signature = 'orders:install';

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
		$order = new Order();
		$package_model = $order->getMorphClass();
		$package_version = '1.0.0';
		$package_options = [
			'name' => 'orders::order.name',
			'permissions' => [
				'orders::role.create',
				'orders::role.read',
				'orders::role.edit',
				'orders::role.delete',
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
