<?php

namespace App\Http\Controllers;

use Schema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function welcome() {
        return view('install.step1_welcome');
    }

    public function requirements() {
        $requirements = [
            'PHP >= 8.1' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'PDO' => extension_loaded('pdo'),
            'Mbstring' => extension_loaded('mbstring'),
            'Storage Writable' => is_writable(storage_path()),
        ];
        return view('install.step2_requirements', compact('requirements'));
    }

    public function envForm() {
        return view('install.step3_env');
    }

    public function saveEnv(Request $request) {
        $data = $request->only(['db_host', 'db_name', 'db_user', 'db_pass']);
        $this->setEnv([
            'DB_HOST' => $data['db_host'],
            'DB_DATABASE' => $data['db_name'],
            'DB_USERNAME' => $data['db_user'],
            'DB_PASSWORD' => $data['db_pass'],
        ]);
        return redirect('/install/database');
    }

    public function dbSetup() {
        try {
            DB::connection()->getPdo();
            Artisan::call('migrate', ['--force' => true]);
            return view('install.step4_admin');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function createAdmin(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $this->setEnv(['APP_INSTALLED' => 'true']);
        return redirect('/install/finish');
    }

    public function finish() {
        return view('install.step5_finish');
    }

    private function setEnv(array $data) {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        foreach ($data as $key => $value) {
            $pattern = "/^$key=.*$/m";
            $replacement = "$key=$value";
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $replacement, $env);
            } else {
                $env .= "\n$replacement";
            }
        }
        file_put_contents($envPath, $env);
    }

}
