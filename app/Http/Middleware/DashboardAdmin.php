<?php

namespace App\Http\Middleware;

use App\Events\DashboardAdminEvent;
use Closure;
use Auth;
use Menu;

class DashboardAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check())
            return $next($request);

        Menu::create('AdminMenu', function($menu) {
            $menu->style('adminlte');

            $admin = Auth::user();

            $attr = ['icon' => 'fa fa-angle-double-right'];

            $menu->add([
                'url' => '/',
                'title' => 'Home',
                'icon' => 'fa fa-home',
                'order' => 1,
            ]);

            // Masters
            if ($admin->can(['read-master-regions', 'read-master-ruas', 'read-master-areas', 'read-master-assets', 'read-master-asset-kinds', 'read-master-asset-types', 'read-master-matriks'])) {
                $menu->dropdown('Masters', function ($sub) use($admin, $attr) {
                    if ($admin->can('read-master-regions')) {
                        $sub->url('master/regions', 'Region', 1, $attr);
                    }
                    if ($admin->can('read-master-ruas')) {
                        $sub->url('master/ruas', 'Ruas', 2, $attr);
                    }
                    if ($admin->can('read-master-areas')) {
                        $sub->url('master/areas', 'Rest Area', 3, $attr);
                    }
                    if ($admin->can('read-master-asset-types')) {
                        $sub->url('master/asset_types', 'Jenis Aset', 4, $attr);
                    }
                    if ($admin->can('read-master-asset-groups')) {
                        $sub->url('master/asset_groups', 'Kelompok Aset', 5, $attr);
                    }
                    if ($admin->can('read-master-asset-kinds')) {
                        $sub->url('master/asset_kinds', 'Jenis Aset', 6, $attr);
                    }
                    if ($admin->can('read-master-assets')) {
                        $sub->url('master/assets', 'Aset', 7, $attr);
                    }
                    if ($admin->can('read-master-matriks')) {
                        $sub->url('master/matriks', 'Matrik Kerusakan', 8, $attr);
                    }
                }, 2, [
                    'title' => 'Masters',
                    'icon' => 'fa fa-list',
                ]);
            }

            if ($admin->can(['read-monitoring-performances', 'read-monitoring-inspections', 'read-monitoring-complaints'])) {
                $menu->dropdown('Monitoring', function ($sub) use($admin, $attr) {
                    if ($admin->can('read-monitoring-performances')) {
                        $sub->url('monitor/performances', 'Performa Aset', 1, $attr);
                    }
                    if ($admin->can('read-monitoring-inspections')) {
                        $sub->url('monitor/inspections', 'Inspeksi', 2, $attr);
                    }
                    if ($admin->can('read-monitoring-complaints')) {
                        $sub->url('monitor/complaints', 'Komplain', 3, $attr);
                    }
                }, 3, [
                    'title' => 'Monitoring',
                    'icon' => 'fa fa-desktop',
                ]);
            }

            if ($admin->can(['read-auth-roles', 'read-auth-permissions', 'read-auth-users'])) {
                $menu->dropdown('Setting', function ($sub) use($admin, $attr) {
                    if ($admin->can('read-auth-roles')) {
                        $sub->url('auth/roles', 'Role', 1, $attr);
                    }
                    if ($admin->can('read-auth-permissions')) {
                        $sub->url('auth/permissions', 'Permisi', 2, $attr);
                    }
                    if ($admin->can('read-auth-users')) {
                        $sub->url('auth/users', 'Pengguna', 3, $attr);
                    }
                }, 4, [
                    'title' => 'Setting',
                    'icon' => 'fa fa-wrench',
                ]);
            }

            event(new DashboardAdminEvent($menu));
        });

        return $next($request);
    }
}
