<?php

namespace Models;

use Backend\Services\Structures\Collection;
use Backend\Services\Structures\Model;
use Backend\Public\Tools;
use PDO;

class User extends Model
{
    public int $id;
    public String $name;
    public String $email;
    public String $password;
    public String $hash;
    public String $created_at;
    public String $updated_at;

    public function save(): void
    {
        $values = ['name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'hash' => $this->hash];

        $query = parent::prepare('SELECT COUNT(id) AS `count` FROM users WHERE id=:id', ['id' => $this->id ?? -1]);
        if ($query->fetch(PDO::FETCH_ASSOC)['count'] == 0) {
            $user = User::create($values);
        } else {
            $user = User::update($this->id, $values);
        }

        $this->setUser($user);
    }

    public function destroy(): void
    {
        User::delete($this->id);
    }

    public function rewriteHash(): void
    {
        $this->hash = crc32(Tools::getTodayDate());
    }

    public function roles(): Collection
    {
        $roles = new Collection();

        $queries = parent::prepare("SELECT roles.* FROM roles,user_has_roles AS uhr WHERE uhr.user_id = :idu GROUP BY id", [
            'idu' => $this->id
        ]);

        foreach ($queries as $query) {
            $roles->addItem(Role::getRole($query));
        }
        return $roles;
    }

    public function relatesRole(Role $role): void
    {
        if ($this->hasRole($role->name)) {
            return;
        }

        parent::prepare("INSERT INTO user_has_roles VALUES (:ui,:ri)", [
            'ui' => $this->id,
            'ri' => $role->id
        ]);
    }

    public function hasPermission(String $permission): bool
    {
        $queries = parent::prepare("SELECT COUNT(`permissions`.`name`) AS `count` FROM `permissions`,role_has_permissions AS rhp, user_has_roles AS uhr 
            WHERE BINARY rhp.role_id = uhr.role_id AND uhr.user_id = :id AND `name` = :p", [
            'p' => $permission,
            'id' => $this->id
        ])->fetch(PDO::FETCH_ASSOC)['count'];

        return $queries > 0;
    }

    public function hasRole(String $role): bool
    {
        $queries = parent::prepare("SELECT COUNT(roles.name) AS `count` FROM roles,user_has_roles AS uhr 
            WHERE BINARY uhr.user_id = :id AND `name` = :r AND uhr.role_id = id", [
            'r' => $role,
            'id' => $this->id
        ])->fetch(PDO::FETCH_ASSOC)['count'];

        return $queries > 0;
    }

    public static function first(): User
    {
        return User::read('id')->getItem(0);
    }

    public static function last(): User|null
    {
        return User::read(byColumn: 'id', arg: ['limit' => 1, 'direction' => 'DESC'])->getItem(0);
    }

    public static function create(array $values): User
    {
        parent::prepare('INSERT INTO users(`name`,`email`,`password`,`created_at`,`updated_at`,`hash`) 
           VALUES (:n,:e,:pass,:ca,:ua,:pp,:h)', [
            'n' => $values['name'],
            'nick' => $values['email'],
            'pass' => $values['password'],
            'ca' => Tools::getTodayDate(),
            'ua' => Tools::getTodayDate(),
            'h' => crc32(Tools::getTodayDate()),
        ]);

        return  User::last();
    }

    public static function read(String $byColumn = null, $value = null, array $arg = null): Collection|User|null
    {
        $params = ['limit' => 100, 'direction' => 'ASC', 'bySearch' => []];

        if (!is_null($arg)) {
            foreach ($arg as $key => $val) {
                $params[$key] = $val;
            }
        }

        if (!is_null($byColumn)) {
            if (!is_null($value)) {
                $query = parent::prepare("SELECT * FROM users WHERE BINARY {$byColumn} = :valu", ['valu' => $value]);
                if ($query->rowCount()) {
                    return User::getUser($query->fetch(PDO::FETCH_ASSOC));
                } else {
                    return null;
                }
            } else {
                $users = new Collection();
                if (count($params['bySearch'])) {
                    $bySearch = '';
                    $first = true;
                    foreach ($params['bySearch'] as $key => $val) {
                        if ($first) {
                            $bySearch .= "{$key} LIKE :{$key} ";
                            $first = false;
                        } else {
                            $bySearch .= "OR {$key} LIKE :{$key}";
                        }
                    }

                    if ($params['limit'] != -1) {
                        $execute = array_merge(['longlimit' => $params['limit']], $params['bySearch']);

                        $queries = parent::prepare(
                            "SELECT * FROM users WHERE {$bySearch} ORDER BY {$byColumn} {$params['direction']} LIMIT :longlimit",
                            $execute
                        );
                    } else {
                        $queries = parent::prepare(
                            "SELECT * FROM users WHERE {$bySearch} ORDER BY {$byColumn} {$params['direction']}",
                            $params['bySearch']
                        );
                    }
                } else {
                    if ($params['limit'] != -1) {
                        $queries = parent::prepare(
                            "SELECT * FROM users ORDER BY {$byColumn} {$params['direction']} LIMIT :longlimit",
                            ['longlimit' => $params['limit']]
                        );
                    } else {
                        $queries = parent::query(
                            "SELECT * FROM users ORDER BY {$byColumn} {$params['direction']}"
                        );
                    }
                }

                foreach ($queries as $query) {
                    $users->addItem(User::getUser($query));
                }
                return $users;
            }
        } else {
            $users = new Collection();
            if ($params['limit'] != -1) {
                $queries = parent::prepare('SELECT * FROM users LIMIT :longlimit ', ['longlimit' => $params['limit']]);
            } else {
                $queries = parent::query('SELECT * FROM users');
            }
            foreach ($queries as $query) {
                $users->addItem(User::getUser($query));
            }
            return $users;
        }
    }

    public static function update(int $id, array $values): User
    {
        $user = User::read('id', $id);

        parent::prepare('UPDATE users SET `name`=:n,`lastname`=:ln,`nickname`=:nick,`password`=:pass,`updated_at`=:ua,`photo_path`=:p,`hash`=:h
                                WHERE id=:id', [
            'id' => $id,
            'n' => isset($values['name']) ? $values['name'] : $user->name,
            'nick' => isset($values['email']) ? $values['email'] : $user->email,
            'pass' => isset($values['password']) ? $values['password'] : $user->password,
            'h' => isset($values['hash']) ? $values['hash'] : $user->hash,
            'ua' => Tools::getTodayDate()
        ]);

        return User::read('id', $id);
    }

    public static function delete(int $id): void
    {
        parent::prepare('DELETE FROM users WHERE id=:id', ['id' => $id,]);
    }

    public function setUser(User $user): void
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->password = $user->password;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
        $this->hash = $user->hash;
    }

    public static function getUser($query): User
    {
        $user = new User();
        $user->id = $query['id'];
        $user->name = $query['name'];
        $user->email = $query['email'];
        $user->password = $query['password'];
        $user->created_at = $query['created_at'];
        $user->updated_at = $query['updated_at'];
        $user->hash = $query['hash'];

        return $user;
    }
}
