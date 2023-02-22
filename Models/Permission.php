<?php

namespace Models;

use Backend\Services\Structures\Collection;
use Backend\Services\Structures\Model;
use Backend\Public\Tools;
use PDO;

class Permission extends Model
{
    public int $id;
    public String $name;
    public String $created_at;
    public String $updated_at;

    public function save(): void
    {
        $values = ['name' => $this->name];

        $query = parent::prepare('SELECT COUNT(id) AS `count` FROM `permissions` WHERE id=:id', ['id' => $this->id ?? -1]);

        if ($query->fetch(PDO::FETCH_ASSOC)['count'] == 0) {
            $permission = Permission::create($values);
        } else {
            $permission = Permission::update($this->id, $values);
        }

        $this->setPermission($permission);
    }

    public function destroy(): void
    {
        Permission::delete($this->id);
    }

    public function roles(): Collection
    {
        $roles = new Collection();

        $queries = parent::prepare("SELECT roles.* FROM roles,role_has_permissions AS rhp WHERE rhp.permission_id = :idp GROUP BY id", [
            'idp' => $this->id
        ]);

        foreach ($queries as $query) {
            $roles->addItem(Role::getRole($query));
        }
        return $roles;
    }

    public function relatesRole(Role $role): void
    {
        if ($role->hasPermission($this->id)) {
            return;
        }

        parent::prepare("INSERT INTO `role_has_permissions`(role_id,permission_id) VALUES (:rid,:pid)", [
            'rid' => $role->id,
            'pid' => $this->id,
        ]);
    }

    public static function first(): Permission
    {

        return Permission::read('id')->getItem(0);
    }

    public static function last(): Permission
    {

        return Permission::read(byColumn: 'id', arg: ['limit' => 1, 'direction' => 'DESC'])->getItem(0);
    }

    public static function create(array $values): Permission
    {
        parent::prepare('INSERT INTO `permissions`(`name`,`created_at`,`updated_at`) 
           VALUES (:n,:ca,:ua)', [
            'n' => $values['name'],
            'ca' => Tools::getTodayDate(),
            'ua' => Tools::getTodayDate(),
        ]);

        return Permission::last();
    }

    public static function read(String $byColumn = null, $value = null, array $arg = null): Collection|Permission|null
    {
        $params = ['limit' => 100, 'direction' => 'ASC'];

        if (!is_null($arg)) {
            foreach ($arg as $key => $val) {
                $params[$key] = $val;
            }
        }

        if (!is_null($byColumn)) {
            if (!is_null($value)) {
                $query = parent::prepare("SELECT * FROM `permissions` WHERE BINARY {$byColumn} = :v", ['v' => $value]);
                if ($query->rowCount()) {
                    return Permission::getPermission($query->fetch(PDO::FETCH_ASSOC));
                } else {
                    return null;
                }
            } else {
                $permissions = new Collection();
                if ($params['limit'] != -1) {
                    $queries = parent::prepare(
                        "SELECT * FROM `permissions` ORDER BY {$byColumn} {$params['direction']} LIMIT :longlimit",
                        ['longlimit' => $params['limit']]
                    );
                } else {
                    $queries = parent::query(
                        "SELECT * FROM `permissions` ORDER BY {$byColumn} {$params['direction']}"
                    );
                }

                foreach ($queries as $query) {
                    $permissions->addItem(Permission::getPermission($query));
                }

                return $permissions;
            }
        } else {
            $permissions = new Collection();
            if ($params['limit'] != -1) {
                $queries = parent::prepare('SELECT * FROM `permissions` LIMIT :longlimit ', ['longlimit' => $params['limit']]);
            } else {
                $queries = parent::query('SELECT * FROM `permissions`');
            }
            foreach ($queries as $query) {
                $permissions->addItem(Permission::getPermission($query));
            }

            return $permissions;
        }
    }

    public static function update(int $id, array $values): Permission
    {
        $permission = Permission::read('id', $id);

        parent::prepare('UPDATE `permissions` SET `name`=:n, updated_at=:ua
                                WHERE id=:id', [
            'id' => $id,
            'n' => isset($values['name']) ? $values['name'] : $permission->name,
            'ua' => Tools::getTodayDate()
        ]);

        return Permission::read('id', $id);
    }

    public static function delete(int $id): void
    {
        parent::prepare('DELETE FROM `permissions` WHERE id=:id', ['id' => $id,]);
    }

    public function setPermission(Permission $permission): void
    {
        $this->id = $permission->id;
        $this->name = $permission->name;
        $this->created_at = $permission->created_at;
        $this->updated_at = $permission->updated_at;
    }

    public static function getPermission($query): Permission
    {
        $permission = new Permission();
        $permission->id = $query['id'];
        $permission->name = $query['name'];
        $permission->created_at = $query['created_at'];
        $permission->updated_at = $query['updated_at'];

        return $permission;
    }
}
