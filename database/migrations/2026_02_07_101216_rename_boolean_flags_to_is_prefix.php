<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            if ($this->columnExists('users', 'admin')) {
                DB::statement('ALTER TABLE users RENAME COLUMN admin TO is_admin');
            }
            if ($this->columnExists('users', 'approved')) {
                DB::statement('ALTER TABLE users RENAME COLUMN approved TO is_approved');
            }
            if ($this->columnExists('users', 'scheduled')) {
                DB::statement('ALTER TABLE users RENAME COLUMN scheduled TO is_scheduled');
            }
            if ($this->columnExists('roles', 'available')) {
                DB::statement('ALTER TABLE roles RENAME COLUMN available TO is_available');
            }
        } elseif ($driver === 'mysql') {
            if ($this->columnExists('users', 'admin')) {
                DB::statement('ALTER TABLE users CHANGE admin is_admin BOOLEAN');
            }
            if ($this->columnExists('users', 'approved')) {
                DB::statement('ALTER TABLE users CHANGE approved is_approved BOOLEAN');
            }
            if ($this->columnExists('users', 'scheduled')) {
                DB::statement('ALTER TABLE users CHANGE scheduled is_scheduled BOOLEAN');
            }
            if ($this->columnExists('roles', 'available')) {
                DB::statement('ALTER TABLE roles CHANGE available is_available BOOLEAN');
            }
        } else {
            // Fallback for other databases - requires doctrine/dbal
            Schema::table('users', function ($table) {
                if (Schema::hasColumn('users', 'admin')) {
                    $table->renameColumn('admin', 'is_admin');
                }
                if (Schema::hasColumn('users', 'approved')) {
                    $table->renameColumn('approved', 'is_approved');
                }
                if (Schema::hasColumn('users', 'scheduled')) {
                    $table->renameColumn('scheduled', 'is_scheduled');
                }
            });

            Schema::table('roles', function ($table) {
                if (Schema::hasColumn('roles', 'available')) {
                    $table->renameColumn('available', 'is_available');
                }
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            if ($this->columnExists('users', 'is_admin')) {
                DB::statement('ALTER TABLE users RENAME COLUMN is_admin TO admin');
            }
            if ($this->columnExists('users', 'is_approved')) {
                DB::statement('ALTER TABLE users RENAME COLUMN is_approved TO approved');
            }
            if ($this->columnExists('users', 'is_scheduled')) {
                DB::statement('ALTER TABLE users RENAME COLUMN is_scheduled TO scheduled');
            }
            if ($this->columnExists('roles', 'is_available')) {
                DB::statement('ALTER TABLE roles RENAME COLUMN is_available TO available');
            }
        } elseif ($driver === 'mysql') {
            if ($this->columnExists('users', 'is_admin')) {
                DB::statement('ALTER TABLE users CHANGE is_admin admin BOOLEAN');
            }
            if ($this->columnExists('users', 'is_approved')) {
                DB::statement('ALTER TABLE users CHANGE is_approved approved BOOLEAN');
            }
            if ($this->columnExists('users', 'is_scheduled')) {
                DB::statement('ALTER TABLE users CHANGE is_scheduled scheduled BOOLEAN');
            }
            if ($this->columnExists('roles', 'is_available')) {
                DB::statement('ALTER TABLE roles CHANGE is_available available BOOLEAN');
            }
        } else {
            Schema::table('users', function ($table) {
                if (Schema::hasColumn('users', 'is_admin')) {
                    $table->renameColumn('is_admin', 'admin');
                }
                if (Schema::hasColumn('users', 'is_approved')) {
                    $table->renameColumn('is_approved', 'approved');
                }
                if (Schema::hasColumn('users', 'is_scheduled')) {
                    $table->renameColumn('is_scheduled', 'scheduled');
                }
            });

            Schema::table('roles', function ($table) {
                if (Schema::hasColumn('roles', 'is_available')) {
                    $table->renameColumn('is_available', 'available');
                }
            });
        }
    }

    private function columnExists(string $table, string $column): bool
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            $result = DB::selectOne(
                'SELECT COUNT(*) as count FROM information_schema.columns WHERE table_name = ? AND column_name = ?',
                [$table, $column]
            );

            return $result->count > 0;
        }

        if ($driver === 'mysql') {
            $result = DB::selectOne(
                'SELECT COUNT(*) as count FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?',
                [$table, $column]
            );

            return $result->count > 0;
        }

        return Schema::hasColumn($table, $column);
    }
};
