<?php

namespace Models;

use Backend\Services\Structures\Collection;
use Backend\Services\Structures\Model;
use Backend\Public\Tools;
use PDO;

class Role extends Model
{
    public int $id;
    public String $name;
    public String $created_at;
    public String $updated_at;

    public function save(): void
    {
        $values = ['name' => $this->name];

        $query = parent::prepare('SELECT COUNT(id) AS `count` FROM roles WHERE id=:id', ['id' => $this->id ?? -1]);

        if ($query->fetch(PDO::FETCH_ASSOC)['count'] == 0) {
            $role = Role::create($values);
        } else {
            $role = Role::update($this->id, $values);
        }

        $this->setRole($role);
    }

    public function destroy(): void
    {
        Role::delete($this->id);
    }

    public function permissions(): Collection
    {
        $permissions = new Collection();
        $queries = parent::prepare("SELECT `permissions`.* FROM `permissions`,role_has_permissions AS rhp WHERE rhp.role_id = :idr GROUP BY id", [
            'idr' => $this->id
        ]);

        foreach ($queries as $query) {
            $permissions->addItem(Permission::getPermission($query));
        }
        return $permissions;
    }

    public function relatesPermission(Permission $permission): void
    {
        if ($this->hasPermission($permission->id)) {
            return;
        }

        parent::prepare("INSERT INTO role_has_permissions VALUES (:rid,:pid)", [
            'rid' => $this->id,
            'pid' => $permission->id
        ]);
    }

    public function syncPermissions(Collection $permissions): void
    {
        parent::prepare('DELETE FROM role_has_permissions WHERE role_id=:rid',['rid'=>$this->id]);

        foreach ($permissions->toArray() as $permission) {
            $this->relatesPermission($permission);
        }
    }

    public function hasPermission(int $permission_id): bool
    {
        $queries = parent::prepare("SELECT COUNT(*) AS `count` FROM role_has_permissions WHERE role_id=:rid AND permission_id=:pid", [
            'pid' => $permission_id,
            'rid' => $this->id
        ])->fetch(PDO::FETCH_ASSOC)['count'];

        return $queries > 0;
    }

    public static function first(): Role
    {
        return Role::read('id')->getItem(0);
    }

    public static function last(): Role
    {
        return Role::read(byColumn: 'id', arg: ['limit' => 1, 'direction' => 'DESC'])->getItem(0);
    }

    public static function create(array $values): Role
    {
        parent::prepare('INSERT INTO roles(`name`,`created_at`,`updated_at`) 
           VALUES (:n,:ca,:ua)', [
            'n' => $values['name'],
            'ca' => Tools::getTodayDate(),
            'ua' => Tools::getTodayDate(),
        ]);

        return Role::last();
    }

    public static function read(String $byColumn = null, $value = null, array $arg = null): Collection|Role|null
    {
        $params = ['limit' => 100, 'direction' => 'ASC'];

        if (!is_null($arg)) {
            foreach ($arg as $key => $val) {
                $params[$key] = $val;
            }
        }

        if (!is_null($byColumn)) {
            if (!is_null($value)) {
                $query = parent::prepare("SELECT * FROM roles WHERE BINARY {$byColumn} = :v", ['v' => $value]);
                if ($query->rowCount()) {
                    return Role::getRole($query->fetch(PDO::FETCH_ASSOC));
                } else {
                    return null;
                }
            } else {
                $roles = new Collection();
                if ($params['limit'] != -1) {
                    $queries = parent::prepare(
                        "SELECT * FROM roles ORDER BY {$byColumn} {$params['direction']} LIMIT :longlimit",
                        ['longlimit' => $params['limit']]
                    );
                } else {
                    $queries = parent::query(
                        "SELECT * FROM roles ORDER BY {$byColumn} {$params['direction']}"
                    );
                }

                foreach ($queries as $query) {
                    $roles->addItem(Role::getRole($query));
                }
                return $roles;
            }
        } else {
            $roles = new Collection();
            if ($params['limit'] != -1) {
                $queries = parent::prepare('SELECT * FROM roles LIMIT :longlimit ', ['longlimit' => $params['limit']]);
            } else {
                $queries = parent::query('SELECT * FROM roles');
            }
            foreach ($queries as $query) {
                $roles->addItem(Role::getRole($query));
            }
            return $roles;
        }
    }

    public static function update(int $id, array $values): Role
    {
        $role = Role::read('id', $id);

        parent::prepare('UPDATE roles SET `name`=:n, updated_at=:ua
                                WHERE id=:id', [
            'id' => $id,
            'n' => isset($values['name']) ? $values['name'] : $role->name,
            'ua' => Tools::getTodayDate()
        ]);

        return Role::read('id', $id);
    }

    public static function delete(int $id): void
    {
        parent::prepare('DELETE FROM roles WHERE id=:id', ['id' => $id,]);
    }

    public function setRole(Role $role): void
    {
        $this->id = $role->id;
        $this->name = $role->name;
        $this->created_at = $role->created_at;
        $this->updated_at = $role->updated_at;
    }

    public static function getRole($query): Role
    {
        $role = new Role();
        $role->id = $query['id'];
        $role->name = $query['name'];
        $role->created_at = $query['created_at'];
        $role->updated_at = $query['updated_at'];

        return $role;
    }
}
